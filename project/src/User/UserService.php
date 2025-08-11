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

    public function find(int $id): ?array
    {
        return $this->users->find($id);
    }
}
