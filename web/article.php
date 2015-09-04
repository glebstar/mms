<?php
define('ROOT_DIR', dirname(__FILE__) . '/..');
require_once ROOT_DIR . '/init.php';

if (!isset($_GET['id'])) {
    echo 'error'; exit;
}

$article = getArticle($_GET['id']);
if (!$article) {
    echo 'error'; exit;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title>Тестовое задание - article</title>
    </head>
    <body>
        <a href="/">На главную страницу</a>
        <h1><?php echo base64_decode($article['title']); ?></h1>
        <p><?php echo base64_decode($article['overview']); ?></p>
        <?php if($article['image']): ?>
        <img src="<?php echo $article['image']; ?>" />
        <?php endif; ?>
        <p><?php echo base64_decode($article['text']); ?></p>
    </body>
</html>
