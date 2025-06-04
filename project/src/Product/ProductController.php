<?php
namespace App\Product;

use AlphaPit\Controller;
use AlphaPit\Attributes\Route;

class ProductController extends Controller
{
    public function __construct(private ProductService $service)
    {
    }

    #[Route('GET', '/products')]
    public function index(): void
    {
        $products = $this->service->all();
        $this->view('products', ['products' => $products]);
    }
}
