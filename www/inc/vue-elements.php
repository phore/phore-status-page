<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 22.11.18
 * Time: 13:27
 */

namespace App;

use Phore\Html\Helper\Highlighter;

$h = new Highlighter();
$doc = fhtml();

$doc[] = [
    "ps-form" => [
        "div @slot-scope=form" => [
            "{{ form }}",
            "input @type=text"  => null,
            "button @type=submit" => "submit"
        ]
    ]
];
$h->end_recording();

$doc[] = pt()->view_code($h->getCode());
return $doc;
