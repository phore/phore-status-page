<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 26.10.18
 * Time: 14:26
 */

namespace Phore\StatusPage\PageHandler;


class NaviButton
{


    public $name;
    public $href;

    public function __construct(string $name, string $href = null)
    {
        $this->name = $name;
        $this->href = $href;
    }



}
