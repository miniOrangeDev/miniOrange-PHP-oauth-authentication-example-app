<?php
namespace Miniorange\Phpoauth\Constants;

enum ResponseType: string {
    case CODE = 'code';
    case TOKEN = 'token';
}