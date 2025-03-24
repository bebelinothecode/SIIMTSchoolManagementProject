<?php

namespace App\Notifications;

use App\DocumentRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class DocumentRequestNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $documentRequest;

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
            ->subject('New Document Request')
            ->line('A student has submitted a new document request.')
            ->line('Document Type: ' . $this->documentRequest->document_type)
            ->line('Student: ' . $this->documentRequest->student->name)
            ->action('View Request', url('/admin/document-requests/' . $this->documentRequest->id))
            ->line('Please review this request at your earliest convenience.');
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
            'student_name' => $this->documentRequest->student->name,
            'document_type' => $this->documentRequest->document_type,
        ];
    }
}
