<?php

namespace Miniorange\Phpoauth\Handlers;

use function Miniorange\Phpoauth\Network\makeCall;
use Miniorange\Phpoauth\Utils\UrlEndpointUtils;
use Miniorange\Phpoauth\Constants\Scope;
use Miniorange\Phpoauth\Constants\GrantType;
use Miniorange\Phpoauth\Constants\Messages;
use \Exception;
use Miniorange\Phpoauth\Utils\PayloadUtils;

function handleAuthorisationCode($auth_code, $config, $loginListener)
{

    /* =========================================================== */
    /*                 Authorisation Code Handler                  */
    /* ----------------------------------------------------------- */
    /* This function processes the authorization code ,            */
    /* then handles token exchange and manages user information     */
    /* retrieval based on the OAuth flow (Authorization or PKCE).   */
    /* =========================================================== */


    // Retrieve the base URI from the configuration
    $baseUri = $config->getBaseUrl();

    // Construct the token endpoint URL
    $tokenUrl =  UrlEndpointUtils::createTokenUrl($baseUri);

    // Set headers for the API request
    $headers = [
        'Content-Type' => 'application/x-www-form-urlencoded'
    ];

    // Retrieve the scope from the configuration
    // $scope = $config->getScope();

    // Retrieve parameters based on grant type
    $params = PayloadUtils::getPayloadParams($auth_code, $config, $loginListener); //for pkce and normal oauth flow

    try {
        //  Make API call to exchange authorization code for tokens
        $response = makeCall($tokenUrl, $headers, $params);

        //  Handle access_token for retrieving user info 
        if (isset($response['access_token'])) {
            $accessToken = $response['access_token'];
            $refreshToken = $response['refresh_token'] ?? null;

            TokenHandler::HandleAccessAndRefreshToken($accessToken, $refreshToken, $config, $loginListener);
        }else
        $loginListener->onError(Messages::ACCESS_TOKEN_NOT_FOUND->value);

        //  Check for ID token in response (for OpenID scope) ....currently skipping id_token from response
        // if (!isset($response['id_token']) && Scope::OPENID->value) {
        //     $loginListener->onError(Messages::ID_TOKEN_NOT_FOUND->value. $response['message'] ?? '');
        //     exit();
        // }

        // $id_token = $response['id_token'];
        // TokenHandler::HandleIdToken($id_token, $config, $loginListener);

    } catch (\Exception $e) {
        //  Handle errors and trigger onError callback
        $loginListener->onError($e->getMessage());
    }
}
