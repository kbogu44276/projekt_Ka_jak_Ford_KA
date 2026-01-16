<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($movie->title) ?> - PLUSFLIX</title>
    <style>
        :root {
            --primary: #e50914;
            --bg-dark: #141414;
            --card-bg: #222;
            --text-gray: #aaa;
        }

        body {
            background-color: var(--bg-dark);
            color: white;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            line-height: 1.6;
        }

        /* Sekcja główna z tłem */
        .movie-hero {
            position: relative;
            padding: 100px 8% 60px 8%;
            display: flex;
            gap: 60px;
            background: linear-gradient(to right, rgba(20,20,20,1) 35%, rgba(20,20,20,0.6) 100%),
            url('<?= $movie->image ?>') center/cover;
            background-attachment: fixed;
        }

        .poster-container img {
            width: 320px;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.8);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .details-container {
            max-width: 800px;
        }

        .movie-title {
            font-size: clamp(36px, 5vw, 64px);
            margin: 0 0 10px 0;
            font-weight: 800;
        }

        .meta-row {
            display: flex;
            gap: 20px;
            font-size: 18px;
            color: var(--text-gray);
            margin-bottom: 25px;
            align-items: center;
        }

        .rating-star {
            color: #ffc107;
            font-weight: bold;
            font-size: 22px;
        }

        .description {
            font-size: 19px;
            color: #eee;
            margin-bottom: 40px;
            max-width: 700px;
        }

        /* Sekcja Gdzie Obejrzeć */
        .streaming-section {
            background: rgba(255, 255, 255, 0.05);
            padding: 25px;
            border-radius: 15px;
            display: inline-block;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .streaming-section h3 {
            margin: 0 0 15px 0;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--text-gray);
        }

        .platform-list {
            display: flex;
            gap: 20px;
        }

        .platform-item {
            transition: transform 0.3s ease;
        }

        .platform-item:hover {
            transform: translateY(-5px);
        }

        .platform-logo {
            height: 35px;
            filter: grayscale(20%);
            transition: filter 0.3s;
        }

        .platform-item:hover .platform-logo {
            filter: grayscale(0%);
        }

        /* Sekcja Podobne Filmy */
        .similar-movies {
            padding: 60px 8%;
        }

        .similar-movies h2 {
            font-size: 28px;
            margin-bottom: 30px;
            border-left: 5px solid var(--primary);
            padding-left: 15px;
            text-transform: uppercase;
        }

        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 30px;
        }

        @media (max-width: 900px) {
            .movie-hero { flex-direction: column; align-items: center; text-align: center; padding-top: 60px; }
            .meta-row { justify-content: center; }
            .streaming-section { display: block; }
            .platform-list { justify-content: center; }
        }
    </style>
</head>
<body>

<?php include BASE_DIR . 'app/views/layout/navbar.php'; ?>

<main>
    <section class="movie-hero">
        <div class="poster-container">
            <img src="<?= $movie->image ?>" alt="<?= htmlspecialchars($movie->title) ?>">
        </div>

        <div class="details-container">
            <div class="meta-row">
                <span class="rating-star">★ <?= $movie->rating ?></span>
                <span>2024</span>
                <span>Napisy PL</span>
            </div>

            <h1 class="movie-title"><?= htmlspecialchars($movie->title) ?></h1>

            <p class="description">
                <?= htmlspecialchars($movie->description ?? '') ?>
            </p>

            <div class="streaming-section">
                <h3>Dostępne na:</h3>
                <div class="platform-list">
                    <a href="https://www.netflix.com" target="_blank" class="platform-item" title="Netflix">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/0/08/Netflix_2015_logo.svg" alt="Netflix" class="platform-logo">
                    </a>
                    <a href="https://www.hbomax.com" target="_blank" class="platform-item" title="HBO Max">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/1/17/HBO_Max_Logo.svg" alt="HBO Max" class="platform-logo">
                    </a>
                    <a href="https://www.disneyplus.com" target="_blank" class="platform-item" title="Disney+">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/3/3e/Disney_Plus_logo.svg" alt="Disney+" class="platform-logo">
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="similar-movies">
        <h2>Podobne filmy</h2>
        <div class="movie-grid">
            <?php foreach ($similarMovies as $movie): ?>
                <?php include BASE_DIR . 'app/views/layout/movie_card.php'; ?>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<footer style="text-align: center; padding: 50px; color: #444; border-top: 1px solid #222;">
    <p>&copy; 2026 PLUSFLIX - Projekt Zaliczeniowy</p>
</footer>

</body>
</html>