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
		if(!mssql_query('DROP TABLE jps_smiffys_category'))
		{
		   echo "failed to drop table jps_smiffys_category" . "<br />";	
		}
		
		if(!mssql_query('CREATE TABLE jps_smiffys_category 
								 (
								 ID int NOT NULL,
								 Name nvarchar(max) NULL,
								 Image nvarchar(max) NULL,
								 Main nvarchar(max) NULL,
								 Sub1 nvarchar(max) NULL,
								 Sub2 nvarchar(max) NULL,
								 Sub3 nvarchar(max) NULL,
								 Sub4 nvarchar(max) NULL,
								 InUse nvarchar(max) NULL,
								 Level int NULL,
								 Code nvarchar(max) NULL,
								 Parent int NULL,
								 HasChildren nvarchar(max) NULL,
								 NoOfItems int NULL,
								 LongDesc nvarchar(max) NULL,
								 UNIQUE (ID)
								 )'))
		   {
			   echo "failed to create table jps_smiffys_category" . "<br />";	
		   }
		   else
		   {
			   echo "Created table jps_smiffys_category" . "<br />";	
		   }
			
		if(mssql_close($link)==TRUE)
		{
			echo "Closed link" . "<br />";
		}
	}
}

?>