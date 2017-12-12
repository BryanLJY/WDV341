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
		//$cust_id = "";
		$cust_email = "";
		$cust_pref1 = "";
		$cust_pref2 = "";
		$cust_pref3 = "";         
		$cust_pref4 = "";
		//$cust_input_date = "";
		
		//error messages
		//$idErrMsg = "";
		$emailErrMsg = "";
		$pref1ErrMsg = "";
		$pref2ErrMsg = "";
		$pref3ErrMsg = "";
		$pref4ErrMsg = "";
		$dateErrMsg = "";
		
		$validForm = false;
		
	if(isset($_POST["submit"]))
	{
		//The form has been submitted and needs to be processed
		
		//Validate the form data here!
		
		//Get the name value pairs from the $_POST variable into PHP variables
		//This example uses PHP variables with the same name as the name atribute from the HTML form
		//$cust_id = $_POST['cust_id'];
		$cust_email = $_POST['cust_email'];
		$cust_pref1 = $_POST['cust_pref1'];
		$cust_pref2 = $_POST['cust_pref2'];
		$cust_pref3 = $_POST['cust_pref3'];
		$cust_pref4 = $_POST['cust_pref4'];
		//$cust_input_date = $_POST['cust_input_date'];
		
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
			function validateCustId($inID)
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
			
			
			function validateCustEmail($inEmail)
			{
				global $validForm, $emailErrMsg;		//Use the GLOBAL Version of these variables instead of making them local
				$emailErrMsg = "";
				
				if($inEmail == "")
				{
					$validForm = false;
					$emailErrMsg = "Email invalid";
				}
			}//end validateCustEmail()
			
			function validateCustPref1($inPref1)
			{
				global $validForm, $pref1ErrMsg;
				$pref1ErrMsg = "";
				
				if($inPref1 == "")
				{
					$validForm = false;
					$pref1ErrMsg = "Please select a preference score";
				}
			}//end validateCustPref1()
			
			
			function validateCustPref2($inPref2)
			{
				global $validForm, $pref2ErrMsg;
				$pref2ErrMsg = "";
				
				if($inPref2 == "")
				{
					$validForm = false;
					$pref2ErrMsg = "Please select a preference score";
				}
			}//end validateCustPref2()
			
			function validateCustPref3($inPref3)
			{
				global $validForm, $pref3ErrMsg;
				$pref3ErrMsg = "";
				
				if($inPref3 == "")
				{
					$validForm = false;
					$pref3ErrMsg = "Please select a preference score";
				}
			}//end validateCustPref3()
			
			function validateCustPref4($inPref4)
			{
				global $validForm, $pref4ErrMsg;
				$pref4ErrMsg = "";
				
				if($inPref4 == "")
				{
					$validForm = false;
					$pref4ErrMsg = "Please select a preference score";
				}
			}//end validateCustPref4()
			
			
			
		// VALIDATE FORM DATE using functions defined above
		$validForm = true;		//switch for keeping track of any form validation errors
		
		//validateCustId($cust_id);
		validateCustEmail($cust_email);
		validateCustPref1($cust_pref1);
		validateCustPref2($cust_pref2);
		validateCustPref3($cust_pref3);
		validateCustPref4($cust_pref4);
		
		if($validForm)
		{
			$message = "All good";
			
			try {
				require 'connectPDO.php'; //CONNECT to database
				
				//mysql DATE stores data in a YYYY-MM-DD format
				$todaysDate = date("Y-m-d");		//use today's date as the default input to the date( )
				
				//Create the SQL command string
				$sql = "INSERT INTO time_preferences (";
				//$sql .= "cust_id, ";
				$sql .= "cust_email, ";
				$sql .= "cust_pref1, ";
				$sql .= "cust_pref2, ";
				$sql .= "cust_pref3, ";
				$sql .= "cust_pref4, ";
				$sql .= "cust_input_date ";  //Last column does NOT have a comma after it
				$sql .= ") VALUES (:cust_email, :cust_pref1, :cust_pref2, :cust_pref3, :cust_pref4, :cust_input_date)";
				
				//PREPARE the sql statement
				$stmt = $conn->prepare($sql);
				
				//BIND the values to the input parameters of the prepared statement
				//$stmt->bindParam(':cust_id', $cust_id);
				$stmt->bindParam(':cust_email', $cust_email);		
				$stmt->bindParam(':cust_pref1', $cust_pref1);		
				$stmt->bindParam(':cust_pref2', $cust_pref2);		
				$stmt->bindParam(':cust_pref3', $cust_pref3);
				$stmt->bindParam(':cust_pref4', $cust_pref4);		
				$stmt->bindParam(':cust_input_date', $todaysDate);	
				
				//EXECUTE the prepared statement
				$stmt->execute();
				
				$message = "Your response has been recorded.";
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

<script type="text/javascript">
	function validateMyForm() {
		// The field is empty, submit the form.
		if(!document.getElementById("honeypot").value) { 
			return true;
		} 
		 // the field has a value it's a spam bot
		else {
			return false;
		}
	}
</script>

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
    	<h1>Customer Survey Form</h1>
    </header>
    
	<!--<?php //require 'includes/navigation.php' ?>-->
    
    <main>
    
        <h1>Submit your survey</h1>
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
        
        <p>Please enter your email, and vote on what time works best for you. The options ranges from 1-4. 1 Being the least likely
		to work for you, and 4 being the most likely to work for you. Please do not choose the same number for every preference option.</p>
		
		<h3>This form is protected from bots</h3>
        <form id="timePreferences" name="timePreferences" onsubmit="return validateMyForm();" method="post" action="timePreferences.php">
        	<fieldset>
              <legend>Add an Event</legend>
              <p>
                <label for="cust_email">Customer Email: </label>
                <input type="text" name="cust_email" id="cust_email" value="<?php echo $cust_email;  ?>" /> 
                <span class="errMsg"> <?php echo $emailErrMsg; ?></span>
              </p>
			  </br>			  
			  <p>1 = worst time    2 = would not prefer    3 = probably would work     4 = best time</P>
			  <p>PLEASE do not repeat the numbers for each options</p>
			  </br>
              <p>
                <label for="cust_pref1">Vote for Monday/Wednesday 10:10am - Noon</label>  
				<select name="cust_pref1">
                <option id="cust_pref1" value="1">1</option>
				<option id="cust_pref1" value="2">2</option>
				<option id="cust_pref1" value="3">3</option>
				<option id="cust_pref1" value="4">4</option>
				</select>
                <span class="errMsg"><?php echo $pref1ErrMsg; ?></span>                
              </p>
			  <p>
                <label for="cust_pref2">Vote for Tuesday 6:00-9:00pm</label>  
                <select name="cust_pref2">
                <option id="cust_pref2" value="1">1</option>
				<option id="cust_pref2" value="2">2</option>
				<option id="cust_pref2" value="3">3</option>
				<option id="cust_pref2" value="4">4</option>
				</select>
                <span class="errMsg"><?php echo $pref2ErrMsg; ?></span>                
              </p>
			  <p>
                <label for="cust_pref3">Vote for Wednesday 6:00-9:00pm</label>  
                <select name="cust_pref3">
                <option id="cust_pref3" value="1">1</option>
				<option id="cust_pref3" value="2">2</option>
				<option id="cust_pref3" value="3">3</option>
				<option id="cust_pref3" value="4">4</option>
				</select>
                <span class="errMsg"><?php echo $pref3ErrMsg; ?></span>                
              </p>
			  <p>
                <label for="cust_pref4">Vote for Tuesday/Thursday 10:10am-Noon</label>  
                <select name="cust_pref4">
                <option id="cust_pref4" value="1">1</option>
				<option id="cust_pref4" value="2">2</option>
				<option id="cust_pref4" value="3">3</option>
				<option id="cust_pref4" value="4">4</option>
				</select>
                <span class="errMsg"><?php echo $pref4ErrMsg; ?></span>                
              </p>
				<div style="display:none;">
				<label>Keep this field blank</label>
				<input type="text" name="honeypot" id="honeypot" />
				</div>
            </fieldset>
         	<p>
            	<input type="submit" name="submit" id="submit" value="Submit Survey" />
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