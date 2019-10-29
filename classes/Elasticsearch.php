<?php

class Elasticsearch {
    protected $_client;

    public function __construct() {
        require_once 'vendor/autoload.php';
        $this->_client = Elasticsearch\ClientBuilder::create()->build();
    }

    // Checks whether the page has been cached or not
    public function is_cached($file) {
        $cachefile_created = (file_exists($file)) ? @filemtime($file) : 0;
        return ((time() - 3600) < $cachefile_created);
    }

    // Reads from a cached file
    public function read_cache($file) {
        $handle = fopen($file, 'r');
        $contents = fread($handle, filesize($file));
        return $contents;
        fclose($handle);
    }

    // Writes to a cached file
    public function write_cache($file, $out) {
        $fp = fopen($file, 'w');
        fwrite($fp, $out);
        fclose($fp);
    }

    // Sets the filter to parameter
    public function createParams($filter) {
        $params = [
            'index' => 'our_airports',
            'size' => '20',
            'body' => [
                'query' => [
                    'match' => [
                        'name' => $filter
                    ],
                ],
            ],
        ];
        
        return $params;
    }

    // Creates the cached filename
    public function hashFilename($params) {
        $hashFilename = '../cache/' . md5(json_encode($params)) . '.json';
        return $hashFilename;
    }

    // Executes the search
    public function search($params) {
        $response = $this->_client->search($params);
        $hits = count($response['hits']['hits']);
        $result = null;
        $i = 0;

        $array = [];
        while ($i < $hits) {
            $array[] = $result[$i] = $response['hits']['hits'][$i]['_source'];
            $i++;
        }
        return json_encode($array);
    }
}