<div class="comment comment-<?=$id?>">
    <p>
        <span class="comment"><?=$comment?></span><br>
        <strong><span id="name"><?= rex_i18n::msg('comment_view_from')?> <?=$name?>, <?=date('d.m.Y', strtotime($createdate))?> <?= rex_i18n::msg('comment_view_around')?> <?=date('H:i', strtotime($createdate))?> <?= rex_i18n::msg('comment_view_clock')?></span></strong><br>
    </p>
</div>