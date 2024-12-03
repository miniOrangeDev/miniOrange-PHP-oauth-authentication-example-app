<?php
namespace Miniorange\Phpoauth\GrantsImplementation;

use Miniorange\Phpoauth\Utils\PayloadUtils;
/* =========================================================== */
/*                Implicit Grant Implementation                */
/* ----------------------------------------------------------- */
/* This class handles the implicit grant flow, where the user   */
/* is redirected to the authorization server and the access     */
/* token is returned directly in the URL as a fragment.         */
/* =========================================================== */
class ImplicitGrant extends OAuthFlow {

    private $config;

    // Constructor to initialize with the configuration object
    public function __construct($config) {
        $this->config = $config;
    }

    /* =========================================================== */
    /*    Create Authorization Request for Implicit Grant Flow      */
    /* ----------------------------------------------------------- */
    /* This function generates an authorization URL for the implicit */
    /* grant flow and redirects the user to the authorization server */
    /* to obtain an access token or id token directly.               */
    /* =========================================================== */
    public function createAuthorizationRequest($email = null, $password = null) {
       
        $authUrl = PayloadUtils::generateAuthorizationUrl($this->config);
        header("Location: {$authUrl}");
        exit();
    }

}
