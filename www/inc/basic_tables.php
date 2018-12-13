<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 30.10.18
 * Time: 14:03
 */

namespace App;

use Phore\Html\Fhtml\FHtml;
use Phore\Html\Helper\Highlighter;
use Phore\Html\Helper\Table;

$h = new Highlighter();

$doc = fhtml();

$data = ["a", "b", "c"];

$tblData = phore_array_transform($data, function($key, $value) {
    return [
        date ("Y-m-d"),
        ["a @href=/some/other" => "Hello Column"]
    ];
});

$doc[] = pt()->basic_table(
    ["Date",    "Comment"],
    $tblData,
    ["",        "@align=right"]
);

$h->end_recording();

$doc[] = pt()->view_code($h->getCode());

return $doc;
