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
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
if(isset($_POST['logout'])){
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
  <link rel="stylesheet" href="style.css">

</head>

<body>
  <div class="app-container">
    <div class="sidebar">
      <div class="sidebar-header">
        <div class="app-icon">
          <img src="https://www.miniorange.com/atlassian/wp-content/uploads/sites/14/2022/11/miniorange-logo-transparent.webp" />
        </div>
      </div>
      <ul class="sidebar-list">
        <li class="sidebar-list-item">
          <a href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
              <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
              <polyline points="9 22 9 12 15 12 15 22" />
            </svg>
            <span>Home</span>
          </a>
        </li>
        <li class="sidebar-list-item active">
          <a href="#">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag">
              <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
              <line x1="3" y1="6" x2="21" y2="6" />
              <path d="M16 10a4 4 0 0 1-8 0" />
            </svg>
            <span>Dashboard</span>

          </a>
        </li>

      </ul>
      <div class="account-info">
        <div class="account-info-picture">
          <img src="https://cdn-icons-png.flaticon.com/128/149/149071.png" alt="Account">
        </div>
        <div class="account-info-name"><?php echo $_SESSION["firstname"] . ' ' . $_SESSION["lastname"]; ?></div>

      </div>
    </div>
    <div class="app-content">
      <div class="app-content-header">
        <h1 class="app-content-headerText">Dashboard</h1>

        <form method="post" action="">
          <button class="app-content-headerButton" type="submit" name="logout" class="btn btn-danger">Logout</button>
        </form>
      </div>
      <?php
      // Assuming tokens are stored in session as 'access_token' and 'refresh_token'
      $tokens = [
        'Access Token' => $_SESSION['access_token'] ?? 'Not Found',
        'Refresh Token' => $_SESSION['refresh_token'] ?? 'Not Found',
        'Id Token' => $_SESSION['id_token'] ?? 'Not Found',
      ];

      if (!empty($tokens)):
      ?>
        <br>
        <h3>Authorization Details</h3>
        <table border="1" style="border-collapse: collapse; width: 50%; padding: 20px; border-radius: 20px;">
          <thead>
            <tr>
              <td style="padding: 8px; text-align: left;">Grant Type</td>
              <td style="padding: 8px; text-align: left;">
                <?php echo htmlspecialchars($config->getGrantType() ?? 'Not Specified'); ?>
              </td>
            </tr>
            <tr>
              <td style="padding: 8px; text-align: left;">Provided Scopes</td>
              <td style="padding: 8px; text-align: left;">
                <?php
                // Assuming scopes are stored as an array in the config
                echo htmlspecialchars( $config->getScope() ?? ['Not Specified']);
                ?>
              </td>
            </tr>
          </thead>
        </table>


        <br>
        <h3>Stored Tokens:</h3>
        <table border="1" style="border-collapse: collapse; width: 50%; padding: 20px; border-radius: 20px;">
          <thead>
            <tr>
              <th style="padding: 8px; text-align: left;">Token Type</th>
              <th style="padding: 8px; text-align: left;">Value</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($tokens as $key => $value): ?>
              <tr>
                <td style="padding: 8px;"><?php echo htmlspecialchars($key); ?></td>
                <td style="padding: 8px;"><?php echo htmlspecialchars($value); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>No tokens found in session.</p>
      <?php endif; ?>

      <?php
      // Assuming $_SESSION['user'] is already an object or associative array
      $user = $_SESSION['user'];

      // If it's an object, cast it to an array for iteration
      if (is_object($user)) {
        $user = (array) $user;
      }

      if ($user && is_array($user)):
      ?>
        <br>
        <br>
        <h3>Server Response:</h3>
        <table border="1" style="border-collapse: collapse; width: 50%;">
          <thead>
            <tr>
              <th style="padding: 8px; text-align: left;">Key</th>
              <th style="padding: 8px; text-align: left;">Value</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($user as $key => $value): ?>
              <tr>
                <td style="padding: 8px;"><?php echo htmlspecialchars($key); ?></td>
                <td style="padding: 8px;"><?php echo htmlspecialchars($value); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p>No user data found in session.</p>
      <?php endif; ?>
      <br>
      <br>

    </div>
  </div>
</body>

</html>