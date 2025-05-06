<?php

namespace App\Http\Controllers\Publisher;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Events\CampaignLinkSubmitted;
use Illuminate\Support\Facades\Log;

class CampaignActionController extends Controller
{
    public function accept(Campaign $campaign)
    {
        if ($campaign->status !== 'pending') {
            return back()->with('error', 'Campaign is not in pending status');
        }

        $campaign->update(['status' => 'active']);

        return redirect()->route('publisher.campaign.submit-link.form', ['campaign' => $campaign->id])
            ->with('success', 'Campaign has been accepted. Please submit your post link.');
    }

    public function reject(Campaign $campaign)
    {
        if ($campaign->status !== 'pending') {
            return back()->with('error', 'Campaign is not in pending status');
        }

        $campaign->update(['status' => 'rejected']);

        return back()->with('success', 'Campaign has been rejected');
    }

    public function showSubmitLinkForm(Campaign $campaign)
    {
        if ($campaign->status !== 'active') {
            return back()->with('error', 'Campaign must be active to submit post link');
        }

        return view('publisher.campaigns.submit-link', compact('campaign'));
    }

    public function submitLink(Request $request, Campaign $campaign)
    {
        if ($campaign->status !== 'active') {
            return back()->with('error', 'Campaign must be active to submit post link');
        }

        $request->validate([
            'post_link' => 'required|url',
            'notes' => 'nullable|string|max:1000'
        ]);

        try {
            $campaign->update([
                'post_link' => $request->post_link,
                'notes' => $request->notes,
                'post_submitted_at' => now(),
                'submission_timestamp' => now()
            ]);

            Log::info('Campaign link submitted', [
                'campaign_id' => $campaign->id,
                'advertiser_id' => $campaign->advertiser_id,
                'post_link' => $request->post_link
            ]);

            // Dispatch event for advertiser notification
            event(new CampaignLinkSubmitted($campaign, $request->post_link));

            Log::info('CampaignLinkSubmitted event dispatched', [
                'campaign_id' => $campaign->id,
                'advertiser_id' => $campaign->advertiser_id
            ]);

            return redirect()->route('publisher.channel.campaigns', [
                'user' => auth()->id(),
                'channel' => $campaign->channel_id
            ])->with('success', 'Post link submitted successfully');
        } catch (\Exception $e) {
            Log::error('Error submitting campaign link:', [
                'error' => $e->getMessage(),
                'campaign_id' => $campaign->id,
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'An error occurred while submitting the post link. Please try again.');
        }
    }
}