<?php



namespace App;
use Phore\Html\Helper\Highlighter;
use Phore\StatusPage\Mod\ModInterMicroServiceNavigaion;
use Phore\StatusPage\PageHandler\NaviButtonWithIcon;
use Phore\StatusPage\StatusPageApp;
require __DIR__ . "/../vendor/autoload.php";


$hl = new Highlighter();

$app = new StatusPageApp("phore");
$app->addModule(new ModInterMicroServiceNavigaion("http://localhost/assets/mod_inter_mico_service_nav.json"));
$app->theme->frameworks["highlightjs"] = true;

// Define the Routes:
$app->addPage("/", function () use ($hl) {
    return ["h1" => "phore/status-page", pt()->view_code($hl->getCode())];
}, new NaviButtonWithIcon("Home", "fas fa-home"));

// Define the Tables site
$app->addPage("/tables", function () {
    return require __DIR__ . "/inc/tables.php";
}, new NaviButtonWithIcon("Tables", "fas fa-table"));

// Define the Cards site
$app->addPage("/basic_table", function () {
    return require __DIR__ . "/inc/basic_tables.php";
}, new NaviButtonWithIcon("Basic Table", "fas fa-table"));

// Define the Cards site
$app->addPage("/cards", function () {
    return require __DIR__ . "/inc/cards.php";
}, new NaviButtonWithIcon("Cards", "fas fa-table"));

$app->addPage("/vue-elements", function () {
    return require __DIR__ . "/inc/vue-elements.php";
}, new NaviButtonWithIcon("Vue Elements", "fas fa-table"));


$app->addPage("/subapp", function() {}, new NaviButtonWithIcon("Sub Application", "fas fa-time"));


$hl->end_recording();
$app->serve();


