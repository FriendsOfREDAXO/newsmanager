<form method="post" action="" onsubmit="return post();">
    <input type="hidden" id="reArticleId" value="<?=$article_id?>">
    <textarea id="comment" required placeholder="Ihr Kommentar"></textarea>
    <br>
    <input type="text" id="username" required placeholder="Name">
    <br>
    <input type="email" id="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="E-Mail">
    <br>
    <input type="submit" value="Post Comment">
</form>