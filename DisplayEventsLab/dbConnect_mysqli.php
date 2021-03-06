<?php
//	This file contains the PHP coding to connect to the database.  This file uses the mysqli or improved mysql commands.  
//
//	Include this file in any page that needs to access the database.  Use the PHP include command before doing any database accesses
//

$hostname = "localhost";	//the name of the server where the database is located.  Usually localhost
$username = "draken5_bryan2";				//the username on the database.  Usually listed on the cPanel listing of databases
$database = "draken5_bryan2";				//the name of the database.  Usually the same as the username.  Located on the cPanel listing of databases
$password = "awesomedude";				//the password of the account or database.  Set a seperate password for the database.  On the cPanel listing of databases

//Builds the connection object called $db and selects the desired database.
//You will need to use the $link variable in the mysqli_query() commands whenever you run a query against the database.
$conn = mysqli_connect($hostname, $username, $password, $database);	//$link is the connection object created by this command.

//$link is a variable that contains an open doorway to a valid database.  



//Check to make sure you properly connected to the database.  This is some sample logic more suitable to a production environment
if (!$conn)										//If the connection ($link) is NOT good then handle the error
	{ 
		//Create an error message using one or more of the following error handling functions
		//   mysqli_connect_error( )
		//   mysqli_error( )
		//   mysqli_errno( )
		//Send this message to the person or web developer in charge of maintaining this site.  
		//This could be done using the emailer() or for more advanced sites an error management system.
		//Clean up any variables or connections that have been left hanging by this error.

		//Display a user friendly error message to the user. Preferably a page thst is formatted and looks like the rest of your website
		//This page should let them know there has been some problems and redirect them provide them with a link to page on your site.
		//Think about what has happened to you on other websites when something didn't work.  How would you like to be treated. 		
	} 
	else {
		//echo ("It works");
	}
	
//Alternative method of checking for a successful connection.  NOT recommended for production applications.	
	
//Check to make sure you properly connected to the database.  This example is ok for testing but not for a production environment.
//  $link = mysqli_connect($hostname,$username,$password,$database) or die("Error " . mysqli_error($link));
?>