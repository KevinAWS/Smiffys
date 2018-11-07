<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
	$wdsl = 'http://webservices.smiffys.com/services/products.asmx?WSDL';
	$soapClient = new SoapClient("$wdsl");
	
	$apiKey = '66a88b940c460bd5437d01c62d16235b';
	$clientID = 'EF_Jesters';
	
	$productParameters = array('apiKey'=>$apiKey, 'clientID'=>$clientID);

	set_time_limit(240); // IMPORTANT – This Needs To Be Set If You Are Calling The GetFullDataSet Method.
	$GetFullDataSet = GetXml($soapClient, 'GetFullDataSet', $productParameters, 'Product');
	
	$ResultSet = array('name'=>'GetFullDataSet', 'ResultSet'=>$GetFullDataSet);

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
		$con=mysqli_connect("213.171.200.62","Jesters1","cxfrt1NJ7f9","Jesters");
		// Check connection
/* 		if (mysqli_connect_errno())		temp comment out !!!!!!!!!!!!!!!!!!!!
   		{
   			echo "Failed to connect to Jesters database: " . mysqli_connect_error() . "<br />";
			return;			
   		}
		else
		{	
			echo "Connected to database" . "<br />";
		} */
		
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
		
		$fieldType=array("ProductCode"=>"T",		
			"ProductName"=>"T",
			"BrochureDescription"=>"T",
			"WebDescription"=>"T",
			"WashingInstructions"=>"T",
			"RRP"=>"N",
			"StockQuantity"=>"N",
			"VatRate"=>"N",
			"Gender"=>"T",
			"PackType"=>"T",
			"PackQty"=>"N",
			"Audience"=>"T",
			"FurtherDetails"=>"T",
			"Colour"=>"T",		
			"ETA"=>"T",  // date
			"CataloguePage"=>"N",
			"BarCode"=>"N",
			"Price1"=>"N",
			"Price2"=>"N",
			"Price3"=>"N",
			"Break1"=>"N",
			"Break2"=>"N",
			"Break3"=>"N",
			"unit_size"=>"N",
			"warnings"=>"T",	
			"carton"=>"N",
			"stdPrice1"=>"N",
			"stdPrice2"=>"N",
			"stdPrice3"=>"N",
			"stdBreak1"=>"N",
			"stdBreak2"=>"N",
			"stdBreak3"=>"N",
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
			"GroupID"=>"N",
			"GroupName"=>"T",
			"GroupID1"=>"N",
			"ThemeGroup1"=>"T",
			"GroupID2"=>"N",
			"ThemeGroup2"=>"T",
			"GroupID3"=>"N",
			"ThemeGroup3"=>"T",
			"EFPrice"=>"N",
			"EFQty"=>"N",
			"Size"=>"T",
			"Ext_Size"=>"T",
			"GenericCode"=>"T");
	
		$i=0;
		while($i < 20)	// Just do 20 to try it out
		// while(1==1)
		{
			$firstNodeList = $xmlNodeList['ResultSet']->item($i)->childNodes;
						
			if($firstNodeList == null)  // change to product is empty
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
					  
				if($name->nodeName=="ProductCode")
				{
					$productCode = $name->nodeValue;
					
					$recNum = $i+1;
					echo "Processing record " . $recNum . " Product Code : " . $productCode . "<br />";
					
					$selectStr = "SELECT ProductCode FROM Products WHERE ProductCode = '" . $name->nodeValue . "'";
					
					// echo "Select string is: " . $selectStr . "<br />";
					
					$result = mysqli_query($con,$selectStr);
					if($result == FALSE)
					{
						$insertStr = "INSERT INTO Products (ProductCode) VALUES ('" . $productCode . "')";												
						// echo "Insert string is: " . $insertStr . "<br />";
						
						echo "Inserting new product, product code: " . $productCode . "<br />";
						
						if( mysqli_query($con,$insertStr) == FALSE )
						{
							echo "INSERT failed : The SQL is: " . $insertStr . "<br />";
						}
					}	
					else
					{
						$result->close();
					}
				} 
					 
				// echo $name->nodeName . "<br />";	 
				
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
		
			$updateStr = substr($updateStr,0,strlen($updateStr)-2); // removes trailing comma			
		
			$DBUpdateStr = "UPDATE Products SET " . $updateStr . " WHERE ProductCode = '" . $productCode . "'";
						
			// echo "Update string is: " . $DBUpdateStr . "<br />";
			
			if(mysqli_query($con,$DBUpdateStr)==FALSE)
			{
				echo "UPDATE failed : The SQL string is: " . $DBUpdateStr . "<br />";
			}				
			
			$i++;
		}
		
		mysqli_close($con);
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
		<h3>Jesters: Populating/Updating Product List</h3>
		<?php processResults($ResultSet) ?>
	</body>
</html>