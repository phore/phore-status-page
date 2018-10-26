<?php

namespace App;
use Phore\MicroApp\App;
use Phore\MicroApp\Handler\JsonExceptionHandler;
use Phore\MicroApp\Handler\JsonResponseHandler;
use Phore\MicroApp\Helper\CORSHelper;
use Phore\MicroApp\Type\QueryParams;
use Phore\MicroApp\Type\Request;
use Phore\MicroApp\Type\RouteParams;
use Phore\StatusPage\BasicAuthStatusPageApp;
use Phore\StatusPage\PageHandler\NaviButton;


require __DIR__ . "/../vendor/autoload.php";

$app = new BasicAuthStatusPageApp(true);
$app->addAllowUser("admin", "admin");

$app->addPage("/", function () {
    return ["h1" => "hello world"];
}, new NaviButton("Home"));

$app->serve();
