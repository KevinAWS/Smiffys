<soap:Header>
POST /services/products.asmx HTTP/1.1
Host: staging.smiffys.com
Content-Type: text/xml; charset=utf-8
Content-Length: length
SOAPAction: "http://smiffys.com/GetCategoryList"
</soap:Header>

<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <GetCategoryList xmlns="http://smiffys.com/">
      <apiKey>string</apiKey>
      <clientID>string</clientID>
    </GetCategoryList>
  </soap:Body>
</soap:Envelope>






