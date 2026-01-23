<?php
namespace App\Controller;

use App\Exception\NotFoundException;
use App\Model\Movie;
use App\Service\Router;
use App\Service\Templating;

class MovieController
{
    public function indexAction(Templating $templating, Router $router): ?string
    {
        $movies = Movie::findAll();
        $html = $templating->render('movie/index.html.php', [
            'movies' => $movies,
            'router' => $router,
        ]);
        return $html;
    }

    public function createAction(?array $requestPost, Templating $templating, Router $router): ?string
    {
        if ($requestPost) {
            $movie = Movie::fromArray($requestPost);
            // @todo missing validation
            $movie->save();

            $path = $router->generatePath('movie-index');
            $router->redirect($path);
            return null;
        } else {
            $movie = new Movie();
        }

        $html = $templating->render('movie/create.html.php', [
            'movie' => $movie,
            'router' => $router,
        ]);
        return $html;
    }

    public function editAction(int $movieId, ?array $requestPost, Templating $templating, Router $router): ?string
    {
        $movie = Movie::find($movieId);
        if (! $movie) {
            throw new NotFoundException("Missing movie with id $movieId");
        }

        if ($requestPost) {
            $movie->fill($requestPost);
            // @todo missing validation
            $movie->save();

            $path = $router->generatePath('movie-index');
            $router->redirect($path);
            return null;
        }

        $html = $templating->render('movie/edit.html.php', [
            'movie' => $movie,
            'router' => $router,
        ]);
        return $html;
    }

    public function showAction(int $movieId, Templating $templating, Router $router): ?string
    {
        $movie = Movie::find($movieId);
        if (! $movie) {
            throw new NotFoundException("Missing movie with id $movieId");
        }

        $html = $templating->render('movie/show.html.php', [
            'movie' => $movie,
            'router' => $router,
        ]);
        return $html;
    }

    public function deleteAction(int $movieId, Router $router): ?string
    {
        $movie = Movie::find($movieId);
        if (! $movie) {
            throw new NotFoundException("Missing movie with id $movieId");
        }

        $movie->delete();
        $path = $router->generatePath('movie-index');
        $router->redirect($path);
        return null;
    }

    public function randomAction(Templating $templating, Router $router): ?string
    {
        $movie = Movie::getRandom();

        if (!$movie) {
            $path = $router->generatePath('movie-index');
            $router->redirect($path);
            return null;
        }
        return $templating->render('movie/show.html.php', [
            'movie' => $movie,
            'router' => $router,
        ]);
    }

    private function getFavorites(): array
    {
        $raw = $_COOKIE['favorites'] ?? '[]';
        $arr = json_decode($raw, true);
        if (!is_array($arr)) return [];
        $arr = array_map('intval', $arr);
        $arr = array_values(array_unique(array_filter($arr, fn($x) => $x > 0)));
        return $arr;
    }

    private function saveFavorites(array $ids): void
    {
        setcookie('favorites', json_encode(array_values($ids)), [
            'expires' => time() + 365*24*60*60,
            'path' => '/',
            'samesite' => 'Lax',
        ]);
    }

    private function isFavorite(int $movieId): bool
    {
        return in_array($movieId, $this->getFavorites(), true);
    }

    public function toggleFavoriteAction(int $movieId, Router $router): ?string
    {
        $ids = $this->getFavorites();

        $pos = array_search($movieId, $ids, true);
        if ($pos === false) $ids[] = $movieId;
        else unset($ids[$pos]);

        $this->saveFavorites($ids);

        $return = $_REQUEST['return'] ?? $router->generatePath('movie-show', ['id' => $movieId]);
        $router->redirect($return);
        return null;
    }

    public function rateAction(int $movieId, int $rating, Router $router): ?string
    {
        if ($rating < 1 || $rating > 5) {
            $router->redirect($router->generatePath('movie-show', ['id' => $movieId]));
            return null;
        }

        $cookieName = "rated_movie_" . $movieId;
        $oldRating = isset($_COOKIE[$cookieName]) ? (int)$_COOKIE[$cookieName] : null;
        if ($oldRating !== null && ($oldRating < 1 || $oldRating > 5)) {
            $oldRating = null;
        }

        // zapis do DB (globalnie)
        Movie::applyRating($movieId, $rating, $oldRating);

        // zapis do cookies
        setcookie($cookieName, (string)$rating, [
            'expires' => time() + 365*24*60*60,
            'path' => '/',
            'samesite' => 'Lax',
        ]);

        $return = $_REQUEST['return'] ?? $router->generatePath('movie-show', ['id' => $movieId]);
        $router->redirect($return);
        return null;
    }

    public function searchAction(Templating $templating, Router $router): ?string
    {
        $q = trim($_GET['q'] ?? '');

        $movies = [];
        if ($q !== '') {
            $movies = Movie::searchByTitle($q, 80);
        }

        return $templating->render('movie/search.html.php', [
            'q' => $q,
            'movies' => $movies,
            'router' => $router,
        ]);
    }


    public function suggestAction(): void
    {
        $q = trim($_GET['q'] ?? '');

        header('Content-Type: application/json; charset=utf-8');

        if (mb_strlen($q) < 3) {
            echo json_encode([]);
            return;
        }

        $data = Movie::suggestTitles($q, 8);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

}