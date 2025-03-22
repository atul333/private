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
            'description' => 'required|string',
            'subscribers' => 'required|integer|min:0',
            'views' => 'required|integer|min:0'
        ]);

        $channel = new Channel($validated);
        $channel->status = 'active';
        $channel->publisher_id = auth()->user()->publisher->id;
        $channel->save();

        return redirect()->route('channels.show', $channel)
            ->with('success', 'Channel created successfully.');
    }

    public function show(Channel $channel)
    {
        if ($channel->publisher_id !== auth()->user()->publisher->id) {
            abort(403);
        }
        return view('channels.show', compact('channel'));
    }

    public function edit(Channel $channel)
    {
        if ($channel->publisher_id !== auth()->user()->publisher->id) {
            abort(403);
        }
        return view('channels.edit', compact('channel'));
    }

    public function update(Request $request, Channel $channel)
    {
        if ($channel->publisher_id !== auth()->user()->publisher->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:active,inactive'
        ]);

        $channel->update($validated);

        return redirect()->route('channels.show', $channel)
            ->with('success', 'Channel updated successfully.');
    }

    public function destroy(Channel $channel)
    {
        if ($channel->publisher_id !== auth()->user()->publisher->id) {
            abort(403);
        }

        $channel->delete();

        return redirect()->route('channels.index')
            ->with('success', 'Channel deleted successfully.');
    }
}