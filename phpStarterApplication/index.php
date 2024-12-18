<?php
// Check if an error message is stored in the session
require 'oauth.php';
$errorMessage = isset($_SESSION['oauth_error']) ? $_SESSION['oauth_error'] : '';
if ($errorMessage) {
    // Clear the session error message after showing it
    unset($_SESSION['oauth_error']);
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
    <?php if ($errorMessage): ?>
        <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x w-100 z-index-5" role="alert">
            <strong>Error!</strong> <?= htmlspecialchars($errorMessage); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div class="app-container">
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="app-icon">
                    <img src="https://www.miniorange.com/atlassian/wp-content/uploads/sites/14/2022/11/miniorange-logo-transparent.webp" />
                </div>
            </div>
            <ul class="sidebar-list">
                <li class="sidebar-list-item active">
                    <a href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                            <polyline points="9 22 9 12 15 12 15 22" />
                        </svg>
                        <span>Login</span>
                    </a>
                </li>
                <li class="sidebar-list-item ">
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
        </div>
        <div class="app-content">
            <div class="app-content-header">
                <h1 class="app-content-headerText">Sample Application</h1>
                <form method="post" action="">
                    <button type="submit" name="startAuth" class="app-content-headerButton">Sign In with MiniOrange</button>
                </form>
            </div>
            <br>
            <h1>Test OAuth Authentication in Sample Php Website</h1>
            <p>This testing interface allows you to experiment with various OAuth grant types and scopes. Configure settings in the .env file to test different authentication scenarios and see how the miniOrange php connector adapts to your requirements seamlessly.</p>
            <br>
            <br>
        </div>
    </div>
</body>

</html>