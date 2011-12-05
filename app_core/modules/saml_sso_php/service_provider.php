<?php
/**
/**
 * Copyright (C) 2007 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
  $error="";

    $service="NO_SERVICE";
    if(isset($_GET['service'])){
      $service=$_GET['service'];
    }
    
 ?>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <link href="global/style.css" type="text/css" rel="stylesheet"/>
  <title>SAML-based Single Sign-On Service for Google Apps - Test Tool</title>
</head>
<body>
  <h1 style="margin-bottom:6px">GOOGLE - Service Provider</h1>
  <div style="padding:6px 0px;border-top:solid 1px #3366cc;
   border-bottom:solid 1px #3366cc">
   <b>Step 2: Google generates SAML Request</b></div></p>
   <p>When an unauthenticated user tries to reach a hosted service, such as 
   Gmail, Google will send a SAML request to the partner, which acts as the 
   identity provider in the SAML transaction. In this step, you can click the 
   <b>Generate SAML Request</b> button, prompting Google to create the SAML 
   request. The request contains four variables:</p>
  <p>
  <ul>
    <li><b>AUTHN_ID</b> - A 160-bit string containing a string of randomly 
	    generated characters.</li>
    <li><b>ISSUE_INSTANT</b> - A timestamp indicating the date and time that 
	    Google generated the request.</li>
    <li><b>PROVIDER_NAME</b> - A string identifying the service provider's 
	    domain (google.com).</li>
    <li><b>ACS_URL</b> - The URL that the service provider uses to verify a 
	    SAML response. This demo uses the following ACS URL:<br>
    <div style="padding:0px 15px">
	https://www.google.com/a/ucreativa.com/acs
	</div>
    </li>
  </ul>
  </p>
	
  <form id="ServiceProviderForm" name="ServiceProviderForm" action="./create_request.php?service=<?echo $service;?>" method="post">
  <input type="hidden" name="action" value="Generate SAML Request">
  <input type="hidden" name="returnPage" value="service_provider.php">
    <input type="hidden" name="service" value="<?echo $service;?>">
  <p><center><input id="btn_saml_request" type="submit" value="Generate SAML Request"></center>
  </form>
  <?php
    if ($error != null) {
  ?>
    <p><center><font color="red"><b><?= $error ?></b></font></center><p>
  <?php
    } else {
      if ($authnRequest != null && $redirectURL != null) {
  ?>
    <p><div style="padding:6px 0px;border-top:solid 1px #3366cc;
	   border-bottom:solid 1px #3366cc">
	   <b>Step 3: Submitting the SAML Request</b></div></p>
    <p>You can now review the generated SAML request before submitting it to 
	   the identity provider.</p>
    <p>As noted in the <b>Pre-Transaction Details</b>, when you install this 
	   application, it will send SAML authentication requests to 
	   <b>process_response.php</b>, which is included in the sample code 
	   package.</p>
    <b>Generated SAML XML</b><p>
    <input type="hidden" name="redirectURL" 
	    value="<?php echo $redirectURL; ?>"/>
    <div class="codediv"><?php echo htmlentities($authnRequest); ?></div>
    <p><center>
    
    <input type="button" id="btn_authrequest" value="Submit AuthnRequest" 
           onclick="javascript:parent.frames['identity_provider'].location = 
		   '<?php echo $redirectURL; ?>';return true;">
    </center>
  <?php
      }
    }
  ?>
</body>
</html>