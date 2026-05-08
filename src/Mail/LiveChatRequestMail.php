<?php

namespace Aranus\Chatbot\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LiveChatRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $sessionCode;
    public $requestTime;

    public function __construct($sessionCode, $requestTime = null)
    {
        $this->sessionCode = $sessionCode;
        $this->requestTime = $requestTime ?? now()->format('d M Y, H:i');
    }

    public function build()
    {
        return $this->subject('[Chatbot] Permintaan Live Chat Baru')
                    ->view('chatbot::mail.livechat-request', [
                        'sessionCode' => $this->sessionCode,
                        'requestTime' => $this->requestTime,
                    ]);
    }
}
