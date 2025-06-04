<?php
namespace App\Home;

use AlphaPit\Controller;
use AlphaPit\Attributes\Route;

class HomeController extends Controller
{
    #[Route('GET', '/')]
    public function index(): void
    {
        $this->view('home', ['title' => 'Welcome to AlphaPit']);
    }
}
