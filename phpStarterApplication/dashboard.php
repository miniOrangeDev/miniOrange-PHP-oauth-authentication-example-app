<?PHP
require_once "phpOAuth/vendor/autoload.php";

use function Miniorange\Phpoauth\Handlers\isSessionActive;
use function MiniOrange\Phpoauth\Handlers\logout;

session_start();

if (!isset($_SESSION['config'])) {
    die("Please login first.");
}

// Unserialize to get the config object back
$config = unserialize($_SESSION['config']);
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    // Clear the session
    session_unset();
    session_destroy();
    
    // Call the logout function
    logout($config);
    exit();
}
if (!isSessionActive($config)) {
    echo "SESSION NOT FOUND PLEASE LOGIN";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Welcome, <?php echo $_SESSION["firstname"] . ' ' . $_SESSION["lastname"]; ?>!</h1>
<h2>You have successfully authenticated and been redirected to this dashboard.</h2>
<p>Use this page to explore and test the features of the PHP OAuth Starter App. You are now logged in with your authenticated session. Feel free to experiment with different grant types and permissions by updating the configuration in the <code>.env</code> file and re-authenticating.</p>
<p>Additionally, To check if your session is active, or if your stored tokens are still valid, you can use the <code>isSessionActive</code> function. This will help you verify whether tokens are expired or still valid, ensuring a smooth and secure testing experience.</p>
<p>If you encounter any issues or have questions, refer to the <a href="https://docs.google.com/document/d/1LVw5yYQJIh3egOYxIOskO0J-ctmJKIz78Y9ay7U6ERU/edit?usp=sharing" target="_blank">Starter App Documentation</a> for more guidance.</p>


<form method="post" action="">
        <button type="submit" name="logout">Logout</button>
    </form>
</body>
</html>