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
            'price_per_story' => 'required|numeric|min:0',
            'mention_available' => 'nullable',
        ]);

        $profileData = [
            'user_id' => Auth::id(),
            'instagram_id' => $validated['instagram_id'],
            'followers' => 0, // Default to 0, will be fetched from Instagram API
            'price_per_story' => $validated['price_per_story'],
            'mention_available' => $request->has('mention_available'),
            'is_active' => true,
            'status' => 'moderation', // New profiles go to moderation
        ];

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $profileData['profile_photo'] = $request->file('profile_photo')
                ->store('instagram/profiles', 'public');
        }

        InstagramProfile::create($profileData);

        return redirect()
            ->route('instagram.publisher.dashboard', ['user' => Auth::id()])
            ->with('success', 'Instagram profile added successfully!');
    }

    /**
     * Show the form for editing the specified Instagram profile.
     */
    public function edit($user, $profile)
    {
        $profile = InstagramProfile::findOrFail($profile);
        
        // Ensure the profile belongs to the authenticated user
        if ($profile->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('instagram.publisher.profile.edit', compact('profile'));
    }

    /**
     * Update the specified Instagram profile.
     */
    public function update(Request $request, $user, $profile)
    {
        $profile = InstagramProfile::findOrFail($profile);
        
        // Ensure the profile belongs to the authenticated user
        if ($profile->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'instagram_id' => 'required|string|unique:instagram_profiles,instagram_id,' . $profile->id,
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'price_per_story' => 'required|numeric|min:0',
            'mention_available' => 'nullable',
            'is_active' => 'nullable',
        ]);

        $profileData = [
            'instagram_id' => $validated['instagram_id'],
            'price_per_story' => $validated['price_per_story'],
            'mention_available' => $request->has('mention_available'),
            'is_active' => $request->input('is_active') == '1',
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
            ->route('instagram.publisher.dashboard', ['user' => Auth::id()])
            ->with('success', 'Instagram profile updated successfully!');
    }

    /**
     * Remove the specified Instagram profile.
     */
    public function destroy($user, $profile)
    {
        $profile = InstagramProfile::findOrFail($profile);
        
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
            ->route('instagram.publisher.dashboard', ['user' => Auth::id()])
            ->with('success', 'Instagram profile deleted successfully!');
    }

    /**
     * View campaigns for a specific profile.
     */
    public function campaigns($user, $profile)
    {
        $profile = InstagramProfile::findOrFail($profile);
        
        // Ensure the profile belongs to the authenticated user
        if ($profile->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Auto-expire: pending OR approved campaigns not completed within 24h of creation → refund advertiser
        $expiredCampaigns = \App\Models\InstagramCampaign::where('instagram_profile_id', $profile->id)
            ->whereIn('status', ['pending', 'approved'])
            ->where('paid', true)
            ->where('created_at', '<=', now()->subHours(24))
            ->get();

        foreach ($expiredCampaigns as $campaign) {
            $campaign->update(['status' => 'expired']);

            $advertiser = \App\Models\User::find($campaign->advertiser_id);
            if ($advertiser && $advertiser->wallet) {
                $instagramId = '@' . $profile->instagram_id;
                $reason = $campaign->status === 'approved'
                    ? 'publisher approved but did not submit story link within 24 hours'
                    : 'publisher did not respond within 24 hours';
                $refundDesc = "[Instagram] Refund for expired Campaign #{$campaign->id} on {$instagramId} — {$reason}";
                $advertiser->wallet->deposit($campaign->price, $refundDesc);
            }
        }

        // Auto-complete published campaigns older than 24 hours
        $completedCampaigns = \App\Models\InstagramCampaign::where('instagram_profile_id', $profile->id)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now()->subHours(24))
            ->get();

        foreach ($completedCampaigns as $campaign) {
            $campaign->update(['status' => 'completed']);

            if ($campaign->paid && $campaign->publisher_id) {
                $publisherUser = \App\Models\User::find($campaign->publisher_id);
                if ($publisherUser && $publisherUser->wallet) {
                    $instagramId = '@' . $profile->instagram_id;
                    $depositDesc = "[Instagram] Campaign #{$campaign->id} completed on {$instagramId}";
                    $publisherUser->wallet->deposit($campaign->price, $depositDesc);
                }
            }
        }

        // Show only paid campaigns to publishers (include expired so publisher sees history)
        $campaigns = $profile->campaigns()
            ->where('paid', true)
            ->with('advertiser')
            ->orderByRaw("CASE
                WHEN status = 'pending' THEN 1
                WHEN status = 'approved' THEN 2
                WHEN status = 'published' THEN 3
                WHEN status = 'completed' THEN 4
                WHEN status = 'rejected' THEN 5
                WHEN status = 'expired' THEN 6
                ELSE 7
            END")
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('instagram.publisher.profile.campaigns', compact('profile', 'campaigns'));
    }

    /**
     * Approve a campaign.
     */
    public function approveCampaign($user, $profile, $campaign)
    {
        $profile = InstagramProfile::findOrFail($profile);
        $campaign = \App\Models\InstagramCampaign::findOrFail($campaign);

        // Ensure the profile belongs to the authenticated user
        if ($profile->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Ensure the campaign belongs to this profile
        if ($campaign->instagram_profile_id !== $profile->id) {
            abort(403, 'Unauthorized action.');
        }

        // Check if campaign is paid and pending
        if (!$campaign->paid) {
            return redirect()
                ->back()
                ->with('error', 'Campaign must be paid before approval.');
        }

        if ($campaign->status !== 'pending') {
            return redirect()
                ->back()
                ->with('error', 'Only pending campaigns can be approved.');
        }

        $campaign->update(['status' => 'approved']);

        return redirect()
            ->back()
            ->with('success', 'Campaign approved successfully!');
    }

    /**
     * Reject a campaign.
     */
    public function rejectCampaign($user, $profile, $campaign)
    {
        $profile = InstagramProfile::findOrFail($profile);
        $campaign = \App\Models\InstagramCampaign::findOrFail($campaign);

        // Ensure the profile belongs to the authenticated user
        if ($profile->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Ensure the campaign belongs to this profile
        if ($campaign->instagram_profile_id !== $profile->id) {
            abort(403, 'Unauthorized action.');
        }

        if ($campaign->status !== 'pending') {
            return redirect()
                ->back()
                ->with('error', 'Only pending campaigns can be rejected.');
        }

        // Refund the advertiser if campaign was paid
        if ($campaign->paid) {
            $advertiser = $campaign->advertiser;
            $wallet = $advertiser->wallet;
            
            if ($wallet) {
                // Refund the campaign price to advertiser's wallet
                $refunded = $wallet->deposit(
                    $campaign->price, 
                    "[Instagram] Refund for rejected campaign #{$campaign->id}"
                );
                
                if (!$refunded) {
                    return redirect()
                        ->back()
                        ->with('error', 'Failed to process refund. Please try again.');
                }
            }
        }

        $campaign->update(['status' => 'rejected']);

        return redirect()
            ->back()
            ->with('success', 'Campaign rejected and refund processed successfully.');
    }

    /**
     * Submit story link and start countdown.
     */
    public function submitStoryLink(Request $request, $user, $profile, $campaign)
    {
        $profile = InstagramProfile::findOrFail($profile);
        $campaign = \App\Models\InstagramCampaign::findOrFail($campaign);

        // Ensure the profile belongs to the authenticated user
        if ($profile->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Ensure the campaign belongs to this profile
        if ($campaign->instagram_profile_id !== $profile->id) {
            abort(403, 'Unauthorized action.');
        }

        // Validate story link
        $validated = $request->validate([
            'story_link' => 'required|url',
        ]);

        // Check if campaign is approved
        if ($campaign->status !== 'approved') {
            return redirect()
                ->back()
                ->with('error', 'Only approved campaigns can have story links submitted.');
        }

        // Update campaign with story link and published timestamp
        $campaign->update([
            'story_link' => $validated['story_link'],
            'published_at' => now(),
            'status' => 'published',
        ]);

        return redirect()
            ->back()
            ->with('success', 'Story link submitted! Campaign will complete in 24 hours.');
    }

    /**
     * Download campaign media file with correct filename and extension.
     */
    public function downloadMedia($user, $profile, $campaign)
    {
        $profile = InstagramProfile::findOrFail($profile);
        $campaign = \App\Models\InstagramCampaign::findOrFail($campaign);

        // Ensure the profile belongs to the authenticated user
        if ($profile->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Ensure the campaign belongs to this profile
        if ($campaign->instagram_profile_id !== $profile->id) {
            abort(403, 'Unauthorized action.');
        }

        // Check file exists in storage
        if (!Storage::disk('public')->exists($campaign->media_file)) {
            abort(404, 'Media file not found.');
        }

        // Build a descriptive download filename like: instagram-campaign-1-@atul_k_333.jpg
        $extension   = pathinfo($campaign->media_file, PATHINFO_EXTENSION);
        $profileHandle = '@' . preg_replace('/[^a-zA-Z0-9_.]/', '_', $profile->instagram_id);
        $downloadName = 'instagram-campaign-' . $campaign->id . '-' . $profileHandle . '.' . $extension;

        return Storage::disk('public')->download($campaign->media_file, $downloadName);
    }
}
