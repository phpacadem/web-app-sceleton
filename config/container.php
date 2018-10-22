<?php

use Zend\ConfigAggregator\ConfigAggregator;
use Zend\ConfigAggregator\PhpFileProvider;

$aggregator = new ConfigAggregator([
    new PhpFileProvider(__DIR__ . '/di/services.php'),
    new PhpFileProvider(__DIR__ . '/../component/*/services.php'),
]);
return $aggregator->getMergedConfig();
