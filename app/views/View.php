<?php
//To jest drugie View? Trzeba usunąć?
class View
{
    public static function render(string $view, array $data = []): void
    {
        extract($data);
        // Pliki będą w app/views/ (np. app/views/movie/homepage.php)
        require "app/views/$view.php";
    }
}