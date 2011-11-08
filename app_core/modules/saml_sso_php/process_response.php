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

require_once 'saml_util.php';

$domainName = 'ucreativa.com';
//$domainName = 'psosamldemo.net';

/**
 * The login method should either return null if the user is not
 * successfully authenticated, or the user's username if the user is
 * successfully authenticated.
 * @param string $username
 * @param string $password
 * @return string
 */
function login($username, $password) {
  // Stage II: Update this method to call your authentication mechanism.
  // Return username for successful authentication. Return null
  // for failed authentication.
  return $username;
}

/**
 * Returns a SAML response with various elements filled in.
 * @param string $authenticatedUser The Google Apps username of the 
                 authenticated user
 * @param string $notBefore The ISO 8601 formatted date before which the 
                 response is invalid
 * @param string $notOnOrAfter The ISO 8601 formatted data after which the 
                 response is invalid
 * @param string $rsadsa 'rsa' if the response will be signed with RSA keys, 
                 'dsa' for DSA keys
 * @param string $requestID The ID of the request we're responding to
 * @param string $destination The ACS URL that the response is submitted to
 * @return string XML SAML response.
 */
function createSamlResponse($authenticatedUser, $notBefore, $notOnOrAfter, 
                            $rsadsa, $requestID, $destination) {
  global $domainName;
  
  $samlResponse = file_get_contents('templates/SamlResponseTemplate.xml');
  $samlResponse = str_replace('<USERNAME_STRING>', $authenticatedUser, 
	                          $samlResponse); 
  $samlResponse = str_replace('<RESPONSE_ID>', samlCreateId(), $samlResponse);
  $samlResponse = str_replace('<ISSUE_INSTANT>', samlGetDateTime(time()), 
	                          $samlResponse);
  $samlResponse = str_replace('<AUTHN_INSTANT>', samlGetDateTime(time()), 
	                          $samlResponse);
  $samlResponse = str_replace('<NOT_BEFORE>', $notBefore, $samlResponse);
  $samlResponse = str_replace('<NOT_ON_OR_AFTER>', $notOnOrAfter, 
	                          $samlResponse);
  $samlResponse = str_replace('<ASSERTION_ID>', samlCreateId(), $samlResponse);
  $samlResponse = str_replace('<RSADSA>', strtolower($rsadsa), $samlResponse);
  $samlResponse = str_replace('<REQUEST_ID>', $requestID, $samlResponse);
  $samlResponse = str_replace('<DESTINATION>', $destination, $samlResponse);
  $samlResponse = str_replace('<ISSUER_DOMAIN>', $domainName, $samlResponse);
  
  return $samlResponse;
}

/**
 * Signs a SAML response with the given private key, and embeds the public key.
 * @param string $responseXmlString
 * @param string $pubKey
 * @param string $privKey
 * @return string
 */
function signResponse($responseXmlString, $pubKey, $privKey) {
  // NOTE: You may want to point this function to a directory on your
  // web server that is suitable for temporary files and is not in your
  // web server path.
  global $error;
  
  // generate unique temporary filename
  $tempFileName = 'saml-response-' . samlCreateId() . '.xml';
  while (file_exists($tempFileName)) 
	     $tempFileName = 'saml-response-' . samlCreateId() . '.xml';
  
  if (!$handle = fopen($tempFileName, 'w')) {
    echo 'Cannot open temporary file (' . $tempFileName . ')';
    exit;
  }
    
  if (fwrite($handle, $responseXmlString) === FALSE) {
    echo 'Cannot write to temporary file (' . $tempFileName . ')';
    exit;
  }

  fclose($handle);

  // The path to xmlsec/xmlsec1 may need to be adjusted here.
  // xmlsec supports many key types, which can be selected
  // by using other command-line parameters.
  if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    // on Windows the anonymous IIS user account needs access to run cmd.exe
    // this can be done with the following command line:
    // cacls %COMSPEC% /E /G %COMPUTERNAME%\IUSR_%COMPUTERNAME%:R
    $cmd = 'C:\libs\xmlsec-win32\xmlsec sign --privkey-pem ' . $privKey . 
	     ' --pubkey-der ' . $pubKey . ' --output ' . $tempFileName . 
	     '.out ' . $tempFileName;
  } else {
    $cmd = '/usr/bin/xmlsec1 sign --privkey-pem ' . $privKey .
             ' --pubkey-der ' . $pubKey . ' --output ' . $tempFileName .
             '.out ' . $tempFileName;
  }
  exec($cmd, $resp);
  var_dump($resp);
  unlink($tempFileName);
  
  $xmlResult = @file_get_contents($tempFileName . '.out');
  if (!$xmlResult) { 
    $error = 'Unable to sign XML response. Please ensure that xmlsec is ' .
	         'installed, and check your keys.'; 
    // uncomment the line below to print xmlsec error messages
    // $error .= '<br><br>'. 
	//             str_replace('[br]', '<br>', 
	//                         htmlentities(implode($resp, '[br]')));
    return false;
  } else {
    unlink($tempFileName . '.out');
    return $xmlResult;
  }
}

if ($_GET['SAMLRequest'] != '') {
  $SAMLRequest = $_GET['SAMLRequest'];
  $relayState = $_GET['RelayState'];
  $error = '';

  $requestXmlString = samlDecodeMessage($SAMLRequest);

  if (($requestXmlString == '') || ($requestXmlString === FALSE)) {
    $error = 'Unable to decode SAML Request.';
  } else {
    $samlAttr = getRequestAttributes($requestXmlString);
    
    $issueInstant = $samlAttr['issueInstant'];
    $acsURL = $samlAttr['acsURL'];
    $providerName = $samlAttr['providerName'];
    $requestID = $samlAttr['requestID'];
  }
} else if($_POST['SAMLRequest'] != '') {

  $samlAction = $_POST['samlAction'];
  $SAMLRequest =$_POST['SAMLRequest'];
  $returnPage = $_POST['returnPage'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $relayStateURL = $_POST['RelayState'];

  if ($SAMLRequest == '') {
    $error = 'Error: Unspecified SAML parameters.';
  } else if ($samlAction == '') {
    $error = 'Error: Invalid SAML action.';
  } else if ($returnPage != '') {
  $requestXmlString = samlDecodeMessage($SAMLRequest);
    if (($requestXmlString == '')||($requestXmlString === FALSE)) {
      $error = 'Unable to decode SAML Request.';
    } else {
      $samlAttr = getRequestAttributes($requestXmlString);
      $issueInstant = $samlAttr['issueInstant'];
      $acsURL = $samlAttr['acsURL'];
      $providerName = $samlAttr['providerName'];
      $requestID = $samlAttr['requestID'];
        
      $username = login($username, $password);
      if ($username == '') {
        $error = 'Login Failed: Invalid user.';
      } else {
        // Acquire public and private DSA keys
  
         /*
        * Stage III: Update the DSA filenames to identify the locations of
        * the DSA/RSA keys that digitally sign SAML responses for your
        * domain. The keys included in the reference implementation sign SAML
        * responses for the psosamldemo.net domain.
        */
        
        $pubKey = 'keys/dsapubkey.der';
        $privKey = 'keys/dsaprivkey.pem';
        $keyType = 'dsa';

        // generate NotBefore and NotOnOrAfter dates
        $notBefore = samlGetDateTime(strtotime('-5 minutes'));
        $notOnOrAfter = samlGetDateTime(strtotime('+10 minutes'));

        // Sign XML containing user name with specified keys
        $responseXmlString = createSamlResponse($username, $notBefore, 
			                                    $notOnOrAfter, $keyType, 
			                                    $requestID, $acsURL);
        $samlResponse = signResponse($responseXmlString, $pubKey, $privKey);
      }
    }  
  }
}

include 'identity_provider.php';

?>