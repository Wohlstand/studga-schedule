<?php
require "../config.php";

$IncludeToHead = '
<META NAME="DESCRIPTION" CONTENT="Расписания занятий Московского Государственного Технического Университета Гражданской Авиации">
<META NAME="keywords" CONTENT="Расписание, МГТУ ГА, МГТУГА, преподавателей, расписания МГТУГА, расписания МГТУ ГА, расписание МГТУГА,  расписание МГТУ ГА">
';

$page_title = "Расписания по аудиторям - " . $SiteTitle;
require_once("../../sys/html-header.php");
require_once("../../sys/html-titlebar.php");
require_once("../_menu.php");

require_once("../../sys/db.php");

$post_id = intval(isset($_GET["id"]) ? $_GET["id"] : 0);
$news_q = mysqlold_query("SELECT * FROM news_feed WHERE id=".intval($post_id)." LIMIT 1;");
?>

<div style="width: 100%; text-align: center;">
<?php
$counter = 0;
while (($news_a = mysqlold_fetch_assoc($news_q)) != NULL)
{
    $counter++;
    ?>
        <div id="news-post" style="width: 60%; margin-left: auto; margin-right: auto;">
        <h1><?=$news_a["title"]?></h1>
        <hr style="border: none; height: 1px; background-color: #BBBBBB;">
        <div id="news-post-content" style="text-align: justify;">
            <?=$news_a["content"]?>
        </div>
        <div id="news-footer" style="margin-bottom: 40px; text-align: right;">
            <hr style="border: none; height: 1px; background-color: #BBBBBB;">
            <small>Опубликовано <?=$news_a["date"]?></small>
        </div>
    </div>
    <?php
}
if($counter == 0)
{?>
<h1>Пост не найден!</h1>
<?php
}
?>
</div>

<?php
require_once("../../sys/html-footer.php");
?>
