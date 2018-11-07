<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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

<?php
$wdsl = 'http://staging.smiffys.com/services/products.asmx?WSDL';
	$soapClient = new SoapClient("$wdsl");
	
	$apiKey = '66a88b940c460bd5437d01c62d16235b';
	$clientID = 'EF_Jesters';
	
	$productCode = '12345S';

	$productParameters = array('apiKey'=>$apiKey, 'clientID'=>$clientID, 'productCode'=>$productCode);

	set_time_limit(120); // IMPORTANT – This Needs To Be Set If You Are Calling The GetFullDataSet Method.
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

<h3>Smiffy's Datafeed PHP Example</h3>
		<h4>GetProduct_AllDetails</h4>
		<table>
		<?php printRows($ResultSet) ?>
		</table>

</body>
</html>
