<?php
namespace AlphaPit;

class Controller
{
    protected function view(string $template, array $data = []): void
    {
        extract($data);
        $base = defined('VIEW_PATH') ? VIEW_PATH : dirname(__DIR__) . '/project/views';
        include "$base/{$template}.php";
    }
}
