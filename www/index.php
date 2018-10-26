<?php
namespace App;
use Phore\Html\Helper\Table;
use Phore\StatusPage\PageHandler\NaviButtonWithIcon;
use Phore\StatusPage\StatusPageApp;

require __DIR__ . "/../vendor/autoload.php";

$app = new StatusPageApp("MyApplication");

$app->addPage("/", function () {
    return ["h1" => "hello world"];
}, new NaviButtonWithIcon("Home", "fas fa-home"));


$app->addPage("/tables", function () {
    $table = new Table(["#", "Name", "Description"]);
    $table->row([1, "Some Name", "Some Description"], "@class=bg-primary");
    return [
        "h1" => "Table example",
        $table
    ];
}, new NaviButtonWithIcon("Tables", "fas fa-table"));


$app->serve();
