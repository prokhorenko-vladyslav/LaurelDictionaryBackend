<?php


namespace App\DTO;


class UserRegisterDTO
{
    protected string $name;
    protected string $email;
    protected string $password;

    public function __construct(
        string $name, string $email, string $password
    ) {
        $this->name = $name;
        $this->email = $email;
        $this->password = bcrypt($password);
    }

    public function toArray() {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ];
    }
}
