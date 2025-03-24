<?php

namespace App\Notifications;

use App\DocumentRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DocumentRequestApproved extends Notification
{
    use Queueable;

    protected $documentRequest;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(DocumentRequest $documentRequest)
    {
        $this->documentRequest = $documentRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->subject('Document Request Approved')
        ->line('Your request for ' . $this->documentRequest->document_type . ' has been approved.')
        ->line('Your request has been accepted, come for the document after 2 working days.')
        ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'document_request_id' => $this->documentRequest->id,
            'document_type' => $this->documentRequest->document_type,
            'message' => 'Your request has been accepted, come for the document after 2 working days.'
        ];
    }
}
