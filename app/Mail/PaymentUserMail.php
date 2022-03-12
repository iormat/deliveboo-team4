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
    // public $order;
    // public $customer;
    // public $user;
    // public $dishes;
    // public function __construct($order, $customer, $user, $dishes)
    // {
    //     $this -> order = $order;
    //     $this -> customer = $customer;
    //     $this -> user = $user;
    //     $this -> dishes = $dishes;
    // }

 public $order;
    public $customer;
    public $user;
    public function __construct($order, $customer, $user)
    {
        $this -> order = $order;
        $this -> customer = $customer;
        $this -> user = $user;
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
