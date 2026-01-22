<?php if(!empty($_SESSION['is_admin'])): ?>
    <a href="/logout.php" class="btn btn-logout">Wyloguj</a>
<?php endif; ?>

<?php /** @var \App\Model\Movie $movie */ ?>

<?php
$movieId = (int)$movie->getId();

// globalna ocena filmu
$avg = $movie->getAverageRating();     // null albo float
$count = $movie->getRatingCount();     // int

// moja ocena z cookie
$myCookieName = 'rated_movie_' . $movieId;
$myRating = isset($_COOKIE[$myCookieName]) ? (int)$_COOKIE[$myCookieName] : 0;
if ($myRating < 0 || $myRating > 5) $myRating = 0;

// ulubione z cookie
$favRaw = $_COOKIE['favorites'] ?? '[]';
$favArr = json_decode($favRaw, true);
if (!is_array($favArr)) $favArr = [];
$favArr = array_map('intval', $favArr);

$isFav = in_array($movieId, $favArr, true);
$favIcon = $isFav ? '♥' : '♡';
?>

<main class="imdb-container">
    <div class="imdb-header">
        <div class="header-content">
            <h1 class="imdb-title"><?= htmlspecialchars($movie->getTitle()) ?></h1>
            <p class="header-subtitle">Szczegóły wybranego filmu</p>
        </div>
        <div class="header-controls">
            <a href="/index.php?action=movie-index" class="btn btn-switch">Powrót do listy</a>
            <?php if(!empty($_SESSION['is_admin'])): ?>
                <a href="/index.php?action=movie-edit&id=<?= $movieId ?>" class="btn btn-secondary">Edytuj</a>
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

            <!-- META -->
            <div class="movie-meta" style="margin-bottom: 1.5rem;">
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

            <!-- OCENA (globalna) + OCENIANIE + ULUBIONE -->
            <div class="rating-fav-bar">

                <div class="rating-left">
                    <div class="rating-header">
                        <div class="rating-title">Oceń film</div>

                        <div class="rating-global">
                            <?php if ($avg === null): ?>
                                <span class="rating-global-empty">Brak ocen</span>
                            <?php else: ?>
                                <span class="rating-global-score"><?= number_format($avg, 1) ?>/5</span>
                                <span class="rating-global-count">(<?= (int)$count ?> głosów)</span>
                            <?php endif; ?>

                            <?php if ($myRating > 0): ?>
                                <span class="rating-my">• Twoja: <?= (int)$myRating ?>/5</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- GWIAZDKI 1–5 (hover od lewej) -->
                    <form class="star-rating"
                          method="post"
                          action="/index.php?action=movie-rate&id=<?= $movieId ?>">
                        <input type="hidden" name="return" value="/index.php?action=movie-show&id=<?= $movieId ?>">

                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <input type="radio"
                                   id="star<?= $i ?>-m<?= $movieId ?>"
                                   name="rating"
                                   value="<?= $i ?>"
                                    <?= ($myRating === $i ? 'checked' : '') ?>>

                            <label for="star<?= $i ?>-m<?= $movieId ?>" title="<?= $i ?> / 5">★</label>
                        <?php endfor; ?>
                    </form>
                </div>

                <!-- ULUBIONE -->
                <form method="post"
                      action="/index.php?action=movie-favorite-toggle&id=<?= $movieId ?>"
                      class="fav-form">
                    <input type="hidden" name="return" value="/index.php?action=movie-show&id=<?= $movieId ?>">
                    <button type="submit" class="fav-btn"
                            title="<?= $isFav ? 'Usuń z ulubionych' : 'Dodaj do ulubionych' ?>">
                        <?= $favIcon ?>
                    </button>
                </form>
            </div>

            <!-- OPIS -->
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
    /* Responsywność pojedynczego widoku */
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
        .rating-fav-bar{
            text-align:left;
        }
    }
</style>

<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

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

    .imdb-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 3rem;
        padding-bottom: 2rem;
        border-bottom: 2px solid #ffd700;
    }

    .header-content { flex: 1; }

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

    .btn-switch { background: #444; color: #fff; }
    .btn-switch:hover { background: #555; }

    .btn-secondary { background: #565656; color: #fff; }
    .btn-secondary:hover { background: #707070; }

    .btn-logout {
        position: fixed;
        top: 1rem;
        right: 1rem;
        background: #565656;
        color: #fff;
        z-index: 100;
    }
    .btn-logout:hover { background: #707070; }

    .movie-poster {
        width: 100%;
        position: relative;
        background: linear-gradient(135deg, #2a2a2a 0%, #333 100%);
        overflow: hidden;
    }

    .poster-placeholder {
        position: absolute;
        top: 0; left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #2a2a2a 0%, #333 100%);
    }

    .meta-badge {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 3px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .category-badge { background: #1f4788; color: #64b5f6; }
    .platform-badge { background: #663d00; color: #ffb74d; }

    /* PANEL */
    .rating-fav-bar{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:1rem;
        margin: 1rem 0 1.75rem;
        padding: 1rem 1.25rem;
        border: 1px solid #333;
        border-radius: 12px;
        background: rgba(0,0,0,0.20);
    }

    .rating-left{
        flex: 1;
        min-width: 200px;
    }

    .rating-title{
        font-weight:700;
        color:#e0e0e0;
        font-size: 1.05rem;
    }

    .rating-header{
        display:flex;
        align-items:flex-end;
        justify-content:space-between;
        gap: 1rem;
        margin-bottom: .4rem;
    }

    .rating-global{
        font-size: .95rem;
        color: #b0b0b0;
        display:flex;
        align-items:center;
        gap: .5rem;
        flex-wrap: wrap;
        justify-content:flex-end;
    }

    .rating-global-score{ color:#ffd700; font-weight:800; }
    .rating-global-empty{ color:#b0b0b0; font-style: italic; }
    .rating-my{ color:#e0e0e0; }

    /* GWIAZDKI */
    .star-rating{
        display:inline-flex;
        flex-direction: row-reverse; /* hover "w lewo" */
        font-size: 2.2rem;
        line-height: 1;
        gap: .25rem;
    }
    .star-rating input{ display:none; }

    .star-rating label{
        color:#777;
        cursor:pointer;
        transition: color .18s ease, transform .18s ease;
        user-select:none;
    }

    .star-rating label:hover,
    .star-rating label:hover ~ label{
        color:#ffd700;
        transform: translateY(-1px);
    }

    .star-rating input:checked ~ label{
        color:#ffd700;
    }

    /* ULUBIONE */
    .fav-form{ margin:0; }

    .fav-btn{
        width: 46px;
        height: 46px;
        border-radius: 999px;
        border: 1px solid #333;
        background: rgba(255,255,255,0.04);
        color: #ffd700;
        font-size: 1.7rem;
        cursor: pointer;
        display:flex;
        align-items:center;
        justify-content:center;
        transition: transform .15s ease, background .15s ease, border-color .15s ease;
    }

    .fav-btn:hover{
        transform: scale(1.05);
        background: rgba(255,215,0,0.10);
        border-color: #ffd700;
    }
</style>
