<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lista filmów</title>
</head>
<body>

<h1>🎬 Lista filmów</h1>

<a href="index.php?controller=movie&action=random">
    🎲 Wylosuj film
</a>

<ul>
    <?php foreach ($movies as $movie): ?>
        <li>
            <strong><?= htmlspecialchars($movie->title) ?></strong><br>
            <?= htmlspecialchars($movie->description) ?>
        </li>
    <?php endforeach; ?>
</ul>

</body>
</html>
