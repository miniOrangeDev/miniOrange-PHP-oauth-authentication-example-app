<?php
namespace Miniorange\Phpoauth\Constants;

enum Messages: string {
    case AUTHORIZATION_REQUEST_FAILED = "Authorization request failed";
    case TOKEN_REQUEST_FAILED = "Token request failed";
    case INVALID_TOKEN = "Invalid token";
    case EMPTY_USERNAME_PASSWORD = "Email and Password are required for Password Grant";
    case SOMETHING_WENT_WRONG = "Something went wrong. Contact the your administrator for more information!";
    case EMPTY_PEM_CERTIFICATE_PATH = "Please enter a valid PEM certificate path it cannot be empty.";
    case TOKEN_DECODING_FAILED = "Token decoding failed. ";
    case CODE_VERIFIER_NOT_FOUND = "NO CODE VERIFIER FOUND for PKCE Grant";
    case ID_TOKEN_NOT_FOUND = "ID token not found.";
    case ACCESS_TOKEN_NOT_FOUND = "Access token or Refresh token not found.";
    case USER_INFO_NOT_FOUND = "Failed to retrieve user info: ";
    case INVALID_STATE = "Error: Invalid state parameter. Possible CSRF attack detected or session expired.";
    case PEM_CERT_PATH_NOT_FOUND = 'PEM certificate path not found in the environment variables.';
    case PEM_FILE_NOT_FOUND = 'PEM certificate file does not exist at the provided path.';
    case UNABLE_TO_READ_PEM = 'Unable to read the PEM certificate file.';
    case FAILED_TO_EXTRACT_PUBLIC_KEY = 'Failed to extract public key from PEM certificate.';
}