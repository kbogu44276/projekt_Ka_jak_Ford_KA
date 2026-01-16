<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Panel administratora</title>
</head>
<body>

<h1>Panel administratora</h1>

<h2>Dodaj film</h2>
<form method="post" action="index.php?controller=admin&action=add">
    <input type="text" name="title" placeholder="Tytuł" required><br><br>
    <textarea name="description" placeholder="Opis" required></textarea><br><br>
    <button type="submit">Dodaj</button>
</form>

<hr>

<h2>Lista filmów</h2>
<ul>
    <?php foreach ($movies as $movie): ?>
        <li>
            <strong><?= htmlspecialchars($movie->title) ?></strong>
            <a href="index.php?controller=admin&action=delete&id=<?= $movie->id ?>"
               onclick="return confirm('Usunąć film?')">
                Usuń
            </a>
        </li>
    <?php endforeach; ?>
</ul>

<br>
<a href="index.php">Powrót do strony głównej</a>

</body>
</html>
