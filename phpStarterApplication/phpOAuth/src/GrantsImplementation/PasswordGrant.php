<?php
namespace Miniorange\Phpoauth\GrantsImplementation;

use Miniorange\Phpoauth\Handlers\TokenHandler;
use Miniorange\Phpoauth\Constants\Messages;
use function Miniorange\Phpoauth\Handlers\getUserInfoUsingAccessToken;
/* =========================================================== 
                    Password Grant Flow                      
 ----------------------------------------------------------- 
 This class implements the OAuth Password Grant flow.        
 It is used when the resource owner (user) directly provides 
 their username (email) and password to obtain an access     
 token and authenticate the user.                            
 =========================================================== */
class PasswordGrant extends OAuthFlow {

    private $config; 
    private $loginListener; // Listener for handling login success events

    public function __construct($config, $loginListener) {
        $this->config = $config;
        $this->loginListener = $loginListener;
    }

    public function createAuthorizationRequest($email = null, $password = null) {
        
        // Validate if both email and password are provided
        if ($email == null || $password == null ) {
            $this->loginListener->onError(Messages::EMPTY_USERNAME_PASSWORD->value);
            exit();
        }

        // Extract the scope (email or openid) from the config
        $scope = $this->config->getScope();

        /* =========================================================== 
                  Handling 'email profile' scope                     
         =========================================================== */
        
        $access_token = TokenHandler::getTokenWithPassword($email, $password, $this->config, $this->loginListener);
        $user = getUserInfoUsingAccessToken($access_token, $this->config);

        /* =========================================================== 
                  Handling 'openid' scope                            
         =========================================================== */ 
        /* else if ($scope === Scope::OPENID->value) {
             $idToken = TokenHandler::getTokenWithPassword($email, $password, $this->config, $this->loginListener);
             $pem = $this->config->getPemCertificatePath();
             if($pem == null){
                 $this->loginListener->onError(Messages::EMPTY_PEM_CERTIFICATE_PATH->value);
                 exit();
             }
             $user = decodeToken($pem, $idToken, $this->loginListener);
            
         } */

        /* =========================================================== */
        /*          Trigger Success Listener if User Info is Found     */
        /* =========================================================== */
        if ($user != null) {
            $this->loginListener->onLoginSuccess($user);
        }else{
            $this->loginListener->onError(Messages::SOMETHING_WENT_WRONG->value);
            exit();
        }
    }
}
