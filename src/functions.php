<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 30.10.18
 * Time: 10:24
 */



function pt(string $optStyles = "") : \Phore\StatusPage\Tpl\Elements
{
    return new \Phore\StatusPage\Tpl\Elements($optStyles);
}
