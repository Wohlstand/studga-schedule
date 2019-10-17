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
require_once("../../sys/msg-counter.php");

$news_q = mysqlold_query("SELECT * FROM news_feed ORDER BY date DESC LIMIT 10;");

$q_count = mysqlold_query("SELECT count(*) AS count FROM news_feed;");
$totalmsgs_arr = mysqlold_fetch_assoc($q_count);
$totalmsgs = $totalmsgs_arr["count"];

?>

<h1>Новостная лента</h1>

<div style="width: 100%; text-align: center;">
<?php messageCounter($totalmsgs, ceil($totalmsgs/10), $pagecount); ?>

<?php
$counter = 0;
while (($news_a = mysqlold_fetch_assoc($news_q)) != NULL)
{
    $counter++;
    ?>
        <div id="news-post" style="width: 60%; margin-left: auto; margin-right: auto;">
        <h2><?=$news_a["title"]?></h2>
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
Новостей нет
<?php
}
?>

<?php messageCounter($totalmsgs, ceil($totalmsgs/10), $pagecount); ?>

</div>

<?php
require_once("../../sys/html-footer.php");
