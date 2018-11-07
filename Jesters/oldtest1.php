<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<?php

$orderParams = array(
		'apiKey'=>'66a88b940c460bd5437d01c62d16235b',
		'clientID'=>'EF_Jesters',
		 array(
			  array(
					'YourOrderNumber'=>'2013/05/22-1-Jesters',
					array(
						'Email'=>'jesters@example.com',
						'Telephone'=>'01462876543',
						'Recipient'=>'Mr Benn',
						'AddressLine'=>'52 Festive Road',
						'City'=>'London',
						'PostCode'=>'EN61AJ',
						'County'=>'London',
						'CountryCode'=>'GB',
						'DeliveryCode'=>'ZZRML_NDSD',
						array(
							  array(
							 	'ProductCode'=>'33131M',
								'ProductQuantity'=>'3'
									)
							  )
						)
					)
			  )
		);
	
$shop = array( 
			  'apiKey'=>'66a88b940c460bd5437d01c62d16235b',
			  'clientID'=>'EF_Jesters',
			  array( 'Title' => "rose", 
                      'Price' => 1.25,
                      'Number' => 15 
                    ),
               array( 'Title' => "daisy", 
                      'Price' => 0.75,
                      'Number' => 25,
                    ),
               array( 'Title' => "orchid", 
                      'Price' => 1.15,
                      'Number' => 7 
                    )
             );

echo $orderParams["apiKey"];
echo "<br />";
echo $orderParams["clientID"];
echo "<br />";
echo $orderParams[0][0][0][0][0]["ProductCode"];
echo "<br />";
	
	
	
echo "<h1>Manual access to each element from associative array</h1>";

for ($row = 0; $row < 3; $row++)
{
    echo $shop[$row]["Title"]." costs ".$shop[$row]["Price"]." and you get ".$shop[$row]["Number"];
    echo "<br />";
}

echo "<h1>Using foreach loop to display elements</h1>";

echo "<ol>";
for ($row = 0; $row < 3; $row++)
{
    echo "<li><b>The row number $row</b>";
    echo "<ul>";

    foreach($shop[$row] as $key => $value)
    {
        echo "<li>".$value."</li>";
    }

    echo "</ul>";
    echo "</li>";
}
echo "</ol>";
	
	
	
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
		<h3>Array Test</h3>
	</body>
</html>