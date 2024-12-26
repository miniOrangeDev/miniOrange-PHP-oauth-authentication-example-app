<?php

namespace Miniorange\Phpoauth\Config;

use \Exception;
use Dotenv\Dotenv;

class OAuthConfig
{
    private string $clientId;
    private string $clientSecret;
    private string $baseUrl;
    private string $redirectUri;
    private string $logoutRedirectUri;
    // private ?string $pemCertificatePath = null;
    private ?string $scope = null; 
    private ?string $grantType= null; 
   

 
    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        $this->clientId = $_ENV['CLIENT_ID'] ?? null;
        $this->clientSecret = $_ENV['CLIENT_SECRET'] ?? null;
        $this->baseUrl = $_ENV['BASE_URL'] ?? null;
        $this->redirectUri = $_ENV['REDIRECT_URI'] ?? null;
        $this->logoutRedirectUri = $_ENV['LOGOUT_REDIRECT_URI'] ?? null;
        // $this->pemCertificatePath = $_ENV['PEM_CERTIFICATE_PATH'];
        $this->scope = $_ENV['SCOPE'] ?? 'email profile'; //default email profile
        $this->grantType = $_ENV['GRANT_TYPE'] ?? 'authorization_code'; //default authorization_code provided

        // Optionally, add checks to ensure required environment variables are set
        if (!$this->clientId || !$this->clientSecret || !$this->baseUrl || !$this->redirectUri || !$this->logoutRedirectUri || /* !$this->pemCertificatePath ||*/ !$this->scope) {
            throw new Exception('Missing required environment variables for OAuthConfig');
        }
    }


    // Getters methods for each field

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }


    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }


    public function getRedirectUri(): string
    {
        return $this->redirectUri;
    }


    public function getLogoutRedirectUri(): string
    {
        return $this->logoutRedirectUri;
    }


    // public function getPemCertificatePath(): string
    // {
    //     return $this->pemCertificatePath;
    // }


    public function getGrantType(): ?string
    {
        return $this->grantType;
    }


    public function getScope(): ?string
    {
        return $this->scope;
    }

}
