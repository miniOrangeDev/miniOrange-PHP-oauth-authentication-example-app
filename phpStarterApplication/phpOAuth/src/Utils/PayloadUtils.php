<?php

namespace Miniorange\Phpoauth\Utils;

use Miniorange\Phpoauth\Constants\GrantType;
use Miniorange\Phpoauth\Constants\Messages;
use Miniorange\Phpoauth\Utils\OAuthUtils;
use Miniorange\Phpoauth\Constants\ResponseType;

class PayloadUtils
{


    public static function generateAuthorizationUrl($config)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $clientId = $config->getClientId();
        $redirectUri = urlencode($config->getRedirectUri());
        $state = $_SESSION['state'] ?? bin2hex(random_bytes(16));
        $_SESSION['state'] = $state;
        $scope = $config->getScope();
        $responseType = ResponseType::CODE->value;

        // if ($config->getGrantType() === 'implicit') {
        if ($config->getGrantType() === GrantType::IMPLICIT->value) {
            $responseType = 'token';
        }

        $codeChallengeParam = '';
        // if ($config->getGrantType() === 'authorization_code_pkce') {
        if ($config->getGrantType() === GrantType::AUTHORIZATION_CODE_PKCE->value) {
            $codeVerifier = OAuthUtils::generateCodeVerifier();
            $_SESSION['code_verifier'] = $codeVerifier;
            $codeChallenge = OAuthUtils::generateCodeChallenge($codeVerifier);
            $codeChallengeParam = "&code_challenge={$codeChallenge}&code_challenge_method=S256";
        }

        return UrlEndpointUtils::createAuthorizationUrl($config->getBaseUrl()) ."?response_type={$responseType}&client_id={$clientId}&redirect_uri={$redirectUri}&scope={$scope}&state={$state}{$codeChallengeParam}";
    }

    public static function getPayloadParams($authCode, $config, $loginListener)
    {
        // Basic parameters for the payload
        
        $params = [
            // 'grant_type' => $grantType,
            'grant_type' => GrantType::AUTHORIZATION_CODE->value,
            'client_id' => $config->getClientId(),
            'client_secret' => $config->getClientSecret(),
            'redirect_uri' => $config->getRedirectUri(),
            'code' => $authCode,
            'scope' => $config->getScope()
        ];

        // Handle PKCE flow if the grant type is AUTHORIZATION_CODE_PKCE
        if ($config->getGrantType() === GrantType::AUTHORIZATION_CODE_PKCE->value) {
            session_start();
            $codeVerifier = $_SESSION['code_verifier'] ?? null;

            if ($codeVerifier !== null) {
                $params['code_verifier'] = $codeVerifier;
            } else {
                $loginListener->onError(Messages::CODE_VERIFIER_NOT_FOUND->value);
                exit();
            }
        }

        return $params;
    }

    
}
