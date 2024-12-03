<?php
namespace Miniorange\Phpoauth\Handlers;
use Miniorange\Phpoauth\Utils\UrlEndpointUtils;
    /* =========================================================== */
    /*                      Logout Function                        */
    /* ----------------------------------------------------------- */
    /* This method handles logging the user out from the OAuth flow. */
    /* =========================================================== */
function logout($config)
{
    $baseUrl = $config->getBaseUrl();
    $redirectUri = $config->getRedirectUri(); 

    // Generate the logout URL
    $logoutUrl = UrlEndpointUtils::createLogoutUrl($baseUrl, $redirectUri);

    // Redirect to the logout URL
    header("Location: $logoutUrl");
    exit();
}
