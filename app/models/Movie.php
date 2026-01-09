<?php

class Movie extends BaseModel
{
    protected static string $table = 'movies';

    public int $id;
    public string $title;
    public string $description;

    public static function getRandom(): ?Movie
    {
        return self::findRandom();
    }
}
