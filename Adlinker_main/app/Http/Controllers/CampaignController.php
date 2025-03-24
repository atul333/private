<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Channel;
use Illuminate\Http\Request;

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
        $campaigns = auth()->user()->campaigns;
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
            'channel_id' => 'required|exists:channels,id',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0'
        ]);

        $campaign = Campaign::create([
            'user_id' => auth()->id(),
            'channel_id' => $validated['channel_id'],
            'duration' => $validated['duration'],
            'price' => $validated['price'],
            'status' => 'pending'
        ]);

        return redirect()->route('campaigns.index', ['user' => auth()->id()])
            ->with('status', 'Campaign created successfully!');

    }

    public function show($user, Campaign $campaign)
    {
        if (auth()->id() != $user) {
            abort(403, 'Unauthorized action.');
        }
        $this->authorize('view', $campaign);
        return view('campaigns.show', compact('campaign'));
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
            'name' => 'required|string|max:255',
            'budget' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'target_audience' => 'required|string',
            'description' => 'required|string'
        ]);

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