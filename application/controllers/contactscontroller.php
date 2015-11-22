<?php
/**
 * Created by PhpStorm.
 * User: saurabh
 * Date: 1/10/15
 * Time: 9:04 AM
 */

class ContactsController extends Controller
{
    function index()
    {
        $this->set("title","Sevasetu | Contact Us");
        if(isset($$_POST['contact_submit']))
        {
            $email=new Email();
            $to="contact@sevasetu.org";
            $subject="Sevasetu Website Contact";
            $from=$_POST['Email'];
            $message=$_POST['Message'];
            $email->prepareMail($to,$subject,$message);
            if($email->sendTextMail()==true)
            {
                $this->set("response","Thank you for contacting SevaSetu");
            }
            else
            {
                $this->set("response","Sorry, something went wrong. Please try again.");
            }
        }
        else
        {
            $this->set("response",false);
        }
    }
}