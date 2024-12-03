<?php
namespace Miniorange\Phpoauth\Constants;

enum GrantType: string {
    case AUTHORIZATION_CODE = "authorization_code";
    case IMPLICIT = 'implicit';
    case AUTHORIZATION_CODE_PKCE = 'authorization_code_pkce';
    case PASSWORD = 'password';
    case REFRESH_TOKEN = 'refresh_token';
}
