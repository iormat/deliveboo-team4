<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentCustomerMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $order;
    public $customer;
    public $dishes;

    public function __construct($order, $customer,$dishes)
    {
        $this -> order = $order;
        $this -> customer = $customer;
        $this -> dishes = $dishes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this -> from('admin@deliverboo.com')
                     -> view('mails.paymentCustomerMail');
    }
}
