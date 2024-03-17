<?php

namespace App\Notifications;

use App\Models\Stock;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ImportantStockUpdate extends Notification
{
    use Queueable;

    private Stock $stock;

    /**
     * Create a new notification instance.
     */
    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Important Stock Update for ' . $this->stock->product->name)
            ->line('We have an important update to the product you have been tracking.')
            ->action('Buy It Now', url($this->stock->url))
            ->line('Go get it!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
