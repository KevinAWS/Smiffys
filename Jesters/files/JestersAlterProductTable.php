<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php

$link = mssql_connect('213.171.218.223','Kev','flair472b');

if(!$link)
{
	echo "Failed to connected to database" . "<br />";
}
else
{
	echo "Connected to database" . "<br />";	
	
	if(mssql_select_db('smarthlsql7', $link))
	{	
		if(!mssql_query('ALTER TABLE jps_smiffys_product ALTER COLUMN barcode nvarchar(max) NULL'))
		{
		   echo "failed to alter table jps_smiffys_product" . "<br />";	
		}			   
			
		if(mssql_close($link)==TRUE)
		{
			echo "Closed link" . "<br />";
		}
	}
}

?>