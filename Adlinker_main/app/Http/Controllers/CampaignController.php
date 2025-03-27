<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Channel;
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
        $channels = Channel::where('status', 'active')->get();
        return view('campaigns.create', compact('channels'));
    }

    public function store(Request $request, $user)
    {
        if (auth()->id() != $user) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'advertisement_content' => 'required|string',
            'advertisement_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $channelId = $request->query('channel_id', $request->input('channel_id'));
        $duration = $request->query('duration', $request->input('duration'));
        $price = $request->query('price', $request->input('price'));

        if (!$channelId || !$duration || !$price) {
            return redirect()->back()->withErrors(['error' => 'Missing required channel information']);
        }

        $channel = Channel::findOrFail($channelId);
        $imagePath = $request->file('advertisement_image')->store('advertisements', 'public');

        $campaign = Campaign::create([
            'publisher_id' => $channel->publisher_id,
            'advertiser_id' => auth()->id(),
            'channel_id' => $channelId,
            'channel_name' => $channel->name,
            'subscribers' => $channel->subscribers_count,
            'channel_link' => $channel->link,
            'duration' => $duration,
            'price' => $price,
            'advertisement_image' => $imagePath,
            'advertisement_content' => $validated['advertisement_content'],
            'status' => 'pending'
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
            return view('campaigns.payment', compact('campaign'));
        }

        // Simple payment process - just activate the campaign
        $campaign->update(['status' => 'active']);

        Session::flash('success', 'Payment processed successfully! Your campaign is now active.');
        return redirect('/'. auth()->id() .'/advertiser/dashboard');
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
            'advertisement_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
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