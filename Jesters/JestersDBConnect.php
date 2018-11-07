<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php

$link = mssql_connect('213.171.218.223','matt','flair472b');

if(!$link)
{
	echo "Failed to connected to database" . "<br />";
}
else
{
	echo "Connected to database" . "<br />";	
	
	if(mssql_select_db('smarthlsql7', $link))
	{	
		$version = mssql_query('SELECT @@VERSION');
		$row = mssql_fetch_array($version);
		
		echo $row[0];
		
		// Clean up
		mssql_free_result($version);
		
		if(mssql_close($link)==TRUE)
		{
			echo "Closed link" . "<br />";
		}
	}
}

?>