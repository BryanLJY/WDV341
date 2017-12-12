<?php
session_start();
if ($_SESSION['validUser'] == "yes")	//If this is a valid user allow access to this page
{	
	include 'dbConnect_mysqli.php';
	if(isset($_POST["submit"]))
	{	
		//The form has been submitted and needs to be processed
		
		//Get the name value pairs from the $_POST variable into PHP variables
		//The example uses variables with the same name as the name atribute from the form
		$meeting_fname = $_POST['meeting_fname'];
		$meeting_lname = $_POST['meeting_lname'];
		$meeting_email = $_POST['meeting_email'];
		$meeting_date = $_POST['meeting_date'];
		$meeting_time = $_POST['meeting_time'];
		$meeting_id = $_POST['meeting_id'];	//from the hidden field of the update form
		
		//Create the SQL UPDATE query or command  
		$sql = "UPDATE meetinginfo SET " ;
		$sql .= "meeting_fname=?, ";
		$sql .= "meeting_lname=?, ";
		$sql .= "meeting_email=?, ";
		$sql .= "meeting_date=?, ";
		$sql .= "meeting_time=? ";	//NOTE last one does NOT have a comma after it
		$sql .= " WHERE (meeting_id='$meeting_id')"; //VERY IMPORTANT  
		
		//echo "<h3>$sql</h3>";			//testing
	
		$query = $conn->prepare($sql);	//Prepare SQL query
	
		$query->bind_param('sssss',$meeting_fname,$meeting_lname,		
			$meeting_email,$meeting_date,$meeting_time);
	
		if ( $query->execute() )
		{
			$message = "<h1>Your meeting has been successfully UPDATED in the database.</h1>";
			$message .= "<p>Please <a href='selectMeeting.php'>view</a> your records.</p>";
		}
		else
		{
			$message = "<h1>You have encountered a problem.</h1>";
			$message .= "<h2 style='color:red'>" . mysqli_error($link) . "</h2>";
		}
				
	}//end if submitted
	else	
	{
		//The form needs to display the fields of the record to the user for changes
		$updateRecId = $_GET['recId'];	//Record Id to be updated
		//$updateRecId = 2;				//Hard code a key for testing purposes
		
		//echo "<h1>updateRecId: $updateRecId</h1>";
		
		//Finds a specific record in the table
		$sql = "SELECT meeting_id, meeting_fname,meeting_lname,meeting_email,meeting_date,meeting_time FROM meetinginfo WHERE meeting_id=?";	
		//echo "<p>The SQL Command: $sql </p>"; //For testing purposes as needed.
	
		$query = $conn->prepare($sql);
		
		$query->bind_param('i',$updateRecId);	
	
		if( $query->execute() )	//Run Query and Make sure the Query ran correctly
		{
			$query->bind_result($meeting_id, $meeting_fname,$meeting_lname,$meeting_email,$meeting_date,$meeting_time);
		
			$query->store_result();
			
			$query->fetch();
		}
		else
		{
			$message = "<h1>You have encountered a problem with your update.</h1>";
			$message .= "<h2>" . mysqli_error($conn) . "</h2>" ;			
		}
	
	}//end else submitted

}//end Valid User True

else
{
	//Invalid User attempting to access this page. Send person to Login Page
	header('Location: login.php');
}	
?>

<!DOCTYPE html>
<html>
<head>
<title>Bryan Lee - Update Meeting</title>
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
      <a href="scheduleMeeting.php">Schedule Meeting</a>
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Admin 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	  <a href="login.php">Login</a>
	  <a class="active" href="login.php">Admin Page</a>
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
        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-coffee fa-fw w3-margin-right w3-xxlarge w3-text-teal">
		</i>Update Meeting - updateRecId: <?php echo $updateRecId; ?></h2>
        <div class="w3-container">
          <div class="container">
<?php
//If the user submitted the form the changes have been made
if(isset($_POST["submit"]))
{
	echo $message;	//contains a Success or Failure output content
} 
else//end if submitted
{	//The page needs to display the form and associated data to the user for changes
?>
<form id="meetingForm" name="meetingForm" method="post" action="updateMeetingForm.php">
  <p>Update the following Meeting's Information.  Place the new information in the appropriate field(s)</p>
  <p>First Name: 
    <input type="text" name="meeting_fname" id="meeting_fname" 
    	value="<?php echo $meeting_fname; ?>"/>	<!-- PHP will put the name into the value of field-->
  </p>
  <p>Last Name:  
    <input type="text" name="meeting_lname" id="meeting_lname" 
    	value="<?php echo $meeting_lname; ?>" />
  </p>
  <p>Email:  
    <input type="text" name="meeting_email" id="meeting_email" 
       	value="<?php echo $meeting_email; ?>" />
  </p>
  <p>Meeting Date (DD/MM/YYYY): 
    <input type="text" name="meeting_date" id="meeting_date" 
        value="<?php echo $meeting_date; ?>" />
  </p>
  <p>Meeting Time: 
    <input type="text" name="meeting_time" id="meeting_time" 
    	value="<?php echo $meeting_time; ?>" />
  </p>
  
  	<!--The hidden form contains the record if for this record. 
    	You can use this hidden field to pass the value of record id 
        to the update page.  It will go as one of the name value
        pairs from the form.
    -->
  	<input type="hidden" name="meeting_id" id="meeting_id"
    	value="<?php echo $meeting_id ?>" />
  
  <p>
    <input type="submit" name="submit" id="submit" value="Update" />
    <input type="reset" name="button2" id="button2" value="Clear Form" />
  </p>
  <p>Return to <a href="selectMeeting.php">Meetings display</a></p>
</form>
<?php
}//end else submitted
$query->close();
$conn->close();
?>
</div>
		  <hr>
        </div>
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
