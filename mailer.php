<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . '/vendor/autoload.php';
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
       $mail->Host = 'smtp.gmail.com';
       $mail->SMTPAuth = true;
       $mail->Username = 'killing.jokeXXIX@gmail.com';
	   $mail->Password = 'vwnwvpcitfnmfyqp';
       $mail->SMTPSecure = 'tls';
       $mail->Port = 587;
       $mail->setFrom('noreply@booking.io', 'BookMe');
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

/*try {
   
   $mail->setFrom('konehb.allicraXXIX@gmail.com', 'Konehb');
   $mail->addAddress('killing.jokeXXIX@gmail.com', 'Killing Joke');
   $mail->Subject = 'Force';
   $mail->Body = 'There is a great disturbance in the Force.';
   $mail->isSMTP();
   $mail->Host = 'smtp.booking.github.io';
   $mail->SMTPAuth = TRUE;
   $mail->SMTPSecure = 'tls';
   $mail->Username = 'killing.jokeXXIX@gmail.com';
   $mail->Password = 'pjhevxohtzqrhnuf';
   $mail->Port = 587;
   /*pjhe vxoh tzqr hnuf*/
   
   /* Enable SMTP debug output. */
 /*  $mail->SMTPDebug = 4;
   
   $mail->send();
}
catch (Exception $e)
{
   echo $e->errorMessage();
}
catch (\Exception $e)
{
   echo $e->getMessage();
}*/