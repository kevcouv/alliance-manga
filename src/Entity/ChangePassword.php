<?php

namespace App\Entity;

use Symfony\Component\Security\Core\Validator\Constraints as Assert;

class ChangePassword
{
    /**
     * @Assert\UserPassword(
     *     message = "Mot de passe incorect"
     * )
     */
    protected $oldPassword;

    protected $password;


    function getOldPassword() {
        return $this->oldPassword;
    }

    function getPassword() {
        return $this->password;
    }

    function setOldPassword($oldPassword) {
        $this->oldPassword = $oldPassword;
        return $this;
    }

    function setPassword($password) {
        $this->password = $password;
        return $this;
    }
}