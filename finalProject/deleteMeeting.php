<?php
session_start();
if ($_SESSION['validUser'] == "yes")	//If this is a valid user allow access to this page
{

	$deleteRecId = $_GET['recId'];	//Pull the event_id from the GET parameter
	
	include 'dbConnect_mysqli.php';		//connects to the database
	
	$sql = "DELETE FROM meetinginfo WHERE meeting_id = ?";
	//echo "<p>The SQL Command: $sql </p>";     //testing
	
	$query = $conn->prepare($sql);	//prepare the statement
	
	$query->bind_param('i',$deleteRecId);	//bind the parameter to the statement
	
	if ( $query->execute() )			//process the query
	{
		$message =  "<h1>Your meeting has been successfully deleted.</h1>";
		$message .= "<h3>Please <a href='selectMeeting.php'>view</a> your records.</h3>";	
	}
	else
	{
		$message = "<h1>You have encountered a problem with your delete.</h1>";
		$message .= "<h2 style='color:red'>" . mysqli_error($link) . "</h2>";
	}
	$query->close();
	$conn->close();	//close the database connection

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
<title>Bryan Lee - Delete Meeting</title>
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
        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-coffee fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Delete Meeting</h2>
        <div class="w3-container">
          <div class="container">
<h2>
	<?php echo $message; ?>
</h2>
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

