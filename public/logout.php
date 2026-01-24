<?php
session_start();

$_SESSION = [];
session_destroy();

header('Location: /index.php?action=movie-index&view=user');
exit;
