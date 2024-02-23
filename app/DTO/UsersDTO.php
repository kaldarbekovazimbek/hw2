<?php

namespace App\DTO;

class UsersDTO
{
    private string $name;
    private string $birthday;
    private string $email;
    private string $phone;
    private string $password;


    public function __construct(string $name, string $birthday, string $email, string $phone, string $password)
    {
        $this->name = $name;
        $this->birthday = $birthday;
        $this->email = $email;
        $this->phone = $phone;
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

    public function getBirthday(): string
    {
        return $this->birthday;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public static function fromArray(array $data): UsersDTO
    {
        return new UsersDTO(
            name: $data['name'],
            birthday: $data['birthday'],
            email: $data['email'],
            phone: $data['phone'],
            password: $data['password'],

        );
    }

}


