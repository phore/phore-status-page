<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 14.11.18
 * Time: 14:23
 */

namespace Phore\StatusPage;

use Phore\StatusPage\PageHandler\NaviButtonWithIcon;

require __DIR__ . "/../../vendor/autoload.php";



$app = new StatusPageApp("Subapp", "/subapp");


$app->addPage("/subapp/", function () {
    return [
        "h1" => "this is a sub-application"
    ];


}, new NaviButtonWithIcon("Home", "fas fa-home", "/subapp/"));


$app->serve();
