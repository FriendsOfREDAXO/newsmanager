<header class="col-12">
    <div class="grid">
        <h1><?= $this->title ?></h1>
    </div>
</header>

<article class="news-entry col-md-12 white">
    <div class="col-md-6"><?= $this->image ?></div>
    <h2><?= $this->subtitle ?></h2>
    <?= $this->richtext ?>
</article>

<footer class="col-12">
    <div class="grid meta">
        <span class="createdate"><?= $this->createdate ?></span>
        <span class="divider">|</span>
        <span class="author"><?= $this->author ?></span>
    </div>
</footer>
