<?php
namespace App;
use Phore\Html\Helper\Table;
use Phore\StatusPage\PageHandler\NaviButton;
use Phore\StatusPage\PageHandler\NaviButtonWithIcon;
use Phore\StatusPage\StatusPageApp;

require __DIR__ . "/../vendor/autoload.php";

$app = new StatusPageApp("MyApp");


// Define the Routes:
$app->addPage("/", function () {
    return ["h1" => "hello world"];
}, new NaviButtonWithIcon("Home", "fas fa-home"));

// Define the Tables site
$app->addPage("/tables", function () {
    return require __DIR__ . "/inc/tables.php";
}, new NaviButtonWithIcon("Tables", "fas fa-table"));

// Define the Cards site
$app->addPage("/cards", function () {
    return require __DIR__ . "/inc/cards.php";
}, new NaviButtonWithIcon("Cards", "fas fa-table"));


$app->serve();
