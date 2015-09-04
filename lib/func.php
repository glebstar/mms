<?php

require_once ROOT_DIR . '/lib/Db.php';
require_once ROOT_DIR . '/lib/simple_html_dom.php';

function getReplays($s) {
    $res = '';   
    while (strlen($s) > 0) {
        $_c = mb_substr($s, 0, 1,'UTF-8');      
        $newS = str_replace($_c, '', $s);       
        if ( (strlen($s)-  strlen($newS)) > 1 ) {
            $res .= $_c . ' ';
        }      
        $s = $newS;
    }
    
    return $res;
}

function parseNews() {
    // очистить таблицу
    Db::deleteFromTable('article');
    
    $data = array();
    
    $max = 10;
    $i = 0;
    
    $html = file_get_html('http://www.rbc.ru/');
    
    foreach ($html->find('.news-main-feed__item') as $a) {
        $data['title'] = base64_encode($a->find('.news-main-feed__item__title', 0)->innertext);
        $articleHtml = file_get_html( $a->attr['href'] );
        
        if (!$articleHtml->find('.article__overview__text')) {
            continue;;
        }
        
        $data['overview'] = base64_encode($articleHtml->find('.article__overview__text', 0)->innertext);
        
        $data['image'] = '';
        if ( $articleHtml->find('.article__main-image__image') ) {
            $data['image'] = $articleHtml->find('.article__main-image__image', 0)->attr['src'];
        }
        
        $data['text'] = base64_encode($articleHtml->find('.article__text', 0)->innertext);
        
        Db::insertArray('article', $data);
        
        $i++;
        if ($i == $max) {
            break;
        }
    }
}

function getNews() {
    $sql = "SELECT id, title, overview FROM article LIMIT 10";
    
    return Db::getAll($sql);
}

function getArticle($id) {
    $sql = "SELECT * FROM article WHERE id=?";
    return Db::getRow($sql, array($id));
}