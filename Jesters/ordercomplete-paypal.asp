<%@LANGUAGE="VBSCRIPT" CODEPAGE="65001"%>
<!--#include file="Connections/jestersps.asp" -->
<%
Dim deptstoplevel
Dim deptstoplevel_cmd
Dim deptstoplevel_numRows

Set deptstoplevel_cmd = Server.CreateObject ("ADODB.Command")
deptstoplevel_cmd.ActiveConnection = MM_jestersps_STRING
deptstoplevel_cmd.CommandText = "SELECT * FROM dbo.jps_view_depts_toplevel ORDER BY toplevelid ASC" 
deptstoplevel_cmd.Prepared = true

Set deptstoplevel = deptstoplevel_cmd.Execute
deptstoplevel_numRows = 0
%>
<%
Dim subcatslist__MMColParam
subcatslist__MMColParam = "1"
If (Request.QueryString("toplevelid") <> "") Then 
  subcatslist__MMColParam = Request.QueryString("toplevelid")
End If
%>
<%
Dim subcatslist
Dim subcatslist_cmd
Dim subcatslist_numRows

Set subcatslist_cmd = Server.CreateObject ("ADODB.Command")
subcatslist_cmd.ActiveConnection = MM_jestersps_STRING
subcatslist_cmd.CommandText = "SELECT * FROM dbo.jps_view_leftnav_subcats WHERE toplevelid = ? ORDER BY subcatname ASC" 
subcatslist_cmd.Prepared = true
subcatslist_cmd.Parameters.Append subcatslist_cmd.CreateParameter("param1", 5, 1, -1, subcatslist__MMColParam) ' adDouble

Set subcatslist = subcatslist_cmd.Execute
subcatslist_numRows = 0
%>
<%
Dim toplevelselected__MMColParam
toplevelselected__MMColParam = "1"
If (Request.QueryString("toplevelid") <> "") Then 
  toplevelselected__MMColParam = Request.QueryString("toplevelid")
End If
%>
<%
Dim toplevelselected
Dim toplevelselected_cmd
Dim toplevelselected_numRows

Set toplevelselected_cmd = Server.CreateObject ("ADODB.Command")
toplevelselected_cmd.ActiveConnection = MM_jestersps_STRING
toplevelselected_cmd.CommandText = "SELECT * FROM dbo.jps_view_depts_toplevel WHERE toplevelid = ?" 
toplevelselected_cmd.Prepared = true
toplevelselected_cmd.Parameters.Append toplevelselected_cmd.CreateParameter("param1", 5, 1, -1, toplevelselected__MMColParam) ' adDouble

Set toplevelselected = toplevelselected_cmd.Execute
toplevelselected_numRows = 0
%>
<%
Dim subcaticons__MMColParam
subcaticons__MMColParam = "1"
If (Request.QueryString("toplevelid") <> "") Then 
  subcaticons__MMColParam = Request.QueryString("toplevelid")
End If
%>
<%
Dim subcaticons
Dim subcaticons_cmd
Dim subcaticons_numRows

Set subcaticons_cmd = Server.CreateObject ("ADODB.Command")
subcaticons_cmd.ActiveConnection = MM_jestersps_STRING
subcaticons_cmd.CommandText = "SELECT * FROM dbo.jps_view_leftnav_subcats WHERE toplevelid = ? ORDER BY subcatname ASC" 
subcaticons_cmd.Prepared = true
subcaticons_cmd.Parameters.Append subcaticons_cmd.CreateParameter("param1", 5, 1, -1, subcaticons__MMColParam) ' adDouble

Set subcaticons = subcaticons_cmd.Execute
subcaticons_numRows = 0
%>

<%
Dim cartitemsmainview__MMColParam
cartitemsmainview__MMColParam = Request("OrderNumber")
If (Request("OrderNumber") <> "") Then 
  cartitemsmainview__MMColParam = Request("OrderNumber")
End If
%>
<%
Dim cartitemsmainview
Dim cartitemsmainview_cmd
Dim cartitemsmainview_numRows

Set cartitemsmainview_cmd = Server.CreateObject ("ADODB.Command")
cartitemsmainview_cmd.ActiveConnection = MM_jestersps_STRING
cartitemsmainview_cmd.CommandText = "SELECT * FROM dbo.jps_view_cart_items_new_2_all WHERE cartSessionId = ? ORDER BY cartitemid desc" 
cartitemsmainview_cmd.Prepared = true
cartitemsmainview_cmd.Parameters.Append cartitemsmainview_cmd.CreateParameter("param1", 200, 1, 50, cartitemsmainview__MMColParam) ' adVarChar

Set cartitemsmainview = cartitemsmainview_cmd.Execute
cartitemsmainview_numRows = 0
%>
<%
Dim cartitemsmainview2__MMColParam
cartitemsmainview2__MMColParam = Request("OrderNumber")
If (Request("OrderNumber") <> "") Then 
  cartitemsmainview2__MMColParam = Request("OrderNumber")
End If
%>
<%
Dim cartitemsmainview2
Dim cartitemsmainview2_cmd
Dim cartitemsmainview2_numRows

Set cartitemsmainview2_cmd = Server.CreateObject ("ADODB.Command")
cartitemsmainview2_cmd.ActiveConnection = MM_jestersps_STRING
cartitemsmainview2_cmd.CommandText = "SELECT * FROM dbo.jps_view_cart_items_new_2_all WHERE cartSessionId = ? ORDER BY cartitemid desc" 
cartitemsmainview2_cmd.Prepared = true
cartitemsmainview2_cmd.Parameters.Append cartitemsmainview2_cmd.CreateParameter("param1", 200, 1, 50, cartitemsmainview2__MMColParam) ' adVarChar

Set cartitemsmainview2 = cartitemsmainview2_cmd.Execute
cartitemsmainview2_numRows = 0
%>
<%
Dim orderdetails__MMColParam
orderdetails__MMColParam = "1"
If (Request.QueryString("OrderNumber") <> "") Then 
  orderdetails__MMColParam = Request.QueryString("OrderNumber")
End If
%>
<%
Dim orderdetails
Dim orderdetails_cmd
Dim orderdetails_numRows

Set orderdetails_cmd = Server.CreateObject ("ADODB.Command")
orderdetails_cmd.ActiveConnection = MM_jestersps_STRING
orderdetails_cmd.CommandText = "SELECT * FROM dbo.jps_view_order_details_all WHERE cartSessionId = ? ORDER BY orderid DESC" 
orderdetails_cmd.Prepared = true
orderdetails_cmd.Parameters.Append orderdetails_cmd.CreateParameter("param1", 200, 1, 50, orderdetails__MMColParam) ' adVarChar

Set orderdetails = orderdetails_cmd.Execute
orderdetails_numRows = 0
%>
<%
Dim Repeat1__numRows
Dim Repeat1__index

Repeat1__numRows = -1
Repeat1__index = 0
deptstoplevel_numRows = deptstoplevel_numRows + Repeat1__numRows
%>
<%
Dim Repeat2__numRows
Dim Repeat2__index

Repeat2__numRows = -1
Repeat2__index = 0
subcatslist_numRows = subcatslist_numRows + Repeat2__numRows
%>
<%
Dim Repeat3__numRows
Dim Repeat3__index

Repeat3__numRows = -1
Repeat3__index = 0
cartitemsmainview_numRows = cartitemsmainview_numRows + Repeat3__numRows
%>
<%
Dim Repeat4__numRows
Dim Repeat4__index

Repeat4__numRows = -1
Repeat4__index = 0
cartitemsmainview2_numRows = cartitemsmainview2_numRows + Repeat4__numRows
%>

<%
	Dim Lines(100,3) 
	lineCount = 0
%>

<%
	orderNum = Request("OrderNumber")
	fileName = "orderOutput" & orderNum & ".xml"
	
	' response.write(fileName)
	
	outputFileExists = false
	submitOrder = false
	
	dim fs
	set fs=Server.CreateObject("Scripting.FileSystemObject")
	if fs.FileExists(Server.MapPath(fileName)) then
		outputFileExists = true
	end if
	set fs=nothing
	
	if outputFileExists = true then
		
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
			
			' response.write("New Element")

			
			' order = itemAttrib.SelectSingleNode("Status").text
			' Lines(0,0) = order
			' orderNum = itemAttrib.SelectSingleNode("YourOrderNumber").text
			   %>
	   <tr>
		  <td><%'=Lines(lineCount-1,0)%></td>
		  <td><%'=Lines(lineCount-1,1)%></td>
		  <td><%'=Lines(lineCount-1,2)%></td>           
	   </tr>
	<%
	
		Next
		
		Set xmlObj = nothing		
	end if
	
	' response.write(GetStatus("24112"))
%>
<%
    Dim MM_editCmd

    Set MM_editCmd = Server.CreateObject ("ADODB.Command")
    MM_editCmd.ActiveConnection = MM_jestersps_STRING
    MM_editCmd.CommandText = "INSERT INTO dbo.jps_orders_completed (cartSessionId, first_name, last_name) VALUES (?, ?, ?)" 
    MM_editCmd.Prepared = true
    MM_editCmd.Parameters.Append MM_editCmd.CreateParameter("param1", 202, 1, 50, (orderdetails.Fields.Item("cartSessionId").Value)) ' adVarWChar
    MM_editCmd.Parameters.Append MM_editCmd.CreateParameter("param2", 202, 1, 50, (orderdetails.Fields.Item("first_name").Value)) ' adVarWChar
    MM_editCmd.Parameters.Append MM_editCmd.CreateParameter("param3", 202, 1, 50, (orderdetails.Fields.Item("last_name").Value)) ' adVarWChar
    MM_editCmd.Execute
    MM_editCmd.ActiveConnection.Close
	
%>
<% 

'Dimension variables
Dim strBody 			'Holds the body of the e-mail
Dim objJMail 			'Holds the mail server object
Dim strMyEmailAddress 		'Holds your e-mail address
Dim strSMTPServerAddress	'Holds the SMTP Server address
Dim strCCEmailAddress		'Holds any carbon copy e-mail addresses if you want to send carbon copies of the e-mail
Dim strBCCEmailAddress		'Holds any blind copy e-mail addresses if you wish to send blind copies of the e-mail
Dim strReturnEmailAddress	'Holds the return e-mail address of the user


'----------------- Place your e-mail address in the following sting ---------------------------------

strMyEmailAddress = (orderdetails.Fields.Item("email_address").Value)

'---------- Place the address of the SMTP server you are using in the following sting ---------------

strSMTPServerAddress = "smtp.jesterspartystores.com"

'-------------------- Place Carbon Copy e-mail address in the following sting ------------------------

strCCEmailAddress = "charlie@jesterspartystores.com" 'Use this string only if you want to send the carbon copies of the e-mail

'-------------------- Place Blind Copy e-mail address in the following sting -------------------------

strBCCEmailAddress = "" 'Use this string only if you want to send the blind copies of the e-mail

'-----------------------------------------------------------------------------------------------------


'Read in the users e-mail address
strReturnEmailAddress = "sales@jesterspartystores.com"


'Initialse strBody string with the body of the e-mail
strBody = "<h2>Jesters Party Stores Order Information</h2>" & vbCrLf
strBody = strBody & "<h2>Order Ref: " & (orderdetails.Fields.Item("cartSessionId").Value) & vbCrLf
strBody = strBody & "</h2>" & vbCrLf
strBody = strBody & "<p>Delivery: " & (orderdetails.Fields.Item("delivery_option").Value) & vbCrLf
strBody = strBody & "<br>" & vbCrLf
strBody = strBody & "Special Instructions: " & (orderdetails.Fields.Item("special_instructions").Value) & vbCrLf
strBody = strBody & "</p>" & vbCrLf
strBody = strBody & "<u>Order Items</u>: " & vbCrLf
strBody = strBody & "<br><br>" & vbCrLf
While ((Repeat3__numRows <> 0) AND (NOT cartitemsmainview.EOF)) 
strBody = strBody & (cartitemsmainview.Fields.Item("product_title").Value) & ", Qty: " & (cartitemsmainview.Fields.Item("qtyrequired").Value) & " at £" & FormatNumber((cartitemsmainview.Fields.Item("product_price").Value),2) & vbCrLf
strBody = strBody & "<br>" & vbCrLf
  Repeat3__index=Repeat3__index+1
  Repeat3__numRows=Repeat3__numRows-1
  cartitemsmainview.MoveNext()
Wend

strBody = strBody & "ORDER TOTAL: £" & FormatNumber((orderdetails.Fields.Item("ordertotal").Value),2) & vbCrLf
strBody = strBody & "<br><br>" & vbCrLf
strBody = strBody & "Name: " & (orderdetails.Fields.Item("first_name").Value) & " " & (orderdetails.Fields.Item("last_name").Value) & vbCrLf
strBody = strBody & "<br>" & vbCrLf
strBody = strBody & "Address 1: " & (orderdetails.Fields.Item("address1").Value) & vbCrLf
strBody = strBody & "<br>" & vbCrLf
strBody = strBody & "Address 2: " & (orderdetails.Fields.Item("address2").Value) & vbCrLf
strBody = strBody & "<br>" & vbCrLf
strBody = strBody & "Town/City: " & (orderdetails.Fields.Item("towncity").Value) & vbCrLf
strBody = strBody & "<br>" & vbCrLf
strBody = strBody & "County: " & (orderdetails.Fields.Item("county").Value) & vbCrLf
strBody = strBody & "<br>" & vbCrLf
strBody = strBody & "Postcode: " & (orderdetails.Fields.Item("postcode").Value) & vbCrLf
strBody = strBody & "<br>" & vbCrLf
strBody = strBody & "Telephone: " & (orderdetails.Fields.Item("telephone").Value) & vbCrLf
strBody = strBody & "<br>" & vbCrLf
strBody = strBody & "Email: " & Session("email") & vbCrLf
strBody = strBody & "<br><br>" & vbCrLf
strBody = strBody & "<u>Delivery Address</u>: " & vbCrLf
strBody = strBody & "<br>" & vbCrLf
strBody = strBody & "Address 1: " & (orderdetails.Fields.Item("delivery_address1").Value) & vbCrLf
strBody = strBody & "<br>" & vbCrLf
strBody = strBody & "Address 2: " & (orderdetails.Fields.Item("delivery_address2").Value) & vbCrLf
strBody = strBody & "<br>" & vbCrLf
strBody = strBody & "Town/City: " & (orderdetails.Fields.Item("delivery_towncity").Value) & vbCrLf
strBody = strBody & "<br>" & vbCrLf
strBody = strBody & "County: " & (orderdetails.Fields.Item("delivery_county").Value) & vbCrLf
strBody = strBody & "<br>" & vbCrLf
strBody = strBody & "Postcode: " & (orderdetails.Fields.Item("delivery_postcode").Value) & vbCrLf
strBody = strBody & "<br>" & vbCrLf

'Check to see if the user has entered an e-mail address and that it is a valid address otherwise set the e-mail address to your own otherwise the e-mail will be rejected
If Len(strReturnEmailAddress) < 5 OR NOT Instr(1, strReturnEmailAddress, " ") = 0 OR InStr(1, strReturnEmailAddress, "@", 1) < 2 OR InStrRev(strReturnEmailAddress, ".") < InStr(1, strReturnEmailAddress, "@", 1) Then
	
	'Set the return e-mail address to your own
	strReturnEmailAddress = strMyEmailAddress
End If	


'Send the e-mail

'Create the e-mail server object
Set objJMail = Server.CreateObject("JMail.SMTPMail")

'Out going SMTP mail server address
objJMail.ServerAddress = strSMTPServerAddress

'Senders email address
objJMail.Sender = strReturnEmailAddress

'Senders name
objJMail.SenderName = "Jesters Party Stores Website"

'Who the e-mail is sent to
objJMail.AddRecipient strMyEmailAddress

'Who the carbon copies are sent to
objJMail.AddRecipientCC strCCEmailAddress

'Who the blind copies are sent to
objJMail.AddRecipientBCC strBCCEmailAddress

'Set the subject of the e-mail
objJMail.Subject = "Jesters Party Stores Order Information"


'Set the main body of the e-mail (HTML format)
objJMail.HTMLBody = strBody

'Set the main body of the e-mail (Plain Text format)
'objJMail.Body = strBody

'Importance of the e-mail ( 1 - highest priority, 3 - normal, 5 - lowest)
objJMail.Priority = 3 

'Send the e-mail
objJMail.Execute

'Close the server object
Set objJMail = Nothing
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jesters Party Stores | Shopping Basket</title>
<link href="jestersps.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="//use.typekit.net/oqc4xpo.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
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

function GetStatus(ProductCode) 
	 prodCount = 0
	 prodStatus = ""
     While prodCount < lineCount 
     	if Lines(prodCount,0) = ProductCode then
			prodStatus = Lines(prodCount,2)
	    end if
		prodCount = prodCount + 1
     Wend
	 GetStatus = prodStatus 
end function

%>
</head>

<body>
	<div class="ContainerOuterMain">
    	<!-- Top Navigation Items -->
        <div class="ContainerTopBar">
    		<div class="ContainerInnerMain" id="InnerTop">
            <div class="ContainerTopInner">
            <!--#include file="inc-navtopleft1.asp" -->
            <div class="TopLogoHolder"><img src="images/logo-top.png" alt="Jesters Party Stores" width="433" height="367" /></div>
            <!--#include file="inc-navtopright1-nocart.asp" -->
            </div>
            </div>
    	</div>
        
        <!-- MiddleItems -->
        <div class="ContainerInnerMain" id="InnerMiddle">
        	<!-- Left Navigation -->
            <!--#include file="inc-navleft1.asp" -->
                
                <div class="MiddleContent1">
<div class="MiddleIconsHolder1">
                    	<div class="MiddleTitleLrg1">Thank you for your order</div>
                        
                        <div class="MiddleTitleLrg2">Order reference: <strong><%= Request("OrderNumber") %></strong></div>
                        <div class="MiddleTitleLrg7"><%=(orderdetails.Fields.Item("delivery_option").Value)%> at £<%=(orderdetails.Fields.Item("delivery_cost").Value)%></div>
<% If items_count <> 0 Then %>
                        <div class="MiddleTitleLrg2">your ordered items:</div>
                        <% End if %>
                        <% 
While ((Repeat4__numRows <> 0) AND (NOT cartitemsmainview2.EOF)) 
%>
<% If (cartitemsmainview2.Fields.Item("Expr1").Value) = "Funshack" Then
		  		this_image_url = "admin/prodimages/thumb_" & Mid((cartitemsmainview2.Fields.Item("Product_Code").Value),1,4) & " " & (cartitemsmainview2.Fields.Item("product_title").Value) & " Sml"
				End if
			 %>
          <% If (cartitemsmainview2.Fields.Item("Expr1").Value) = "Rubies" Then
		  		this_image_url = "admin/prodimages-rubies/thumb_" & (cartitemsmainview2.Fields.Item("Product_Code").Value)
				End if
			 %>
              <% If (cartitemsmainview2.Fields.Item("Expr1").Value) = "Smiffys" Then
		  		this_image_url = "admin/prodimages-smiffys/thumb_" & Mid((cartitemsmainview2.Fields.Item("Product_Code").Value),1,5)
				End if
			 %>
             <% If (cartitemsmainview2.Fields.Item("toplevelid").Value) <> 1 Then
			 		this_image_url = "admin/prodimages/thumb_" & (cartitemsmainview2.Fields.Item("Image_Ref").Value)
				End if
			 %>
             <% If (cartitemsmainview2.Fields.Item("toplevelid").Value) <> 1 AND (cartitemsmainview2.Fields.Item("Expr1").Value) = "Smiffys" Then
			 		this_image_url = "admin/prodimages-smiffys/thumb_" & (cartitemsmainview2.Fields.Item("Image_Ref").Value)
				End if
			 %>
             <% If (cartitemsmainview2.Fields.Item("toplevelid").Value) <> 1 AND (cartitemsmainview2.Fields.Item("Expr1").Value) = "Rubies" AND isnull(cartitemsmainview2.Fields.Item("Image_Ref").Value) Then
			 		this_image_url = "admin/prodimages-rubies/thumb_" & (cartitemsmainview2.Fields.Item("Product_Code").Value)
				End if
			 %>
             <% If (cartitemsmainview2.Fields.Item("toplevelid").Value) = 7 AND (cartitemsmainview2.Fields.Item("Expr1").Value) = "Amscan" Then
			 		this_image_url = "admin/prodimages-balloons/thumb_" & Mid((cartitemsmainview2.Fields.Item("Product_Code").Value),1,5)
				End if
			 %>
                        <div class="BasketItemHolder">
                            <div class="BasketImageIcon"><img src="<%=this_image_url%>.jpg" width="100" border="0" onerror="this.src='images/awaitingimage.jpg';" /></div>
                          <div class="BasketItemTitle"><strong><%=(cartitemsmainview2.Fields.Item("product_title").Value)%></strong><br />
                              price: <strong>&pound;<%=FormatNumber((cartitemsmainview2.Fields.Item("product_price").Value),2)%></strong><br />
colour: <strong><%=(cartitemsmainview2.Fields.Item("Colour").Value)%></strong><br />
                              size: <strong><%=(cartitemsmainview2.Fields.Item("Product_Size").Value)%></strong><br />
                              product code:<strong><%=(cartitemsmainview2.Fields.Item("GenericCode").Value)%></strong><br />
                              status:
                              <%
							  prodStatus = GetStatus((cartitemsmainview2.Fields.Item("GenericCode").Value))
							  if prodStatus = "" then
							  	prodStatus = "Submitting"
							  end if
							  if prodStatus = "RejectedOutOfStock" then
							  	prodStatus = "Out Of Stock"
							  end if
  							  if prodStatus = "RejectedProductNotFound" then
							  	prodStatus = "Product Not Found"
							  end if				  							  
							   %>
							  	<strong><%=prodStatus%></strong>
                              <br />
                          </div>
                          
                          <div class="BasketItemActionBox2">
                          <br />Quantity:<br />
                          <%=(cartitemsmainview2.Fields.Item("qtyrequired").Value)%>                          </div>
                          <div class="BasketItemActionBox3"><br />
                          SUB TOTAL:<br />
                          <% item_sub_total = (cartitemsmainview2.Fields.Item("product_price").Value) * (cartitemsmainview2.Fields.Item("qtyrequired").Value) %>
                          <span style="font-size:22px;">&pound;<%=FormatNumber(item_sub_total,2)%></span>                          </div>
                            </div>
                        <% 
  Repeat4__index=Repeat4__index+1
  Repeat4__numRows=Repeat4__numRows-1
  cartitemsmainview2.MoveNext()
Wend
%>

<table width="700" cellpadding="5" cellspacing="0" class="TableStyle1">
                          <tr>
                            <td height="36" colspan="2" align="right"><div align="left"><u><strong>Your
                                    Details</strong></u></div>
                                <div align="left"></div></td>
                          </tr>
                          <tr>
                            <td width="104" align="right"><div align="left">First&nbsp;name:</div></td>
                            <td><strong><%=(orderdetails.Fields.Item("first_name").Value)%></strong></td>
                          </tr>
                          <tr>
                            <td align="right"><div align="left">Last&nbsp;name:</div></td>
                            <td><strong><%=(orderdetails.Fields.Item("last_name").Value)%></strong></td>
                          </tr>
                          <tr>
                            <td align="right"><div align="left">Address 1:</div></td>
                            <td><strong><%=(orderdetails.Fields.Item("address1").Value)%></strong></td>
                          </tr>
                          <tr>
                            <td>Address 2:</td>
                            <td><strong><%=(orderdetails.Fields.Item("address2").Value)%></strong></td>
                          </tr>
                          <tr>
                            <td align="right"><div align="left">Town/City:</div></td>
                            <td><strong><%=(orderdetails.Fields.Item("towncity").Value)%></strong></td>
                          </tr>
                          <tr>
                            <td>Postcode:</td>
                            <td><strong><%=(orderdetails.Fields.Item("postcode").Value)%></strong></td>
                          </tr>
                          <tr>
                            <td align="right"><div align="left">Email:</div></td>
                            <td><strong><%=(orderdetails.Fields.Item("email_address").Value)%></strong></td>
                          </tr>
                          <tr>
                            <td>Special Instructons:</td>
                            <td><strong><%=(orderdetails.Fields.Item("special_instructions").Value)%></strong></td>
                          </tr>

                          <tr>
                            <td colspan="2"><u><strong>Delivery  Details</strong></u></td>
                          </tr>
                          <tr>
                            <td align="right"><div align="left">First&nbsp;name:</div></td>
                            <td><strong><%=(orderdetails.Fields.Item("delivery_first_name").Value)%></strong></td>
                          </tr>
                          <tr>
                            <td align="right"><div align="left">Last&nbsp;name:</div></td>
                            <td><strong><%=(orderdetails.Fields.Item("delivery_last_name").Value)%></strong></td>
                          </tr>
                          <tr>
                            <td align="right"><div align="left">Address 1:</div></td>
                            <td><strong><%=(orderdetails.Fields.Item("delivery_address1").Value)%></strong></td>
                          </tr>
                          <tr>
                            <td>Address 2:</td>
                            <td><strong><%=(orderdetails.Fields.Item("delivery_address2").Value)%></strong></td>
                          </tr>
                          <tr>
                            <td align="right"><div align="left">Town/City:</div></td>
                            <td><strong><%=(orderdetails.Fields.Item("delivery_towncity").Value)%></strong></td>
                          </tr>
                          <tr>
                            <td>Postcode:</td>
                            <td><strong><%=(orderdetails.Fields.Item("delivery_postcode").Value)%></strong></td>
                          </tr>
                          
                          <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                          </tr>
        </table>


</div>
                </div>
        </div>
        
        
        <!-- Footer -->
        <!--#include file="inc-footer1.asp" -->
        
        
    </div> <!-- ContainerOuterMain END -->

<%
	if outputFileExists = false then
	
		' email = "mark.foster@dpcar.co.uk"
		' telephone = "01427123456"
		' recipient = "Mark Foster"
		' addressline = "73 Farleigh Road"
		' city = "Warlingham"
		' postcode = "CR6 9EJ"
		' county = "Surrey"
		' countrycode = "GB"
		' deliverycode = "ZZRML_1SGN"
		' productcode1 = "33321M"
		' productquantity1 = "1"
		' productcode2 = "24112"
		' productquantity2 = "3"

	
		email = (orderdetails.Fields.Item("email_address").Value)
		telephone = ""   ' not supplied to page
		recipient = (orderdetails.Fields.Item("delivery_first_name").Value) & " " & (orderdetails.Fields.Item("delivery_last_name").Value)
		addressline = (orderdetails.Fields.Item("delivery_address1").Value) & " " & (orderdetails.Fields.Item("delivery_address2").Value)
		city = (orderdetails.Fields.Item("delivery_towncity").Value)
		postcode = (orderdetails.Fields.Item("delivery_postcode").Value)
		county = "" ' not supplied to page
		countrycode = "" ' not supplied to page
		deliverycode = "ZZRML_1SGN"
		
		text="<Order>"
		text=text & "<YourOrderNumber>" & Request("OrderNumber") & "</YourOrderNumber>"
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
		' cartitemsmainview2.MoveFirst()
		cartitemsmainview2.Close()
		Set cartitemsmainview2 = Nothing
		Set cartitemsmainview2 = cartitemsmainview2_cmd.Execute

		While (NOT cartitemsmainview2.EOF) 
			text=text & "<Line>"
			text=text & "<ProductCode>" & (cartitemsmainview2.Fields.Item("GenericCode").Value) & "</ProductCode>"
			text=text & "<ProductQuantity>" & (cartitemsmainview2.Fields.Item("qtyrequired").Value) & "</ProductQuantity>"
			text=text & "</Line>"
	  	    cartitemsmainview2.MoveNext()
		Wend
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
			submitOrder = true				
		end if
		
	end if
%>
</body>
</html>
<%
deptstoplevel.Close()
Set deptstoplevel = Nothing
%>
<%
subcatslist.Close()
Set subcatslist = Nothing
%>
<%
toplevelselected.Close()
Set toplevelselected = Nothing
%>
<%
subcaticons.Close()
Set subcaticons = Nothing
%>
<%
cartitemsmainview.Close()
Set cartitemsmainview = Nothing
%>
<%
cartitemsmainview2.Close()
Set cartitemsmainview2 = Nothing
%>
<%
orderdetails.Close()
Set orderdetails = Nothing
if submitOrder = true then	
	Response.Redirect("jesters_order_entry.php")
end if
%>
