<?php
define('ROOT_DIR', dirname(__FILE__) . '/..');
require_once ROOT_DIR . '/init.php';

$repResult = false;

if (isset($_GET['t'])) {
    $repResult = getReplays($_GET['t']);
}

// парсим новости с rbk.ru
parseNews();
$news = getNews();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Тестовое задание</title>
    </head>
    <body>
        <form method="GET" action="/">
            Введите текст: <input type="text" style="width: 200px;" name="t" />
            <input type="submit" value="Отправить" />
        </form>
        <br />
        Результат: <span style="color: #f00;"><?php if($repResult): echo $repResult; endif; ?></span>
        <br /><br />
        
        <?php foreach ($news as $_n): ?>
        <h4><?php echo base64_decode($_n['title']) ?></h4>
        <p>
            <?php echo mb_substr(base64_decode($_n['overview']), 0, 300,'UTF-8'); ?>
            <br >
            <a href="/article.php?id=<?php echo $_n['id']; ?>" >Подробнее</a>
        </p>
        <br />
        <?php endforeach; ?>
    </body>
</html>


