<?php
namespace Miniorange\Phpoauth\Constants;

enum TokenType: string {
    case ID_TOKEN = 'id_token';
    case ACCESS_TOKEN = 'access_token';
}