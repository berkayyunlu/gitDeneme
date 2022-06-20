<?php

include_once('classes/curl.php');

$url = "https://www.metacritic.com/browse/movies/release-date/theaters/date";

$page = new Curl($url);

$html = $page->getResult();

//remove delete all empty spaces and new lines
$cleanHtml = preg_replace("/^\s+|\n|\r|\s+$/m", "", $html);
//print_r($cleanHtml);


preg_match_all('/<table.class="clamp-list">.*?<\/table>/', $cleanHtml, $subCategories);
//print_r($subCategories[0]);
//die();


$movies = [];
foreach ($subCategories[0] as $subCategory) {
    preg_match_all('/<h3>(.*?)<\/h3><\/a><.*?><span>(.*?)<\/span><span.*?<\/span><\/div><div.*?>(.*?)<\/div>/', $subCategory, $movie);


    //$y = count($movie);



    for ($i = 0; $i < count($movie[1]); $i++) {

        $movies[] = [
            'name' => $movie[1][$i],
            'publishDate' => $movie[2][$i],
            'desc' => $movie[3][$i]
        ];
    }

    // var_dump($deger);
}
print_r($movies);
