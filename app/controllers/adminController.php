<?php

class AdminController
{
    public function panel(): void
    {
        $movies = Movie::findAll();
        View::render('admin/panel', ['movies' => $movies]);
    }

    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = Database::connect();

            $stmt = $db->prepare(
                "INSERT INTO movies (title, description) VALUES (:title, :description)"
            );
            $stmt->execute([
                'title' => $_POST['title'],
                'description' => $_POST['description']
            ]);

            header("Location: index.php?controller=admin&action=panel");
        }
    }

    public function delete(): void
    {
        if (isset($_GET['id'])) {
            $db = Database::connect();

            $stmt = $db->prepare(
                "DELETE FROM movies WHERE id = :id"
            );
            $stmt->execute(['id' => $_GET['id']]);

            header("Location: index.php?controller=admin&action=panel");
        }
    }
}
