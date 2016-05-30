<?php require_once('vendor/autoload.php');


define('DS',DIRECTORY_SEPARATOR);
define('ROOT', __DIR__.DS);
define('TEMPLATE_PATH',ROOT.'Templates'.DS);
define('FILES_PATH',ROOT.'Files'.DS);

define('ENABLE_DEBUGGING',false); //set false to true to enable debugging

if(ENABLE_DEBUGGING){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

$recipients = array(
			array('name' => 'Nathan','email'=>'codenathan@codenathan.com'),
			array('name' => 'John Doe', 'email' => 'johndoe@example.com'),
			array('email'=> 'foo@bar.com')
);

$data = array('name'=>'John Simth', 'author' => 'Codenathan');

$email = new EmailService();
$email->setTemplate('email');
$email->addRecipients($recipients);
$email->addCC('admin@codenathan.com');
$email->addAttachment(FILES_PATH.'attachment.txt');
$email->generateContent('This is a test email',$data);
//echo $email->getContent(); //uncomment this to view the content
$send = $email->sendEmail(); //send variable tells you if email was sent