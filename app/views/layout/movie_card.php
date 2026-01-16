<style>
    /* Style dla karty filmu - komponent wielokrotnego użytku */
    .movie-card {
        background: #222;
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.3s ease;
        position: relative;
        cursor: pointer;
        box-shadow: 0 10px 20px rgba(0,0,0,0.4);
        display: flex;
        flex-direction: column;
    }

    .movie-card:hover {
        transform: scale(1.05);
        box-shadow: 0 15px 30px rgba(229, 9, 20, 0.3); /* Czerwona poświata przy najechaniu */
        z-index: 5;
    }

    .movie-card img {
        width: 100%;
        height: 330px;
        object-fit: cover;
        display: block;
    }

    .movie-info {
        padding: 15px;
        background: #222;
    }

    .movie-title {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
        color: #fff;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis; /* Skracanie zbyt długich tytułów */
    }

    .rating-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 215, 0, 0.9);
        color: black;
        padding: 4px 10px;
        border-radius: 6px;
        font-weight: 800;
        font-size: 14px;
        z-index: 2;
    }
</style>

<div class="movie-card" onclick="window.location.href='index.php?controller=movie&action=show&id=<?= $movie->id ?>'"
     style="cursor: pointer; background: #222; border-radius: 8px; overflow: hidden; position: relative;">
    <div style="position: absolute; top: 10px; right: 10px; background: gold; color: black; padding: 2px 8px; border-radius: 4px; font-weight: bold; font-size: 12px;">
        ★ <?= $movie->rating ?>
    </div>
    <img src="<?= $movie->image ?>" alt="Poster" style="width: 100%; height: 280px; object-fit: cover;">
    <div style="padding: 10px;">
        <h3 style="margin: 0; font-size: 15px; color: white; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
            <?= htmlspecialchars($movie->title) ?>
        </h3>
    </div>
</div>