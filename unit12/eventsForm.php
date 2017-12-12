<?php
session_start();
/*
//Only allow a valid user access to this page
if ($_SESSION['validUser'] !== "yes") {
	header('Location: index.php');
}
*/

	//Setup the variables used by the page
		//field data
		//$event_id = "";
		$event_name = "";
		$event_description = "";
		$event_presenter = "";
		$event_date = "";         
		$event_time = "";
		
		//error messages
		//$idErrMsg = "";
		$nameErrMsg = "";
		$descriptionErrMsg = "";
		$presenterErrMsg = "";
		$dateErrMsg = "";
		$timeErrMsg = "";
		
		$validForm = false;
		
	if(isset($_POST["submit"]))
	{
		//The form has been submitted and needs to be processed
		
		//Validate the form data here!
		
		//Get the name value pairs from the $_POST variable into PHP variables
		//This example uses PHP variables with the same name as the name atribute from the HTML form
		//$event_id = $_POST['event_id'];
		$event_name = $_POST['event_name'];
		$event_description = $_POST['event_description'];
		$event_presenter = $_POST['event_presenter'];
		$event_date = $_POST['event_date'];
		$event_time = $_POST['event_time'];
		
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
			function validateEventId($inID)
			{
				global $validForm, $idErrMsg;  //Use the GLOBAL Version of these variables instead of making them local
				$idErrMsg = "";
				
				if($inID == "")
				{
					$validForm = false;
					$idErrMsg = "ID invalid";	
				}
			}//end validateEventId()
			*/
			
			
			function validateEventName($inName)
			{
				global $validForm, $nameErrMsg;		//Use the GLOBAL Version of these variables instead of making them local
				$nameErrMsg = "";
				
				if($inName == "")
				{
					$validForm = false;
					$nameErrMsg = "Event name required";
				}
			}//end validateEventName()
			
			function validateEventDesc($inDesc)
			{
				global $validForm, $descriptionErrMsg;
				$descriptionErrMsg = "";
				
				if($inDesc == "")
				{
					$validForm = false;
					$descriptionErrMsg = "Description required";
				}
			}//end validateEventDesc()
			
			function validateEventPresenter($inPresenter)
			{
				global $validForm, $presenterErrMsg;
				$presenterErrMsg = "";
				
				if($inPresenter == "")
				{
					$validForm = false;
					$presenterErrMsg = "Presenter name required";
				}
			}//end validateEventPresenter()
			
			function validateEventDate($inDate) //Make sure inDate is in 'm/d/Y' format
			{
				global $validForm, $dateErrMsg;
				$dateErrMsg = "";
				
				if($inDate == "")
				{
					$validForm = false;
					$dateErrMsg = "Event date required";
				}
			}//end validateEventDate()
			
			function validateEventTime($inTime)
			{
				global $validForm, $timeErrMsg;
				$timeErrMsg = "";
				
				if($inTime == "")
				{
					$validForm = false;
					$timeErrMsg = "Event time required";
				}
			}//end validateEventTime()
			
		// VALIDATE FORM DATE using functions defined above
		$validForm = true;		//switch for keeping track of any form validation errors
		
		//validateEventId($event_id);
		validateEventName($event_name);
		validateEventDesc($event_description);
		validateEventPresenter($event_presenter);
		validateEventDate($event_date);
		validateEventTime($event_time);
		
		if($validForm)
		{
			$message = "All good";
			
			try {
				require 'connectPDO.php'; //CONNECT to database
				
				//mysql DATE stores data in a YYYY-MM-DD format
				$todaysDate = date("Y-m-d");		//use today's date as the default input to the date( )
				
				//Create the SQL command string
				$sql = "INSERT INTO wdv341_event (";
				//$sql .= "event_id, ";
				$sql .= "event_name, ";
				$sql .= "event_description, ";
				$sql .= "event_presenter, ";
				$sql .= "event_date, ";
				$sql .= "event_time, ";
				$sql .= "event_dateAdded ";  //Last column does NOT have a comma after it
				$sql .= ") VALUES (:event_name, :event_description, :event_presenter, :event_date, :event_time, :event_dateAdded)";
				
				//PREPARE the sql statement
				$stmt = $conn->prepare($sql);
				
				//BIND the values to the input parameters of the prepared statement
				//$stmt->bindParam(':event_id', $event_id);
				$stmt->bindParam(':event_name', $event_name);		
				$stmt->bindParam(':event_description', $event_description);		
				$stmt->bindParam(':event_presenter', $event_presenter);		
				$stmt->bindParam(':event_date', $event_date);
				$stmt->bindParam(':event_time', $event_time);		
				$stmt->bindParam(':event_dateAdded', $todaysDate);	
				
				//EXECUTE the prepared statement
				$stmt->execute();
				
				$message = "The event has been registered.";
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

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<title>Presenting Information Technology</title>

	<link rel="stylesheet" href="css/pit.css">

</head>

<body>

<div id="container">

	<header>
    	<h1>Presenting Information Technology</h1>
    </header>
    
	<!--<?php //require 'includes/navigation.php' ?>-->
    
    <main>
    
        <h1>Add a new Event</h1>
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
        
        <p>Once the form is submitted and validated it will call the eventsForm.php page. That page will pull the form data into the PHP and <br>
		add a new record to the database.</p>
        <form id="eventsForm" name="eventsForm" method="post" action="eventsForm.php">
        	<fieldset>
              <legend>Add an Event</legend>
              <p>
                <label for="event_name">Event Name: </label>
                <input type="text" name="event_name" id="event_name" value="<?php echo $event_name;  ?>" /> 
                <span class="errMsg"> <?php echo $nameErrMsg; ?></span>
              </p>
              <p>
                <label for="event_description">Event Description: </label>  
                <input type="text" name="event_description" id="event_description" value="<?php echo $event_description;  ?>" />
                <span class="errMsg"><?php echo $descriptionErrMsg; ?></span>                
              </p>
              <p>
                <label for="event_presenter">Event Presenter: </label>
                <input type="text" name="event_presenter" id="event_presenter" value="<?php echo $event_presenter;  ?>" />
				<span class="errMsg"><?php echo $presenterErrMsg; ?></span>  
              </p>
              <p>
                <label for="event_date">Event Date(MM/DD/YYYY): </label> 
                <input type="text" name="event_date" id="event_date" value="<?php echo $event_date;  ?>"/>
				<span class="errMsg"><?php echo $dateErrMsg; ?></span>  
              </p>
              <p>
                <label for="event_time">Event Time: </label> 
                <input type="text" name="event_time" id="event_time" value="<?php echo $event_time;  ?>"/>
                <span class="errMsg"><?php echo $timeErrMsg; ?></span>                
              </p>
                       
              
            </fieldset>
         	<p>
            	<input type="submit" name="submit" id="submit" value="Add Event" />
            	<input type="reset" name="button2" id="button2" value="Clear Form" onClick="clearForm()" />
        	</p>  
        </form>
        <?php
			}//end else
        ?>    	
        
	</main>
    
	<footer>
    	<p>Copyright &copy; <script> var d = new Date(); document.write (d.getFullYear());</script> All Rights Reserved</p>
    
    </footer>




</div>
</body>
</html>