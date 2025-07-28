<?php

include '../connection.php';

$cname = $_POST['conname'];
$cemail = $_POST['conemail'];
$cmsg = $_POST['conmsg'];

$sql = "INSERT INTO contact(`name` , `email` , `message`) VALUES ('{$cname}' , '{$cemail}' , '{$cmsg}')";
$result = mysqli_query($con, $sql);

//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader (created by composer, not included with PHPMailer)
require '../../vendor/autoload.php';


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);






try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'yousha.mirza328@gmail.com';                     //SMTP username
    $mail->Password   = 'garofwmqaujqwufq';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->addAddress('yousha.mirza328@gmail.com', 'Yusha Mirza'); 
    $mail->setFrom($cemail, $cname);

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Contact Message from User';
    $mail->Body    = $cmsg;

    $mail->send();
    echo '<script>alert("Message Has Been Sent!")</script>';
    header("Location: ../Profile_Pages/contact.php");
    exit();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}