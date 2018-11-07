<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
	$wdsl = 'http://webservices.smiffys.com/services/products.asmx?WSDL';
	$soapClient = new SoapClient("$wdsl");
	
	$apiKey = '66a88b940c460bd5437d01c62d16235b';
	$clientID = 'EF_Jesters';
	
	$categoryParameters = array('apiKey'=>$apiKey, 'clientID'=>$clientID);

	set_time_limit(120); // IMPORTANT – This Needs To Be Set If You Are Calling The GetFullDataSet Method.
	$GetCategoryList = GetXml($soapClient, 'GetCategoryList', $categoryParameters, 'Category');

	$ResultSet = array('name'=>'GetCategoryList', 'ResultSet'=>$GetCategoryList);
	
	$old_error_handler = set_error_handler("myErrorHandler");
	
	function myErrorHandler($errno, $errstr, $errfile, $errline)
	{
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }
	
	return true; // uncomment to invoke our own error handling

    switch ($errno) {
    case E_USER_ERROR:
        echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
        echo "  Fatal error on line $errline in file $errfile";
        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        echo "Aborting...<br />\n";
        exit(1);
        break;

    case E_USER_WARNING:
        echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
        break;

    case E_USER_NOTICE:
        echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
        break;

    default:
        echo "Unknown error type: [$errno] $errstr<br />\n";
        break;
    }

    /* Don't execute PHP internal error handler */
    return true;
	}

	function GetXml($soapClient, $method, $parameters, $resultSetTag)
	{
		try
		{
			$methodResultName = $method."Result";
			$result = $soapClient->$method($parameters);
			$simpleresult = $result->$methodResultName;
			
			return getElementsFromResult($resultSetTag, $simpleresult);
		}
		catch (SoapFault $exception)
		{
			echo $exception;
			return $exception;
		}
	}
	
	function getElementsFromResult($elementName, $simpleresult)
	{
		$dom = new DOMDocument;
		$dom->preserveWhiteSpace = FALSE;
		
		if($simpleresult == null)
		{
			echo 'null';
			return 'Simpleresult was equal to Null.';
		}
		else
		{
			$dom->loadXML($simpleresult->any);
			return $dom->getElementsByTagName($elementName);
		}
	}
	
	function processResults($xmlNodeList)
	{
		// $con=mysqli_connect("213.171.200.62","Jesters1","cxfrt1NJ7f9","Jesters");
		// $con=mysqli_connect("213.171.200.62","Jesters2","hjy4t6he36frp7","Jesters");
		$link = mssql_connect('213.171.218.223','matt','flair472b');
		// Check connection
 		if (!$link)	
   		{
   			echo "Failed to connect to server 213.171.218.223" . "<br />";
			return;			
   		}
		else
		{	
			echo "Connected to server 213.171.218.223" . "<br />";
		} 
		
		if(!mssql_select_db('smarthlsql7', $link))
		{	
			echo "Failed to select database smarthlsql7" . "<br />";
			if(mssql_close($link)==TRUE)
			{
				echo "Closed link" . "<br />";
			}
			return;
		}
		else
		{	
			echo "Selected database smarthlsql7" . "<br />";
		} 

		
		// Mapping Array XML field => Database field
		$fieldName=array("ID"=>"ID",
 				"Name"=>"Name",
 				"Image"=>"Image",
 				"Main"=>"Main",
 				"Sub1"=>"Sub1",
 				"Sub2"=>"Sub2",
 				"Sub3"=>"Sub3",
 				"Sub4"=>"Sub4",
 				"Use"=>"InUse",
 				"Level"=>"Level",
 				"Code"=>"Code",
 				"Parent"=>"Parent",
 				"HasChildren"=>"HasChildren",
 				"NoOfItems"=>"NoOfItems",
 				"LongDesc"=>"LongDesc");	
		
		// Mapping Array XML field => field type for SQL purposes T = text, N = numeric
		$fieldType=array("ID"=>"N",
 				"Name"=>"T",
 				"Image"=>"T",
 				"Main"=>"T",
 				"Sub1"=>"T",
 				"Sub2"=>"T",
 				"Sub3"=>"T",
 				"Sub4"=>"T",
 				"Use"=>"T",
 				"Level"=>"N",
 				"Code"=>"T",
 				"Parent"=>"N",
 				"HasChildren"=>"T",
 				"NoOfItems"=>"N",
 				"LongDesc"=>"T");
		
		echo "Applying insert/updates to table jps_smiffys_category" . "<br />";
		
		$i=0;
		while(1==1)
		{
			$firstNodeList = $xmlNodeList['ResultSet']->item($i)->childNodes;
						
			if($firstNodeList == null)  
			{
				break;
			}						
	
			$updateStr = "";
			foreach($firstNodeList as $name)
			{
				/* echo "<tr>
						  <td id=\"Attribute\">
						  $name->nodeName</td>
						  <td id=\"Value\">
						  $name->nodeValue</td>
					  </tr>"; */
					  
				if($name->nodeName=="ID")
				{
					$ID = $name->nodeValue;
					
					$recNum = $i+1;
					// echo "Processing record " . $recNum . " ID : " . $ID . "<br />";
					
					$selectStr = "SELECT ID FROM jps_smiffys_category WHERE ID = " . $name->nodeValue;
					
					// , Name, Image, Main, Sub1 , Sub2, Sub3, Sub4, InUse, Level, Code, Parent, HasChildren, NoOfItems, LongDesc 					
					// echo "Select string is: " . $selectStr . "<br />";
					
					$query = mssql_query($selectStr);

					// $result = mysqli_query($con,$selectStr);					
					// if($result == FALSE)
					
					if (!mssql_num_rows($query)) 
					{
						$insertStr = "INSERT INTO jps_smiffys_category (ID) VALUES (" . $ID . ")";												
						// echo "Insert string is: " . $insertStr . "<br />";
						
						// echo "Inserting new category into jps_smiffys_category, ID: " . $ID . "<br />";
						
						if(!mssql_query($insertStr))
						// if( mysqli_query($con,$insertStr) == FALSE )
						{
							echo "INSERT failed : The SQL is: " . $insertStr . "<br />";
						}
					}	
					else
					{
						// $result->close();
						
						// $row = mssql_fetch_array($query);
						// echo $row[0] . "<br />";
						// $row['ID']
						mssql_free_result($query);
					}
				} 
				else
				{ 								
					$fn = $fieldName[$name->nodeName];
					if(strlen($fn) > 0)
					{				
						if($fieldType[$name->nodeName]=='N')
						{
							if(strlen($name->nodeValue) <> 0)
							{
								$updateStr = $updateStr . $fieldName[$name->nodeName] . "=" . $name->nodeValue . ", "; 				  
							}
							else
							{
								$updateStr = $updateStr . $fieldName[$name->nodeName] . " = 0" . ", "; 				  
							}
		
						}
						else
						{
							if(strchr($name->nodeValue,"'")==FALSE)
							{
								$updateStr = $updateStr . $fieldName[$name->nodeName] . "= '" . $name->nodeValue . "', ";
							}
							else
							{
								$updateStr = $updateStr . $fieldName[$name->nodeName] . "= " . chr(34). $name->nodeValue . chr(34) . ", ";
							}							
						}				
					}
				}
			}			
		
			$updateStr = substr($updateStr,0,strlen($updateStr)-2); // removes trailing comma			
		
			$DBUpdateStr = "UPDATE jps_smiffys_category SET " . $updateStr . " WHERE ID = " . $ID;
						
			// echo "Update string is: " . $DBUpdateStr . "<br />";
			
			// if(mysqli_query($con,$DBUpdateStr)==FALSE)
			
			if(!mssql_query($DBUpdateStr))
			{
				echo "UPDATE failed : The SQL string is: " . $DBUpdateStr . "<br />";
			}				
			else
			{
				// echo "Updating jps_smiffys_category, ID: " . $ID . "<br />";
			}
			
			$i++;	

		}
		
		echo "Completed insert/updates to table jps_smiffys_category" . "<br />";
		
		// mysqli_close($con);
		
		if(mssql_close($link)==TRUE)
		{
			echo "Closed database connection" . "<br />";
		}	

	}	

?>

<html>
	<head>
		<title>Jesters</title>
		<style type='text/css'>
			body
			{
				font-family: helvetica;
				font-size: 14px;
			}
			h4, table
			{
				margin-left: 20px;
			}
			table
			{
				margin-top: -10px;
			}
			#Attribute, #Value
			{
				border: 0px solid black;
				padding-right: 10px;
			}
			#Attribute
			{
				background-color: #E5E5E5;
			}
			#Value
			{
				background-color: #F5F5F5;
			}
		</style>
	</head>
	<body>
		<h3>Jesters: Populating/Updating Category List</h3>
		<?php processResults($ResultSet) ?>
	</body>
</html>