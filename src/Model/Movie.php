<?php
namespace App\Model;

use App\Service\Config;

class Movie
{
    private ?int $id = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?string $platform = null;
    private ?string $category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Movie
    {
        $this->id = $id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): Movie
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Movie
    {
        $this->description = $description;

        return $this;
    }

    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    public function setPlatform(?string $platform): Movie
    {
        $this->platform = $platform;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): Movie
    {
        $this->category = $category;

        return $this;
    }

    public static function fromArray($array): Movie
    {
        $movie = new self();
        $movie->fill($array);

        return $movie;
    }

    public function fill($array): Movie
    {
        if (isset($array['id']) && ! $this->getId()) {
            $this->setId($array['id']);
        }
        if (isset($array['title'])) {
            $this->setTitle($array['title']);
        }
        if (isset($array['description'])) {
            $this->setDescription($array['description']);
        }
        if (isset($array['platform'])) {
            $this->setPlatform($array['platform']);
        }
        if (isset($array['category'])) {
            $this->setCategory($array['category']);
        }

        return $this;
    }

    private static function getConnection()
    {
        require_once __DIR__ . '/../../Database.php';
        $database = new \Database();
        return $database->getConnection();
    }

    public static function findAll(): array
    {
        $pdo = self::getConnection();
        $sql = 'SELECT * FROM movies';
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $movies = [];
        $moviesArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($moviesArray as $movieArray) {
            $movies[] = self::fromArray($movieArray);
        }

        return $movies;
    }

    public static function find($id): ?Movie
    {
        $pdo = self::getConnection();
        $sql = 'SELECT * FROM movies WHERE id = :id';
        $statement = $pdo->prepare($sql);
        $statement->execute(['id' => $id]);

        $movieArray = $statement->fetch(\PDO::FETCH_ASSOC);
        if (! $movieArray) {
            return null;
        }
        $movie = Movie::fromArray($movieArray);

        return $movie;
    }

    public static function findByPlatform(string $platform): array
    {
        $pdo = self::getConnection();
        $sql = 'SELECT * FROM movies WHERE platform = :platform';
        $statement = $pdo->prepare($sql);
        $statement->execute(['platform' => $platform]);

        $movies = [];
        $moviesArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($moviesArray as $movieArray) {
            $movies[] = self::fromArray($movieArray);
        }

        return $movies;
    }

    public static function findByCategory(string $category): array
    {
        $pdo = self::getConnection();
        $sql = 'SELECT * FROM movies WHERE category = :category';
        $statement = $pdo->prepare($sql);
        $statement->execute(['category' => $category]);

        $movies = [];
        $moviesArray = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($moviesArray as $movieArray) {
            $movies[] = self::fromArray($movieArray);
        }

        return $movies;
    }

    public static function getRandom(): ?Movie
    {
        $pdo = self::getConnection();
        $sql = 'SELECT * FROM movies ORDER BY RAND() LIMIT 1';
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $movieArray = $statement->fetch(\PDO::FETCH_ASSOC);
        if (! $movieArray) {
            return null;
        }
        $movie = Movie::fromArray($movieArray);

        return $movie;
    }


    public static function getAvailablePlatforms(): array
    {
        $pdo = self::getConnection();
        $sql = 'SELECT DISTINCT platform FROM movies WHERE platform IS NOT NULL ORDER BY platform';
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $platforms = [];
        $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($results as $result) {
            $platforms[] = $result['platform'];
        }

        return $platforms;
    }

    public function save(): void
    {
        $pdo = self::getConnection();
        if (! $this->getId()) {
            $sql = "INSERT INTO movies (title, description, platform, category) VALUES (:title, :description, :platform, :category)";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                'title' => $this->getTitle(),
                'description' => $this->getDescription(),
                'platform' => $this->getPlatform(),
                'category' => $this->getCategory(),
            ]);

            $this->setId($pdo->lastInsertId());
        } else {
            $sql = "UPDATE movies SET title = :title, description = :description, platform = :platform, category = :category WHERE id = :id";
            $statement = $pdo->prepare($sql);
            $statement->execute([
                ':title' => $this->getTitle(),
                ':description' => $this->getDescription(),
                ':platform' => $this->getPlatform(),
                ':category' => $this->getCategory(),
                ':id' => $this->getId(),
            ]);
        }
    }


    public function delete(): void
    {
        $pdo = self::getConnection();
        $sql = "DELETE FROM movies WHERE id = :id";
        $statement = $pdo->prepare($sql);
        $statement->execute([
            ':id' => $this->getId(),
        ]);

        $this->setId(null);
        $this->setTitle(null);
        $this->setDescription(null);
        $this->setPlatform(null);
    }
}