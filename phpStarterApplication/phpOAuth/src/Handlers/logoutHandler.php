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
    $logoutRedirectUri = $config->getLogoutRedirectUri(); 

    // Generate the logout URL
    $logoutUrl = UrlEndpointUtils::createLogoutUrl($baseUrl, $logoutRedirectUri);

    // Redirect to the logout URL
    header("Location: $logoutUrl");
    exit();
}
