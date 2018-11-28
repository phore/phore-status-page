<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 26.10.18
 * Time: 13:13
 */

namespace Phore\StatusPage\PageHandler;


use Phore\MicroApp\App;
use Phore\MicroApp\Type\QueryParams;
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
        $defParam = [
            "app" => $app,
            "routeParams" => $routeParams,
            "request" => $request
        ];
        foreach ($routeParams->list() as $key) {
            $defParam[$key] = $routeParams->get($key);
        }

        $params = $app->buildParametersFor($this->cb, $defParam);
        
        $content = ($this->cb)(...$params);
        
        if ($content === true)
            return true;
        
        $pageConfig = clone $app->theme;
        $pageConfig->mainContent = $content;

        (new CoreUi_PageWithSidebar($pageConfig))->out();
        return true;
    }


}
