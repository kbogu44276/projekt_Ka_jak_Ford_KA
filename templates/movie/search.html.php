<?php /** @var string $q */ ?>
<?php /** @var array $movies */ ?>

<main class="imdb-container">
    <div class="imdb-header">
        <div class="header-content">
            <h1 class="imdb-title">Search</h1>
            <p class="header-subtitle">
                <?= $q !== '' ? 'Results for: ' . htmlspecialchars($q) : 'Type something to search movies' ?>
            </p>
        </div>

        <div class="header-controls">
            <a href="/index.php?action=movie-index&view=user" class="btn btn-switch">⬅ Back to Home</a>
        </div>
    </div>

    <div class="search-section">
        <?php
        $q = $q ?? '';
        require __DIR__ . '/searchBar.html.php';
        ?>
    </div>

    <?php if (($q ?? '') === ''): ?>
        <div class="empty-state">
            <p class="empty-icon">🔎</p>
            <p class="empty-message">Start typing a movie title.</p>
        </div>
    <?php elseif (empty($movies)): ?>
        <div class="empty-state">
            <p class="empty-icon">🎬</p>
            <p class="empty-message">No movies found</p>
        </div>
    <?php else: ?>
        <div class="movies-grid">
            <?php foreach ($movies as $movie): ?>
                <div class="movie-item">
                    <div class="movie-poster">
                        <div class="poster-placeholder">🎬</div>
                    </div>

                    <div class="movie-info">
                        <h3 class="movie-name"><?= htmlspecialchars($movie->getTitle() ?? '') ?></h3>

                        <div class="movie-meta">
                            <?php if ($movie->getCategory()): ?>
                                <span class="meta-badge category-badge"><?= htmlspecialchars($movie->getCategory()) ?></span>
                            <?php endif; ?>
                            <?php if ($movie->getPlatform()): ?>
                                <span class="meta-badge platform-badge"><?= htmlspecialchars($movie->getPlatform()) ?></span>
                            <?php endif; ?>
                        </div>

                        <p class="movie-desc"><?= htmlspecialchars($movie->getDescription() ?? '') ?></p>

                        <div class="movie-actions">
                            <a class="btn btn-primary" href="/index.php?action=movie-show&id=<?= (int)$movie->getId() ?>">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

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
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 2px solid #ffd700;
        gap: 1.5rem;
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

    /* Search section */
    .search-section {
        margin: 0 0 2.5rem 0;
    }

    /* Search bar (matches homepage style) */
    .search-bar {
        width: 100%;
        position: relative;
    }

    .search-row {
        display: flex;
        width: 100%;
    }

    .search-input {
        flex: 1;
        padding: 1rem 1.25rem;
        font-size: 1rem;
        background: #1a1a2e;
        color: #e0e0e0;
        border: 2px solid #ffd700;
        border-right: none;
        border-radius: 6px 0 0 6px;
        outline: none;
    }

    .search-input::placeholder {
        color: #b0b0b0;
    }

    .search-input:focus {
        box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.25);
    }

    .search-submit {
        width: 64px;
        font-size: 1.1rem;
        background: #ffd700;
        color: #000;
        border: 2px solid #ffd700;
        border-radius: 0 6px 6px 0;
        cursor: pointer;
        transition: background 0.25s ease;
    }

    .search-submit:hover {
        background: #ffed4e;
    }

    .search-dropdown {
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        right: 0;
        background: #1a1a2e;
        border: 1px solid #ffd700;
        border-radius: 6px;
        z-index: 50;
        overflow: hidden;
        box-shadow: 0 12px 24px rgba(0,0,0,0.5);
    }

    .search-dropdown-item {
        padding: 0.75rem 1.25rem;
        cursor: pointer;
        color: #e0e0e0;
        border-bottom: 1px solid #333;
    }

    .search-dropdown-item:last-child {
        border-bottom: none;
    }

    .search-dropdown-item:hover,
    .search-dropdown-item.active {
        background: rgba(255, 215, 0, 0.15);
        color: #ffd700;
    }

    /* Movies Grid */
    .movies-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
        margin-top: 0.5rem;
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
        padding-top: 75%;
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
        font-size: 2.5rem;
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

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        border: 1px solid #333;
        border-radius: 8px;
        background: rgba(255, 215, 0, 0.05);
    }

    .empty-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }

    .empty-message {
        color: #b0b0b0;
        font-size: 1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .imdb-title { font-size: 2rem; }
        .imdb-header { flex-direction: column; }
        .header-controls { width: 100%; justify-content: flex-start; }

        .movies-grid { grid-template-columns: 1fr; }
        .movie-item { flex-direction: row; }
        .movie-poster {
            width: 120px;
            min-width: 120px;
            padding-top: 120px;
        }
    }
</style>
