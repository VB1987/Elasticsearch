<?php

require_once 'classes/Elasticsearch.php';

$client = new Elasticsearch();

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $params = $client->createParams($_POST['city']);
    //$params = $client->createParams('Goma');
    $hash = $client->hashFilename($params);

    // Check if it has already been cached and not expired
    // If true then we output the cached file contents and finish
    if ($client->is_cached($hash)) {
        echo $client->read_cache($hash);
    } else {
        $content = $client->search($params);
        $client->write_cache($hash, $content);
    }        
}