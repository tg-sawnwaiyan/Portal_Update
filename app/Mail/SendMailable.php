<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $getCustomer;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($getCustomer)
    {
        $this->getCustomer = $getCustomer;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    { return $this->view(['mail.mail','mail.mailplaintext'])
       
                    ->subject('[TIS ティーズ]事業者新規登録確認');
    }
}
