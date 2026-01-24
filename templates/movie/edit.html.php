<?php
/** @var \App\Model\Movie $movie */
/** @var \App\Service\Router $router */

$title = 'Edit Movie · ' . htmlspecialchars($movie->getTitle());
$bodyClass = "edit";

ob_start(); ?>

    <main class="imdb-container">
        <div class="imdb-header">
            <div class="header-content">
                <h1 class="imdb-title">Edit Movie</h1>
                <p class="header-subtitle">
                    Editing: <strong><?= htmlspecialchars($movie->getTitle()) ?></strong>
                </p>
            </div>

            <div class="header-controls">
                <a href="<?= $router->generatePath('movie-index') ?>" class="btn btn-switch">
                    Back to list
                </a>
            </div>
        </div>

        <div class="edit-card">
            <form action="<?= $router->generatePath('movie-edit', ['id' => $movie->getId()]) ?>"
                  method="post"
                  class="edit-form">

                <?php require __DIR__ . DIRECTORY_SEPARATOR . '_form.html.php'; ?>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        Save changes
                    </button>
                    <a href="<?= $router->generatePath('movie-index') ?>" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>

<?php $main = ob_get_clean();
include __DIR__ . '/../base.html.php';
?>

<style>


    .edit-card {
        max-width: 720px;
        margin: 0 auto;
        padding: 2rem 2.5rem;
        background: rgba(26, 26, 46, 0.9);
        border: 1px solid #333;
        border-radius: 12px;
        box-shadow: 0 12px 28px rgba(0,0,0,0.45);
    }

    .edit-form label {
        display: block;
        margin-bottom: 0.4rem;
        font-weight: 600;
        color: #ffd700;
    }

    .edit-form input[type="text"],
    .edit-form textarea,
    .edit-form select {
        width: 100%;
        padding: 0.85rem 1rem;
        margin-bottom: 1.5rem;
        border-radius: 6px;
        border: 1px solid #444;
        background: #1a1a2e;
        color: #e0e0e0;
        font-size: 1rem;
    }

    .edit-form textarea {
        min-height: 140px;
        resize: vertical;
    }

    .edit-form input:focus,
    .edit-form textarea:focus,
    .edit-form select:focus {
        outline: none;
        border-color: #ffd700;
        box-shadow: 0 0 0 2px rgba(255, 215, 0, 0.25);
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 1.5rem;
    }

</style>

