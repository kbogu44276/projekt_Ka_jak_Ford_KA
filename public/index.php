<?php
session_start();




if (!isset($_SESSION['is_admin'])) {
    $_SESSION['is_admin'] = false;
}


require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'autoload.php';

$config = new \App\Service\Config();
$templating = new \App\Service\Templating();
$router = new \App\Service\Router();

$action = $_REQUEST['action'] ?? null;
$viewType = $_GET['view'] ?? 'user';

if ($viewType === 'admin' && empty($_SESSION['is_admin'])) {
    header('Location: /login.php');
    exit;
}


switch ($action) {
    case 'movie-index':
    case null:
        $controller = new \App\Controller\MovieController();
        $movies = $controller->indexAction($templating, $router);

        if (!is_array($movies)) {
            $movies = \App\Model\Movie::findAll();
        }

        // Filtracja tylko w widoku user
        if ($viewType === 'user') {
            if (!empty($_GET['platform'])) {
                $movies = \App\Model\Movie::findByPlatform($_GET['platform']);
            }
            if (!empty($_GET['category'])) {
                $movies = array_filter($movies, fn($m) => $m->getCategory() === $_GET['category']);
            }
        }

        // Render szablonu
        $view = $templating->render('movie/index.html.php', [
            'movies' => $movies,
            'viewType' => $viewType
        ]);
        break;

    case 'movie-create':
        $controller = new \App\Controller\MovieController();
        $view = $controller->createAction($_REQUEST['movie'] ?? null, $templating, $router);
        break;

    case 'movie-edit':
        if (!$_REQUEST['id']) { break; }
        $controller = new \App\Controller\MovieController();
        $view = $controller->editAction($_REQUEST['id'], $_REQUEST['movie'] ?? null, $templating, $router);
        break;

    case 'movie-show':
        if (!$_REQUEST['id']) { break; }
        $controller = new \App\Controller\MovieController();
        $view = $controller->showAction($_REQUEST['id'], $templating, $router);
        break;

    case 'movie-delete':
        if (!$_REQUEST['id']) { break; }
        $controller = new \App\Controller\MovieController();
        $view = $controller->deleteAction($_REQUEST['id'], $router);
        break;

    case 'movie-random':
        $controller = new \App\Controller\MovieController();
        $view = $controller->randomAction($templating, $router);
        break;

    case 'movie-rate':
        if (!$_REQUEST['id'] || !isset($_REQUEST['rating'])) { break; }
        $controller = new \App\Controller\MovieController();
        $view = $controller->rateAction((int)$_REQUEST['id'], (int)$_REQUEST['rating'], $router);
        break;

    case 'movie-favorite-toggle':
        if (!$_REQUEST['id']) { break; }
        $controller = new \App\Controller\MovieController();
        $view = $controller->toggleFavoriteAction((int)$_REQUEST['id'], $router);
        break;


}

if ($view) {
    echo $view;
}

