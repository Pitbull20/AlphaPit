<?php
namespace AlphaPit;

use AlphaPit\DI\ServiceContainer;

class Module
{
    public array $controllers = [];
    public array $providers = [];
    public array $imports = [];

    public function register(Router $router, ServiceContainer $container): void
    {
        foreach ($this->imports as $import) {
            $module = $container->get($import);
            if ($module instanceof Module) {
                $module->register($router, $container);
            }
        }

        foreach ($this->providers as $provider) {
            $container->set($provider);
        }

        foreach ($this->controllers as $controller) {
            $router->registerController($controller, $container);
        }
    }
}
