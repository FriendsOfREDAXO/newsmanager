<article class="news-entry news-list-entry grid">
    <?php if ($image != "") : ?>
    <div class="col-12">
        <h2><a href="<?=$url?>"><?=$title?></a></h2>
                <h3><?=$subtitle?></h3>

        <small><?=$createdate?> | <?=$author?></small>
    </div>
    <div class="col-4">
        <?=$image?>
    </div>
    <div class="col-8">
        <?=$teasertext?>
        <a href="<?=$url?>" class="btn">Weiterlesen …</a>
    </div>
    <?php else : ?>
        <div class="col-12">
            <h2><a href="<?=$url?>"><?=$title?></a></h2>
                    <h3><?=$subtitle?></h3>

            <small><?=$createdate?> | <?=$author?></small>
            <?=$teasertext?>
            <a href="<?=$url?>" class="btn">Weiterlesen …</a>
        </div>
    <?php endif ?> 
</article>
