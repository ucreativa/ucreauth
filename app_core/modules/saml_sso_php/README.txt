README

   This distribution contains a SAML demo tool written in PHP.
   The sample code demonstrates an identity provider which authenticates
   users using the Google Apps Single Sign-On service.


REQUIREMENTS

   The SAML Demo Tool for PHP has been tested using the following software.
   You may need to install these libraries or packages to run this demo code.

    *   Apache HTTP Server v2.2.4
    *   PHP v5.2.1 or later
    *   xmlsec v1.2.10 or later. xmlsec is a C library and command-line 
        executable for signing, verifying, encrypting and decrypting XML 
	documents. The demo tool uses the xmlsec commandline executable for 
	signing SAML responses.
       
        For Windows, you need the following files:

        iconv.dll
        libxml2.dll
        libxmlsec.dll
        libxmlsec-openssl.dll
        libxslt.dll
        xmlsec.exe
        zlib1.dll
        ssleay32.dll
        libeay32.dll

        These can be obtained from the packages at:
          http://www.zlatkovic.com/pub/libxml/
         
        Ensure that the *.dll files are included in your PATH environment
        variable.  You may need to include the full path to the xmlsec.exe
        binary in the process_response.php file.


SUPPORT
  
   Google does not offer any support for this sample code. You can find answers
   by asking the Google Apps APIs discussion group at
   http://groups.google.com/group/google-apps-apis



THE PHP DEMO CODE
                
   process_response.php  - contains functionality to generate and sign a SAML
                           response.
   saml_util.php         - provides functions required to parse and generate
                           the SAML response.
   create_request.php    - contains functionality to construct a SAML request.
   identity_provider.php - provides a UI for process_response.php, and is not
                           required in a production SSO service.
   saml_demo.php         - provides a user interface for the SSO demo.
   service_provider.php  - provides a UI for create_request.php.