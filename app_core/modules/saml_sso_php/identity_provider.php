<?php

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

 ?>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta http-equiv="cache-control" content="no-cache, no-store">
  <meta http-equiv="pragma" content="no-cache">
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
  <link href="global/style.css" type="text/css" rel="stylesheet"/>
  <title>SAML-based Single Sign-On Service for Google Apps - Test Tool</title>
</head>
<script language="JavaScript">
  function submit_now(s,r) {
    document.acsForm.SAMLResponse.value=s;
    document.acsForm.RelayState.value=r;
    document.acsForm.submit();
  }
</script>
<body>
<h1>PARTNER - Identity Provider</h1>
<?php
  if ($username == null) {
    //$username = 'uti';
    $username = 'unknown';
  }

  //If SAML parameters still null, then authnRequest has not yet been
  //received by the Identity Provider, so user should not be logged in.
  if ( $SAMLRequest == null ) {
?>
 
<p><div style="padding:0px 8px;border:solid 1px #000;background:#ddd">
<p><center><img src="global/warning.gif"></center>
<p><b>Note: The user cannot be authenticated, and a SAML response cannot 
be sent, until a SAML request is received from the service provider. </b>
</p>
</div>
<?php
  } else {  
    
    if ($error != "") {
?>
    <p><font color="red"><b><?php echo $error; ?></b></font><p>
<?php
  }
?>
<form  name="IdentityProviderForm" action="process_response.php" method="post">
<input type="hidden" name="SAMLRequest" value="<?php echo $SAMLRequest; ?>"/>
<input type="hidden" name="RelayState" value="<?php echo htmlentities($relayState); ?>"/>
<input type="hidden" name="returnPage" value="identity_provider.php">
<input type="hidden" name="samlAction" value="Generate SAML Response">

<p><div style="padding:6px 0px;border-top:solid 1px #3366cc;
   border-bottom:solid 1px #3366cc">
   <b>Step 4: Partner Handles SAML Request, Authenticates User</b>
   </div>
   <p>The following values have been parsed from the SAML request:</p>
   <p>
   <ul>
     <li><b>Issue Instant</b> - <?php echo $issueInstant; ?></li>
     <li><b>Provider Name</b> - <?php echo $providerName; ?></li>
     <li><b>ACS URL</b> - <?php echo $acsURL; ?></li>
     <li><b>Request ID</b> - <?php echo $requestID; ?></li>
   </ul>
   <p>
     <b>Note:</b> These are all values that you will receive from the 
     service provider in a SAML transaction.
   </p>
   <p><b>User Login Details</b></p> 
   <p>During this step, you also authenticate the user. The reference code 
      is designed to log a user into the account <b>uti@ucreativa.com
      </b>. However, the reference implementation does not actually 
      authenticate the user; it assumes that the authentication is successful. 
      You will need to modify the reference code to call your internal 
      mechanism for authenticating users.
   </p>

   <!-- Stage II: Display a Username and Password Field -->
   <!-- Remove the comments around the following four lines in Stage II -->

       <blockquote>
       <p>Username: <input type="text" id="username" name="username" value=""/></p>
       <p style="visibility:hidden;">Password: <input type="password" name="password" value=""/></p>
       <p>
       <b>Note:</b> The submit buttons in step 5 submit the username and
          password to the ProcessResponseServlet.
       </p>
      </blockquote>
   

    <!-- Stage II: Hide default username values -->
    <!-- Comment out the following three lines in Stage II -->
    <!--<blockquote>
    <p>Username: <?php echo $username; ?>@<?php echo $domainName; ?>
    <p>Password: ******
    </blockquote>-->

    <p><div style="padding:6px 0px;border-top:solid 1px #3366cc;border-bottom:solid 1px #3366cc">
       <b>Step 5: Partner Generates SAML Response</b>
       </div>
       <p>In this step, you can click the <b>Generate SAML Response</b> button, 
       prompting the reference implementation to generate a SAML response
       indicating that the user (uti@ucreativa.com) is authorized to
       reach the Gmail service. When you click the <b>Generate SAML 
       Response</b> button, you will execute process_response.php's 
       POST handler.</p>
       <p>
       <center>
       <input type="submit" id="btn_saml_response" name="samlButton" value="Generate SAML Response">
       </center>
     <p><br>
    </form>
  <?php 
    if ($samlResponse != null) {
      if ($username != null) {
  ?>
    <!-- This is a hidden form that POSTs the SAML response to the ACS. -->
    <form id="acsForm" name="acsForm" action="<?php echo $acsURL; ?>" method="post" target="_parent">
    <div style="display: none">
    <textarea rows=10 cols=80 name="SAMLResponse"><?php echo $samlResponse; ?>
	</textarea>
    <textarea rows=10 cols=80 name="RelayState"><?php echo htmlentities($relayStateURL); ?>
	</textarea>
    </div>
    </form>
  <?php
      } else {
  ?> 
    <p><span style="font-weight:bold;color:red">
     You must enter a valid username and password to log in.
    </span></p>
  <?php
      }
  ?>
    <span id="samlResponseDisplay" style="display:inline">
    <b> Generated and Signed SAML Response </b>
    <p><div class="codediv"><?php echo htmlentities($samlResponse); ?></div>
    <p>The SAML response contains the following variables:</p>
    <p>
    <ul>
      <li>
        <p>
        <b>RESPONSE_ID</b> - A 160-bit string containing a set of 
        randomly generated characters. The code calls the 
        <b>samlCreateId()</b> method to generate this value.
        </p>
      </li>
      <li>
        <p>
        <b>ISSUE_INSTANT</b> - A timestamp indicating the date and time 
           that the SAML response was generated. The code calls the 
        <b>samlGetDateTime()</b> method to generate this value.
        </p>
      </li>
      <li>
        <p>
        <b>ASSERTION_ID</b> - A 160-bit string containing a set of 
        randomly generated characters. The code calls the 
        <b>samlCreateId()</b> method to generate this value.
        </p>
      </li>
      <li>
        <p>
        <b>USERNAME_STRING</b> - The username for the authenticated user. 
        Modify the <b>login()</b> method in process_response.php to return 
        the correct value.
        </p>
      </li>
      <li>
        <p>
        <b>NOT_BEFORE</b> - A timestamp identifying the date and time 
        before which the SAML response is deemed invalid. The code sets 
        this value to the <b>IssueInstant</b> value from the SAML request.
        </p>
      </li>
      <li>
        <p>
        <b>NOT_ON_OR_AFTER</b> - A timestamp identifying the date and time
        after which the SAML response is deemed invalid.
        </p>
      </li>
      <li>
        <p>
        <b>AUTHN_INSTANT</b> - A timestamp indicating the date and time 
        that you authenticated the user.
        </p>
      </li>
    </ul>
    <p>
    <center>
    <input type="button" id="btn_logoogle" value="Submit SAML Response" >
    </center>
    </span>
  <?php
      }
    }
  ?>
</body>
</html>
