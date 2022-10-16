<article class="news-entry news-list-entry grid">
    <?php if ($this->image != "") : ?>
        <div class="col-12">
            <h2><a href="<?= $this->url ?>"><?= $this->title ?></a></h2>
            <h3><?= $this->subtitle ?></h3>

            <small><?= $this->createdate ?> | <?= $this->author ?></small>
        </div>
        <div class="col-4">
            <?= $this->image ?>
        </div>
        <div class="col-8">
            <?= $this->teasertext ?>
            <a href="<?= $this->url ?>" class="btn">Weiterlesen …</a>
        </div>
    <?php else : ?>
        <div class="col-12">
            <h2><a href="<?= $this->url ?>"><?= $this->title ?></a></h2>
            <h3><?= $this->subtitle ?></h3>

            <small><?= $this->createdate ?> | <?= $this->author ?></small>
            <?= $this->teasertext ?>
            <a href="<?= $this->url ?>" class="btn">Weiterlesen …</a>
        </div>
    <?php endif ?>
</article>
