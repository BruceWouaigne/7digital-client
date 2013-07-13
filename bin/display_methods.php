<?php

require 'vendor/autoload.php';

$serviceDir = new \DirectoryIterator('src/SevenDigital/Service/');
$client = new \SevenDigital\ApiClient(null);

foreach ($serviceDir as $fileInfo) {
    if ($fileInfo->isDot()) {
        continue;
    }
    $refClass = new \ReflectionClass($service = $client->{'get'.$fileInfo->getBasename('.php').'service'}());
    $refProperty = $refClass->getParentClass()->getProperty('methods');
    $refProperty->setAccessible(true);
    foreach ($refProperty->getValue($service) as $name => $method) {
        echo sprintf("  - %s/%s\n", $service->getName(), $name);
    }
}

