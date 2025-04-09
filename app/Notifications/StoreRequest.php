<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StoreRequest extends Notification
{
    use Queueable;

    public $store, $requested_by_name;

    /**
     * Create a new notification instance.
     */
    public function __construct($store, $requested_by_name)
    {
        $this->store = $store;
        $this->requested_by_name = $requested_by_name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'store_id' => $this->store->id,
            'store_name' => $this->store->name,
            'requested_by' => $this->store->user_id,
            'name' => $this->requested_by_name,
            'status' => $this->store->status,
            'message' => 'A new store request has been submitted for approval.',
        ];
    }
}
