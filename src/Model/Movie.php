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

    private int $rating_sum = 0;
    private int $rating_count = 0;

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

    public function getRatingSum(): int { return $this->rating_sum; }
    public function setRatingSum(int $v): Movie { $this->rating_sum = $v; return $this; }

    public function getRatingCount(): int { return $this->rating_count; }

    public function setRatingCount(int $v): Movie { $this->rating_count = $v; return $this; }

    public function getAverageRating(): ?float
    {
        if($this->rating_sum <= 0) return null;
        return $this->rating_sum / $this->rating_count;
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
        if (isset($array['rating_sum'])) {
            $this->setRatingSum((int)$array['rating_sum']);
        }
        if (isset($array['rating_count'])) {
            $this->setRatingCount((int)$array['rating_count']);
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

    public static function applyRating(int $movieId, int $newRating, ?int $oldRating = null): void
    {
        $pdo = self::getConnection();
        $pdo->beginTransaction();

        // blokujemy wiersz (MySQL/InnoDB)
        $stmt = $pdo->prepare("SELECT rating_sum, rating_count FROM movies WHERE id = :id FOR UPDATE");
        $stmt->execute(['id' => $movieId]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$row) {
            $pdo->rollBack();
            throw new \RuntimeException("Movie not found");
        }

        $sum = (int)$row['rating_sum'];
        $count = (int)$row['rating_count'];

        if ($oldRating === null) {
            $sum += $newRating;
            $count += 1;
        } else {
            $sum = $sum - $oldRating + $newRating; // zmiana oceny
        }

        $upd = $pdo->prepare("UPDATE movies SET rating_sum = :sum, rating_count = :count WHERE id = :id");
        $upd->execute(['sum' => $sum, 'count' => $count, 'id' => $movieId]);

        $pdo->commit();
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

    public static function searchByTitle(string $query, int $limit = 50): array
    {
        $query = trim($query);
        if ($query === '') return [];

        $pdo = self::getConnection();

        // ESCAPE dla LIKE (żeby % i _ nie psuły zapytania)
        $like = str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $query);
        $like = "%{$like}%";

        $stmt = $pdo->prepare("
        SELECT *
        FROM movies
        WHERE title LIKE :q ESCAPE '\\\\'
        ORDER BY title ASC
        LIMIT :limit
    ");
        $stmt->bindValue(':q', $like, \PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        $movies = [];
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $movies[] = self::fromArray($row);
        }

        return $movies;
    }


    public static function suggestTitles(string $query, int $limit = 8): array
    {
        if (mb_strlen(trim($query)) < 3) return [];
        $movies = self::searchByTitle($query, $limit);

        return array_map(fn($m) => [
            'id' => $m->id,
            'title' => $m->title,
        ], $movies);
    }
}