<?php

try {
    if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
        include __DIR__ . '/../vendor/autoload.php';
    } else if (file_exists(__DIR__ . '/../../../autoload.php')) {
        include __DIR__ . '/../../../autoload.php';
    } else {
        exit('Fail - missing autoloader');
    }

    $url = new RapidSpike\Targets\Url('https://api.rapidspike.com/v1/test');

    $curl = new \RapidSpike\Utils\BasicCurl($url);
    $curl->setOption([
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POST => 1,
        CURLOPT_HTTPHEADER => array('x-api-key: i-am-a-long-api-key-made-by-tyler'),
        CURLOPT_POSTFIELDS => json_encode([
            "int" => 1,
            "string" => "string",
            "array" => [1, 2, '3'],
        ])
    ]);
    $curl->makeRequest();

    print_r(json_decode($curl->getHtml()));

    echo PHP_EOL, 'Pass', PHP_EOL;
} catch (\Exception $e) {
    echo 'Fail', PHP_EOL, $e->getMessage(), PHP_EOL;
}
