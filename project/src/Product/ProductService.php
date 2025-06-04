<?php
namespace App\Product;

class ProductService
{
    public function __construct(private ProductEntity $products)
    {
    }

    public function all(): array
    {
        return $this->products->all();
    }
}
