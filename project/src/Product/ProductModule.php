<?php
namespace App\Product;

use AlphaPit\Module;

class ProductModule extends Module
{
    public array $controllers = [ProductController::class];
    public array $providers = [ProductService::class, ProductEntity::class];
}
