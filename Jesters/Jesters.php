<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php
	$wdsl = 'http://staging.smiffys.com/services/products.asmx?WSDL';
	$soapClient = new SoapClient("$wdsl");

	// $functions = $soapClient->__getFunctions ();
	// var_dump ($functions);
	
	$apiKey = '66a88b940c460bd5437d01c62d16235b';
	$clientID = 'EF_Jesters';	

	/*if(method_exists($soapClient, "GetAvailableLanguages"))
	{
		echo "GOOD";
	}
	else
	{
		echo "BAD BADGER";
	}*/

	try
	{
		$method = 'GetAvailableLanguages';
		$result = $soapClient->$method(array('apiKey'=>$apiKey,'clientID'=>$clientID));
		return;
	}
	catch (SoapFault $exception)
	{
		echo $exception;
		return $exception;
	}
?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
</body>
</html>