<?php
namespace Miniorange\Phpoauth\Utils;

class OAuthUtils {
    public static function generateRandomString(int $length = 64): string
    {
        return rtrim(strtr(base64_encode(random_bytes($length)), '+/', '-_'), '=');
    }

    public static function generateCodeVerifier(): string
    {
        return self::generateRandomString(64); 
    }

    public static function generateState(): string
    {
        return self::generateRandomString(32); 
    }

    public static function verifyState($storedState, $receivedState): bool
    {
        return $storedState === $receivedState;
    }
    public static function generateCodeChallenge(string $codeVerifier): string
    {
        // Hash the verifier using SHA-256 and base64 URL-encode it
        return rtrim(strtr(base64_encode(hash('sha256', $codeVerifier, true)), '+/', '-_'), '=');
    }
}
