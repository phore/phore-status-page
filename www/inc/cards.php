<?php
namespace App;

$doc = fhtml();

$t = $doc->elem("@row");
$t->elem("@col-6")[] = pt()->card("Header 1", "Also");
$t->elem("@col-6")[] = pt()->card(["Header with badge", "span @badge @badge-success @float-right"=>"Success"], "Also");

$t = $doc->elem("@row");
$t->elem("@col-12")[] = pt()->card("Just one row");

$t = $doc->elem("@row");
$t->elem("@col-4")[] =
    pt("@bg-primary @text-center @text-white")->card(null, ["blockquote" => ["p"=>"I have no title", "footer"=>"and primary"]]);

$t->elem("@col-4")[] =
    pt("@bg-warning @text-center @text-white")->card(null, ["blockquote" => ["p"=>"I have no title", "footer"=>"and warning"]]);

$t->elem("@col-4")[] =
    pt("@bg-success @text-center @text-white")->card(null, ["blockquote" => ["p"=>"I have no title", "footer"=>"and success"]]);

$t = $doc->elem("@row");
$t->elem("@col-md-4 @col-12")[] =
    pt("@bg-warning @text-center @text-white")->card("Title", ["blockquote" => ["p"=>"I'm big", "footer"=>"and love fishes"]]);

$t->elem("@col-md-4 @col-12")[] =
    pt("@bg-success @text-center @text-white")->card("Title", ["blockquote" => ["p"=>"I'm big", "footer"=>"and love fishes"]]);

return $t;
