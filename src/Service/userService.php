<?php

namespace App\Service;

use App\Entity\User;

class userService
{
    private bool $isLogged ;
    private User $user ; 
    public function __construct()
    {
        $this->isLogged = false;
        $this->user = new User();
    }

    public function setUser(User $u):void
    {
        $this->user = $u;
    }

    public function setIsLogged(bool $status = false ):void
    {
        $this->isLogged = $status ;
    }

    public function isLogged():bool
    {
        return $this->isLogged;
    }

    public function getUser():User
    {
        return $this->user;
    }
}