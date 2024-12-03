<?php
namespace Miniorange\Phpoauth\Constants;

enum Scope: string {
    case EMAIL = 'email';
    case OPENID = 'openid';
    case PROFILE = 'profile';
}