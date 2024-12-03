<?php

namespace Miniorange\Phpoauth\Utils;

// use Dotenv\Dotenv;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use \Exception;
use Miniorange\Phpoauth\Constants\Messages;

function decodeToken($pemCertificatePath, $id_token, $loginListener)
{
    try {
        /* =========================================================== */
        /*                  JWT Token Decoding Function                */
        /* ----------------------------------------------------------- */
        /* This function decodes the JWT token passed and verifies the  */
        /* signature against a public PEM key to ensure its validity.   */
        /* ===========================================================  */
        if ($pemCertificatePath === false) {
            $loginListener->onError(Messages::PEM_CERT_PATH_NOT_FOUND->value);
            exit();
        }

        // Check if the file exists at the specified path
        if (!file_exists($pemCertificatePath)) {
            $loginListener->onError(Messages::PEM_FILE_NOT_FOUND->value);
            exit();
        }

        // Read the content of the PEM certificate file
        $pemCertificateContent = file_get_contents($pemCertificatePath);

        // Check if the content was successfully read
        if ($pemCertificateContent === false) {
            $loginListener->onError(Messages::UNABLE_TO_READ_PEM->value);
            exit();
        }

        // Extract the public key from the PEM certificate
        $publicKey = openssl_pkey_get_public($pemCertificateContent);

        // Check if the public key extraction was successful
        if ($publicKey === false) {
            $loginListener->onError(Messages::FAILED_TO_EXTRACT_PUBLIC_KEY->value);
            exit();
        }

        // Get the public key details
        $keyDetails = openssl_pkey_get_details($publicKey);

        // Ensure that the public key details are correctly retrieved
        if ($keyDetails === false || !isset($keyDetails['key'])) {
            $loginListener->onError(Messages::FAILED_TO_EXTRACT_PUBLIC_KEY->value);
            exit();
        }

        // Extract the public key string from the details
        $publicKeyString = $keyDetails['key'];

        // Decode the JWT using the public key and verify its signature
        $decoded = JWT::decode($id_token, new Key($publicKeyString, 'RS256'));

        return $decoded;
    } catch (Exception $e) {
        // Handle the exception if decoding fails
        $loginListener->onError(Messages::TOKEN_DECODING_FAILED->value .$e->getMessage());
        exit();
    }
}