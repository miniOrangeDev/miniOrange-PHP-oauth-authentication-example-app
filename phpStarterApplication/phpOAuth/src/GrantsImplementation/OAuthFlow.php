<?php
namespace Miniorange\Phpoauth\GrantsImplementation;

/* =========================================================== */
/*                    Abstract OAuth Flow                      */
/* ----------------------------------------------------------- */
/* This abstract class serves as a blueprint for implementing  */
/* different OAuth grant types, such as Authorization Code,    */
/* Implicit, and others. Classes extending this abstract class */
/* must implement the createAuthorizationRequest method.       */
/* =========================================================== */
abstract class OAuthFlow {
    /*    Abstract Method for Creating Authorization Requests      */
    abstract protected function createAuthorizationRequest($email = null, $password = null);
}
