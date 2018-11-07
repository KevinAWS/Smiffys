<%@LANGUAGE="VBSCRIPT" CODEPAGE="1252"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jesters Order Entry</title>

<style type="text/css">
<!--
body {
	font: 100% Verdana, Arial, Helvetica, sans-serif;
	background: #666666;
	margin: 0; /* it's good practice to zero the margin and padding of the body element to account for differing browser defaults */
	padding: 0;
	text-align: center; /* this centers the container in IE 5* browsers. The text is then set to the left aligned default in the #container selector */
	color: #000000;
}
.oneColElsCtr #container {
	width: 46em;
	background: #FFFFFF;
	margin: 0 auto; /* the auto margins (in conjunction with a width) center the page */
	border: 1px solid #000000;
	text-align: left; /* this overrides the text-align: center on the body element. */
}
.oneColElsCtr #mainContent {
	padding: 0 20px; /* remember that padding is the space inside the div box and margin is the space outside the div box */
}
-->
</style>
<%
Response.Buffer = true 
 
Function WaitFor(SecDelay) 
     timeStart = Timer() 
     timeEnd = timeStart + SecDelay 
 
     i = SecDelay 
     Do While timeStart < timeEnd 
         timeStart = Timer() 
     Loop 
End Function 
%>
</head>

<body class="oneColElsCtr">

<%
	orderNum = "1072657072"
	fileName = "orderOutput" & orderNum & ".xml"
	
	outputFileExists = false
	
	dim fs
	set fs=Server.CreateObject("Scripting.FileSystemObject")
	if fs.FileExists(Server.MapPath(fileName)) then
		outputFileExists = true
	end if
	set fs=nothing
	
	if outputFileExists = true then
		Dim Lines(100,3) 
		
		Set xmlObj = Server.CreateObject("Microsoft.XMLDOM")
		xmlObj.async = False
		xmlObj.load(Server.MapPath(fileName))
		
		Dim itemList : Set itemList = xmlObj.DocumentElement.SelectNodes("/soap:Envelope/soap:Body/SubmitOrderResponse/SubmitOrderResult/Lines/Line")
		
		lineCount = 0
		For Each itemAttrib In itemList
			Lines(lineCount,0) = itemAttrib.SelectSingleNode("ProductCode").text    
			Lines(lineCount,1) = itemAttrib.SelectSingleNode("ProductQuantity").text   
			Lines(lineCount,2) = itemAttrib.SelectSingleNode("Status").text    
			lineCount = lineCount + 1
			
			response.write("New Element")

			
			' order = itemAttrib.SelectSingleNode("Status").text
			' Lines(0,0) = order
			' orderNum = itemAttrib.SelectSingleNode("YourOrderNumber").text
			   %>
	   <tr>
		  <td><%=Lines(lineCount-1,0)%></td>
		  <td><%=Lines(lineCount-1,1)%></td>
		  <td><%=Lines(lineCount-1,2)%></td>           
	   </tr>
	<%
	
		Next
		
		Set xmlObj = nothing		
		
	else

		email = "mark.foster@dpcar.co.uk"
		telephone = "01427123456"
		recipient = "Mark Foster"
		addressline = "73 Farleigh Road"
		city = "Warlingham"
		postcode = "CR6 9EJ"
		county = "Surrey"
		countrycode = "GB"
		deliverycode = "ZZRML_1SGN"
		productcode1 = "33321M"
		productquantity1 = "1"
		productcode2 = "24112"
		productquantity2 = "3"
	
		text="<Order>"
		text=text & "<YourOrderNumber>" & orderNum & "</YourOrderNumber>"
		text=text & "<Recipient>"
		text=text & "<Email>" & email & "</Email>"
		text=text & "<Telephone>" & telephone & "</Telephone>"
		text=text & "<Recipient>" & recipient & "</Recipient>"
		text=text & "<AddressLine>" & addressline & "</AddressLine>"
		text=text & "<City>" & city & "</City>"
		text=text & "<PostCode>" & postcode & "</PostCode>"
		text=text & "<County>" & county & "</County>"
		text=text & "<CountryCode>" & countrycode & "</CountryCode>"
		text=text & "</Recipient>"
		text=text & "<DeliveryCode>" & deliverycode & "</DeliveryCode>"
		text=text & "<Lines>"
		text=text & "<Line>"
		text=text & "<ProductCode>" & productcode1 & "</ProductCode>"
		text=text & "<ProductQuantity>" & productquantity1 & "</ProductQuantity>"
		text=text & "</Line>"
		text=text & "<Line>"
		text=text & "<ProductCode>" & productcode2 & "</ProductCode>"
		text=text & "<ProductQuantity>" & productquantity2 & "</ProductQuantity>"
		text=text & "</Line>"	
		text=text & "</Lines>"
		text=text & "</Order>"
	
		set xmlDoc=Server.CreateObject("Msxml2.DOMDocument.6.0")
	
		xmlDoc.async=false
		xmlDoc.loadXML(text)
		
		filename = "JestersOrder.xml"	
		
		break=0
		dim inputFs
		set inputFs=Server.CreateObject("Scripting.FileSystemObject")
		if inputFs.FileExists(Server.MapPath(fileName)) then
			response.write("Waiting for 5 seconds as input file already exists!")
			WaitFor(5)						
		end if
		
		if inputFs.FileExists(Server.MapPath(fileName)) then
			response.write("Order submission failed, Please try again")	
			set inputFs = nothing
		else
			set inputFs = nothing	
			xmldoc.save(Server.MapPath(filename))	
			Response.Redirect("jesters_order_entry.php")
		end if
		
	end if
%>

</body>
</html>
