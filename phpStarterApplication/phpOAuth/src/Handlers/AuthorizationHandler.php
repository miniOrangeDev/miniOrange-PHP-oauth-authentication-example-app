<?php
namespace Miniorange\Phpoauth\Handlers;

use Miniorange\Phpoauth\GrantTypeFactory;
use Miniorange\Phpoauth\Constants\GrantType;

/* =========================================================== */
/*                 Authorization Handler Class                 */
/* ----------------------------------------------------------- */
/* This class is responsible for managing the OAuth            */
/* authorization process. It retrieves the configured grant    */
/* type from the OAuth config and creates the corresponding     */
/* authorization request flow (e.g., Authorization Code, Implicit,*/
/* PKCE). It starts the authorization process                   */
/* by redirecting the user to the appropriate authorization     */
/* endpoint based on the chosen grant type.                    */
/* =========================================================== */
class AuthorizationHandler {

    private $config; 

    public function __construct($config) {
        $this->config = $config;
    }

    /* 
     * Starts the authorization process.
     * It retrieves the configured grant type and starts the
     * authorization request based on that.
     */
    public function startAuthorization($email = null, $password = null) {

        // Get the grant type from the configuration
        $grantTypeValue = $this->config->getGrantType();
            
        try {
            // Convert grant type string to enum
            $grantType = GrantType::from($grantTypeValue);
        } catch (\ValueError $e) {
            // Throw an error if grant type is invalid
            throw new \Exception('Invalid grant type provided: ' . $grantTypeValue);
        }
        
        // Get the correct grant flow based on the grant type
        $grantFlow = GrantTypeFactory::getGrantType($this->config);
        
        // Start the authorization request (e.g., redirect user)
        $grantFlow->createAuthorizationRequest($email, $password);
    }
}
