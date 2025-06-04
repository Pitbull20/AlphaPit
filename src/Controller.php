<?php
namespace AlphaPit;

class Controller
{
    protected function view(string $template, array $data = []): void
    {
        extract($data);
        include __DIR__ . "/../views/{$template}.php";
    }
}
