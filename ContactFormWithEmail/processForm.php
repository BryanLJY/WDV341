<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>WDV341 Intro PHP - Form Processing</title>
</head>

<body>
<h1>WDV341 Intro PHP</h1>
<h2>Programming Project - Contact Form</h2>
<h3>Your response is saved and sent to the administrator. A confirmation email has been sent to your email.</h3>
<h3>We look forward to get in contact with you.</h3>
<p>&nbsp;</p>
</body>
</html>

<?php

	$name = $_REQUEST['textfield'];
	$email = $_REQUEST['textfield2'];
	$reason = $_REQUEST['select2'];
	$comment = $_REQUEST['textarea'];
	$mailingList = $_REQUEST['checkbox'];
	$information = $_REQUEST['checkbox2'];
	
    require("PHPMailer/class.phpmailer.php");

    $mail = new PHPMailer();
	
	$mail->IsSMTP();
    $mail->Host = "mail.drakeninjas.com";  // specify main and backup server
    $mail->SMTPAuth = true;     // turn on SMTP authentication
    $mail->Username = "bryan@bryan2.drakeninjas.com";  // SMTP username
    $mail->Password = "awesomedude"; // SMTP password
	
	$mail->From = $email;
    $mail->FromName = $name;
	
	$mail->AddAddress("jennyang_22@hotmail.com");
    $mail->Subject = "Response from contact form";
    $mail->Body    = "Reason for contact: ".$reason."    Comment: ".$comment."      Mailing List: ".$mailingList."      Information Request: ".$information;

	$mail->Send();
	
	//Send second mail
	$mail2 = new PHPMailer();

    $mail2->IsSMTP();
    $mail2->Host = "mail.drakeninjas.com";  // specify main and backup server
    $mail2->SMTPAuth = true;     // turn on SMTP authentication
    $mail2->Username = "bryan@bryan2.drakeninjas.com";  // SMTP username
    $mail2->Password = "awesomedude"; // SMTP password

    $mail2->From = ("jennyang_22@hotmail");
    $mail2->FromName = "Bryan Lee";
	
	$mail2->AddAddress($email);
    $mail2->Subject = "We have received your response - WDV341";
    $mail2->Body    = "This is your confirmation email. Your response has been sent.";

    $mail2->Send();
	
?>