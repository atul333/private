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

        // Combined sorting logic
        $sortBy = $request->get('sort_by');
        
        switch ($sortBy) {
            case 'max_followers':
                $query->orderBy('followers', 'desc');
                break;
            case 'lower_followers':
                $query->orderBy('followers', 'asc');
                break;
            case 'max_price':
                $query->orderBy('price_per_story', 'desc');
                break;
            case 'lower_price':
                $query->orderBy('price_per_story', 'asc');
                break;
            default:
                // Default sorting - max followers
                $query->orderBy('followers', 'desc');
                break;
        }

        $profiles = $query->paginate(12)->withQueryString();

        return view('instagram.advertiser.profiles.index', compact('profiles'));
    }

    /**
     * Show the form for creating a new campaign.
     */
    public function create($user, $profile)
    {
        $profile = InstagramProfile::findOrFail($profile);
        
        if (!$profile->is_active) {
            return redirect()
                ->route('instagram.advertiser.profiles.index', ['user' => auth()->id()])
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
            'link_text' => 'required|string|max:100',
            'link_url' => 'required|url|max:500',
        ]);


        $profile = InstagramProfile::findOrFail($validated['instagram_profile_id']);


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
            'link_text' => $validated['link_text'],
            'link_url' => $validated['link_url'],
            'status' => 'pending',
            'price' => $profile->price_per_story,
            'paid' => false,
        ]);

        return redirect()
            ->route('instagram.advertiser.campaigns.payment', ['user' => auth()->id(), 'campaign' => $campaign->id])
            ->with('success', 'Campaign created! Please complete the payment.');
    }

    /**
     * Show the payment page for a campaign.
     */
    public function payment($user, $campaign)
    {
        $campaign = InstagramCampaign::findOrFail($campaign);
        
        // Ensure the campaign belongs to the authenticated user
        if ($campaign->advertiser_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if already paid
        if ($campaign->paid) {
            return redirect()
                ->route('instagram.advertiser.dashboard', ['user' => auth()->id()])
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
    public function processPayment($user, $campaign)
    {
        $campaign = InstagramCampaign::findOrFail($campaign);
        
        // Ensure the campaign belongs to the authenticated user
        if ($campaign->advertiser_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if already paid
        if ($campaign->paid) {
            return redirect()
                ->route('instagram.advertiser.dashboard', ['user' => auth()->id()])
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
            $campaign->load('instagramProfile');
            $instagramId = $campaign->instagramProfile ? '@' . $campaign->instagramProfile->instagram_id : '';
            $description = "[Instagram] Payment for Campaign #{$campaign->id}" . ($instagramId ? " on {$instagramId}" : '');
            if (!$wallet->withdraw($campaign->price, $description)) {
                throw new \Exception('Failed to process wallet transaction');
            }

            // Mark campaign as paid
            $campaign->update(['paid' => true]);

            DB::commit();

            return redirect()
                ->route('instagram.advertiser.dashboard', ['user' => auth()->id()])
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
    public function show($user, $campaign)
    {
        $campaign = InstagramCampaign::findOrFail($campaign);
        
        // Ensure the campaign belongs to the authenticated user
        if ($campaign->advertiser_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $campaign->load(['instagramProfile', 'publisher']);

        return view('instagram.advertiser.campaigns.show', compact('campaign'));
    }
}
