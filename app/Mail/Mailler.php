<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Mailler extends Mailable
{
    use Queueable, SerializesModels;

    public $userInfo;
    public $viewName;
    public $subject;

    public function __construct($userInfo, $viewName, $subject)
    {
        $this->userInfo = $userInfo;
        $this->viewName = $viewName;
        $this->subject = $subject;
    }

    public function build()
    {
        return $this->view($this->viewName)
            ->subject($this->subject)
            ->with($this->userInfo);
    }
}
