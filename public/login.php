<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($login === 'admin' && $password === 'admin') {
        $_SESSION['is_admin'] = true;
        header('Location: /index.php?action=movie-index&view=admin');
        exit;
    } else {
        $error = 'Nieprawidłowy login lub hasło!';
    }
}
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie Admin</title>
    <style>
        body { font-family: sans-serif; background:#f2f2f2; display:flex; justify-content:center; align-items:center; height:100vh; }
        form { background:#fff; padding:2rem; border-radius:10px; box-shadow:0 3px 6px rgba(0,0,0,0.1); }
        input { display:block; margin:1rem 0; padding:0.5rem; width:100%; border-radius:5px; border:1px solid #ccc; }
        .btn { background:#007bff; color:#fff; padding:0.5rem; border:none; border-radius:5px; cursor:pointer; }
        .error { color:red; }
    </style>
</head>
<body>
<form method="post">
    <h2>Logowanie Admin</h2>
    <?php if($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
    <input type="text" name="login" placeholder="Login" required>
    <input type="password" name="password" placeholder="Hasło" required>
    <button type="submit" class="btn">Zaloguj</button>
</form>
</body>
</html>
