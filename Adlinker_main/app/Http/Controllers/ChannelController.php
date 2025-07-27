<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:publisher');
    }

    public function index()
    {
        $channels = auth()->user()->publisher->channels;
        return view('channels.index', compact('channels'));
    }

    public function create()
    {
        return view('channels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'link' => ['required', 'url', function ($attribute, $value, $fail) {
                // Remove any spaces from the URL
                $value = str_replace(' ', '', $value);
                if (!filter_var($value, FILTER_VALIDATE_URL)) {
                    $fail('The '.$attribute.' must be a valid URL.');
                }
            }],
            'description' => 'required|string',
            'price_1_day' => 'nullable|numeric|min:0',
            'price_2_days' => 'nullable|numeric|min:0',
            'price_3_days' => 'nullable|numeric|min:0',
            'price_7_days' => 'nullable|numeric|min:0',
            'logo' => 'nullable|image|max:2048'
        ]);
        
        // Set default subscribers count to 0
        $validated['subscribers_count'] = 0;

        // Clean and prepare the data
        $validated['link'] = str_replace(' ', '', $validated['link']);
        
        $channel = new Channel();
        $channel->fill($validated);
        $channel->publisher_id = auth()->user()->publisher->id;
        $channel->status = Channel::STATUS_MODERATION;

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('channel-logos', 'public');
            $channel->logo_path = $path;
        }

        $channel->save();

        return redirect()->to('/' . auth()->id() . '/publisher/dashboard')
            ->with('success', 'Channel has been submitted for moderation. We will review it shortly.');
    }

    public function show($user, Channel $channel)
    {
        if ($channel->publisher_id !== auth()->user()->publisher->id || $user != auth()->id()) {
            abort(403);
        }
        return view('channels.show', compact('channel'));
    }

    public function edit($user, Channel $channel)
    {
        if ($channel->publisher_id !== auth()->user()->publisher->id || $user != auth()->id()) {
            abort(403);
        }
        return view('channels.edit', compact('channel'));
    }

    public function update(Request $request, $user, Channel $channel)
    {
        if ($channel->publisher_id !== auth()->user()->publisher->id || $user != auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price_1_day' => 'nullable|numeric|min:0',
            'price_2_days' => 'nullable|numeric|min:0',
            'price_3_days' => 'nullable|numeric|min:0',
            'price_7_days' => 'nullable|numeric|min:0',
            'logo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('channel-logos', 'public');
            $channel->logo_path = $path;
        }

        $channel->fill($validated);
        $channel->touch(); // Update the updated_at timestamp
        $channel->save();

        return redirect()->route('channels.show', ['user' => auth()->id(), 'channel' => $channel])
            ->with('success', 'Channel updated successfully.');

    }

    public function destroy($user, Channel $channel)
    {
        if ($channel->publisher_id !== auth()->user()->publisher->id || $user != auth()->id()) {
            abort(403);
        }

        $channel->delete();

        return redirect()->to('/' . auth()->id() . '/publisher/dashboard')
            ->with('success', 'Channel deleted successfully.');
    }
}