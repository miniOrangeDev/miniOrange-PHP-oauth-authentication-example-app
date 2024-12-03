<?php

namespace Miniorange\Phpoauth\Handlers;

use Miniorange\Phpoauth\Config\OAuthConfig;
use Miniorange\Phpoauth\Handlers\TokenHandler;
use Miniorange\Phpoauth\Constants\TokenType;

function isSessionActive(OAuthConfig $config): bool
{
    // Retrieve ID token from session
    $idToken = $_SESSION['id_token'] ?? null;

    // Check if ID token exists
    if ($idToken) {
        // Validate the ID token
        $isValid = TokenHandler::validateToken($idToken, $config, TokenType::ID_TOKEN->value);

        // Return true if the ID token is valid
        return $isValid;
    }

    // If ID token is not present, check for access token
    $accessToken = $_SESSION['access_token'] ?? null;

    if ($accessToken) {
        // Validate the access token
        $isValid = TokenHandler::validateToken($accessToken, $config, TokenType::ACCESS_TOKEN->value);

        if ($isValid) {
            // Access token is valid, return true
            return true;
        } else {
            // If access token is expired or invalid, check for a refresh token
            $refreshToken = $_SESSION['refresh_token'] ?? null;

            // If no refresh token is found, return false
            if (!$refreshToken) {
                return false;
            }

            // Attempt to get a new access token using the refresh token
            $newAccessTokenResponse = TokenHandler::getNewAccessToken($refreshToken, $config);

            // Check if the response contains a success status and a valid access token
            if (isset($newAccessTokenResponse['status']) && $newAccessTokenResponse['status'] === 'SUCCESS' && isset($newAccessTokenResponse['access_token'])) {
                // Save the new access token in the session
                $_SESSION['access_token'] = $newAccessTokenResponse['access_token'];

                // Return true as we now have a valid access token
                return true;
            } else {
                // If no new access token was obtained or status is not SUCCESS, return false
                return false;
            }
        }
    }

    // If neither ID token nor access token is present, return false
    return false;
}
