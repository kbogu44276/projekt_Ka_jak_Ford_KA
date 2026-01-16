<?php

class Movie extends BaseModel
{
    // Nazwa  tabeli w bazie danych Aiven
    protected static string $table = 'movies';

    // zmienne z bazy
    public $id;
    public $title;
    public $description;
    public $rating;
    public $image;
}