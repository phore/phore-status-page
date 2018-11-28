<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 30.10.18
 * Time: 14:03
 */

namespace App;

use Phore\Html\Fhtml\FHtml;
use Phore\Html\Helper\Table;

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
return $doc;
