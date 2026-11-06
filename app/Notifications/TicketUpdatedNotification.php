<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketUpdatedNotification extends Notification
{
    use Queueable;
     private $tickets;

    /**
     * Create a new notification instance.
     */
  
    public function __construct($tickets)
    {
   $this->tickets = $tickets;
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
     * Get the mail representation of the notification.
     */
     //public function toMail(object $notifiable): MailMessage
    // {
        // return (new MailMessage)
                  //  ->greeting("hello")
                   //  ->line('The introduction to the notification.')
                   // ->line('Thank you for using our application!');
    // }

    // /**
    //  * Get the array representation of the notification.
    //  *
    //  * @return array<string, mixed>
    //  */
    public function toArray(object $notifiable): array
    {
        return [
           
             $this->tickets['subject'].' Ticket Created'
        ];
    }
}
