<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
	$wdsl = 'http://staging.smiffys.com/services/products.asmx?WSDL';
	$soapClient = new SoapClient("$wdsl",array("exception" => 0));
	// var_dump($soapClient->__getTypes());
	// $functions = $soapClient->__getFunctions ();
	// var_dump ($functions);
	
	$apiKey = '66a88b940c460bd5437d01c62d16235b';
	$clientID = 'EF_Jesters';
	$result = '';
	
	// $newparams = array( $apiKey, $clientID )
	// $result = $soapClient->__soapCall('GetAvailableLanguages', null);
	
	
	// $productCode = '33131M';
	$productCode = '00380 ';
	
	if(method_exists($soapClient, "GetAvailableLanguages"))
{
    echo "GOOD";
}
else
{
    echo "BAD BADGER 1";
}

if(method_exists($soapClient, "GetThemesAndProducts"))
{
    echo "GOOD";
}
else
{
    echo "BAD BADGER 2";
}

	$productParameters = array('apiKey'=>$apiKey, 'clientID'=>$clientID, 'productCode'=>$productCode);

	set_time_limit(120); // IMPORTANT – This Needs To Be Set If You Are Calling The GetFullDataSet Method.
	
	// $result=GetProduct_AllDetails($apiKey,$clientID,'12345');
	
	
	$proxy=$soapClient->GetProxy();
	
	echo "test1";	
	$result = $proxy->GetAvailableLanguages($apiKey,$clientID);
	
	echo "test2";
	$result = $soapClient->GetThemesAndProducts($apiKey,$clientID,'EN');
	
	if (is_soap_fault($result)) {
    	trigger_error("SOAP Fault: (faultcode: {$result->faultcode}, faultstring: {$result->faultstring})", E_USER_ERROR);
	}
		
	// $result = $soapClient->GetProduct_AllDetails($apiKey,$clientID,$productCode);
	
	// $GetProduct_AllDetails = GetXml($soapClient, 'GetProduct_AllDetails', $productParameters, 'Product');

	// $ResultSet = array('name'=>'GetProduct_AllDetails', 'ResultSet'=>$GetProduct_AllDetails); 

	function GetXml($soapClient, $method, $parameters, $resultSetTag)
	{
		try
		{
			$methodResultName = $method."Result";
			// var_dump($soapClient->__getFunctions());
			// $result = $soapClient->$method($parameters);
			// $simpleresult = $result->$methodResultName;
			
			return;
			// return getElementsFromResult($resultSetTag, $simpleresult);
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

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
</body>
</html>