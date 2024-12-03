<?php
namespace Miniorange\Phpoauth\Listeners;


interface LoginListener {

    /*
     * Called when the user successfully logs in.
     *
     * @param mixed $user Information about the logged-in user
     */
    public function onLoginSuccess($user);

    /*
     * Called when an error occurs during login.
     *
     * @param string $errorMessage Error message describing the issue
     */
    public function onError($errorMessage);
}
