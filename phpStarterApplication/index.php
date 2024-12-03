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
    <title>PHP OAUTH</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>
    <!-- Popup for error message -->
    <?php if ($errorMessage): ?>
        <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x w-100 z-index-5" role="alert">
            <strong>Error!</strong> <?= htmlspecialchars($errorMessage); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <section class="background-radial-gradient overflow-hidden">
        <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
            <div class="row gx-lg-5 align-items-center mb-5">
                <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
                    <h1 class="my-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
                        Test Php OAuth Connector Here <br />
                        <span style="color: hsl(218, 81%, 75%)">for your business</span>
                    </h1>
                    <p class="mb-4 opacity-70" style="color: hsl(218, 81%, 85%)">
                        This testing interface allows you to experiment with various OAuth grant types and scopes.
                        Configure settings in the .env file to test different authentication scenarios and see how the
                        connector adapts to your requirements seamlessly.
                    </p>
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
                    <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
                    <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

                    <div class="card bg-glass">
                        <div class="card-body px-4 py-5 px-md-5">
                            <form action="index.php" method="post">
                                <img src="./assets/miniorange-logo.png" alt="miniorange-logo" width="50%">

                                <!-- Email input -->
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="email" id="form3Example3" class="form-control" name="email" />
                                    <label class="form-label" for="form3Example3">Email address</label>
                                </div>

                                <!-- Password input -->
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input type="password" id="form3Example4" class="form-control" name="pass" />
                                    <label class="form-label" for="form3Example4">Password</label>
                                </div>

                                <!-- Submit button -->
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-primary btn-block mb-4">
                                    Sign In with Password Grant
                                </button>
                            </form>
                            <!-- Checkbox -->
                            <div class="form-check d-flex justify-content-center mb-4">
                                <p name="signup">Not a user? <a href="https://www.miniorange.com/businessfreetrial">Signup Here!</a></p>
                            </div>
                            <p class="text-center">OR</p>
                            <!-- Submit button -->
                            <div class="text-center">
                                <form method="post">
                                    <input type="hidden" name="startAuth" value="1">
                                    <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-primary btn-block">
                                        Sign In with MiniOrange
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</body>

</html>