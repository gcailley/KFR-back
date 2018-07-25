<?php
namespace RoutanglangquanBundle\Form\Dto\Security;

class RtlqCredentialsDTO
{
    protected $login;

    protected $password;

    public $token;

    public $roles;

    public $username;

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getToken()
    {
        return $this->token;
    }
    public function setToken($value)
    {
        $this->token = $value;
        return $this;
    }

    
    public function getRoles()
    {
        return $this->roles;
    }
    public function setRoles($value)
    {
        $this->roles = $value;
        return $this;
    }


    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername($value)
    {
        $this->username = $value;
        return $this;
    }

}
