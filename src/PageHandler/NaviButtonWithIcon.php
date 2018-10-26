<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 26.10.18
 * Time: 14:31
 */

namespace Phore\StatusPage\PageHandler;


class NaviButtonWithIcon extends NaviButton
{

    public $icon;

    public function __construct(string $name, string $icon, string $href = null)
    {
        parent::__construct($name, $href);
        $this->icon = $icon;
    }

}
