<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Services\MailService;
use Illuminate\Http\Request;

class MailController extends Controller
{
    private $mail;

    public function __construct(MailService $mail)
    {
        $this->mail = $mail;
    }
    public function register()
    {
        $this->mail->sendMailRegister('test@gmail.com', 'test', 'verify_link');
    }

    public function verify()
    {
        $this->mail->sendMailVerify('test@gmail.com', 'test', 'login_link');
    }


}
