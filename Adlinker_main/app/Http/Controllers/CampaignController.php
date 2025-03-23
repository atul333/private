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

    public function index()
    {
        $campaigns = auth()->user()->campaigns;
        return view('campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        $channels = Channel::where('status', 'active')->get();
        return view('campaigns.create', compact('channels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'budget' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'target_audience' => 'required|string',
            'description' => 'required|string'
        ]);

$campaign = Campaign::create(array_merge($validated, ['user_id' => auth()->id()]));

        return redirect()->route('campaigns.show', $campaign)
            ->with('status', 'Campaign created successfully!');
    }

    public function show(Campaign $campaign)
    {
        $this->authorize('view', $campaign);
        return view('campaigns.show', compact('campaign'));
    }

    public function edit(Campaign $campaign)
    {
        $this->authorize('update', $campaign);
        return view('campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, Campaign $campaign)
    {
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

    public function destroy(Campaign $campaign)
    {
        $this->authorize('delete', $campaign);
        $campaign->delete();

        return redirect()->route('campaigns.index')
            ->with('status', 'Campaign deleted successfully!');
    }
}