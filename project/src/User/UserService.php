<?php
namespace App\User;

class UserService
{
    public function __construct(private UserEntity $users)
    {
    }

    public function all(): array
    {
        return $this->users->all();
    }
}
