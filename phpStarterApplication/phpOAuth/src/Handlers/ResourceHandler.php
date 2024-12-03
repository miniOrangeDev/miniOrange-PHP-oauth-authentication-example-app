<?php
namespace Miniorange\Phpoauth\Handlers;
use Miniorange\Phpoauth\Utils\UrlEndpointUtils;
function getUserInfoUsingAccessToken($access_token, $config)
{

        // Get the UserInfo URL
        $getUserInfoUrl = UrlEndpointUtils::getUserInfoUrl($config->getBaseUrl());

        // Initialize cURL session
        $ch = curl_init($getUserInfoUrl);
    
        // Set headers, including Authorization with Bearer token
        $headers = [
            'Authorization: Bearer ' . $access_token,
            'Accept: application/json'
        ];
    
        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as string
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Set headers
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Verify SSL for secure request
    
        // Execute the request
        $response = curl_exec($ch);
    
        // Check for cURL errors
        if (curl_errno($ch)) {
            throw new \Exception('CURL Error: ' . curl_error($ch));
        }
    
        // Close cURL session
        curl_close($ch);
    
        // Decode the response (assuming it's JSON)
        $user = json_decode($response, true);
    
        // Check for JSON decoding errors
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('JSON Decode Error: ' . json_last_error_msg());
        }

        $userObj = (object) $user;
        return $userObj;

}

