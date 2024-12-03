<?php

namespace Miniorange\Phpoauth\Handlers;

use function Miniorange\Phpoauth\Network\makeCall;
use Miniorange\Phpoauth\Config\OAuthConfig;
use Miniorange\Phpoauth\Utils\UrlEndpointUtils;
use Miniorange\Phpoauth\Constants\Scope;
use \Exception;
use Miniorange\Phpoauth\Constants\GrantType;
use Miniorange\Phpoauth\Constants\Messages;
use function Miniorange\Phpoauth\Utils\decodeToken;

/**
 * Class TokenHandler
 * 
 * This class is responsible for handling the OAuth token requests. It requests
 * an access token or an ID token depending on the provided scope (email or openid).
 */
class TokenHandler
{

    public static function getTokenWithPassword(string $username, string $password, OAuthConfig $config, $loginListener): string
    {
        try {
            // Prepare the POST data for the token request
            $postData = [
                'grant_type' => GrantType::PASSWORD->value,
                'username' => $username,
                'password' => $password,
                'client_id' => $config->getClientId(),
                'client_secret' => $config->getClientSecret(),
                'scope' => $config->getScope(),
            ];

            // Set the request headers
            $headers = ['Accept: application/json'];

            // Make the POST request to get the token response
            $tokenResponse = makeCall(UrlEndpointUtils::createTokenUrl($config->getBaseUrl()), $headers, $postData);
            session_start();
            // Check if the scope is 'openid' (this is specific to OpenID Connect)
            if ($config->getScope() == Scope::OPENID->value) {   
                // If the scope is openid, we expect an id_token in the response
                if (!isset($tokenResponse['id_token'])) {
                    throw new Exception(Messages::ID_TOKEN_NOT_FOUND->value);
                }

                $_SESSION['id_token'] = $tokenResponse['id_token']; //store id_token
                return $tokenResponse['id_token'];  // Return the id_token for OpenID
            }

            // For non-openid scopes, we expect an access_token
            if (!isset($tokenResponse['access_token'])) {
                // If no access_token is found, throw an exception
                throw new Exception(Messages::ACCESS_TOKEN_NOT_FOUND->value);
            }
            $_SESSION['access_token'] = $tokenResponse["access_token"]; //store access token
            $_SESSION['refresh_token'] = $tokenResponse["refresh_token"]; //store refresh token
            // Return the access token for OAuth requests with other scopes (like email, profile)
            return $tokenResponse['access_token'];
        } catch (Exception $e) {
            //parse message from response like incorrect username or password..
            $loginListener->onError(isset($tokenResponse['message']) ? $tokenResponse['message'] : Messages::SOMETHING_WENT_WRONG->value);
            exit();
            
        }
    }

    public static function validateToken($token, OAuthConfig $config, $tokenTypeHint = ''): bool
    {
        // URL for token validation (introspection endpoint)
        $validationUrl = UrlEndpointUtils::createIntrospectionUrl($config->getBaseUrl());

        // Prepare POST data
        $postData = [
            'token' => $token,
            'client_id' => $config->getClientId(),
            'client_secret' => $config->getClientSecret()
        ];

        // Optionally add token_type_hint if provided
        if (!empty($tokenTypeHint)) {
            $postData['token_type_hint'] = $tokenTypeHint;
        }

        // Prepare headers
        $authHeader = 'Basic ' . base64_encode($config->getClientId() . ':' . $config->getClientSecret());
        $headers = [
            'Authorization: ' . $authHeader,
            'Content-Type: application/x-www-form-urlencoded'
        ];

        // Make the POST request to validate the token
        $response = makeCall($validationUrl, $headers, $postData);

        // Process the response
        if (isset($response['active']) && $response['active'] == 1) {
            // Token is active, thus valid
            return true;
        } else {
            // Token is either inactive, invalid, or expired
            return false;
        }
    }

    public static function getNewAccessToken(string $refreshToken, OAuthConfig $config): array
    {
        // Base URI from the config
        $baseUri = $config->getBaseUrl();

        // Create token URL
        $tokenUrl = UrlEndpointUtils::createTokenUrl($baseUri);

        // Prepare POST data
        $postData = [
            'grant_type' => GrantType::REFRESH_TOKEN->value,
            'refresh_token' => $refreshToken,
        ];

        // Prepare Authorization header with Basic authentication (client_id:client_secret)
        $authHeader = 'Basic ' . base64_encode($config->getClientId() . ':' . $config->getClientSecret());
        $headers = [
            'Authorization: ' . $authHeader,
            'Content-Type: application/x-www-form-urlencoded'
        ];

        // Use the makeCall function to make the POST request
        $response = makeCall($tokenUrl, $headers, $postData);

        // return the response
        return $response;
    }

    public static function HandleAccessAndRefreshToken($access_token, $refresh_token, $config, $loginListener) {
        $user = getUserInfoUsingAccessToken($access_token, $config);
        if ($user != null) {
            $loginListener->onLoginSuccess($user);
            $_SESSION['access_token'] = $access_token; 
            
            // Store refresh token only if it is not null
            if ($refresh_token !== null) {
                $_SESSION['refresh_token'] = $refresh_token;
            }
            
            exit;
        } else {
            $loginListener->onError(Messages::SOMETHING_WENT_WRONG->value);
        }
    }

    public static function HandleIdToken($id_token, $config, $loginListener){
        $pem = $config->getPemCertificatePath();
        $user = decodeToken($pem, $id_token, $loginListener);
        if ($user != null){
            $loginListener->onLoginSuccess($user);
            $_SESSION['id_token'] = $id_token; //store id token

        }else{
            $loginListener->onError(Messages::SOMETHING_WENT_WRONG->value);
        }
        exit();
    }
}
