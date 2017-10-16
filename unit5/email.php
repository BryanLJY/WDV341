<!DOCTYPE html>
<html>
<style>
body {
background-color: limegreen;
margin: 50px;
}
</style>

<body>

<h1>Unit 5 - Email Class</h1>

<h2>Your response has been sent</h2>
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
	
?> 


</body>
</html>
