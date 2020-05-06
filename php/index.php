<?php

require "../vendor/autoload.php";

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

$msDocs = "https://docs.microsoft.com/en-us/windows/uwp/design/style/segoe-ui-symbol-font";
$client = new Client();
$response = $client->request('GET', $msDocs);

$html = ''.$response->getBody();
$crawler = new Crawler($html);

$nodeValues = $crawler->filter('table tr')->each(function (Crawler $node, $i){
    $unicode        = $node->filter('td:nth-of-type(2)')->text();
    $description    = $node->filter('td:nth-of-type(3)')->text();

    $array = [
        'unicode'       => $unicode,
        'description'   => $description
    ];
    return $array;
});

foreach($nodeValues as $item){
    echo "&.".$item['description']."::before{\n";
    echo "    content: \"\\".$item['unicode']."\";\n";
    echo "}\n";
};

?>