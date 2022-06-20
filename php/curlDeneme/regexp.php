<?php

include_once('classes/curl.php');

$url = "https://en.wikipedia.org/wiki/Category:Western_(genre)_films";

$page = new Curl($url);

$html = $page->getResult();

//remove delete all empty spaces and new lines
$cleanHtml = preg_replace("/^\s+|\n|\r|\s+$/m", "", $html);

preg_match_all('/<div.class="mw-category-group">.*?<\/div>/', $cleanHtml, $subCategories);

print_r($subCategories);

$titles = [];
foreach ($subCategories[0] as $subCategory) {
    preg_match_all('/<a.*?>(.*?)<\/a>/', $subCategory, $title);

    // print_r($title);
    // die();

    $titles[] = $title[1][0];
}

print_r($titles);
