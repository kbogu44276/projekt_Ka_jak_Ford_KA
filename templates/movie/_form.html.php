<?php
/** @var $movie ?\App\Model\Movie */
?>

<div class="form-group">
    <label>Title</label>
    <input type="text" name="movie[title]" value="<?= $movie ? $movie->getTitle() : '' ?>" required>
</div>

<div class="form-group">
    <label>Platform</label>
    <select name="movie[platform]">
        <option value="">-- Select Platform --</option>
        <option value="Netflix" <?= $movie && $movie->getPlatform() === 'Netflix' ? 'selected' : '' ?>>Netflix</option>
        <option value="HBO" <?= $movie && $movie->getPlatform() === 'HBO' ? 'selected' : '' ?>>HBO</option>
        <option value="Disney+" <?= $movie && $movie->getPlatform() === 'Disney+' ? 'selected' : '' ?>>Disney+</option>
        <option value="Prime Video" <?= $movie && $movie->getPlatform() === 'Prime Video' ? 'selected' : '' ?>>Prime Video</option>
        <option value="Apple TV+" <?= $movie && $movie->getPlatform() === 'Apple TV+' ? 'selected' : '' ?>>Apple TV+</option>
    </select>
</div>

<div class="form-group">
    <label>Description</label>
    <textarea name="movie[description]" rows="10" required><?= $movie ? $movie->getDescription() : '' ?></textarea>
</div>