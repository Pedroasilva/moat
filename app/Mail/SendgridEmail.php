<?php

namespace App\Mail;

use SendGrid;
use SendGrid\Mail\Mail;
use Illuminate\Support\Facades\View;

use App\Mail\Email;

class SendgridEmail
{
    public $data;
    public $type;
    public $template;
    public $toEmail;
    public $toName;
    public $subject;
    public $fromEmail;
    public $fromName;

    /* 
     * 
     */
    public function __construct($type, $to, $subject, $data)
    {
        $this->setType($type);

        $this->data = $data;
        $this->toEmail = $to['email'];
        $this->toName = $to['name'];

        if ($subject == '') {
            $this->subject = "Alerta de ".env("APP_NAME");
        } else {
            $this->subject = $subject;
        }

        $this->fromEmail = "noreply@zuupy.app";
        $this->fromName = env("APP_NAME")." No-Reply";

        $this->setup();
    }


    public function setType($type)
    {
        $this->type = $type;
        $this->template = 'emails.'.$type;
    }


    public function setup()
    {
        $this->email = new Mail();
        $this->email->setFrom($this->fromEmail, $this->fromName);
        $this->email->setSubject($this->subject);
        $this->email->addTo($this->toEmail, $this->toName);

        $this->build();
    }


    public function build()
    {
        if (View::exists($this->template))
        {
            $body = View::make($this->template, $this->data)->render();

            $this->email->addContent("text/plain", "and easy to do anywhere, even with PHP");
            $this->email->addContent("text/html", $body);
        }
    }


    public function send()
    {
        if (View::exists($this->template))
        {
            $sendgrid = new SendGrid(env("SENDGRID_API_KEY"));

            try {
                $response = $sendgrid->send($this->email);
            } catch (Exception $e) {
                echo 'Caught exception: '. $e->getMessage() ."\n";
            }
        }
    }


    private function asJSON($data)
    {
        $json = json_encode($data);
        $json = preg_replace('/(["\]}])([,:])(["\[{])/', '$1$2 $3', $json);

        return $json;
    }


    private function asString($data)
    {
        $json = $this->asJSON($data);
        
        return wordwrap($json, 76, "\n   ");
    }
}