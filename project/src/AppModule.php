<?php
namespace App;

use AlphaPit\Module;
use App\User\UserModule;
use App\Home\HomeModule;
use App\Product\ProductModule;

class AppModule extends Module
{
    public array $imports = [HomeModule::class, UserModule::class, ProductModule::class];
}
