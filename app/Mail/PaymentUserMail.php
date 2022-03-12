<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentUserMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $order;
    public $customer;
    public $user;
    public $orderDishesInfo;

    public function __construct($order, $customer, $user, $orderDishesInfo) {
        $this -> order = $order;
        $this -> customer = $customer;
        $this -> user = $user;
        $this -> orderDishesInfo = $orderDishesInfo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this -> from('admin@deliverboo.com')
                     -> view('mails.paymentUserMail');
    }
}
