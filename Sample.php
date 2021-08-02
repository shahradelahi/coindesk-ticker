<?php
require_once __DIR__ . '/vendor/autoload.php';

// Setup settings
$Settings = [
    'close_time' => strtotime('+10 second', time()) // Required
];

try {

    // Initialization for our ticker
    $CDApi = new CoinDesk\Api();

    // If you need only one tick
    $OneTick = $CDApi->ticker()->getOneTick();
    echo "<pre>" . json_encode($OneTick, JSON_PRETTY_PRINT) . "</pre>";

    // Connect to the stream channel
    $CDApi->ticker()->setTicker(function (array $Coins) {
        echo "<pre>" . json_encode($Coins, JSON_PRETTY_PRINT) . "</pre>";
    }, $Settings);

} catch (Exception $e) {

    // Throw out exceptions
    echo "Error: " . $e->getMessage();

}
