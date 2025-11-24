<?php

namespace App\Http\Controllers\Instagram\Publisher;

use App\Http\Controllers\Controller;
use App\Models\InstagramProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:publisher']);
    }

    /**
     * Show the form for creating a new Instagram profile.
     */
    public function create()
    {
        return view('instagram.publisher.profile.create');
    }

    /**
     * Store a newly created Instagram profile.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'instagram_id' => 'required|string|unique:instagram_profiles,instagram_id',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'followers' => 'required|integer|min:0',
            'price_per_story' => 'required|numeric|min:0',
            'mention_available' => 'boolean',
        ]);

        $profileData = [
            'user_id' => Auth::id(),
            'instagram_id' => $validated['instagram_id'],
            'followers' => $validated['followers'],
            'price_per_story' => $validated['price_per_story'],
            'mention_available' => $request->has('mention_available'),
            'is_active' => true,
        ];

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $profileData['profile_photo'] = $request->file('profile_photo')
                ->store('instagram/profiles', 'public');
        }

        InstagramProfile::create($profileData);

        return redirect()
            ->route('instagram.publisher.dashboard')
            ->with('success', 'Instagram profile added successfully!');
    }

    /**
     * Show the form for editing the specified Instagram profile.
     */
    public function edit(InstagramProfile $profile)
    {
        // Ensure the profile belongs to the authenticated user
        if ($profile->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('instagram.publisher.profile.edit', compact('profile'));
    }

    /**
     * Update the specified Instagram profile.
     */
    public function update(Request $request, InstagramProfile $profile)
    {
        // Ensure the profile belongs to the authenticated user
        if ($profile->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'instagram_id' => 'required|string|unique:instagram_profiles,instagram_id,' . $profile->id,
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'followers' => 'required|integer|min:0',
            'price_per_story' => 'required|numeric|min:0',
            'mention_available' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $profileData = [
            'instagram_id' => $validated['instagram_id'],
            'followers' => $validated['followers'],
            'price_per_story' => $validated['price_per_story'],
            'mention_available' => $request->has('mention_available'),
            'is_active' => $request->has('is_active'),
        ];

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($profile->profile_photo) {
                Storage::disk('public')->delete($profile->profile_photo);
            }
            
            $profileData['profile_photo'] = $request->file('profile_photo')
                ->store('instagram/profiles', 'public');
        }

        $profile->update($profileData);

        return redirect()
            ->route('instagram.publisher.dashboard')
            ->with('success', 'Instagram profile updated successfully!');
    }

    /**
     * Remove the specified Instagram profile.
     */
    public function destroy(InstagramProfile $profile)
    {
        // Ensure the profile belongs to the authenticated user
        if ($profile->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete profile photo if exists
        if ($profile->profile_photo) {
            Storage::disk('public')->delete($profile->profile_photo);
        }

        $profile->delete();

        return redirect()
            ->route('instagram.publisher.dashboard')
            ->with('success', 'Instagram profile deleted successfully!');
    }

    /**
     * View campaigns for a specific profile.
     */
    public function campaigns(InstagramProfile $profile)
    {
        // Ensure the profile belongs to the authenticated user
        if ($profile->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $campaigns = $profile->campaigns()
            ->with('advertiser')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('instagram.publisher.profile.campaigns', compact('profile', 'campaigns'));
    }
}
