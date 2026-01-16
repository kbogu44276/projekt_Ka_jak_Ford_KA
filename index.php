<?php
// Włącz wyświetlanie błędów, aby widzieć co się dzieje
ini_set('display_errors', 1);
error_reporting(E_ALL);

define('BASE_DIR', __DIR__ . DIRECTORY_SEPARATOR);

// POPRAWIONE ŚCIEŻKI na podstawie Twojej struktury plików
//require_once BASE_DIR . 'core' . DIRECTORY_SEPARATOR . 'Db' . DIRECTORY_SEPARATOR . 'Database.php';
require_once BASE_DIR . 'core' . DIRECTORY_SEPARATOR . 'BaseModel.php';
require_once BASE_DIR . 'core' . DIRECTORY_SEPARATOR . 'View.php';

require_once BASE_DIR . 'app' . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'Movie.php';
require_once BASE_DIR . 'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'MovieController.php';
require_once BASE_DIR . 'app' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . 'adminController.php';

$controller = $_GET['controller'] ?? 'movie';
$action = $_GET['action'] ?? 'list';

$controllerClass = ucfirst($controller) . 'Controller';

if (class_exists($controllerClass)) {
    $instance = new $controllerClass();
    if (method_exists($instance, $action)) {
        $instance->$action();
    } else {
        die("Akcja $action nie istnieje.");
    }
} else {
    die("Kontroler $controllerClass nie istnieje.");
}