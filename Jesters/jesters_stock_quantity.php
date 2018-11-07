<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>SubmitOrder</title>

<style type="text/css">
</style>


<?php

	$debug = false;       // set to true if you want to see debug output

	// Smiffys test (staging) system
	// $wdsl = 'http://staging.smiffys.com/services/products.asmx?WSDL';	
	// Smiffys live system
	$wdsl = 'http://webservices.smiffys.com/services/products.asmx?WSDL';
	
	$soapClient = new SoapClient("$wdsl",array('trace' => 1));

	if($debug == true)
		var_dump($soapClient->__getTypes());
		
	$returnCode = "";

	function ProcessRequest($soapClient, $productCode, $debug)
	{
		$inputDom = new DOMDocument;
		$inputDom->preserveWhiteSpace = FALSE;
				
		$fileName = "stockRequest.xml";
		$inputDom->load($fileName);
		$productCodeXml = $inputDom->saveXML();
		
		$nodeRoot = $inputDom->getElementsByTagName("ProductCode");
		if ($nodeRoot->length > 0) 
		{
			$productCodeNode = $nodeRoot->item(0);  
	 		$productCode = $productCodeNode->nodeValue;
			$returnCode = $productCode;
			echo "Product Code = " ,$productCodeNode->nodeValue,"<br>";
		}
		else
		{
			echo "Node not found", "<br>";
		}			
	
		$stockParams = array('apiKey'=>'66a88b940c460bd5437d01c62d16235b','clientID'=>'EF_Jesters','filterCode'=>$productCode,'filterDescription'=>'');			

		try
		{
			$result = $soapClient->GetStockQuantities_LightVersion_XML($stockParams);
			
			if ($debug == true )
			{
				echo "Request :<br>", htmlentities($soapClient->__getLastRequest()), "<br>";
				echo "Response :<br>", htmlentities($soapClient->__getLastResponse()), "<br>";
			}
		 	 
			$outputDom = new DOMDocument;
			$outputDom->preserveWhiteSpace = FALSE;
			$outputDom->loadXML($soapClient->__getLastResponse());
			
			$outputfileName = "stockResponse" . $productCode . ".xml";	
			
			$outputDom->save($outputfileName);	
			
			$newFilename = "stockRequest" . $productCode . ".xml";		
			echo $newFilename;	
			
			unlink($newFilename);   // The new file shouldn't exist but just in case we delete it here !
			rename("stockRequest.xml",$newFilename);
			
			$rc = $productCode;		
		}
		catch (SoapFault $exception)
		{
			echo $exception;
			$rc = "";
		}
		
		return $rc;
	}

?>
</head>

	<body>
		<?php 

		$productCode = "";
		$productCode = ProcessRequest($soapClient,$productCode,$debug);
		
		if($productCode=="")
		{
			echo "Stock Request Failed","<br>";
		}
		else
		{		
			if($debug==false)
			{
				$returnLoc = "Location: products-view-bysmiffycode.asp?GenericCode=" . $productCode;
				header($returnLoc);
			}
		}

		?>
        
	</body>
    </html>
