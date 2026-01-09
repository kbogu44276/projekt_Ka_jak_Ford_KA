<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Losowy film</title>
</head>
<body>

<h1> Wylosowany film</h1>
<h2><?= htmlspecialchars($movie->title) ?></h2>
<p><?= htmlspecialchars($movie->description) ?></p>

<a href="index.php?controller=movie&action=random">Losuj ponownie</a>
<br><br>
<a href="index.php">Powrót do listy</a>

</body>
</html>


