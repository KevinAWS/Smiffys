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
Dim MM_editAction
MM_editAction = CStr(Request.ServerVariables("SCRIPT_NAME"))
If (Request.QueryString <> "") Then
  MM_editAction = MM_editAction & "?" & Server.HTMLEncode(Request.QueryString)
End If

' boolean to abort record edit
Dim MM_abortEdit
MM_abortEdit = false
%>
<%
' IIf implementation
Function MM_IIf(condition, ifTrue, ifFalse)
  If condition = "" Then
    MM_IIf = ifFalse
  Else
    MM_IIf = ifTrue
  End If
End Function
%>
<%
If (CStr(Request("MM_insert")) = "form1") Then
  If (Not MM_abortEdit) Then
    ' execute the insert
    Dim MM_editCmd

    Set MM_editCmd = Server.CreateObject ("ADODB.Command")
    MM_editCmd.ActiveConnection = MM_jestersps_STRING
    MM_editCmd.CommandText = "INSERT INTO dbo.jps_cart_items (qtyrequired, productid, productcode, cartSessionId, sizeproductcode, GenericCode, product_title, supplier, size_description, product_price, stock_level, product_colour) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)" 
    MM_editCmd.Prepared = true
    MM_editCmd.Parameters.Append MM_editCmd.CreateParameter("param1", 5, 1, -1, MM_IIF(Request.Form("qty"), Request.Form("qty"), null)) ' adDouble
    MM_editCmd.Parameters.Append MM_editCmd.CreateParameter("param2", 5, 1, -1, MM_IIF(Request.Form("pid"), Request.Form("pid"), null)) ' adDouble
    MM_editCmd.Parameters.Append MM_editCmd.CreateParameter("param3", 202, 1, 50, Request.Form("pcode")) ' adVarWChar
    MM_editCmd.Parameters.Append MM_editCmd.CreateParameter("param4", 202, 1, 50, Request.Form("SiD")) ' adVarWChar
	MM_editCmd.Parameters.Append MM_editCmd.CreateParameter("param5", 202, 1, 50, Request.Form("sizeproductcode")) ' adVarWChar
	MM_editCmd.Parameters.Append MM_editCmd.CreateParameter("param6", 202, 1, 50, Request.Form("GenericCode")) ' adVarWChar
	MM_editCmd.Parameters.Append MM_editCmd.CreateParameter("param7", 202, 1, 250, Request.Form("product_title")) ' adVarWChar
	MM_editCmd.Parameters.Append MM_editCmd.CreateParameter("param8", 202, 1, 50, Request.Form("supplier")) ' adVarWChar
	MM_editCmd.Parameters.Append MM_editCmd.CreateParameter("param9", 202, 1, 50, Request.Form("sizeproductcode")) ' adVarWChar
	MM_editCmd.Parameters.Append MM_editCmd.CreateParameter("param10", 5, 1, -1, MM_IIF(Request.Form("product_price"), Request.Form("product_price"), null)) ' adDouble
	MM_editCmd.Parameters.Append MM_editCmd.CreateParameter("param11", 5, 1, -1, MM_IIF(Request.Form("stock_level"), Request.Form("stock_level"), null)) ' adDouble
	MM_editCmd.Parameters.Append MM_editCmd.CreateParameter("param12", 202, 1, 50, Request.Form("product_colour")) ' adVarWChar
    MM_editCmd.Execute
    MM_editCmd.ActiveConnection.Close

    ' append the query string to the redirect URL
    Dim MM_editRedirectUrl
    MM_editRedirectUrl = "products-quickcart.asp?action=Added"
    If (Request.QueryString <> "") Then
      If (InStr(1, MM_editRedirectUrl, "?", vbTextCompare) = 0) Then
        MM_editRedirectUrl = MM_editRedirectUrl & "?" & Request.QueryString
      Else
        MM_editRedirectUrl = MM_editRedirectUrl & "&" & Request.QueryString
      End If
    End If %>
  <% End If
End If
%>
<%
Dim toplevelcat__MMColParam
toplevelcat__MMColParam = "1"
If (Request.QueryString("toplevelid") <> "") Then 
  toplevelcat__MMColParam = Request.QueryString("toplevelid")
End If
%>
<%
Dim toplevelcat
Dim toplevelcat_cmd
Dim toplevelcat_numRows

Set toplevelcat_cmd = Server.CreateObject ("ADODB.Command")
toplevelcat_cmd.ActiveConnection = MM_jestersps_STRING
toplevelcat_cmd.CommandText = "SELECT * FROM dbo.jps_view_depts_toplevel WHERE toplevelid = ?" 
toplevelcat_cmd.Prepared = true
toplevelcat_cmd.Parameters.Append toplevelcat_cmd.CreateParameter("param1", 5, 1, -1, toplevelcat__MMColParam) ' adDouble

Set toplevelcat = toplevelcat_cmd.Execute
toplevelcat_numRows = 0
%>
<%
Dim subcat__MMColParam
subcat__MMColParam = "1"
If (Request.QueryString("subcatid") <> "") Then 
  subcat__MMColParam = Request.QueryString("subcatid")
End If
%>
<%
Dim subcat
Dim subcat_cmd
Dim subcat_numRows

Set subcat_cmd = Server.CreateObject ("ADODB.Command")
subcat_cmd.ActiveConnection = MM_jestersps_STRING
subcat_cmd.CommandText = "SELECT * FROM dbo.jps_depts_subcats WHERE subcatid = ?" 
subcat_cmd.Prepared = true
subcat_cmd.Parameters.Append subcat_cmd.CreateParameter("param1", 5, 1, -1, subcat__MMColParam) ' adDouble

Set subcat = subcat_cmd.Execute
subcat_numRows = 0
%>
<%
Dim stocklevels__MMColParam
stocklevels__MMColParam = "1"
If (Request.QueryString("GenericCode") <> "") Then 
  stocklevels__MMColParam = Request.QueryString("GenericCode")
End If
%>
<%
Dim stocklevels
Dim stocklevels_cmd
Dim stocklevels_numRows

Set stocklevels_cmd = Server.CreateObject ("ADODB.Command")
stocklevels_cmd.ActiveConnection = MM_jestersps_STRING
stocklevels_cmd.CommandText = "SELECT * FROM dbo.jps_view_smiffys_stocklevels WHERE GenericCode = ?" 
stocklevels_cmd.Prepared = true
stocklevels_cmd.Parameters.Append stocklevels_cmd.CreateParameter("param1", 200, 1, 255, stocklevels__MMColParam) ' adVarChar

Set stocklevels = stocklevels_cmd.Execute
stocklevels_numRows = 0
%>
<%
Dim productslist__MMColParam
productslist__MMColParam = "1"
If (Request.QueryString("GenericCode") <> "") Then 
  productslist__MMColParam = cStr(Request.QueryString("GenericCode"))
End If
%>
<%
Dim productslist
Dim productslist_cmd
Dim productslist_numRows

Set productslist_cmd = Server.CreateObject ("ADODB.Command")
productslist_cmd.ActiveConnection = MM_jestersps_STRING
productslist_cmd.CommandText = "SELECT * FROM dbo.jps_view_smiffys_product WHERE GenericCode LIKE ?" 
productslist_cmd.Prepared = true
productslist_cmd.Parameters.Append productslist_cmd.CreateParameter("param1", 200, 1, 255, "%" + productslist__MMColParam + "%") ' adVarChar
Set productslist = productslist_cmd.Execute
productslist_numRows = 0
%>
<%
Dim productsizes__MMColParam
productsizes__MMColParam = "1"
If (Request.QueryString("GenericCode") <> "") Then 
  productsizes__MMColParam = cStr(Request.QueryString("GenericCode"))
End If
%>
<%
Dim productsizes
Dim productsizes_cmd
Dim productsizes_numRows

Set productsizes_cmd = Server.CreateObject ("ADODB.Command")
productsizes_cmd.ActiveConnection = MM_jestersps_STRING
productsizes_cmd.CommandText = "SELECT * FROM dbo.jps_view_smiffys_product WHERE GenericCode LIKE ?" 
productsizes_cmd.Prepared = true
productsizes_cmd.Parameters.Append productsizes_cmd.CreateParameter("param1", 200, 1, 255, "%" + productsizes__MMColParam + "%") ' adVarChar
Set productsizes = productsizes_cmd.Execute
productsizes_numRows = 0
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
stocklevels_numRows = stocklevels_numRows + Repeat3__numRows
%>

<%
	Dim Lines(100,3) 
	lineCount = 0
	Dim StockCount
	Dim StockCountStr
%>

<%
	prodCode = Request("GenericCode")
	fileName = "stockResponse" & prodCode & ".xml"
	
	' response.write(fileName)
	
	outputFileExists = false
	submitStockRequest = false
	
	dim fs
	set fs=Server.CreateObject("Scripting.FileSystemObject")
	if fs.FileExists(Server.MapPath(fileName)) then
		outputFileExists = true
	end if

	if outputFileExists = true then
		' response.write("output file exists")
		
		Set xmlObj = Server.CreateObject("Microsoft.XMLDOM")
		xmlObj.async = False
		xmlObj.load(Server.MapPath(fileName))
		
		Dim itemList : Set itemList = xmlObj.DocumentElement.SelectNodes("/soap:Envelope/soap:Body/GetStockQuantities_LightVersion_XMLResponse/GetStockQuantities_LightVersion_XMLResult/StockValues/Product")
		
		' looping here but in theory there should only be one entry
		lineCount = 0
		For Each itemAttrib In itemList
			Lines(lineCount,0) = itemAttrib.SelectSingleNode("Product_Code").text    
			Lines(lineCount,1) = itemAttrib.SelectSingleNode("Available_Stock").text   
			Lines(lineCount,2) = itemAttrib.SelectSingleNode("Due_Date").text    
			lineCount = lineCount + 1		
		Next
		
		' Response.Write(Lines(0,1))
		
		' Lines(0,1) = "0"  ' uncomment to test 'out-of-stock' 
		
		StockCountStr = Lines(0,1)
		StockCount = Cint(Lines(0,1))
		
		set f=fs.GetFile(Server.MapPath(fileName))
 		f.Delete
 		set f=nothing
		
		fileName2 = "stockRequest" & prodCode & ".xml"
		set f=fs.GetFile(Server.MapPath(fileName2))
 		f.Delete
 		set f=nothing
		
	end if
	
	set fs=nothing
%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><%=(productslist.Fields.Item("ProductName").Value)%> - Jesters Party Stores</title>
<link href="jestersps.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="//use.typekit.net/oqc4xpo.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<link rel="stylesheet" href="PaginationStyles/misalgoritmos/pagination.css" type="text/css" />
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-39107099-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>

<body>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=11969165742";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
	<div class="ContainerOuterMain">
    	<!-- Top Navigation Items -->
        <div class="ContainerTopBar">
    		<div class="ContainerInnerMain" id="InnerTop">
            <div class="ContainerTopInner">
            <!--#include file="inc-navtopleft1.asp" -->
            <div class="TopLogoHolder"><img src="images/logo-top.png" alt="Jesters Party Stores" width="433" height="367" /></div>
            <!--#include file="inc-navtopright1.asp" -->
            </div>
            </div>
    	</div>
        
        <!-- MiddleItems -->
        <div class="ContainerInnerMain" id="InnerMiddle">
        	<!-- Left Navigation -->
            <!--#include file="inc-navleft1.asp" -->
                
                <div class="MiddleContent1">
<div class="MiddleIconsHolder1">
						<div class="MiddleIconsLeftHolder1">
                    	<div class="MiddleTitleLrg1"><%=(toplevelcat.Fields.Item("toplevelname").Value)%></div>
                        <div class="MiddleTitleLrg2"><%=(productslist.Fields.Item("GroupName").Value)%></div>
                        <div class="MiddleTitleLrg7"><%=(productslist.Fields.Item("ThemeName").Value)%></div>
        				<div class="MiddleTitleLrg6"><%=(productslist.Fields.Item("WebDescription").Value)%></div>
                        </div>
                        <div class="MiddleIconsRightHolder1">
                        <% If not isnull(productslist.Fields.Item("RRP").Value) Then %>
                        <div class="MiddleTitleLrg5">&pound;<%=FormatNumber((productslist.Fields.Item("RRP").Value),2)%></strong></div>
                        <% End if %>
                        <div class="MiddleTitleLrg6">Product Code: <strong><%=Request("GenericCode")%></strong></div>
                        <div class="MiddleTitleLrg6"><u>Stock levels:</u> <%=StockCountStr%></div>
                        <div class="MiddleTitleLrg6SmlText">
                        <% item_count = 0 %>
                          <% 
While ((Repeat3__numRows <> 0) AND (NOT stocklevels.EOF)) 
%>
                           <strong></strong><%=(stocklevels.Fields.Item("Size").Value)%> -
  <% If StockCount = 0 Then %>
                          <strong>Out of Stock</strong>
                          <% End if %>
                          <% If StockCount > 0 Then %>
                          <strong>In Stock</strong>
                          <% item_count = item_count + 1 %>
                          <% End if %>
                          <br />
                            <% 
  Repeat3__index=Repeat3__index+1
  Repeat3__numRows=Repeat3__numRows-1
  stocklevels.MoveNext()
Wend
%>
                        </div>
                        
                        <% If item_count > 0  Then %>
                        
                        <form id="form1" name="form1" method="POST" action="<%=MM_editAction%>">
                        <div class="MiddleTitleLrg6">Select Size:<br />

                        <select name="sizeproductcode" class="FormBox5">
                          <%
While (NOT productsizes.EOF)
%>
                          <% If (productsizes.Fields.Item("StockQuantity").Value) > 0 Then %>
                          <option value="<%=(productsizes.Fields.Item("Size").Value)%>"><%=(productsizes.Fields.Item("Size").Value)%></option>
                          <% End if %>
                          
                          <%
  productsizes.MoveNext()
Wend
If (productsizes.CursorType > 0) Then
  productsizes.MoveFirst
Else
  productsizes.Requery
End If
%></select>

                        </div>
  Qty: 
  <label>
  <input name="qty" type="text" class="FormBox1" id="qty" value="1" size="3" maxlength="3" />
  </label>
  <label>
  <input name="button" type="submit" class="SubmitButton1" id="button" value="Add to Basket" />
  </label>
  <input name="pid" type="hidden" id="pid" value="<%=(productslist.Fields.Item("GenericCode").Value)%>" />
  <input name="GenericCode" type="hidden" id="GenericCode" value="<%=(productslist.Fields.Item("GenericCode").Value)%>" />
  <input name="pcode" type="hidden" id="pcode" value="<%=GenericCode%>" />
  <input name="SiD" type="hidden" id="SiD" value="<%=Session.SessionID()%>" />
  <input name="product_title" type="hidden" id="product_title" value="<%=(productslist.Fields.Item("ProductName").Value)%>" />
  <input name="supplier" type="hidden" id="supplier" value="Smiffys" />
  <input name="product_price" type="hidden" id="product_price" value="<%=(productslist.Fields.Item("RRP").Value)%>" />
  <input name="stock_level" type="hidden" id="stock_level" value="<%=(productslist.Fields.Item("StockQuantity").Value)%>" />
  <input name="product_colour" type="hidden" id="product_colour" value="n/a" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>					

						<% If Cdbl((productslist.Fields.Item("StockQuantity").Value)) <=0 Then 
							stock_message = "Delivery:<br>Estimated 3 Days from order"
							End if
							If Cdbl((productslist.Fields.Item("StockQuantity").Value)) >0 Then 
							stock_message = "Delivery:<br>Estimated 3 Days from order"
							End if
						%>
                        
                        <% End if %>
                        
                        
                        <% If item_count = 0 Then %>
                        <strong>All Sizes Currently Out of Stock</strong>
                        <% End if %>
                        
                
                        <div class="MiddleTitleLrg6"><strong><%=stock_message%></strong></strong><br />
                        <br />
                          Gender: <strong><%=(productslist.Fields.Item("Gender").Value)%></strong><br />
Audience: <strong><%=(productslist.Fields.Item("Audience").Value)%></strong>
<% If isnull(productslist.Fields.Item("Audience").Value) OR (productslist.Fields.Item("Audience").Value) = "" Then %>
<strong>All</strong>
<% End if %>
<br />
                        </div>
    </div>

                        
</div>
                        
                        

  <div class="MiddleIconsHolder2">
    <div class="SocialProductBox1">
      <div class="fb-like" data-send="false" data-width="250" data-show-faces="false" data-font="trebuchet ms"></div>
    </div>
  </div>

<div class="MiddleIconsHolder2">
                        <div class="MiddleTitleLrg3"><%=(productslist.Fields.Item("ProductName").Value)%></div>
                        
            
                        <img onerror="this.src='images/awaitingimage.jpg';" src="admin/prodimages-smiffys-lrg/<%=(productslist.Fields.Item("Photo").Value)%>" border="0" />
                        
                        <!-- ACCESSORIES -->
                        <div class="MiddleIconsHolder3">
                         
                          <div class="MiddleTitleLrg3"> </div>
                          
                          
                          <% If not isnull(productslist.Fields.Item("acc_code1").Value) Then %>                   
                          <div class="MiddleTitleLrg3">These items may also be
                            of interest...</div>
                          
                          <div class="BasketImageIcon">
                          <a href="products-view-bysmiffycode.asp?GenericCode=<%=(productslist.Fields.Item("acc_code1").Value)%>"><img src="admin/prodimages-smiffys/thumb_<%=(productslist.Fields.Item("acc_code1").Value)%>.jpg" width="100" border="0" onerror="this.src='images/awaitingimage.jpg';" /></a>
                          </div>
                          <% End if %>
                        
                         <% If not isnull(productslist.Fields.Item("acc_code2").Value) Then %>
                        <div class="BasketImageIcon">
                        <a href="products-view-bysmiffycode.asp?GenericCode=<%=(productslist.Fields.Item("acc_code2").Value)%>"><img src="admin/prodimages-smiffys/thumb_<%=(productslist.Fields.Item("acc_code2").Value)%>.jpg" width="100" border="0" onerror="this.src='images/awaitingimage.jpg';" /></a>
                        </div>
                        <% End if %>
                        
                        <% If not isnull(productslist.Fields.Item("acc_code3").Value) Then %>
                        <div class="BasketImageIcon">
                        <a href="products-view-bysmiffycode.asp?GenericCode=<%=(productslist.Fields.Item("acc_code3").Value)%>"><img src="admin/prodimages-smiffys/thumb_<%=(productslist.Fields.Item("acc_code3").Value)%>.jpg" width="100" border="0" onerror="this.src='images/awaitingimage.jpg';" /></a>
                        </div>
                        <% End if %>
                        
                        <% If not isnull(productslist.Fields.Item("acc_code4").Value) Then %>
                        <div class="BasketImageIcon">
                        <a href="products-view-bysmiffycode.asp?GenericCode=<%=(productslist.Fields.Item("acc_code4").Value)%>"><img src="admin/prodimages-smiffys/thumb_<%=(productslist.Fields.Item("acc_code4").Value)%>.jpg" width="100" border="0" onerror="this.src='images/awaitingimage.jpg';" /></a>
                        </div>
                        <% End if %>
                        
                        <% If not isnull(productslist.Fields.Item("acc_code5").Value) Then %>
                        <div class="BasketImageIcon">
                        <a href="products-view-bysmiffycode.asp?GenericCode=<%=(productslist.Fields.Item("acc_code5").Value)%>"><img src="admin/prodimages-smiffys/thumb_<%=(productslist.Fields.Item("acc_code5").Value)%>.jpg" width="100" border="0" onerror="this.src='images/awaitingimage.jpg';" /></a>
                        </div>
                        <% End if %>

                        
                        
                        
                        
                        
          </div>
                
        </div>
        
        
        <!-- Footer -->
        <!--#include file="inc-footer1.asp" -->
        
        
    </div> <!-- ContainerOuterMain END -->
    <%
	if outputFileExists = false then
	
		text="<ProductDetails>"
		text=text & "<ProductCode>" & Request("GenericCode") & "</ProductCode>"
		text=text & "</ProductDetails>"		

		set xmlDoc=Server.CreateObject("Msxml2.DOMDocument.6.0")
	
		xmlDoc.async=false
		xmlDoc.loadXML(text)
		
		filename = "stockRequest.xml"	
		submitStockRequest = true
		
		break=0
		dim inputFs
		set inputFs=Server.CreateObject("Scripting.FileSystemObject")
		
		xmldoc.save(Server.MapPath(filename))
		submitStockRequest = true				
		
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
productslist.Close()
Set productslist = Nothing
%>
<%
productsizes.Close()
Set productsizes = Nothing
%>
<%
toplevelcat.Close()
Set toplevelcat = Nothing
%>
<%
subcat.Close()
Set subcat = Nothing
%>
<%
stocklevels.Close()
Set stocklevels = Nothing
%>
<%
if submitStockRequest = true then	
	Response.Redirect("jesters_stock_quantity.php")
end if
%>
