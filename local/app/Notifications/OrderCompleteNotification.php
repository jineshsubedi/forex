<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderCompleteNotification extends Notification
{
    use Queueable;
    public $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
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
            'message' => 'Thank You, '.\App\Models\User::getName($this->order->customer_id).' your order is completed!',
            'customer_id' => 1,
            'customer_name' =>  ucwords(\App\Models\User::getName(1)),
            'customer_photo' =>  ucwords(\App\Models\User::getPhoto(1)),
            'order_id' => $this->order->id,
            'total_amount' => $this->order->total_cost,
            'order_date' => $this->order->order_date,
            'created_at' => Carbon::parse($this->order->created_at)->format('d M, Y H:i a'),
        ];
    }
}
