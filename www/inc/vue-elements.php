<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 22.11.18
 * Time: 13:27
 */
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

return $doc;
