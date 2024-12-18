<?php

// Include the autoloader script from the phpOAuth library.
require_once 'phpOAuth/vendor/autoload.php';

session_start();
if (isset($_SESSION["firstname"]) && isset($_SESSION["lastname"])) {
    header("Location: dashboard.php");
    exit();
}
// Import necessary classes from the phpOAuth library.
use Miniorange\Phpoauth\{
    Config\OAuthConfig,
    Handlers\AuthorizationHandler,
    Listeners\LoginListener,
    Handlers\CallbackHandler
};

// Initialize OAuth configuration and authorization handler.
try {
    $config = new OAuthConfig();

    $authHandler = new AuthorizationHandler($config);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}


$_SESSION['config'] = serialize($config);
class MyLoginSuccessListener implements LoginListener
{
    public function onLoginSuccess($user)
    {
        $_SESSION["firstname"] = $user->firstname;
        $_SESSION["lastname"] = $user->lastname;
        $_SESSION["user"] = $user;
        header("Location: /phpStarterApplication/dashboard.php");
    }
    public function onError($errorMessage)
    {
        // You can either show the error on the current page or redirect to an error page.
        $_SESSION['oauth_error'] = $errorMessage;

        // Optionally, you can redirect to the same page to show the error
        header("Location: " . $_SERVER['PHP_SELF']);
        
        exit();
    }
}


$loginListener = new MyLoginSuccessListener();
$fullUri = $_SERVER['REQUEST_URI'];
$myCallbackHandler = new CallbackHandler($config, $loginListener);

$myCallbackHandler->handleUri($fullUri);


if (isset($_POST['startAuth'])) {
    // Call the startAuthorization method when button is clicked
    try {
        $authHandler->startAuthorization();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
