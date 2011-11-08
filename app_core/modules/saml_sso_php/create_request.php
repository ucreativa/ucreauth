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

require_once('saml_util.php');

/**
 * Creates a SAML authentication request.
 * @param string $acsURL The URL to the SSO ACS
 * @param string $providerName The domain name of the identity requestor
 * @return string
 */
function createAuthnRequest($acsURL, $providerName) {
  $tml = file_get_contents('templates/AuthnRequestTemplate.xml');
  
  $tml = str_replace('<PROVIDER_NAME>', $providerName, $tml); 
  $tml = str_replace('<AUTHN_ID>', samlCreateId(), $tml); 
  $tml = str_replace('<ACS_URL>', $acsURL, $tml); 
  $tml = str_replace('<ISSUE_INSTANT>', samlGetDateTime(time()), $tml); 
  
  return $tml;
}

/**
 * Assembles a URL containing the identity provider URL, the encoded
 * SAML auth request, and the RelayState.
 * @param string $ssoURL
 * @param string $authnRequest
 * @param string $relayStateURL
 * @return string
 */
function computeURL($ssoURL, $authnRequest, $relayStateURL) {
  $url = $ssoURL;
  $url .= '?SAMLRequest=' . samlEncodeMessage($authnRequest);
  $url .= '&RelayState=' . urlencode($relayStateURL);
  return $url;
}

$action = $_POST['action'];
$returnPage = $_POST['returnPage'];

$ssoURL = 'process_response.php';

$providerName = 'google.com';
$domainName = 'ucreativa.com';
//$domainName = 'psosamldemo.net';
$relayStateURL = 'http://mail.google.com/a/' . $domainName;
$acsURI = 'https://www.google.com/a/' . $domainName . '/acs';

$authnRequest = '';
$redirectURL = '';
$error = '';

$authnRequest = createAuthnRequest($acsURI, $providerName);
if ($authnRequest == NULL) {
  $error = 'Error: unable to locate request template';
};

$redirectURL = computeURL($ssoURL, $authnRequest, $relayStateURL);

include('service_provider.php');

?>