<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLUSFLIX - Twoje centrum filmowe</title>
    <style>
        /* Główne zmienne i tło strony */
        :root {
            --primary: #e50914;
            --bg-dark: #141414;
            --text-light: #ffffff;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-light);
            font-family: 'Segoe UI', Roboto, Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Sekcja Hero (Wyszukiwarka na środku) */
        .hero {
            min-height: 450px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: linear-gradient(rgba(20,20,20,0.6), rgba(20,20,20,1)),
            url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            text-align: center;
            padding: 40px 20px;
        }

        .hero h1 {
            font-size: clamp(32px, 6vw, 56px);
            margin-bottom: 30px;
            font-weight: 800;
        }

        .search-container {
            width: 100%;
            max-width: 650px;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 18px 30px;
            border-radius: 50px;
            border: 2px solid #555;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            font-size: 20px;
            outline: none;
            transition: 0.3s;
        }

        .search-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 20px rgba(229, 9, 20, 0.4);
        }

        .search-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--primary);
            border: none;
            color: white;
            padding: 10px 25px;
            border-radius: 40px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
        }

        /* Układ sekcji z filmami */
        .main-content {
            padding: 20px 5% 60px 5%;
        }

        .movie-section {
            margin-bottom: 60px;
        }

        .section-header {
            margin-bottom: 25px;
            border-left: 5px solid var(--primary);
            padding-left: 15px;
        }

        .section-header h2 {
            margin: 0;
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        /* Siatka (Grid) - musi być tutaj, bo movie_card to tylko pojedynczy kafelek */
        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 30px;
        }

        @media (max-width: 768px) {
            .movie-grid {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 15px;
            }
        }
    </style>
</head>
<body>

<?php include BASE_DIR . 'app/views/layout/navbar.php'; ?>

<header class="hero">
    <h1>Znajdź swój ulubiony film</h1>
    <div class="search-container">
        <form action="index.php" method="GET">
            <input type="hidden" name="controller" value="movie">
            <input type="hidden" name="action" value="list">
            <input type="text" name="query" class="search-input" placeholder="Wpisz tytuł..." value="<?= htmlspecialchars($_GET['query'] ?? '') ?>">
            <button type="submit" class="search-btn">SZUKAJ</button>
        </form>
    </div>
</header>

<main class="main-content">

    <section class="movie-section">
        <div class="section-header">
            <h2>Najwyżej oceniane</h2>
        </div>
        <div class="movie-grid">
            <?php if (empty($topRated)): ?>
                <p>Brak filmów do wyświetlenia.</p>
            <?php else: ?>
                <?php foreach ($topRated as $movie): ?>
                    <?php include BASE_DIR . 'app/views/layout/movie_card.php'; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <section class="movie-section">
        <div class="section-header">
            <h2>Polecane dla Ciebie</h2>
        </div>
        <div class="movie-grid">
            <?php if (empty($recommended)): ?>
                <p>Brak polecanych filmów.</p>
            <?php else: ?>
                <?php foreach ($recommended as $movie): ?>
                    <?php include BASE_DIR . 'app/views/layout/movie_card.php'; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

</main>

<footer style="text-align: center; padding: 40px; color: #555; border-top: 1px solid #222;">
    <p>&copy; 2026 PLUSFLIX - Projekt Zaliczeniowy</p>
</footer>

</body>
</html>