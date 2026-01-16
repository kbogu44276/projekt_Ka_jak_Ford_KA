<?php

class MovieController
{
    /**
     * Strona główna (homepage.php)
     */
    public function list(): void
    {
        // 1. Statyczna lista filmów (nasza tymczasowa baza danych)
        $allMovies = [
            (object)['id' => 1, 'title' => 'Incepcja', 'rating' => 8.8, 'image' => 'https://bit.ly/3XkE7yA'],
            (object)['id' => 2, 'title' => 'Interstellar', 'rating' => 8.6, 'image' => 'https://bit.ly/4cmW3yB'],
            (object)['id' => 3, 'title' => 'Mroczny Rycerz', 'rating' => 9.0, 'image' => 'https://bit.ly/3VvUoN3'],
            (object)['id' => 4, 'title' => 'Pulp Fiction', 'rating' => 8.9, 'image' => 'https://bit.ly/3Xf9U7r'],
            (object)['id' => 5, 'title' => 'Diuna: Część Druga', 'rating' => 8.1, 'image' => 'https://bit.ly/4aOshmE'],
            (object)['id' => 6, 'title' => 'Matrix', 'rating' => 8.7, 'image' => 'https://bit.ly/3x8mH8D']
        ];

        // 2. Obsługa wyszukiwarki
        $query = $_GET['query'] ?? '';
        if (!empty($query)) {
            $allMovies = array_filter($allMovies, function($m) use ($query) {
                return mb_stripos($m->title, $query) !== false;
            });
        }

        // 3. Sekcja: Najwyżej oceniane (Sortowanie po ratingu)
        $topRated = $allMovies;
        usort($topRated, fn($a, $b) => $b->rating <=> $a->rating);
        $topRated = array_slice($topRated, 0, 4);

        // 4. Sekcja: Polecane (Losowa kolejność)
        $recommended = $allMovies;
        shuffle($recommended);
        $recommended = array_slice($recommended, 0, 4);

        // Renderowanie widoku z przekazaniem obu list
        View::render('movie/homepage', [
            'topRated' => $topRated,
            'recommended' => $recommended
        ]);
    }

    /**
     * Strona ulubionych filmów
     */
    public function favorites(): void
    {
        // Statyczna lista wybranych filmów dla widoku favorites.php
        $favoriteMovies = [
            (object)['id' => 1, 'title' => 'Incepcja', 'rating' => 8.8, 'image' => 'https://bit.ly/3XkE7yA'],
            (object)['id' => 3, 'title' => 'Mroczny Rycerz', 'rating' => 9.0, 'image' => 'https://bit.ly/3VvUoN3']
        ];

        View::render('movie/favorites', ['movies' => $favoriteMovies]);
    }

    /**
     * Strona losowania filmu
     */
    public function random(): void
    {
        $allMovies = [
            (object)['id' => 1, 'title' => 'Incepcja', 'rating' => 8.8, 'image' => 'https://bit.ly/3XkE7yA'],
            (object)['id' => 2, 'title' => 'Interstellar', 'rating' => 8.6, 'image' => 'https://bit.ly/4cmW3yB'],
            (object)['id' => 3, 'title' => 'Mroczny Rycerz', 'rating' => 9.0, 'image' => 'https://bit.ly/3VvUoN3']
        ];

        // Wybór jednego losowego filmu
        $randomMovie = $allMovies[array_rand($allMovies)];

        View::render('movie/random', ['movie' => $randomMovie]);
    }
}