<?php

namespace App\Http\Controllers;

use App\Events\NewCampaignAssigned;
use App\Models\Campaign;
use App\Models\Channel;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CampaignController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:advertiser']);
    }

    public function index($user)
    {
        if (auth()->id() != $user) {
            abort(403, 'Unauthorized action.');
        }
        $campaigns = Campaign::where('advertiser_id', auth()->id())->get();
        return view('campaigns.index', compact('campaigns'));
    }

    public function create($user)
    {
        if (auth()->id() != $user) {
            abort(403, 'Unauthorized action.');
        }
        $channels = Channel::where('status', 'active')
            ->orderBy('subscribers_count', 'desc')
            ->paginate(6);
        return view('campaigns.create', compact('channels'));
    }

    public function store(Request $request, $user)
    {
        if (auth()->id() != $user) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'advertisement_content' => 'required|string',
            'advertisement_image' => 'required|image|mimes:jpg,jpeg|max:2048'
        ], [
            'advertisement_image.mimes' => 'Only .jpg file images are allowed to upload'
        ]);

        $channelId = $request->query('channel_id', $request->input('channel_id'));
        $duration = $request->query('duration', $request->input('duration'));
        $price = $request->query('price', $request->input('price'));

        if (!$channelId || !$duration || !$price) {
            return redirect()->back()->withErrors(['error' => 'Missing required channel information']);
        }

        $channel = Channel::with('publisher.user')->findOrFail($channelId);
        
        if (!$channel->publisher || !$channel->publisher->user) {
            return redirect()->back()->withErrors(['error' => 'Invalid channel publisher']);
        }

        $imagePath = $request->file('advertisement_image')->store('advertisements', 'public');

        $campaign = Campaign::create([
            'publisher_id' => $channel->publisher->user->id,
            'advertiser_id' => auth()->id(),
            'channel_id' => $channelId,
            'channel_name' => $channel->name,
            'subscribers' => $channel->subscribers_count,
            'channel_link' => $channel->link,
            'duration' => $duration,
            'price' => $price,
            'advertisement_image' => $imagePath,
            'advertisement_content' => $validated['advertisement_content'],
            'status' => 'expired'
        ]);

        return redirect()->route('campaigns.payment.create', ['user' => auth()->id(), 'campaign' => $campaign->id]);

    }

    public function show($user, Campaign $campaign)
    {
        if (auth()->id() != $user) {
            abort(403, 'Unauthorized action.');
        }
        $this->authorize('view', $campaign);
        return view('campaigns.show', compact('campaign'));
    }

    public function processPayment($user, Campaign $campaign)
    {
        if (auth()->id() != $user) {
            abort(403, 'Unauthorized action.');
        }

        $route = request()->route()->getName();
        
        if ($route === 'campaigns.payment.create') {
            $wallet = Wallet::firstOrCreate(
                ['user_id' => auth()->id()],
                ['balance' => 0, 'pending_balance' => 0]
            );
            return view('campaigns.payment', compact('campaign', 'wallet'));
        }

        // Get advertiser's wallet
        $wallet = Wallet::where('user_id', auth()->id())->firstOrFail();

        // Check if wallet has sufficient balance
        if ($wallet->balance < $campaign->price) {
            Session::flash('error', 'Insufficient wallet balance. Please add funds to your wallet.');
            return redirect()->back();
        }

        try {
            // Deduct amount from wallet
            if (!$wallet->withdraw($campaign->price, "Payment for Campaign on {$campaign->channel_name} for {$campaign->duration} days")) {
                throw new \Exception('Failed to process wallet transaction');
            }

            // Activate the campaign
            $campaign->update(['status' => 'active']);

            // Get the channel and dispatch the notification event
            $channel = Channel::findOrFail($campaign->channel_id);
            event(new NewCampaignAssigned($campaign, $channel));

            Session::flash('success', 'Payment processed successfully! Your campaign is now active.');
            return redirect('/'. auth()->id() .'/advertiser/dashboard');
        } catch (\Exception $e) {
            Session::flash('error', 'An error occurred while processing the payment. Please try again.');
            return redirect()->back();
        }
    }

    public function edit($user, Campaign $campaign)
    {
        if (auth()->id() != $user) {
            abort(403, 'Unauthorized action.');
        }
        $this->authorize('update', $campaign);
        return view('campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, $user, Campaign $campaign)
    {
        if (auth()->id() != $user) {
            abort(403, 'Unauthorized action.');
        }
        $this->authorize('update', $campaign);

        $validated = $request->validate([
            'advertisement_content' => 'required|string',
            'advertisement_image' => 'nullable|image|mimes:jpg,jpeg|max:2048'
        ]);

        if ($request->hasFile('advertisement_image')) {
            $imagePath = $request->file('advertisement_image')->store('advertisements', 'public');
            $validated['advertisement_image'] = $imagePath;
        }

        $campaign->update($validated);

        return redirect()->route('campaigns.show', $campaign)
            ->with('status', 'Campaign updated successfully!');
    }

    public function showChannelDetails($user, Channel $channel)
    {
        if (auth()->id() != $user) {
            abort(403, 'Unauthorized action.');
        }
        return view('campaigns.channel-details', compact('channel'));
    }

    public function destroy($user, Campaign $campaign)
    {
        if (auth()->id() != $user) {
            abort(403, 'Unauthorized action.');
        }
        $this->authorize('delete', $campaign);
        $campaign->delete();

        return redirect()->route('campaigns.index')
            ->with('status', 'Campaign deleted successfully!');
    }
}