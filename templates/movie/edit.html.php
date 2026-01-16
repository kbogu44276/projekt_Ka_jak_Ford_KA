<?php

/** @var \App\Model\Movie $movie */
/** @var \App\Service\Router $router */

$title = 'Edit Movie ' . $movie->getTitle() . ' (' . $movie->getId() . ')';
$bodyClass = "edit";

ob_start(); ?>
    <h1><?= $title ?></h1>
    <form action="<?= $router->generatePath('movie-edit', ['id' => $movie->getId()]) ?>" method="post" class="edit-form">
        <?php require __DIR__ . DIRECTORY_SEPARATOR . '_form.html.php'; ?>
        <input type="submit" value="Submit">
    </form>

    <a href="<?= $router->generatePath('movie-index') ?>">Back to list</a>
<?php $main = ob_get_clean();

include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'base.html.php';