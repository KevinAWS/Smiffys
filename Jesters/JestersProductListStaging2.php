<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
	set_time_limit(1800); // IMPORTANT – This Needs To Be Set If You Are Calling The GetFullDataSet Method. (time limit on script set to half-an-hour)

	$wdsl = 'http://webservices.smiffys.com/services/products.asmx?WSDL';
	$soapClient = new SoapClient("$wdsl");
	
	$apiKey = '66a88b940c460bd5437d01c62d16235b';
	$clientID = 'EF_Jesters';	

	$productParameters = array('apiKey'=>$apiKey, 'clientID'=>$clientID);

	$GetFullDataSet = GetXml($soapClient, 'GetFullDataSet', $productParameters, 'Product');
	
	$ResultSet = array('name'=>'GetFullDataSet', 'ResultSet'=>$GetFullDataSet);
	
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
		$writeToFile = true;	
		$debugProducts = false;
	
		$fileName = sprintf("JPL%s_2.txt",date("Ymd"));
		$crlf = sprintf("%c%c",13,10);
		$file=fopen($fileName,"w") or exit("Unable to open file!");
		
		if($writeToFile==true)
		{
			echo "Writing output to file " . $fileName . "<br />";
		}
		else
		{
			echo "Writing output to browser window" . "<br />";
		}
	
		$link = mssql_connect('213.171.218.223','matt','flair472b');
		// Check connection
 		if (!$link)	
   		{
			$outText = "Failed to connect to server 213.171.218.223";
			if($writeToFile)
			{
				if(fwrite($file,$outText)==FALSE)
				{
					echo "Failed to write to file : " . $outText . "<br />";
				}
				fwrite($file,$crlf);
			}				
			else
			{
   				echo $outText . "<br />";
			}
			return;			
   		}
		else
		{			
			$outText = "Connected to server 213.171.218.223";
			if($writeToFile)
			{
				if(fwrite($file,$outText)==FALSE)
				{
					echo "Failed to write to file : " . $outText  . "<br />";
				}
				fwrite($file,$crlf);
			}
			else
			{
 				echo $outText . "<br />";
			}			
		} 
		
		if(!mssql_select_db('smarthlsql7', $link))
		{	
			$outText = "Failed to select database smarthlsql7";
			if($writeToFile)
			{
				if(fwrite($file,$outText,"\n")==FALSE)
				{
					echo "Failed to write to file : " . $outText . "<br />";
				}
				fwrite($file,$crlf);
			}
			else
			{
 				echo $outText . "<br />";
			}			

			if(mssql_close($link)==TRUE)
			{
				$outText = "Closed link";
				if($writeToFile)
				{
					if(fwrite($file,$outText,"\n")==FALSE)
					{
						echo "Failed to write to file : " . $outText . "<br />";
					}
					fwrite($file,$crlf);
				}
				else
				{
					echo $outText . "<br />";
				}			
			}
			return;
		}
		else
		{	
			$outText = "Selected database smarthlsql7";
			if($writeToFile)
			{
				if(fwrite($file,$outText)==FALSE)
				{
					echo "Failed to write to file : " . $outText . "<br />";
				}
				fwrite($file,$crlf);
			}
			else
			{
				echo $outText . "<br />";
			}					
		} 
		
		// Mapping Array XML field => Database field
		$fieldName=array("ProductCode"=>"ProductCode",		
			"ProductName"=>"ProductName",
			"BrochureDescription"=>"BrochureDescription",
			"WebDescription"=>"WebDescription",
			"WashingInstructions"=>"WashingInstructions",
			"RRP"=>"RRP",
			"StockQuantity"=>"StockQuantity",
			"VatRate"=>"VatRate",
			"Gender"=>"Gender",
			"PackType"=>"PackType",
			"PackQty"=>"PackQty",
			"Audience"=>"Audience",
			"FurtherDetails"=>"FurtherDetails",
			"Colour"=>"Colour",		
			"ETA"=>"ETA",  
			"CataloguePage"=>"CataloguePage",
			"BarCode"=>"BarCode",
			"Price1"=>"Price1",
			"Price2"=>"Price2",
			"Price3"=>"Price3",
			"Break1"=>"Break1",
			"Break2"=>"Break2",
			"Break3"=>"Break3",
			"unit_size"=>"unit_size",
			"warnings"=>"warnings",	
			"carton"=>"carton",
			"stdPrice1"=>"stdPrice1",
			"stdPrice2"=>"stdPrice2",
			"stdPrice3"=>"stdPrice3",
			"stdBreak1"=>"stdBreak1",
			"stdBreak2"=>"stdBreak2",
			"stdBreak3"=>"stdBreak3",
			"Photo"=>"Photo",
			"SideShot"=>"SideShot", 
			"FrontShot"=>"FrontShot", 
			"BackShot"=>"BackShot", 	
			"CatalogueCode"=>"CatalogueCode",
			"CatalogueName"=>"CatalogueName",
			"Catalogue"=>"Catalogue",
			"acc_code1"=>"acc_code1",
			"acc_code2"=>"acc_code2",
			"acc_code3"=>"acc_code3",
			"acc_code4"=>"acc_code4",
			"acc_code5"=>"acc_code5",
			"alt_code1"=>"alt_code1",
			"alt_code2"=>"alt_code2",
			"alt_code3"=>"alt_code3",
			"alt_code4"=>"alt_code4",
			"alt_code5"=>"alt_code5",
			"new_code"=>"new_code",	
			"art_cat"=>"art_cat",
			"Seasonal"=>"Seasonal",
			"p_list2"=>"p_list2",	
			"DropDate"=>"DropDate",
			"Licence_Territory"=>"Licence_Territory",	
			"ThemeName"=>"ThemeName",
			"AdditionalTheme"=>"AdditionalTheme", 
			"GroupID"=>"GroupID",
			"GroupName"=>"GroupName",
			"GroupID1"=>"GroupID1",
			"ThemeGroup1"=>"ThemeGroup1",
			"GroupID2"=>"GroupID2",
			"ThemeGroup2"=>"ThemeGroup2",
			"GroupID3"=>"GroupID3",
			"ThemeGroup3"=>"ThemeGroup3",
			"EFPrice"=>"EFPrice",
			"EFQty"=>"EFQty",
			"Size"=>"Size",
			"Ext_Size"=>"Ext_Size",
			"GenericCode"=>"GenericCode");
		
		// Mapping Array XML field => field type for SQL purposes T = text, N = numeric 
		// note: no need to differentiate between numeric types for sql update statements
		$fieldType=array("ProductCode"=>"T",		
			"ProductName"=>"T",
			"BrochureDescription"=>"T",
			"WebDescription"=>"T",
			"WashingInstructions"=>"T",
			"RRP"=>"F",
			"StockQuantity"=>"I",
			"VatRate"=>"F",
			"Gender"=>"T",
			"PackType"=>"T",
			"PackQty"=>"I",
			"Audience"=>"T",
			"FurtherDetails"=>"T",
			"Colour"=>"T",		
			"ETA"=>"T",  // date
			"CataloguePage"=>"T",
			"BarCode"=>"T",
			"Price1"=>"F",
			"Price2"=>"F",
			"Price3"=>"F",
			"Break1"=>"F",
			"Break2"=>"F",
			"Break3"=>"F",
			"unit_size"=>"T",
			"warnings"=>"T",	
			"carton"=>"T",
			"stdPrice1"=>"F",
			"stdPrice2"=>"F",
			"stdPrice3"=>"F",
			"stdBreak1"=>"F",
			"stdBreak2"=>"F",
			"stdBreak3"=>"F",
			"Photo"=>"T",
			"SideShot"=>"T", 
			"FrontShot"=>"T", 
			"BackShot"=>"T", 
			"CatalogueCode"=>"T",
			"CatalogueName"=>"T",
			"Catalogue"=>"T",
			"acc_code1"=>"T",
			"acc_code2"=>"T",
			"acc_code3"=>"T",
			"acc_code4"=>"T",
			"acc_code5"=>"T",
			"alt_code1"=>"T",
			"alt_code2"=>"T",
			"alt_code3"=>"T",
			"alt_code4"=>"T",
			"alt_code5"=>"T",
			"new_code"=>"T",	
			"art_cat"=>"T",
			"Seasonal"=>"T",
			"p_list2"=>"T",	
			"DropDate"=>"T", // date
			"Licence_Territory"=>"T",	
			"ThemeName"=>"T",
			"AdditionalTheme"=>"T",
			"GroupID"=>"T",
			"GroupName"=>"T",
			"GroupID1"=>"T",
			"ThemeGroup1"=>"T",
			"GroupID2"=>"T",
			"ThemeGroup2"=>"T",
			"GroupID3"=>"T",
			"ThemeGroup3"=>"T",
			"EFPrice"=>"F",
			"EFQty"=>"I",
			"Size"=>"T",
			"Ext_Size"=>"T",
			"GenericCode"=>"T");
	
		$i=5000;
		
		$outText = "Applying insert/updates to table jps_smiffys_product";
		if($writeToFile)
		{
			if(fwrite($file,$outText)==FALSE)
			{
				echo "Failed to write to file : " . $outText . "<br />";
			}
			fwrite($file,$crlf);
		}
		else
		{
			echo $outText . "<br />";
		}					
		
 	    // while($i < 20)	// Just do 20 to try it out
		while(1==1)
		{
			$firstNodeList = $xmlNodeList['ResultSet']->item($i)->childNodes;
						
			if($firstNodeList == null) 
			{
				break;
			}				
	
			$updateStr = "";
			$DBQueryStr = ""; 
			$maxFields = 0;
			$XMLfields = array();
			$XMLfieldNames = array();
			$XMLfieldTypes = array();
			$newProduct = FALSE;
			foreach($firstNodeList as $name)
			{
				/* echo "<tr>
						  <td id=\"Attribute\">
						  $name->nodeName</td>
						  <td id=\"Value\">
						  $name->nodeValue</td>
					  </tr>"; */					
					
				if($name->nodeName=="ProductCode")
				{
					$productCode = $name->nodeValue;
					$XMLfields[$maxFields] = $name->nodeValue;
					$XMLfieldTypes[$maxFields] = 'T';
					$XMLfieldNames[$maxFields] = 'ProductCode';
					$maxFields++;					
				
					$recNum = $i+1;
					$outText = "Processing record " . $recNum . " Product Code : " . $productCode;
					echo $outText . "<br />";
					
					if($writeToFile)
					{
						if(fwrite($file,$outText)==FALSE)
						{
							echo "Failed to write to file : " . $outText . "<br />";
						}
						fwrite($file,$crlf);
					}
					
					// mssql_query("DELETE FROM jps_smiffys_product WHERE ProductCode = '00495'");  // temp for testing !!!!!!!!!!!!!!
					
					$selectStr = "SELECT ProductCode FROM jps_smiffys_product WHERE ProductCode = '" . $name->nodeValue . "'";
					
					$DBQueryStr = "SELECT CAST(ProductCode AS TEXT), "; 
					
					// echo "Select string is: " . $selectStr . "<br />";
					
					$query = mssql_query($selectStr);

					// $result = mysqli_query($con,$selectStr);					
					// if($result == FALSE)
					
					if (!mssql_num_rows($query)) 
					{
						$newProduct = TRUE;
						
						/* $insertStr = "INSERT INTO jps_smiffys_product (ProductCode) VALUES ('" . $productCode . "')";												
						// echo "Insert string is: " . $insertStr . "<br />";
						
						// echo "Inserting new product, product code: " . $productCode . "<br />";
						
						if(!mssql_query($insertStr))
						{
							echo "INSERT failed : The SQL is: " . $insertStr . "<br />";
						}	*/					
					}	
					else
					{
						mssql_free_result($query);
					}
				} 
				else
				{ 			
					$fn = $fieldName[$name->nodeName];
					$XMLfieldNames[$maxFields] = $fn;
					if(strlen($fn) > 0)
					{
						$DBQueryStr = $DBQueryStr . "CAST(" . $fieldName[$name->nodeName];
						$XMLfields[$maxFields] = $name->nodeValue;
						
						if($fieldType[$name->nodeName]=='F' || $fieldType[$name->nodeName]=='I')
						{
							if($fieldType[$name->nodeName]=='F')
							{
								$XMLfieldTypes[$maxFields] = 'F';
								$DBQueryStr = $DBQueryStr . " AS FLOAT), ";
							}
							if($fieldType[$name->nodeName]=='I')
							{
								$XMLfieldTypes[$maxFields] = 'I';
								$DBQueryStr = $DBQueryStr . " AS INT), ";
							}							
							
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
							$DBQueryStr = $DBQueryStr . " AS TEXT), ";
							$XMLfieldTypes[$maxFields] = 'T';
							
							if(strchr($name->nodeValue,"'")==FALSE)
							{
								$updateStr = $updateStr . $fieldName[$name->nodeName] . "= '" . $name->nodeValue . "', ";
							}
							else
							{						
								$updateStr = $updateStr . $fieldName[$name->nodeName] . "= " . chr(34). $name->nodeValue . chr(34) . ", ";
							}							
						}	
						$maxFields++;
					}
				}
			}			
			
			if(strlen($updateStr) > 1)		
				$updateStr = substr($updateStr,0,strlen($updateStr)-2); // removes trailing comma			
				
			if(strlen($DBQueryStr) > 1)		
				$DBQueryStr = substr($DBQueryStr,0,strlen($DBQueryStr)-2); // removes trailing comma			
		
			$DBUpdateStr = "UPDATE jps_smiffys_product SET " . $updateStr . " WHERE ProductCode = '" . $productCode . "'";
			
			$DBQueryStr = $DBQueryStr . " FROM jps_smiffys_product WHERE ProductCode = '" . $productCode . "'";
						
			// echo "Query string is: " . $DBQueryStr . "<br />";				
			// echo "Update string is: " . $DBUpdateStr . "<br />";										
				
			$query = mssql_query($DBQueryStr);
			
			$same = TRUE;
			if($query && !$newProduct)
			{
				$row = mssql_fetch_row($query);
				
				// TEMP FOR TESTING
				
				/* if(strcmp(trim($productCode),"00495") == 0)
				{
					$XMLfields[6] = "788";
				}*/
				
				// END
				
				$XMLFieldCount = 0;
				while($XMLFieldCount < $maxFields)				
				{			
					if($debugProducts==true)
					{
						if($XMLfieldTypes[$XMLFieldCount]=='F')
						{
							sprintf($outText,"Product code %s, field name %s, XML field is %f DB field is %f",$productCode,$XMLfieldNames[$XMLFieldCount],(float)$XMLfields[$XMLFieldCount],(float)$row[$XMLFieldCount]);   
							fwrite($file,$outText);
							fwrite($file,$crlf);                   
						}
						else if($XMLfieldTypes[$XMLFieldCount]=='I')
						{	
							sprintf($outText,"Product code %s, field name %s, XML field is %u DB field is %u",$productCode,$XMLfieldNames[$XMLFieldCount],(int)$XMLfields[$XMLFieldCount],(int)$row[$XMLFieldCount]); 
							fwrite($file,$outText);
							fwrite($file,$crlf);                   
						}
						else if($XMLfieldTypes[$XMLFieldCount]=='T')
						{	
							$outText = "Product code is " . $productCode . " Field Name " . $XMLfieldNames[$XMLFieldCount] . " XML field is " . $XMLfields[$XMLFieldCount] . " DB field is " . $row[$XMLFieldCount];
							fwrite($file,$outText);
							fwrite($file,$crlf);                   
						}
						else
						{
							$outText = "Unknown field type, Field Name" . $XMLfieldNames[$XMLFieldCount] . " Field Type " . $XMLfieldTypes[$XMLFieldCount] . " unknown at index " . $XMLFieldCount;
							fwrite($file,$outText);
							fwrite($file,$crlf);                   
						}
					}
					
					if($XMLfieldTypes[$XMLFieldCount]=='F')	
					{
						if(((float)$XMLfields[$XMLFieldCount]) != ((float)$row[$XMLFieldCount]))
						{	
							sprintf($outText,"Difference found, product code %s, field name %s, XML field is %f DB field is %f",$productCode,$XMLfieldNames[$XMLFieldCount],(float)$XMLfields[$XMLFieldCount],(float)$row[$XMLFieldCount]); 
							if($writeToFile)
							{
								if(fwrite($file,$outText)==FALSE)
								{
									echo "Failed to write to file : " . $outText . "<br />";
								}
								fwrite($file,$crlf);
							}
							else
							{
								echo $outText . "<br />";
							}	

							// echo "FLOAT NOT MATCHED !!!!!" . "<br />"; 
							$same = FALSE;
						}
					}
					else if($XMLfieldTypes[$XMLFieldCount]=='I')
					{	
						if(((int)$XMLfields[$XMLFieldCount]) != ((int)$row[$XMLFieldCount]))
						{
							sprintf($outText,"Difference found, product code %s, field name %s, XML field is %u DB field is %u",$productCode,$XMLfieldNames[$XMLFieldCount],(int)$XMLfields[$XMLFieldCount],(int)$row[$XMLFieldCount]); 
							if($writeToFile)
							{
								if(fwrite($file,$outText)==FALSE)
								{
									echo "Failed to write to file : " . $outText . "<br />";
								}
								fwrite($file,$crlf);
							}
							else
							{
								echo $outText . "<br />";
							}				

							// echo "INT NOT MATCHED !!!!!" . "<br />"; 
							$same = FALSE;							
						}
					}
					else if($XMLfieldTypes[$XMLFieldCount]=='T')
					{					
						if(strcmp(trim($XMLfields[$XMLFieldCount]),trim($row[$XMLFieldCount])) != 0)
						{
							$outText = "Difference found, product code is " . $productCode . " Field Name " . $XMLfieldNames[$XMLFieldCount] . " XML field is " . $XMLfields[$XMLFieldCount] . " DB field is " . $row[$XMLFieldCount];
							if($writeToFile)
							{
								if(fwrite($file,$outText)==FALSE)
								{
									echo "Failed to write to file : " . $outText . "<br />";
								}
								fwrite($file,$crlf);
							}
							else
							{
								echo $outText . "<br />";
							}					
						
							// echo "TEXT NOT MATCHED !!!!!" . "<br />"; 
							$same = FALSE;
						}				
					}
					else
					{
						$outText = "Field Name" . $XMLfieldNames[$XMLFieldCount] . " Field Type " . $XMLfieldTypes[$XMLFieldCount] . " unknown at index " . $XMLFieldCount;
						if($writeToFile)
						{
							if(fwrite($file,$outText)==FALSE)
							{
								echo "Failed to write to file : " . $outText . "<br />";
							}
							fwrite($file,$crlf);
						}
						else
						{							
							echo $outText . "<br />";
						}				
					}
										
					$XMLFieldCount++;
				}					
			}	
			
			// echo "Processing Product Code " . $productCode . "<br />";
			
			if($newProduct == TRUE)
			{
				$insertStr = "INSERT INTO jps_smiffys_product (ProductCode) VALUES ('" . $productCode . "')";												
				// echo "Insert string is: " . $insertStr . "<br />";
				
				$outText = "Inserting new product, product code: " . $productCode;
				if($writeToFile)
				{
					if(fwrite($file,$outText)==FALSE)
					{
						echo "Failed to write to file : " . $outText . "<br />";
					}
					fwrite($file,$crlf);
				}
				else
				{
					echo $outText . "<br />";
				}				
				
				if(!mssql_query($insertStr))
				{
					$outText = "INSERT failed : The SQL is: " . $insertStr;
					if($writeToFile)
					{
						if(fwrite($file,$outText)==FALSE)
						{
							echo "Failed to write to file : " . $outText . "<br />";
						}
						fwrite($file,$crlf);
					}
					else
					{
						echo $outText . "<br />";
					}				
				}	
				else
				{
					$same = FALSE;
				}
			}
						
			if($same == FALSE)
			{
				if(!mssql_query($DBUpdateStr))
				{
					$outText = "UPDATE failed : The SQL string is: " . $DBUpdateStr;
					if($writeToFile)
					{
						if(fwrite($file,$outText)==FALSE)
						{
							echo "Failed to write to file : " . $outText . "<br />";
						}
						fwrite($file,$crlf);
					}
					else
					{
						echo $outText . "<br />";
					}					
				}				
				else
				{
					$outText = "Updating Table jps_smiffys_product, Product Code: " . $productCode;
					if($writeToFile)
					{
						if(fwrite($file,$outText)==FALSE)
						{
							echo "Failed to write to file : " . $outText . "<br />";
						}
						fwrite($file,$crlf);
					}
					else
					{
						echo $outText . "<br />";
					}					

				}
			}
			
			$i++;
			
			unset($XMLfields);
			unset($XMLfieldTypes);
			unset($XMLfieldNames);
			
			if($i > 10000)		// TEMP for testing purposes!
			{
				break;
			}
		}
		
		$outText = "Completed insert/updates to table jps_smiffys_product";
		if($writeToFile)
		{
			if(fwrite($file,$outText)==FALSE)
			{
				echo "Failed to write to file : " . $outText . "<br />";
			}
			fwrite($file,$crlf);
		}
		else
		{
			echo $outText . "<br />";
		}					
	
		if(mssql_close($link)==TRUE)
		{
			$outText = "Closed database connection";
			if($writeToFile)
			{
				if(fwrite($file,$outText)==FALSE)
				{
					echo "Failed to write to file : " . $outText . "<br />";
				}
				fwrite($file,$crlf);
			}
			else
			{
				echo $outText . "<br />";
			}				
		}	
		
		fclose($file);
		
		if($writeToFile==true)
		{
			echo "Processing complete, file " . $fileName . " closed" . "<br />";
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
		<h3>Jesters: Populating/Updating Product List (Batch 2), Version 2.1</h3>
		<?php processResults($ResultSet) ?>
	</body>
</html>