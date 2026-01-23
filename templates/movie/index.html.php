<?php if(!empty($_SESSION['is_admin'])): ?>
    <a href="/logout.php" class="btn btn-logout">Wyloguj</a>
<?php endif; ?>

<?php
$favRaw = $_COOKIE['favorites'] ?? '[]';
$favArr = json_decode($favRaw, true);
if (!is_array($favArr)) $favArr = [];
$favArr = array_map('intval', $favArr);
?>


<main class="imdb-container">
    <div class="imdb-header">
        <div class="header-content">
            <h1 class="imdb-title">Movies</h1>
            <p class="header-subtitle">Explore our collection of films</p>
        </div>
        <div class="header-controls">
            <?php if($viewType === 'admin'): ?>
                <a href="/index.php?action=movie-create" class="btn btn-add"> Add Movie</a>
                <a href="/index.php?action=movie-index&view=user" class="btn btn-switch">User View</a>
            <?php else: ?>
                <a href="/index.php?action=movie-index&view=admin" class="btn btn-switch">Admin View</a>
            <?php endif; ?>

            <?php if($viewType === 'user'): ?>
                <a href="index.php?action=movie-random&view=user" class="btn btn-random">Random Movie</a>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($viewType === 'user'): ?>
        <div class="search-section">
            <?php
            $q = $_GET['q'] ?? '';
            require __DIR__ . '/searchBar.html.php';
            ?>
        </div>
    <?php endif; ?>

    <?php if($viewType === 'user'): ?>
        <div class="filter-section">
            <form method="get" class="filter-form">
                <input type="hidden" name="action" value="movie-index">
                <input type="hidden" name="view" value="user">

                <div class="filter-group">
                    <label for="platform-filter">Platform</label>
                    <select name="platform" id="platform-filter">
                        <option value="">All Platforms</option>
                        <?php foreach(\App\Model\Movie::getAvailablePlatforms() as $platform): ?>
                            <option value="<?= htmlspecialchars($platform) ?>" <?= ($_GET['platform'] ?? '') === $platform ? 'selected' : '' ?>>
                                <?= htmlspecialchars($platform) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="category-filter">Category</label>
                    <select name="category" id="category-filter">
                        <option value="">All Categories</option>
                        <?php
                        $categories = array_unique(array_map(fn($m) => $m->getCategory(), $movies));
                        foreach($categories as $category): ?>
                            <option value="<?= htmlspecialchars($category) ?>" <?= ($_GET['category'] ?? '') === $category ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-search">Search</button>
            </form>
        </div>
    <?php endif; ?>

    <?php if (empty($movies)): ?>
        <div class="empty-state">
            <p class="empty-icon">🎬</p>
            <p class="empty-message">No movies found</p>
        </div>
    <?php else: ?>
        <div class="movies-grid">
            <?php foreach ($movies as $movie): ?>
                <div class="movie-item">
                    <div class="movie-poster">
                        <div class="poster-placeholder">
                            🎬
                        </div>
                    </div>

                    <div class="movie-info">
                        <?php $isFav = in_array((int)$movie->getId(), $favArr, true); ?>
                        <h3 class="movie-name">
                            <?= htmlspecialchars($movie->getTitle()) ?>
                            <span title="<?= $isFav ? 'Ulubione' : 'Nieulubione' ?>" style="margin-left:.4rem; color:#ffd700;">
                                <?= $isFav ? '♥' : '♡' ?>
                            </span>
                        </h3>


                        <div class="movie-meta">
                            <?php if ($movie->getCategory()): ?>
                                <span class="meta-badge category-badge"><?= htmlspecialchars($movie->getCategory()) ?></span>
                            <?php endif; ?>
                            <?php if ($movie->getPlatform()): ?>
                                <span class="meta-badge platform-badge"><?= htmlspecialchars($movie->getPlatform()) ?></span>
                            <?php endif; ?>
                        </div>

                        <p class="movie-desc"><?= htmlspecialchars($movie->getDescription()) ?></p>

                        <div class="movie-actions">
                            <a class="btn btn-primary" href="/index.php?action=movie-show&id=<?= $movie->getId() ?>">
                                View Details
                            </a>

                            <?php if($viewType === 'admin'): ?>
                                <a class="btn btn-secondary" href="/index.php?action=movie-edit&id=<?= $movie->getId() ?>">
                                    Edit
                                </a>
                                <form method="post" action="/index.php?action=movie-delete&id=<?= $movie->getId() ?>" onsubmit="return confirm('Are you sure you want to delete this movie?');" style="display:inline;">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            <?php endif; ?>
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

    .btn-add, .btn-random {
        background: #ffd700;
        color: #000;
    }

    .btn-add:hover, .btn-random:hover {
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

    .btn-search {
        background: #ffd700;
        color: #000;
        align-self: flex-end;
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
        padding-top: 75%; /* ZMNIEJSZONE ZDJĘCIE (było 150%) */
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
    }

    /* Responsive */
    @media (max-width: 768px) {
        .imdb-title { font-size: 2rem; }
        .imdb-header { flex-direction: column; gap: 1.5rem; }
        .header-controls { width: 100%; justify-content: flex-start; }
        .movies-grid { grid-template-columns: 1fr; }
        .movie-item { flex-direction: row; }
        .movie-poster {
            width: 120px;
            min-width: 120px;
            padding-top: 120px;
        }
    }

    /* === SEARCH BAR (IMDb style) === */

    .search-section {
        margin: 2rem 0 3rem 0;
    }

    /* form */
    .search-bar {
        position: relative;
        max-width: 100%;
    }

    /* input */
    .search-input {
        width: 100%;
        padding: 1rem 3.5rem 1rem 1.25rem;
        font-size: 1rem;
        border-radius: 6px;
        background: #1a1a2e;
        color: #e0e0e0;
        border: 2px solid #ffd700;
        outline: none;
        transition: all 0.25s ease;
    }

    .search-input::placeholder {
        color: #b0b0b0;
    }

    .search-input:focus {
        box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.25);
    }

    /* lupa */
    .search-submit {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        background: #ffd700;
        border: none;
        color: #000;
        width: 38px;
        height: 38px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1rem;
        font-weight: bold;
    }

    .search-submit:hover {
        background: #ffed4e;
    }

    /* dropdown */
    .search-dropdown {
        position: absolute;
        top: calc(100% + 6px);
        left: 0;
        right: 0;
        background: #1a1a2e;
        border: 1px solid #ffd700;
        border-radius: 6px;
        overflow: hidden;
        z-index: 20;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.5);
    }

    /* item */
    .search-dropdown-item {
        padding: 0.75rem 1.25rem;
        cursor: pointer;
        color: #e0e0e0;
        border-bottom: 1px solid #333;
    }

    .search-dropdown-item:last-child {
        border-bottom: none;
    }

    .search-dropdown-item:hover {
        background: rgba(255, 215, 0, 0.12);
        color: #ffd700;
    }
</style>