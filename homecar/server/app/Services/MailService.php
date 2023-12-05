<?php

namespace App\Services;

use App\Mail\BuyerApprove;
use App\Mail\BuyerConfirm;
use App\Mail\BuyerRefuse;
use App\Mail\RegisterMail;
use App\Mail\SellerApprove;
use App\Mail\SellerConfirm;
use App\Mail\SellerRefuse;
use App\Mail\VerifyMail;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public function sendMailRegister(
        $mail,
        $name,
        $verify_link,
    )
    {
        Mail::to($mail)->send(new RegisterMail($name, $verify_link));
    }

    public function sendMailVerify(
        $mail,
        $name,
        $login_link
    )
    {
        Mail::to($mail)->send(new VerifyMail($name, $login_link));
    }



    public function buyerApprove($mail)
    {
        Mail::to($mail)->send(new BuyerApprove());
    }

    public function buyerRefuse($mail)
    {
        Mail::to($mail)->send(new BuyerRefuse());
    }

    public function sellerConfirm($mail)
    {
        Mail::to($mail)->send(new SellerConfirm());
    }

    public function sellerApprove($mail)
    {
        Mail::to($mail)->send(new SellerApprove());
    }

    public function sellerRefuse($mail)
    {
        Mail::to($mail)->send(new SellerRefuse());
    }
}
