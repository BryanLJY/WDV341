<!DOCTYPE html>
<html>
<body>

<h1>Unit 4 - Email</h1>

<h2>Your response has been sent, a confirmation email will be sent to your inbox.</h2>
<form action="/action_page.php">
    <label for="fname">First Name</label>
    <input type="text" id="firstname" name="firstname" placeholder="Your name..">
	</br>
	
	<label for="lname">Last Name</label>
    <input type="text" id="lastname" name="lastname" placeholder="Your last name..">
	</br>
	
	<label for="email">Email</label>
    <input type="text" id="email" name="email" placeholder="Primary email address..">
	</br>


    <label for="message">Comments</label>
    <textarea id="message" name="message" placeholder="Please write down your message.." style="height:200px"></textarea>
	</br>

    <input type="submit" value="Submit">
	
<?php		

		$email = $_REQUEST['email'];
		$message = $_REQUEST['message'];
		$firstName = $_REQUEST['firstname'];
		$lastName = $_REQUEST['lastname'];

    require("PHPMailer/class.phpmailer.php");

    $mail = new PHPMailer();

    $mail->IsSMTP();
    $mail->Host = "mail.drakeninjas.com";  // specify main and backup server
    $mail->SMTPAuth = true;     // turn on SMTP authentication
    $mail->Username = "bryan@bryan2.drakeninjas.com";  // SMTP username
    $mail->Password = "awesomedude"; // SMTP password

    $mail->From = $email;
    $mail->FromName = $lastName.', '.$firstName;

    $mail->AddAddress("jennyang_22@hotmail.com");
    $mail->Subject = "Entry from Unit 4 - Email";
    $mail->Body    = $message;

    $mail->Send();
	
	
	$mail2 = new PHPMailer();

    $mail2->IsSMTP();
    $mail2->Host = "mail.drakeninjas.com";  // specify main and backup server
    $mail2->SMTPAuth = true;     // turn on SMTP authentication
    $mail2->Username = "bryan@bryan2.drakeninjas.com";  // SMTP username
    $mail2->Password = "awesomedude"; // SMTP password

    $mail2->From = ("jennyang_22@hotmail");
    $mail2->FromName = "Bryan Lee";

    $mail2->AddAddress($email);
    $mail2->Subject = "Confirmation Email for Unit 4 - Email";
    $mail2->Body    = "This is your confirmation email. Your message was: ".$message;

    $mail2->Send();
?> 


</body>
</html>
