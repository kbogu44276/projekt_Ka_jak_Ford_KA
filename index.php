<?php

require_once 'core/Database.php';
require_once 'core/BaseModel.php';
require_once 'core/View.php';

require_once 'app/models/Movie.php';
require_once 'app/controllers/MovieController.php';

$controller = $_GET['controller'] ?? 'movie';
$action = $_GET['action'] ?? 'list';

$controllerClass = ucfirst($controller) . 'Controller';

$instance = new $controllerClass();
$instance->$action();
