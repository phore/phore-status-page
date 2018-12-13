<?php
namespace App;

use Phore\Html\Helper\Highlighter;

$doc = fhtml();

$h = new Highlighter();
$t = $doc["@row"];
$t["@col-6"][] = pt()->card("Header 1", "Also");
$t["@col-6"][] = pt()->card(["Header with badge", "span @badge @badge-success @float-right"=>"Success"], "Also");

$t = $doc["@row"];
$t["@col-12"][] = pt()->card("Just one row");

$t = $doc["@row"];
$t["@col-4"][] =
    pt("@bg-primary @text-center @text-white")->card(null, ["blockquote" => ["p"=>"I have no title", "footer"=>"and primary"]]);

$t["@col-4"][] =
    pt("@bg-warning @text-center @text-white")->card(null, ["blockquote" => ["p"=>"I have no title", "footer"=>"and warning"]]);

$t["@col-4"][] =
    pt("@bg-success @text-center @text-white")->card(null, ["blockquote" => ["p"=>"I have no title", "footer"=>"and success"]]);

$t = $doc["@row"];
$t["@col-md-4 @col-12"][] =
    pt("@bg-warning @text-center @text-white")->card("Title", ["blockquote" => ["p"=>"I'm big", "footer"=>"and love fishes"]]);


$t["@col-md-4 @col-12"][] =
    pt("@bg-success @text-center @text-white")->card("Title", ["blockquote" => ["p"=>"I'm big", "footer"=>"and love fishes"]]);

$h->end_recording();


$t[] = pt()->view_code($h->getCode());

return $t;
