<?php
namespace Miniorange\Phpoauth;

use Miniorange\Phpoauth\Constants\GrantType;
use Miniorange\Phpoauth\GrantsImplementation\AuthorizationCodeGrant;
use Miniorange\Phpoauth\GrantsImplementation\ImplicitGrant;
use Miniorange\Phpoauth\GrantsImplementation\PasswordGrant;
use Miniorange\Phpoauth\GrantsImplementation\PKCEGrant;
use Miniorange\Phpoauth\GrantsImplementation\OAuthFlow;

class GrantTypeFactory {

    public static function getGrantType($config): OAuthFlow {
        switch ($config->getGrantType()) {  
            case GrantType::IMPLICIT:
                return new ImplicitGrant($config);
            case GrantType::AUTHORIZATION_CODE_PKCE:
                return new PKCEGrant($config);
            //case GrantType::PASSWORD:
            //   return new PasswordGrant();
            default:
                return new AuthorizationCodeGrant($config);
        }
    }
}
