<?php

namespace App\Http\Controllers\Instagram\Advertiser;

use App\Http\Controllers\Controller;
use App\Models\InstagramProfile;
use App\Models\InstagramCampaign;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:advertiser']);
    }

    /**
     * Display a listing of Instagram profiles for campaign creation.
     */
    public function index(Request $request)
    {
        $query = InstagramProfile::active()->with('user');

        // Filter by followers
        if ($request->has('min_followers')) {
            $query->where('followers', '>=', $request->min_followers);
        }

        if ($request->has('max_followers')) {
            $query->where('followers', '<=', $request->max_followers);
        }

        // Filter by price
        if ($request->has('max_price')) {
            $query->where('price_per_story', '<=', $request->max_price);
        }

        // Filter by mention availability
        if ($request->has('mention_available')) {
            $query->where('mention_available', true);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'followers');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $profiles = $query->paginate(12)->withQueryString();

        return view('instagram.advertiser.profiles.index', compact('profiles'));
    }

    /**
     * Show the form for creating a new campaign.
     */
    public function create(InstagramProfile $profile)
    {
        if (!$profile->is_active) {
            return redirect()
                ->route('instagram.advertiser.profiles.index')
                ->with('error', 'This profile is not active.');
        }

        return view('instagram.advertiser.campaigns.create', compact('profile'));
    }

    /**
     * Store a newly created campaign.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'instagram_profile_id' => 'required|exists:instagram_profiles,id',
            'media_type' => 'required|in:image,video',
            'media_file' => 'required|file|mimes:jpg,jpeg,png,mp4,mov|max:10240',
            'caption' => 'nullable|string|max:2200',
            'mention_required' => 'boolean',
        ]);

        $profile = InstagramProfile::findOrFail($validated['instagram_profile_id']);

        // Check if mention is required but profile doesn't support it
        if ($request->has('mention_required') && !$profile->mention_available) {
            return redirect()
                ->back()
                ->with('error', 'This profile does not support mentions.');
        }

        // Handle media file upload
        $mediaPath = $request->file('media_file')
            ->store('instagram/campaigns', 'public');

        // Create campaign
        $campaign = InstagramCampaign::create([
            'advertiser_id' => Auth::id(),
            'publisher_id' => $profile->user_id,
            'instagram_profile_id' => $profile->id,
            'media_type' => $validated['media_type'],
            'media_file' => $mediaPath,
            'caption' => $validated['caption'],
            'mention_required' => $request->has('mention_required'),
            'status' => 'pending',
            'price' => $profile->price_per_story,
            'paid' => false,
        ]);

        return redirect()
            ->route('instagram.advertiser.campaigns.payment', $campaign)
            ->with('success', 'Campaign created! Please complete the payment.');
    }

    /**
     * Show the payment page for a campaign.
     */
    public function payment(InstagramCampaign $campaign)
    {
        // Ensure the campaign belongs to the authenticated user
        if ($campaign->advertiser_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if already paid
        if ($campaign->paid) {
            return redirect()
                ->route('instagram.advertiser.dashboard')
                ->with('info', 'This campaign has already been paid for.');
        }

        $wallet = Wallet::firstOrCreate(
            ['user_id' => Auth::id()],
            ['balance' => 0, 'pending_balance' => 0]
        );

        return view('instagram.advertiser.campaigns.payment', compact('campaign', 'wallet'));
    }

    /**
     * Process the payment for a campaign.
     */
    public function processPayment(InstagramCampaign $campaign)
    {
        // Ensure the campaign belongs to the authenticated user
        if ($campaign->advertiser_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if already paid
        if ($campaign->paid) {
            return redirect()
                ->route('instagram.advertiser.dashboard')
                ->with('info', 'This campaign has already been paid for.');
        }

        $wallet = Wallet::where('user_id', Auth::id())->firstOrFail();

        // Check if wallet has sufficient balance
        if ($wallet->balance < $campaign->price) {
            return redirect()
                ->back()
                ->with('error', 'Insufficient wallet balance. Please add funds to your wallet.');
        }

        try {
            DB::beginTransaction();

            // Deduct amount from wallet
            if (!$wallet->withdraw($campaign->price, "Payment for Instagram Campaign #{$campaign->id}")) {
                throw new \Exception('Failed to process wallet transaction');
            }

            // Mark campaign as paid
            $campaign->update(['paid' => true]);

            DB::commit();

            return redirect()
                ->route('instagram.advertiser.dashboard')
                ->with('success', 'Payment processed successfully! Your campaign is now pending publisher approval.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'An error occurred while processing the payment. Please try again.');
        }
    }

    /**
     * Display the specified campaign.
     */
    public function show(InstagramCampaign $campaign)
    {
        // Ensure the campaign belongs to the authenticated user
        if ($campaign->advertiser_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $campaign->load(['instagramProfile', 'publisher']);

        return view('instagram.advertiser.campaigns.show', compact('campaign'));
    }

    /**
     * Display campaign history.
     */
    public function history()
    {
        $campaigns = InstagramCampaign::where('advertiser_id', Auth::id())
            ->with(['instagramProfile', 'publisher'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('instagram.advertiser.campaigns.history', compact('campaigns'));
    }
}
