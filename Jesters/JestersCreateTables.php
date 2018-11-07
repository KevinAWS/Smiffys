<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php

echo 'attempting connection';


$con=mysqli_connect("213.171.200.62","Jesters1","cxfrt1NJ7f9","Jesters");
// Check connection
 if (mysqli_connect_errno())
   {
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }
 else
 	{
		echo "Connected";
	}
 

?>