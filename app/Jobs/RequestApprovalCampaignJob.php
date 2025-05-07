<?php
namespace App\Jobs;

use App\Mail\ApprovalMail;
use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class RequestApprovalCampaignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $campaign;
    protected $owner;
    /**
     * Create a new job instance.
     */
    public function __construct($owner, $campaign)
    {
        $this->campaign = $campaign;
        $this->owner    = $owner;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $campaign = Campaign::findOrFail($this->campaign);
        Mail::to($this->owner)->send(new ApprovalMail($campaign));
    }
}
