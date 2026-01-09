<?php

abstract class BaseModel
{
    protected static string $table;

    public static function findAll(): array
    {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM " . static::$table);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([static::class, 'map'], $rows);
    }

    public static function findRandom(): ?static
    {
        $db = Database::connect();
        $stmt = $db->query(
            "SELECT * FROM " . static::$table . " ORDER BY RAND() LIMIT 1"
        );

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? static::map($row) : null;
    }

    protected static function map(array $row): BaseModel
    {
        $obj = new static();
        foreach ($row as $key => $value) {
            $obj->$key = $value;
        }
        return $obj;
    }
}
