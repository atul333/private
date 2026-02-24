<?php

namespace App\Http\Controllers\Instagram\Publisher;

use App\Http\Controllers\Controller;
use App\Models\InstagramCampaign;
use App\Models\InstagramProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    /**
     * Submit story link for a campaign
     */
    public function submitStory(Request $request, $user, $profile, $campaign)
    {
        // Validate the request
        $validated = $request->validate([
            'story_link' => 'required|url|max:500',
        ]);

        // Find the campaign
        $campaignModel = InstagramCampaign::findOrFail($campaign);

        // Verify the campaign belongs to the authenticated user's profile
        $profileModel = InstagramProfile::where('id', $profile)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($campaignModel->instagram_profile_id !== $profileModel->id) {
            abort(403, 'Unauthorized action.');
        }

        // Verify the campaign is in approved status
        if ($campaignModel->status !== 'approved') {
            return back()->with('error', 'Campaign must be in approved status to submit story link.');
        }

        // Update the campaign with story link and set status to published
        $campaignModel->update([
            'story_link' => $validated['story_link'],
            'status' => 'published',
            'published_at' => now(),
        ]);

        return back()->with('success', 'Story link submitted successfully! The 24-hour countdown has started.');
    }
}
