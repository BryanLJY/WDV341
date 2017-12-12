<?php
session_start();
/*
if ($_SESSION['validUser'] == "yes")	//If this is a valid user allow access to this page
{	
*/
	include 'dbConnect_mysqli.php';
	if(isset($_POST["submit"]))
	{	
		//The form has been submitted and needs to be processed
		
		//Get the name value pairs from the $_POST variable into PHP variables
		//The example uses variables with the same name as the name atribute from the form
		$event_name = $_POST['event_name'];
		$event_description = $_POST['event_description'];
		$event_presenter = $_POST['event_presenter'];
		$event_date = $_POST['event_date'];
		$event_time = $_POST['event_time'];
		$event_id = $_POST['event_id'];	//from the hidden field of the update form
		
		//Create the SQL UPDATE query or command  
		$sql = "UPDATE wdv341_event SET " ;
		$sql .= "event_name=?, ";
		$sql .= "event_description=?, ";
		$sql .= "event_presenter=?, ";
		$sql .= "event_date=?, ";
		$sql .= "event_time=? ";	//NOTE last one does NOT have a comma after it
		$sql .= " WHERE (event_id='$event_id')"; //VERY IMPORTANT  
		
		//echo "<h3>$sql</h3>";			//testing
	
		$query = $conn->prepare($sql);	//Prepare SQL query
	
		$query->bind_param('sssss',$event_name,$event_description,		
			$event_presenter,$event_date,$event_time);
	
		if ( $query->execute() )
		{
			$message = "<h1>Your record has been successfully UPDATED the database.</h1>";
			$message .= "<p>Please <a href='selectEvents.php'>view</a> your records.</p>";
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
		
		echo "<h1>updateRecId: $updateRecId</h1>";
		
		//Finds a specific record in the table
		$sql = "SELECT event_id, event_name,event_description,event_presenter,event_date,event_time FROM wdv341_event WHERE event_id=?";	
		//echo "<p>The SQL Command: $sql </p>"; //For testing purposes as needed.
	
		$query = $conn->prepare($sql);
		
		$query->bind_param('i',$updateRecId);	
	
		if( $query->execute() )	//Run Query and Make sure the Query ran correctly
		{
			$query->bind_result($event_id, $event_name,$event_description,$event_presenter,$event_date,$event_time);
		
			$query->store_result();
			
			$query->fetch();
		}
		else
		{
			$message = "<h1>You have encountered a problem with your update.</h1>";
			$message .= "<h2>" . mysqli_error($conn) . "</h2>" ;			
		}
	
	}//end else submitted
/*
}//end Valid User True

else
{
	//Invalid User attempting to access this page. Send person to Login Page
	header('Location: presentersLogin.php');
}	
*/
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WDV341 Intro PHP - Update Form</title>
</head>

<body>
<h1>WDV341 Intro PHP</h1>
<h1>Update Form</h1>
<h3>UPDATE Form for Changing information on a Events</h3>
<!--
<p>This page is called from the presentersSelectView.php page when you click on the Update link of a presenter. That page attaches the presenter_id to the URL of this page making it a GET parameter.</p>
<p>This page uses that information to SELECT the requested record from the database. Then PHP is used to pull the various column values for the record and place them in the form fields as their default values. </p>
<p>The user/customer can make changes as needed or leave the information as is. When the form is submitted and validated it will update the record in the database.</p>
<p>Notice that this form uses a hidden field. The value of this hidden field contains the presenter_id. It is passed as one of the form name-value pairs. The submitted page will use that value to determine which record to update on the database.</p>
-->
<?php
//If the user submitted the form the changes have been made
if(isset($_POST["submit"]))
{
	echo $message;	//contains a Success or Failure output content
}//end if submitted

else
{	//The page needs to display the form and associated data to the user for changes
?>
<form id="eventsForm" name="eventsForm" method="post" action="updateEventForm.php">
  <p>Update the following Events's Information.  Place the new information in the appropriate field(s)</p>
  <p>Event Name: 
    <input type="text" name="event_name" id="event_name" 
    	value="<?php echo $event_name; ?>"/>	<!-- PHP will put the name into the value of field-->
  </p>
  <p>Event Description:  
    <input type="text" name="event_description" id="event_description" 
    	value="<?php echo $event_description; ?>" />
  </p>
  <p>Event Presenter:  
    <input type="text" name="event_presenter" id="event_presenter" 
       	value="<?php echo $event_presenter; ?>" />
  </p>
  <p>Event Date (DD/MM/YYYY): 
    <input type="text" name="event_date" id="event_date" 
        value="<?php echo $event_date; ?>" />
  </p>
  <p>Event Time: 
    <input type="text" name="event_time" id="event_time" 
    	value="<?php echo $event_time; ?>" />
  </p>
  
  	<!--The hidden form contains the record if for this record. 
    	You can use this hidden field to pass the value of record id 
        to the update page.  It will go as one of the name value
        pairs from the form.
    -->
  	<input type="hidden" name="event_id" id="event_id"
    	value="<?php echo $event_id ?>" />
  
  <p>
    <input type="submit" name="submit" id="submit" value="Update" />
    <input type="reset" name="button2" id="button2" value="Clear Form" />
  </p>
</form>

<?php
}//end else submitted
$query->close();
$conn->close();
?>
<p>Return to <a href="selectEvents.php">Events display</a></p>
</body>
</html>
