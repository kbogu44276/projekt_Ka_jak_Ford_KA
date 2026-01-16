<?php

class MovieController
{
    private function getMoviesData()
    {
        return [
            (object)['id' => 1, 'title' => 'Incepcja', 'rating' => 8.8, 'image' => 'https://bit.ly/3XkE7yA', 'description' => 'Złodziej kradnie tajemnice korporacyjne poprzez technologię dzielenia się snami.'],
            (object)['id' => 2, 'title' => 'Interstellar', 'rating' => 8.6, 'image' => 'https://bit.ly/4cmW3yB', 'description' => 'Zespół badaczy podróżuje poza naszą galaktykę, by ratować ludzkość.'],
            (object)['id' => 3, 'title' => 'Mroczny Rycerz', 'rating' => 9.0, 'image' => 'https://bit.ly/3VvUoN3', 'description' => 'Batman walczy z Jokerem, który chce pogrążyć Gotham w chaosie.'],
            (object)['id' => 4, 'title' => 'Pulp Fiction', 'rating' => 8.9, 'image' => 'https://bit.ly/3Xf9U7r', 'description' => 'Przemoc i odkupienie w świecie przestępczym Los Angeles.'],
            (object)['id' => 5, 'title' => 'Diuna: Część Druga', 'rating' => 8.1, 'image' => 'https://bit.ly/4aOshmE', 'description' => 'Paul Atryda jednoczy się z Fremenami, by zemścić się na spiskowcach.'],
            (object)['id' => 6, 'title' => 'Matrix', 'rating' => 8.7, 'image' => 'https://bit.ly/3x8mH8D', 'description' => 'Haker komputerowy dowiaduje się o prawdziwej naturze swojej rzeczywistości.']
        ];
    }

    public function list(): void
    {
        $allMovies = $this->getMoviesData();
        View::render('movie/homepage', [
            'topRated' => array_slice($allMovies, 0, 4),
            'recommended' => $allMovies
        ]);
    }

    public function show(): void
    {
        $id = $_GET['id'] ?? null;
        $allMovies = $this->getMoviesData();

        $selectedMovie = null;
        foreach ($allMovies as $m) {
            if ($m->id == $id) {
                $selectedMovie = $m;
                break;
            }
        }

        if (!$selectedMovie) {
            header("Location: index.php");
            exit;
        }

        // Przygotuj podobne filmy (wszystkie oprócz wybranego)
        $similar = array_filter($allMovies, fn($m) => $m->id != $id);

        View::render('movie/show', [
            'movie' => $selectedMovie,
            'similarMovies' => array_slice($similar, 0, 4)
        ]);
    }
}