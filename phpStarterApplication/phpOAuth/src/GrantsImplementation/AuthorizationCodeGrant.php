<?php

namespace Miniorange\Phpoauth\GrantsImplementation;

use Miniorange\Phpoauth\Utils\PayloadUtils;
/* =========================================================== */
/*             Authorization Code Grant Implementation         */
/* ----------------------------------------------------------- */
/* This class handles the authorization code grant flow. It     */
/* constructs the authorization URL and redirects the user      */
/* to the authorization server to retrieve an authorization     */
/* code. This code is used to later obtain access tokens.       */
/* =========================================================== */

class AuthorizationCodeGrant extends OAuthFlow
{

    private $config;

    // Constructor to initialize with the configuration object
    public function __construct($config)
    {
        $this->config = $config;
    }

    /* =========================================================== */
    /*    Create Authorization Request for Authorization Code      */
    /* ----------------------------------------------------------- */
    /* This function creates the authorization request by forming   */
    /* the authorization URL with client credentials and redirects  */
    /* the user to the authorization server for login.              */
    /* =========================================================== */
    public function createAuthorizationRequest($email = null, $password = null)
    {
        
        $authUrl = PayloadUtils::generateAuthorizationUrl($this->config);
        // ============================================================
        //  Redirect the user to the authorization server for login
        // ============================================================
        header("Location: {$authUrl}");
        exit();  // Exit the script to ensure the redirection happens immediately
    }
}
