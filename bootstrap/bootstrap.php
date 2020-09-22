<?php
require_once __DIR__ . '/../vendor/autoload.php';

use SocialNetwork\Application\GetStatisticsAction;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

// Start the clock time in seconds
$start_time = microtime(true);

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/../.env');

try {
    $container = new ContainerBuilder();
    $loader = new PhpFileLoader($container, new FileLocator(__DIR__ . '/DependencyInjection'));
    $loader->load('config.php');

    /** @var GetStatisticsAction $getStatistics */
    $getStatistics = $container->get('getStatisticsAction');
    $stat = $getStatistics->run();

    echo json_encode($stat, JSON_PRETTY_PRINT);

} catch (Exception $e) {
    echo $e->getMessage();
}

// End the clock time in seconds
$end_time = microtime(true);

// Calculate the script execution time
$execution_time = ($end_time - $start_time);

echo "\n It takes " . $execution_time . " seconds to execute the script \n";