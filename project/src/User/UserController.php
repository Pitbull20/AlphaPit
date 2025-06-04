<?php
namespace App\User;

use AlphaPit\Controller;
use AlphaPit\Attributes\Route;

class UserController extends Controller
{
    public function __construct(private UserService $service)
    {
    }

    #[Route('GET', '/users')]
    public function index(): void
    {
        header('Content-Type: application/json');
        echo json_encode($this->service->all());
    }
}
