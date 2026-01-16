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

<div class="movie-card">
    <div class="rating-badge">★ <?= $movie->rating ?></div>
    <img src="<?= $movie->image ?>" alt="<?= htmlspecialchars($movie->title) ?>" loading="lazy">
    <div class="movie-info">
        <h3 class="movie-title"><?= htmlspecialchars($movie->title) ?></h3>
    </div>
</div>