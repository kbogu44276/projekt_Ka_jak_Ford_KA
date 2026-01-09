<?php

class MovieController
{
    public function list(): void
    {
        $movies = Movie::findAll();
        View::render('movie/list', ['movies' => $movies]);
    }

    public function random(): void
    {
        $movie = Movie::getRandom();

        if (!$movie) {
            echo "Brak filmów w bazie.";
            return;
        }

        View::render('movie/random', ['movie' => $movie]);
    }
}
