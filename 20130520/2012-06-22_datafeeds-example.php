<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php
	$wdsl = 'http://webservices.smiffys.com/services/products.asmx?WSDL';
	$soapClient = new SoapClient("$wdsl");
	
	$apiKey = 'aa36302a322a82a3a42a5a149439a59a';
	$clientID = '.atest1';
	
	$productCode = '33131M';

	$productParameters = array('apiKey'=>$apiKey, 'clientID'=>$clientID, 'productCode'=>$productCode);

	set_time_limit(120); // IMPORTANT � This Needs To Be Set If You Are Calling The GetFullDataSet Method.
	$GetProduct_AllDetails = GetXml($soapClient, 'GetProduct_AllDetails', $productParameters, 'Product');

	$ResultSet = array('name'=>'GetProduct_AllDetails', 'ResultSet'=>$GetProduct_AllDetails);

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
	
	function printRows($xmlNodeList)
	{
		$firstNodeList = $xmlNodeList['ResultSet']->item(0)->childNodes;
			  
		foreach($firstNodeList as $name)
		{
			echo "<tr>
					  <td id=\"Attribute\">
					  $name->nodeName</td>
					  <td id=\"Value\">
					  $name->nodeValue</td>
				  </tr>";
		}
	}
?>


<html>
	<head>
		<title>Datafeeds PHP Example</title>
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
		<h3>Smiffy's Datafeed PHP Example</h3>
		<h4>GetProduct_AllDetails</h4>
		<table>
		<?php printRows($ResultSet) ?>
		</table>
	</body>
</html>