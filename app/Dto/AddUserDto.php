<?php

namespace App\Dto;

class AddUserDto
{

    private $name;
    private $password;

    public function __construct(string $name, string $password)
    {
        $this->name = $name;
        $this->password = $password;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getEncryptedPassword(): string
    {
        return sha1($this->password);
    }
}