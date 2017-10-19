<article id="" class="news-entry news-list-entry grid">
    <?php if ($image != "") : ?>
    <div class="col-12">
        <h2><a href="<?=$url?>"><?=$title?></a></h2>
        <small><?=$createdate?> | <?=$author?></small>
    </div>
    <div class="col-4">
        <?=$image?>
    </div>
    <div class="col-8">
        <?=$teasertext?>
    </div>
    <?php else : ?>
        <div class="col-12">
            <h2><a href="<?=$url?>"><?=$title?></a></h2>
            <small><?=$createdate?> | <?=$author?></small>
            <?=$teasertext?>
        </div>
    <?php endif ?> 
</article>