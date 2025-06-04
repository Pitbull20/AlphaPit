<?php
namespace App\User;

use AlphaPit\Module;

class UserModule extends Module
{
    public array $controllers = [UserController::class];
    public array $providers = [UserService::class, UserEntity::class];
}
