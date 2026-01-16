<style>
    /* Style wspólne dla Navbaru */
    .navbar {
        background: rgba(0, 0, 0, 0.95);
        padding: 15px 5%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 1000;
        backdrop-filter: blur(10px);
        border-bottom: 1px solid #222;
    }

    .brand {
        color: #e50914;
        font-size: 28px;
        font-weight: 900;
        text-decoration: none;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .nav-links {
        display: flex;
        align-items: center;
        gap: 25px;
    }

    .nav-links a {
        color: #ffffff;
        text-decoration: none;
        font-size: 24px;
        transition: transform 0.3s ease, color 0.3s ease;
    }

    .nav-links a:hover {
        transform: scale(1.2);
        color: #e50914;
    }

    .admin-link {
        font-size: 14px !important;
        color: #a3a3a3 !important;
        border: 1px solid #444;
        padding: 5px 12px;
        border-radius: 4px;
        text-transform: uppercase;
        font-family: sans-serif;
    }
</style>

<nav class="navbar">
    <a href="index.php" class="brand">PLUSFLIX</a>
    <div class="nav-links">
        <a href="index.php?controller=movie&action=search" title="Szukaj">🔍</a>
        <a href="index.php?controller=movie&action=favorites" title="Ulubione">❤️</a>
        <a href="index.php?controller=movie&action=random" title="Losuj film">🎲</a>
        <a href="index.php?controller=admin&action=panel" class="admin-link">Admin</a>
    </div>
</nav>