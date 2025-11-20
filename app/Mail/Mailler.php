<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;

class Mailler extends Mailable
{
    use Queueable, SerializesModels;

    public $userInfo;
    public $viewName;
    public $subject;
    public $locale;
    public $subjectKey;

    public function __construct($userInfo, $viewName, $subject, $locale = null, $subjectKey = null)
    {
        $this->userInfo = $userInfo;
        $this->viewName = $viewName;
        $this->subject = $subject;
        $this->locale = $locale;
        $this->subjectKey = $subjectKey;
    }

    public function build()
    {
        // Eğer locale belirtilmişse, mail gönderilirken locale'i ayarla
        if ($this->locale) {
            App::setLocale($this->locale);
        }

        // Subject'i belirle: eğer subjectKey varsa onu kullan, yoksa mevcut subject'i kullan
        $finalSubject = $this->subjectKey ? __($this->subjectKey) : $this->subject;

        return $this->view($this->viewName)
            ->subject($finalSubject)
            ->with($this->userInfo);
    }
}
