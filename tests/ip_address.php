<?php

try {
    if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
        include __DIR__ . '/../vendor/autoload.php';
    } else if (file_exists(__DIR__ . '/../../../autoload.php')) {
        include __DIR__ . '/../../../autoload.php';
    } else {
        exit('Fail - missing autoloader');
    }

    // IPv4
	$url = new RapidSpike\Targets\IpAddress('8.8.8.8');
	print_r($url);
	echo PHP_EOL;

    // IPv4 + port
    $url = new RapidSpike\Targets\IpAddress('8.8.8.8:80');
    print_r($url);
	echo PHP_EOL;

	// IPv6
    $url = new RapidSpike\Targets\IpAddress('2345:0425:2CA1:0000:0000:0567:5673:23b5');
    print_r($url);
	echo PHP_EOL;
	
    echo PHP_EOL, 'Pass', PHP_EOL;
} catch (\Exception $e) {
    echo 'Fail', PHP_EOL, $e->getMessage(), PHP_EOL;
}
