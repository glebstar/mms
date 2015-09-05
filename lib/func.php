<?php

require_once ROOT_DIR . '/lib/Db.php';

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

function getHtmlCurl($url) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko) Chrome/8.0.552.224 Safari/534.10');
    $html = curl_exec($curl);
    curl_close($curl);
    
    return $html;
}

function parseNews() {
    Db::deleteFromTable('article');
    
    $max = 10;
    $i = 0;
    
    $html = getHtmlCurl('http://www.rbc.ru/');
    
    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->loadHTML($html);
    $xpath = new DOMXPath($dom);
    
    
    $rows = $xpath->query("//a[contains(@class, 'news-main-feed__item')]");
    
    foreach ($rows as $_r) {
        $data = array();

        $q = $xpath->query('.//span[@class="news-main-feed__item__title"]', $_r);
        $data['title'] = base64_encode(trim($q->item(0)->nodeValue));
        
        $html2 = getHtmlCurl($_r->getAttribute('href'));
        $dom2 = new DOMDocument();
        $dom2->loadHTML($html2);
        $xpath2 = new DOMXPath($dom2);
        
        $q = $xpath2->query('//div[@class="article__overview__text"]');       
        $data['overview'] = base64_encode(trim($q->item(0)->nodeValue));
        
        $data['image'] = '';
        $q = $xpath2->query('//img[@class="article__main-image__image"]');
        if ($q->length > 0) {
            $data['image'] = $q->item(0)->getAttribute('src');
        }
        
        $q = $xpath2->query('//div[@class="article__text"]');
        $data['text'] = base64_encode(trim($q->item(0)->nodeValue));
        
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