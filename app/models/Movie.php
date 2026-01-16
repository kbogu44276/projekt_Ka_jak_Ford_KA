<?php

class Movie extends BaseModel
{
    // Nazwa Twojej tabeli w bazie danych Aiven
    protected static string $table = 'movies';

    // Te zmienne muszą odpowiadać kolumnom w Twojej bazie danych
    public $id;
    public $title;
    public $description;
    public $rating;
    public $image;
}