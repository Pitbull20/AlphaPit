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

    #[Route('GET', '/users/{id}')]
    public function show(string $id): void
    {
        header('Content-Type: application/json');
        $user = $this->service->find((int)$id);
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Not Found']);
        }
    }
}
