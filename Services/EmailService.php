<?php

Class EmailService{
    private $config;
    private $mail;
    private $template;
    private $content;

    public function __construct(){
        $this->config = require(ROOT.'config.php'); // change this to however you would like.
        $this->mail = new PHPMailer();
        return $this;
    }

    public function setTemplate($template_name){
        $this->template = $template_name; //template name
        return $this;
    }

    public function addRecipients($users){
        foreach($users as $recipients){
            if(isset($recipients['name'])) {
                $this->mail->AddAddress($recipients['email'], $recipients['name']);  // Add a recipient
            }else{
               $this->mail->AddAddress($recipients['email']);// Name is optional
            }   
        }
        return $this;
    }

    public function addCC($email,$name=false){
        $this->mail->addCC($email,$name);
        return $this;
    }

    public function addAttachment($path=false){
        //$this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        if($path!=false)  $this->mail->AddAttachment($path); //ensure you give absolute path not relative path
        return $this;
    }

    public function generateContent($subject,$data){
        $template = new TemplateService();
        $content = $template->render_template($this->template.'.twig',$data);
        $this->mail->Subject    = $subject;
        $this->mail->Body       = $content;
        $this->content          = $content;
        return $this;
    }

    public function getContent(){
        return $this->content;
    }

    public function sendEmail(){
        $this->mail->IsSMTP();                                      // Set mailer to use SMTP
        //$this->mail->SMTPDebug = 2;
        $this->mail->Host = $this->config['email']['host'];     // Specify main and backup server
        $this->mail->Port = $this->config['email']['port'];      // Set the SMTP port
        $this->mail->SMTPAuth = true;                               // Enable SMTP authentication
        $this->mail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent, reduces SMTP overhead
        $this->mail->Username = $this->config['email']['username'];             // SMTP username
        $this->mail->Password = $this->config['email']['password'];                // SMTP password
        $this->mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

        $this->mail->From =  $this->config['email']['from_email'];
        $this->mail->FromName = $this->config['email']['from_name'];



        $this->mail->IsHTML(true);                                  // Set email format to HTML


        if(!$this->mail->Send()) {
            $status = false;

            // echo 'Message could not be sent.';
            // echo 'Mailer Error: ' . $this->mail->ErrorInfo;
        }else{

            $status = true;
            // echo 'Message has been sent';
        }

        $this->mail->clearAllRecipients();
        $this->mail->clearAddresses();
        $this->mail->clearAttachments();

        return $status;
    }

}