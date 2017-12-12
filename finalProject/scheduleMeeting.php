<?php
session_start();

//Only allow a valid user access to this page
if ($_SESSION['validUser'] == "yes") {
	
}
else {
	header('Location: login.php');
}

	//Setup the variables used by the page
		//field data
		//$meeting_id = "";
		$meeting_fname = "";
		$meeting_lname = "";
		$meeting_email = "";
		$meeting_date = "";         
		$meeting_time = "";
		
		//error messages
		//$idErrMsg = "";
		$fnameErrMsg = "";
		$lnameErrMsg = "";
		$emailErrMsg = "";
		$dateErrMsg = "";
		$timeErrMsg = "";
		
		$validForm = false;
		
	if(isset($_POST["submit"]))
	{
		//The form has been submitted and needs to be processed
		
		//Validate the form data here!
		
		//Get the name value pairs from the $_POST variable into PHP variables
		//This example uses PHP variables with the same name as the name atribute from the HTML form
		//$meeting_id = $_POST['meeting_id'];
		$meeting_fname = $_POST['meeting_fname'];
		$meeting_lname = $_POST['meeting_lname'];
		$meeting_email = $_POST['meeting_email'];
		$meeting_date = $_POST['meeting_date'];
		$meeting_time = $_POST['meeting_time'];
		
		/*	FORM VALIDATION PLAN
		
			FIELD NAME				VALIDATION TESTS & VALID RESPONSES
			Event ID				Required Field		May not be empty
			Event Name 				Required Field		May not be empty
			
			Event Description		Required Field
			Event Presenter			Required Field
			
			Event Date				Required Field		Format and Date
			Event Time				Required Field		Format and Time
		*/
		
		
		//VALIDATION FUNCTIONS		Use functions to contain the code for the field validations.
			/*
			function validateId($inID)
			{
				global $validForm, $idErrMsg;  //Use the GLOBAL Version of these variables instead of making them local
				$idErrMsg = "";
				
				if($inID == "")
				{
					$validForm = false;
					$idErrMsg = "ID invalid";	
				}
			}//end validateId()
			*/
			
			
			function validateFirstName($inFName)
			{
				global $validForm, $fnameErrMsg;		//Use the GLOBAL Version of these variables instead of making them local
				$fnameErrMsg = "";
				
				if($inFName == "")
				{
					$validForm = false;
					$fnameErrMsg = "First name required";
				}
			}//end validateFirstName()
			
			function validateLastName($inLName)
			{
				global $validForm, $lnameErrMsg;
				$lnameErrMsg = "";
				
				if($inLName == "")
				{
					$validForm = false;
					$lnameErrMsg = "Last Name required";
				}
			}//end validateLastName()
			
			function validateEmail($inEmail)
			{
				global $validForm, $emailErrMsg;
				$emailErrMsg = "";
				
				if($inEmail == "")
				{
					$validForm = false;
					$emailErrMsg = "Email required";
				}
			}//end validateEmail()
			
			function validateDate($inDate) //Make sure inDate is in 'm/d/Y' format
			{
				global $validForm, $dateErrMsg;
				$dateErrMsg = "";
				
				if($inDate == "")
				{
					$validForm = false;
					$dateErrMsg = "Date required";
				}
			}//end validateDate()
			
			function validateTime($inTime)
			{
				global $validForm, $timeErrMsg;
				$timeErrMsg = "";
				
				if($inTime == "")
				{
					$validForm = false;
					$timeErrMsg = "Time required";
				}
			}//end validateTime()
			
		// VALIDATE FORM DATE using functions defined above
		$validForm = true;		//switch for keeping track of any form validation errors
		
		//validateId($meeting_id);
		validateFirstName($meeting_fname);
		validateLastName($meeting_lname);
		validateEmail($meeting_email);
		validateDate($meeting_date);
		validateTime($meeting_time);
		
		if($validForm)
		{
			$message = "All good";
			
			try {
				require 'connectPDO.php'; //CONNECT to database
				
				//mysql DATE stores data in a YYYY-MM-DD format
				$todaysDate = date("Y-m-d");		//use today's date as the default input to the date( )
				
				//Create the SQL command string
				$sql = "INSERT INTO meetinginfo (";
				//$sql .= "meeting_id, ";
				$sql .= "meeting_fname, ";
				$sql .= "meeting_lname, ";
				$sql .= "meeting_email, ";
				$sql .= "meeting_date, ";
				$sql .= "meeting_time, ";
				$sql .= "meeting_dateAdded ";  //Last column does NOT have a comma after it
				$sql .= ") VALUES (:meeting_fname, :meeting_lname, :meeting_email, :meeting_date, :meeting_time, :meeting_dateAdded)";
				
				//PREPARE the sql statement
				$stmt = $conn->prepare($sql);
				
				//BIND the values to the input parameters of the prepared statement
				//$stmt->bindParam(':event_id', $event_id);
				$stmt->bindParam(':meeting_fname', $meeting_fname);		
				$stmt->bindParam(':meeting_lname', $meeting_lname);		
				$stmt->bindParam(':meeting_email', $meeting_email);		
				$stmt->bindParam(':meeting_date', $meeting_date);
				$stmt->bindParam(':meeting_time', $meeting_time);		
				$stmt->bindParam(':meeting_dateAdded', $todaysDate);	
				
				//EXECUTE the prepared statement
				$stmt->execute();
				
				$message = "The meeting has been scheduled.";
			}
			
			catch(PDOException $e)
			{
				$message = "There has been a problem. The system administrator has been contacted. Please try again later.";
	
				error_log($e->getMessage());			//Delivers a developer defined error message to the PHP log file at c:\xampp/php\logs\php_error_log
				error_log(var_dump(debug_backtrace()));
			
				//Clean up any variables or connections that have been left hanging by this error.		
			
				//header('Location: files/505_error_response_page.php');	//sends control to a User friendly page	
			}
		}
		else
		{
			$message = "Something went wrong";
		}//ends check for valid form
	}
	else{
		//Form has not been seen by the user. Display the form
	}//ends if submit
	
?>

<!DOCTYPE html>
<html>
<head>
<title>Bryan Lee - Schedule Meeting</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif}
body {margin:0;}

h2{
	color: #ddd;
}

.topnav {
  overflow: hidden;
  background-color: #009999;
}

.topnav a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
    background-color: #ddd;
    color: black;
}

input[type=text], select, textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-top: 6px;
    margin-bottom: 16px;
    resize: vertical;
}

input[type=submit] {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}

input[type=reset] {
    background-color: #4CAF50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=reset]:hover {
    background-color: #45a049;
}

.container {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
}

.dropdown {
    float: left;
    overflow: hidden;
}

.dropdown .dropbtn {
    font-size: 16px;    
    border: none;
    outline: none;
    color: white;
    padding: 14px 16px;
    background-color: inherit;
}

.navbar a:hover, .dropdown:hover .dropbtn {
    background-color: #ddd;
	color: black;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    float: none;
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}

.dropdown-content a:hover {
    background-color: #ddd;
}

.dropdown:hover .dropdown-content {
    display: block;
}

</style>
</head>
<body class="w3-light-grey">
<div class="topnav">
  <a href="index.html">Home</a>
  <a href="homework.html">Homework</a>
  <a href="about.html">About</a>
  <div class="dropdown">
    <button class="dropbtn">Contact Me 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	  <a href="contact.html">Contact Form</a>
      <a class="active" href="scheduleMeeting.php">Schedule Meeting</a>
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Admin 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	  <a href="login.php">Login</a>
	  <a href="login.php">Admin Page</a>
      <a href="logout.php">Logout</a>
    </div>
  </div>
</div>

<!-- Page Container -->
<div class="w3-content w3-margin-top" style="max-width:1400px;">

  <!-- The Grid -->
  <div class="w3-row-padding">
  
    <!-- Left Column -->
    <div class="w3-third">
    
      <div class="w3-white w3-text-grey w3-card-4">
        <div class="w3-display-container">
          <img src="images/bryan_lee.jpg" style="width:100%" alt="Bryan">
          <div class="w3-display-bottomleft w3-container w3-text-black">
            <h2>Bryan Lee</h2>
          </div>
        </div>
        <div class="w3-container">
          <p><i class="fa fa-user fa-fw w3-margin-right w3-large w3-text-teal"></i>Student at DMACC</p>
		  <p><i class="fa fa-briefcase fa-fw w3-margin-right w3-large w3-text-teal"></i>Intern at Computer Repair of Des Moines</p>
          <p><i class="fa fa-home fa-fw w3-margin-right w3-large w3-text-teal"></i>Des Moines, USA</p>
          <p><i class="fa fa-envelope fa-fw w3-margin-right w3-large w3-text-teal"></i>jennyang_22@hotmail.com</p>
          <p><i class="fa fa-phone fa-fw w3-margin-right w3-large w3-text-teal"></i>(515)707-5762</p>
          <hr>
          <br>
        </div>
      </div><br>

    <!-- End Left Column -->
    </div>

    <!-- Right Column -->
    <div class="w3-twothird">
    
      <div class="w3-container w3-card-2 w3-white w3-margin-bottom">
        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-coffee fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Schedule Meeting</h2>
        <div class="w3-container">
          <h5 class="w3-opacity"><b>Fill in the form below to schedule a meeting with me.</b></h5>
          <div class="container">
		  <?php
            //If the form was submitted and valid and properly put into database display the INSERT result message
			if($validForm)
			{
        ?>
            <h1><?php echo $message ?></h1>
			
        
        <?php
			}
			else	//display form
			{
        ?>
  <form id="scheduleMeeting" name="scheduleMeeting" method = "post" action="scheduleMeeting.php">
    <label for="meeting_fname">First Name</label>
    <input type="text" id="meeting_fname" name="meeting_fname" placeholder="John" value="<?php echo $meeting_fname; ?>" />
	<span class="errMsg"> <?php echo $fnameErrMsg; ?></span>
	
	<label for="meeting_lname">Last Name</label>
    <input type="text" id="meeting_lname" name="meeting_lname" placeholder="Doe" value="<?php echo $meeting_lname; ?>"  />
	<span class="errMsg"> <?php echo $lnameErrMsg; ?></span>
	
	<label for="meeting_email">Email</label>
    <input type="text" id="meeting_email" name="meeting_email" placeholder="someone@example.com" value="<?php echo $meeting_email; ?>"  />
	<span class="errMsg"> <?php echo $emailErrMsg; ?></span>
	
	<label for="meeting_date">Meeting Date</label>
    <input type="text" id="meeting_date" name="meeting_date" placeholder="MM/DD/YYYY" value="<?php echo $meeting_date; ?>"  />
	<span class="errMsg"> <?php echo $dateErrMsg; ?></span>
	
	<label for="meeting_time">Meeting Time</label>
    <input type="text" id="meeting_time" name="meeting_time" placeholder="9a.m." value="<?php echo $meeting_time; ?>"  />
	<span class="errMsg"> <?php echo $timeErrMsg; ?></span>


    

    <input type="submit" name="submit" id="submit" value="Schedule Meeting" />
	<input type="reset" name="button2" id="button2" value="Clear Form" onClick="clearForm()" />
  </form>
  <?php
			}//end else
        ?>  
</div>
		  <hr>
        </div>
      </div>
    <!-- End Right Column -->
    </div>
    
  <!-- End Grid -->
  </div>
  
  <!-- End Page Container -->
</div>



<footer class="w3-container w3-teal w3-center w3-margin-top">
  <p>Find me on social media.</p>
  <a href="https://www.facebook.com/bryan.j.lee.77"><i class="fa fa-facebook-official w3-hover-opacity"></i></a>
  <a href="https://www.linkedin.com/in/jenn-yang-lee-378b0560/"><i class="fa fa-linkedin w3-hover-opacity"></i></a>
  <p>Thanks for visiting and please contact me for more information!</p>
</footer>

</body>
</html>