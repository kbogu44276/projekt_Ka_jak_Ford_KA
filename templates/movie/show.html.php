<?php if(!empty($_SESSION['is_admin'])): ?>
    <a href="/logout.php" class="btn btn-logout">🚪 Wyloguj</a>
<?php endif; ?>

<?php /** @var \App\Model\Movie $movie */ ?>

<main class="imdb-container">
    <div class="imdb-header">
        <div class="header-content">
            <h1 class="imdb-title"><?= htmlspecialchars($movie->getTitle()) ?></h1>
            <p class="header-subtitle">Szczegóły wybranego filmu</p>
        </div>
        <div class="header-controls">
            <a href="/index.php?action=movie-index" class="btn btn-switch">⬅️ Powrót do listy</a>
            <?php if(!empty($_SESSION['is_admin'])): ?>
                <a href="/index.php?action=movie-edit&id=<?= $movie->getId() ?>" class="btn btn-secondary">🛠️ Edytuj</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="movie-single-layout" style="display: flex; gap: 3rem; background: rgba(26, 26, 46, 0.8); padding: 2rem; border-radius: 12px; border: 1px solid #333;">

        <div class="movie-poster-single" style="flex: 0 0 250px;">
            <div class="movie-poster" style="padding-top: 150%; border-radius: 8px; border: 1px solid #ffd700;">
                <div class="poster-placeholder" style="font-size: 4rem;">🎬</div>
            </div>
        </div>

        <div class="movie-details" style="flex: 1;">
            <div class="movie-meta" style="margin-bottom: 2rem;">
                <?php if ($movie->getCategory()): ?>
                    <span class="meta-badge category-badge" style="font-size: 1rem; padding: 0.5rem 1rem;">
                        <?= htmlspecialchars($movie->getCategory()) ?>
                    </span>
                <?php endif; ?>
                <?php if ($movie->getPlatform()): ?>
                    <span class="meta-badge platform-badge" style="font-size: 1rem; padding: 0.5rem 1rem;">
                        <?= htmlspecialchars($movie->getPlatform()) ?>
                    </span>
                <?php endif; ?>
            </div>

            <h2 style="color: #ffd700; margin-bottom: 1.5rem; font-size: 2rem; border-bottom: 1px solid #333; padding-bottom: 0.5rem;">
                Opis fabuły
            </h2>
            <p style="font-size: 1.15rem; line-height: 1.8; color: #d0d0d0;">
                <?= nl2br(htmlspecialchars($movie->getDescription())) ?>
            </p>
        </div>
    </div>
</main>

<style>
    /* Dodatkowe style dla responsywności pojedynczego widoku */
    @media (max-width: 768px) {
        .movie-single-layout {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .movie-poster-single {
            flex: 0 0 200px;
            width: 200px;
        }
    }
</style>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 100%);
        color: #e0e0e0;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        min-height: 100vh;
    }

    .imdb-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }

    /* Header */
    .imdb-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 3rem;
        padding-bottom: 2rem;
        border-bottom: 2px solid #ffd700;
    }

    .header-content {
        flex: 1;
    }

    .imdb-title {
        font-size: 3rem;
        font-weight: 700;
        color: #ffd700;
        margin-bottom: 0.5rem;
        letter-spacing: 1px;
    }

    .header-subtitle {
        font-size: 1rem;
        color: #b0b0b0;
        font-weight: 300;
    }

    .header-controls {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    /* Buttons */
    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 4px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s ease;
        text-align: center;
    }

    .btn-add {
        background: #ffd700;
        color: #000;
    }

    .btn-add:hover {
        background: #ffed4e;
        transform: translateY(-2px);
    }

    .btn-switch {
        background: #444;
        color: #fff;
    }

    .btn-switch:hover {
        background: #555;
    }

    .btn-primary {
        background: #ffd700;
        color: #000;
        flex: 1;
        min-width: 120px;
    }

    .btn-primary:hover {
        background: #ffed4e;
    }

    .btn-secondary {
        background: #565656;
        color: #fff;
    }

    .btn-secondary:hover {
        background: #707070;
    }

    .btn-danger {
        background: #e74c3c;
        color: #fff;
        padding: 0.75rem 1.25rem;
    }

    .btn-danger:hover {
        background: #c0392b;
    }

    .btn-logout {
        position: fixed;
        top: 1rem;
        right: 1rem;
        background: #565656;
        color: #fff;
        z-index: 100;
    }

    .btn-logout:hover {
        background: #707070;
    }

    /* Filter Section */
    .filter-section {
        margin-bottom: 3rem;
        background: rgba(255, 215, 0, 0.05);
        padding: 2rem;
        border-radius: 8px;
        border: 1px solid #ffd700;
    }

    .filter-form {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
        align-items: flex-end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        flex: 1;
        min-width: 200px;
    }

    .filter-group label {
        font-weight: 600;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        color: #ffd700;
    }

    .filter-group select {
        padding: 0.75rem;
        background: #2a2a2a;
        color: #e0e0e0;
        border: 1px solid #ffd700;
        border-radius: 4px;
        font-size: 0.9rem;
    }

    .filter-group select:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(255, 215, 0, 0.3);
    }

    .btn-search {
        background: #ffd700;
        color: #000;
        align-self: flex-end;
    }

    .btn-search:hover {
        background: #ffed4e;
    }

    /* Movies Grid */
    .movies-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }

    .movie-item {
        background: #1a1a2e;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid #333;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .movie-item:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(255, 215, 0, 0.15);
        border-color: #ffd700;
    }

    .movie-poster {
        width: 100%;
        padding-top: 150%;
        position: relative;
        background: linear-gradient(135deg, #2a2a2a 0%, #333 100%);
        overflow: hidden;
    }

    .poster-placeholder {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        background: linear-gradient(135deg, #2a2a2a 0%, #333 100%);
    }

    .movie-info {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .movie-name {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        color: #ffd700;
        line-height: 1.3;
    }

    .movie-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .meta-badge {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 3px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .category-badge {
        background: #1f4788;
        color: #64b5f6;
    }

    .platform-badge {
        background: #663d00;
        color: #ffb74d;
    }

    .movie-desc {
        color: #b0b0b0;
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 1rem;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .movie-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-top: auto;
    }

    .movie-actions form {
        flex: 1;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    .empty-message {
        font-size: 1.5rem;
        color: #b0b0b0;
        font-weight: 300;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .imdb-title {
            font-size: 2rem;
        }

        .imdb-header {
            flex-direction: column;
            gap: 1.5rem;
        }

        .header-controls {
            width: 100%;
            justify-content: flex-start;
        }

        .filter-form {
            flex-direction: column;
        }

        .filter-group {
            width: 100%;
        }

        .btn-search {
            width: 100%;
        }

        .movies-grid {
            grid-template-columns: 1fr;
        }

        .movie-item {
            flex-direction: row;
        }

        .movie-poster {
            width: 150px;
            min-width: 150px;
            padding-top: 225%;
        }
    }
</style>