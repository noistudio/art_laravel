<?php

declare(strict_types = 1);

namespace App\Auth;

use Illuminate\Database\Eloquent\Model;

/**
 * Trait NoRememberTokenAuthenticatable
 *
 * @mixin Model
 */
trait NoRememberTokenAuthenticatable {

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName() {
        return 'id';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier() {
        return $this->id;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function getAuthPassword() {
        throw new \BadMethodCallException('Unexpected method call');
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function getRememberToken() {
        throw new \BadMethodCallException('Unexpected method call');
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param string $value
     * @codeCoverageIgnore
     */
    public function setRememberToken($value) {
        throw new \BadMethodCallException('Unexpected method call');
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function getRememberTokenName() {
        throw new \BadMethodCallException('Unexpected method call');
    }

}
