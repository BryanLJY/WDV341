<?php
session_start();

	include 'dbConnect_mysqli.php';
	
	$sql = "SELECT event_id,event_name,event_description,event_presenter,event_day,event_time FROM wdv341_events";
	
	$query = $conn->prepare($sql) or die("<h1>Prepare Error</h1>");	//prepare the Statement Object
	
	//run the statement
	
	
	if( $query->execute() )	//Run Query and Make sure the Query ran correctly
	{		
		
		$query->bind_result($event_id,$event_name,$event_description,$event_presenter,$event_day,$event_time);
	
		$query->store_result();
	}
	else
	{
		//Problems were encountered.
		$message = "<h1 style='color:red'>Houston, We have a problem!</h1>";	
		$message .= "mysqli_error($conn)";		//Display error message information	
		echo $message;
	}


?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>WDV341 Intro PHP  - Display Events Example</title>
    <style>
		.eventBlock{
			width:500px;
			margin-left:auto;
			margin-right:auto;
			background-color:#CCC;	
		}
		
		.displayEvent{
			text_align:left;
			font-size:18px;	
		}
		
		.displayDescription {
			margin-left:100px;
		}
	</style>
</head>

<body>
    <h1>WDV341 Intro PHP</h1>
    <h2>Example Code - Display Events as formatted output blocks</h2>   
    <h3> <?php echo $query->num_rows; ?> Events are available today.</h3>

<?php
	//Display each row as formatted output
	while( $query->fetch() )		
	//Turn each row of the result into an associative array 
  	{
		//For each row you have in the array create a block of formatted text
 	
?>
	<p>
        <div class="eventBlock">	
            <div>
            	<span class="displayEvent">Event: <?php echo "$event_name"?></span>
            	<span class="displayDescription">Description: <?php echo "$event_description"?></span>
            </div>
            <div>
            	Presenter: <?php echo "$event_presenter"?>
            </div>
            <div>
            	<span class="displayTime">Time: <?php echo "$event_time"?></span>
            </div>
            <div>
            	<span class="displayDate">Date: <?php echo date('d/m/Y', strtotime($event_day))?></span>
            </div>
        </div>
    </p>

<?php
  	}//close while loop
	$query->close();
	$conn->close();	//Close the database connection	
?>
</div>	
</body>
</html>