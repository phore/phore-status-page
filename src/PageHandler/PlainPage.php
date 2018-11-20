<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 26.10.18
 * Time: 13:13
 */

namespace Phore\StatusPage\PageHandler;


use Phore\MicroApp\App;
use Phore\MicroApp\Type\Request;
use Phore\MicroApp\Type\RouteParams;
use Phore\StatusPage\StatusPageApp;
use Phore\Theme\CoreUI\CoreUi_PageWithSidebar;

class PlainPage
{

    private $cb;

    public function __construct(callable $callback)
    {
        $this->cb = $callback;
    }


    public function on_get(StatusPageApp $app, RouteParams $routeParams, Request $request)
    {
        $params = $app->buildParametersFor($this->cb, [
            "routeParams" => $routeParams,
            "request" => $request
        ]);
        $content = ($this->cb)(...$params);
        $pageConfig = clone $app->theme;
        $pageConfig->mainContent = $content;

        (new CoreUi_PageWithSidebar($pageConfig))->out();
        return true;
    }


}
