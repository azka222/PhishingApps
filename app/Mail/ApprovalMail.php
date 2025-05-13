<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $campaign;
    /**
     * Create a new message instance.
     */

    public function __construct($campaign)
    {
        $this->campaign = $campaign;

    }

    public function build()
    {
        $approveUrl = url("/approval/{$this->campaign->id}/approve?token={$this->campaign->token}");
        $rejectUrl  = url("/approval/{$this->campaign->id}/reject?token={$this->campaign->token}");

        $json = json_decode($this->campaign->data);
        $jsonName = $json->name;
        return $this->view('mail.approval')
            ->with([
                'campaignName' => $jsonName,
                'approveUrl'   => $approveUrl,
                'rejectUrl'    => $rejectUrl,
            ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Approval Mail',
        );
    }

    /**
     * Get the message content definition.
     */

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
