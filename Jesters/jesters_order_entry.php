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
	$wdsl = 'http://staging.smiffys.com/services/orders.asmx?WSDL';	
	// Smiffys live system
	// $wdsl = 'http://webservices.smiffys.com/services/orders.asmx?WSDL';
	
	$soapClient = new SoapClient("$wdsl",array('trace' => 1));

	if($debug == true)
		var_dump($soapClient->__getTypes());

	function ProcessOrder($soapClient, $orderNum, $debug)
	{
		$inputDom = new DOMDocument;
		$inputDom->preserveWhiteSpace = FALSE;
		// $fileName = "order" . $orderNum . ".xml";
		$fileName = "jestersOrder.xml";
		$inputDom->load($fileName);
		$orderXml = $inputDom->saveXML();
		
		$nodeRoot = $inputDom->getElementsByTagName("YourOrderNumber");
		if ($nodeRoot->length > 0) {
			 $orderNumNode = $nodeRoot->item(0);    
		}
		
		$orderNum = $orderNumNode->nodeValue;
		echo "Order No. = " ,$orderNumNode->nodeValue,"<br>";			

		$orderParams = array('apiKey'=>'66a88b940c460bd5437d01c62d16235b','clientID'=>'EF_Jesters','orderXml'=>$orderXml);	

		try
		{
			$result = $soapClient->SubmitOrder($orderParams);
			
			if ($debug == true )
			{
				echo "Request :<br>", htmlentities($soapClient->__getLastRequest()), "<br>";
				echo "Response :<br>", htmlentities($soapClient->__getLastResponse()), "<br>";
			}
		 	 
			$outputDom = new DOMDocument;
			$outputDom->preserveWhiteSpace = FALSE;
			$outputDom->loadXML($soapClient->__getLastResponse());
			
			/* $nodeRoot = $outputDom->getElementsByTagName("ReturnCode");
		    if ($nodeRoot->length > 0) {
        		 $returnCode = $nodeRoot->item(0);    
     		}
			
			echo "return code node = " ,$returnCode->nodeValue,"<br>";
			
			$nodeRoot = $outputDom->getElementsByTagName("Status");
		    if ($nodeRoot->length > 0) {
        		 $status = $nodeRoot->item(0);    
     		}
			
			echo "status node = " ,$status->nodeValue,"<br>";*/

			$outputfileName = "orderOutput" . $orderNum . ".xml";	
			// $outputfileName = "orderOutput.xml";
			
			$outputDom->save($outputfileName);	
			
			/* $returnVal = $inputDom->createElement("ReturnCode");
     		$inputDom->appendChild($returnVal);
			
     		$tNode = $inputDom->createTextNode($returnCode->nodeValue);
     		$returnVal->appendChild($tNode);
			
			$returnStatus = $inputDom->createElement("Status");
     		$inputDom->appendChild($returnStatus);
			
     		$statusNode = $inputDom->createTextNode($status->nodeValue);
     		$returnStatus->appendChild($statusNode);

			echo $inputDom->saveXML();
			
			$inputDom->save($fileName);*/
			
			$newFilename = "Order" . $orderNum . ".xml";		
			echo $newFilename;		
			rename("jestersOrder.xml",$newFilename);
			
			$rc = $orderNum;		
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
		// $orderNum = trim($_POST["orderNum"]); 
		$orderNum = "";
		$orderNum = ProcessOrder($soapClient,$orderNum,$debug);
		
			if($debug==false)
	{
		$returnLoc = "Location: ordercomplete-paypal-kevtest.asp?OrderNumber=" . $orderNum;
		// header("Location: ordercomplete-paypal-kevtest.asp?OrderNumber=251216309");
		header($returnLoc);
	}

		?>
        
	</body>
    </html>
