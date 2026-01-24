<?php /** @var string|null $q */ ?>

<form class="search-bar js-search" data-suggest-url="index.php?action=movie-suggest"
      autocomplete="off"
      data-suggest-url="index.php?action=movie-suggest">

    <input type="hidden" name="action" value="movie-search">

    <div class="search-row">
        <input
            type="text"
            name="q"
            class="search-input"
            placeholder="Search movies..."
            value="<?= htmlspecialchars($q ?? '') ?>"
            autocomplete="off"
        >

        <button type="submit" class="search-submit" aria-label="Search">
            🔍
        </button>
    </div>

    <div class="search-dropdown" hidden></div>
</form>
