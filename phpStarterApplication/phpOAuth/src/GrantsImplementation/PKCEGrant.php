<?php
namespace Miniorange\Phpoauth\GrantsImplementation;

use Miniorange\Phpoauth\Utils\PayloadUtils;
/* =========================================================== */
/*                    PKCE Grant Flow                          */
/* ----------------------------------------------------------- */
/* This class implements the PKCE (Proof Key for Code Exchange) */
/* flow for OAuth. PKCE enhances security for public clients   */
/* (such as mobile apps) by using code_verifier and code_challenge. */
/* =========================================================== */
class PKCEGrant extends OAuthFlow {

    private $config; 

    public function __construct($config) {
        $this->config = $config;
    }

    /* =========================================================== */
    /*        Authorization Request for PKCE Grant                 */
    /* ----------------------------------------------------------- */
    /* This method handles the authorization request in the PKCE    */
    /* Grant flow. It generates a code_verifier and code_challenge, */
    /* builds the authorization URL, and redirects the user to it.  */
    /* =========================================================== */
    public function createAuthorizationRequest($email = null, $password = null) {

        $authUrl = PayloadUtils::generateAuthorizationUrl($this->config);
        // Redirect the user to the authorization URL
        header("Location: {$authUrl}");
        exit(); // Ensure no further code is executed after the redirect
    }

}
