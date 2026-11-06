<?php
 
namespace App\Mail;
 
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
 
class MailNotify extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    
 
    /**
     * The order instance.
     *
     * @var \App\Models\Order
     */
    public $order;
 
    /**
     * Create a new message instance.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function __construct($details)
    {
       $this->details = $details;    
   }
 
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('NRIVA Tech Support Team')
                    ->view('mail');
    }
}