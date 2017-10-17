<?php
		$inDate = $_POST["pickDate"];
		$inString = $_POST["string"];
		$inNumber = $_POST["number"];
		$inNumber2 = $_POST["number2"];
		
		$inDate1 = date('m/d/y', strtotime($inDate));
		$inDate2 = date('d/m/y', strtotime($inDate));
		$inLength = strlen($inString);
		$inWhite = str_replace(' ','',$inString);
		$inLower = strtolower($inString);
		$dmacc = "dmacc";
		$inDmacc = strpos($inLower, $dmacc);
		$inDmaccTrueOrFalse = "";
		
		if  ($inDmacc === false){
			$inDmaccTrueOrFalse = "False";
		} else {
			$inDmaccTrueOrFalse = "True";
		}
		
		$inNumber3 = number_format($inNumber);
		$inNumber4 = "$".number_format($inNumber2,2)."<br>";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Assignment: PHP Functions</title>
</head>

<body>

<h1>Assignment Unit 3: PHP Functions</h1>

  <p><strong>Pick a date:</strong></p>
  <p>You choose this date: <?php echo $inDate; ?></p>
  <p>Date in mm/dd/yyyy format: <?php echo $inDate1; ?></p>
  <p>Date in dd/mm/yyyy format: <?php echo $inDate2; ?></p>
  </br>
  
  <p><strong>Input a string:</strong></p>
  <p>You typed in the string: <?php echo $inString; ?></p>
  <p>Length of string: <?php echo $inLength; ?></p>
  <p>Whitespace removed: <?php echo $inWhite; ?></p>
  <p>String with all lower case: <?php echo $inLower; ?></p>
  <p>Does string contain DMACC: <?php echo $inDmaccTrueOrFalse; ?></p>
  </br>
  
  <p><strong>Input a number:</strong></p>
  <p>You typed in this number: <?php echo $inNumber; ?></p>
  <p>Formatted Number: <?php echo $inNumber3; ?></p>
  </br>
  
  <p><strong>Input another number:</strong></p>
  <p>You typed in this number: <?php echo $inNumber2; ?></p>
  <p>US Currency: <?php echo $inNumber4; ?></p>


</body>

</html>