<?php

namespace Miniorange\Phpoauth\Handlers;


use  Miniorange\Phpoauth\Utils\OAuthUtils;
use Miniorange\Phpoauth\Constants\Messages;

class CallbackHandler
{

    private $config;
    private $loginListener;

    // Constructor to initialize with config and loginListener
    public function __construct($config, $loginListener)
    {
        $this->config = $config;
        $this->loginListener = $loginListener;
    }

    /* =========================================================== */
    /*                  Callback Handler Function                  */
    /* ----------------------------------------------------------- */
    /* This function verifies the state and manages the code flow   */
    /* according to the callback received.                          */
    /* =========================================================== */
    public function handleUri($uri)
    {


        // Parse the URI and query parameters
        $parsedUrl = parse_url($uri);
        $queryParams = [];

        // Ensure the URL contains `/callback` in the path
        if (isset($parsedUrl['path']) && strpos($parsedUrl['path'], '/callback') === false) {
            return; 
        }

        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
        }

        // ============================================================
        //  Validate Incoming State
        // ============================================================

        if (isset($queryParams['state']) && !OAuthUtils::verifyState($queryParams['state'], $_SESSION['state'] ?? null)) {
            $this->loginListener->onError(Messages::INVALID_STATE->value);
            exit();
        }


        // $scope = $this->config->getScope();
        // ============================================================
        //  Handle id_token for implicit flow  
        // ============================================================
        // if (isset($queryParams["id_token"])) { 
        //     $id_token = $queryParams["id_token"];
        //     TokenHandler::HandleIdToken($id_token, $this->config, $this->loginListener);           
        // }

        // ============================================================
        //   Handle access_token for implicit flow 
        // ============================================================
        if (isset($queryParams["access_token"])) {
            $access_token = $queryParams["access_token"];
            $refresh_token = $response['refresh_token'] ?? null;
            TokenHandler::HandleAccessAndRefreshToken($access_token, $refresh_token,  $this->config, $this->loginListener);
        }
        // ============================================================
        //  Handle authorization code for Authorization and PKCE Code Grant flow
        // ============================================================
        if (isset($queryParams['code'])) {
            $code = $queryParams['code'];
            handleAuthorisationCode($code,  $this->config, $this->loginListener);
        }

        if(!isset($queryParams["access_token"]) && !isset($queryParams['code']))
            $this->loginListener->onError(Messages::ACCESS_TOKEN_NOT_FOUND->value);

    }
}
