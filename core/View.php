<?php

class View
{
    public static function render(string $view, array $data = []): void
    {
        extract($data);
        require "app/views/$view.php";
    }
}
