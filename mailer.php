<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . '/vendor/autoload.php';
include("env.php");

$mail = new PHPMailer(TRUE);

$errors = [];
$errorMessage = '';


if (!empty($_POST)) {
   $name = $_POST['name'];
   $email = $_POST['email'];
   $subject = $_POST['subject'];
   $message = $_POST['message'];
   
   if (empty($name)) {
       $errors[] = 'Name is empty';
   }

   if (empty($email)) {
       $errors[] = 'Email is empty';
   } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $errors[] = 'Email is invalid';

   }


   if (empty($message)) {
       $errors[] = 'Message is empty';
   }

   if (!empty($errors)) {
       $allErrors = join('<br/>', $errors);
       $errorMessage = "<p style='color: red;'>{$allErrors}</p>";
   } else {
       $mail = new PHPMailer();


       // specify SMTP credentials


       $mail->isSMTP();
       $mail->Host = $MAIL_HOST;
       $mail->SMTPAuth = true;
       $mail->Username = $MAIL_USERNAME;
	   $mail->Password = $MAIL_PASSWORD;
       $mail->SMTPSecure = $MAIL_ENCRYPTION;
       $mail->Port = $MAIL_PORT;
       $mail->setFrom($MAIL_FROM_ADDRESS, $MAIL_FROM_NAME);
       $mail->addAddress($email, $name);
       $mail->Subject = $subject;

       // Enable HTML if needed
       $mail->isHTML(true);
       $bodyParagraphs = ["Name: {$name}", "Email: {$email}", "Message:", nl2br($message)];
       $body = join('<br />', $bodyParagraphs);
       $mail->Body = $body;
       echo $body;

       if($mail->send()){
           header('Location: index.html'); // Redirect to 'thank you' page. Make sure you have it
       } else {

           $errorMessage = 'Oops, something went wrong. Mailer Error: ' . $mail->ErrorInfo;
       }

   }

}