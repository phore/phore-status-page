<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 26.10.18
 * Time: 12:24
 */

namespace Phore\StatusPage;


use Phore\MicroApp\App;
use Phore\MicroApp\Handler\JsonExceptionHandler;
use Phore\StatusPage\PageHandler\NaviButton;
use Phore\StatusPage\PageHandler\PlainPage;
use Phore\Theme\Bootstrap\Bootstrap4_Config;
use Phore\Theme\CoreUI\CoreUI;
use Phore\Theme\CoreUI\CoreUi_Config_PageWithSidebar;
use Phore\Theme\CoreUI\CoreUiModule;

class StatusPageApp extends App
{

    /**
     * @var CoreUi_Config_PageWithSidebar
     */
    public $theme;

    public function __construct(string $title = "unnamed system", string $routingStartPath = "", string $brandLogoUri = null)
    {
        parent::__construct();

        $this->activateExceptionErrorHandlers();
        $this->setOnExceptionHandler(new JsonExceptionHandler());

        if ($brandLogoUri === null)
            $brandLogoUri = $routingStartPath . "/assets/brand-logo.png";

        $this->assets("$routingStartPath/assets")
            ->addAssetSearchPath(getcwd() . "/assets")
            ->addAssetSearchPath(Bootstrap4_Config::ASSETS_DIR_BOOTSTAP)
            ->addAssetSearchPath(CoreUI::COREUI_ASSET_PATH)
            ->addVirtualAsset("all.js", [])
            ->addVirtualAsset("all.css", []);


        $this->addModule(new CoreUiModule());


        if (get_class($this) == StatusPageApp::class) {
            $this->acl->addRule(aclRule()->ALLOW());
        }
        $this->theme = new CoreUi_Config_PageWithSidebar();

        $this->theme->assetPath = "$routingStartPath/assets";

        $this->theme->brandLogoUrl = $brandLogoUri;
        $this->theme->favicon = "$routingStartPath/assets/favicon.png";

        $this->theme->title = $title;
        $this->theme->brandName = $title;
        $this->theme->sidebarMenu = [];
        $this->theme->header_menu_main = [];
        $this->theme->header_badgebar = [];
        $this->theme->showBreadcrumbs = false;
        $this->theme->footer = [];
    }

    public function addPage (string $route, callable $callable, NaviButton $navigation=null)
    {
        $page = new PlainPage($callable);
        $this->router->get($route, [$page, "on_get"]);
        //$this->router->post($route, [$page, "on_post"]);
        if ($navigation !== null) {
            if ($navigation->href === null)
                $navigation->href = $route;
            $this->theme->sidebarMenu[] = (array)$navigation;
        }
    }


    public function addCtrl(string $className, NaviButton $naviButton=null) : App
    {
        if ( ! in_array(StatusPageController::class, class_implements($className))) {
            return parent::addCtrl($className);
        }
        $ref = new \ReflectionClass($className);
        if ( ! $ref->hasConstant("ROUTE")) {
            throw new \InvalidArgumentException("Cannot add addCtrl($className): Class $className requires ROUTE constant.");
        }

        $route = $ref->getConstant("ROUTE");

        if ( ! $ref->getMethod("on_get")->isPublic()) {
            throw new \InvalidArgumentException("StatusPageController '$className' requires public method 'on_get'");
        }

        $page = new PlainPage(function (array $__call_params) use ($className) {
            $params = $this->buildParametersForConstructor($className, $__call_params);

            $ctrl = new $className($params);
            return $this([$ctrl, "on_get"], $__call_params);
        });
        $this->router->get($route, [$page, "on_get"]);

        if ($ref->hasMethod("on_post")) {
            $this->router->onPost($route, function (array $__call_params) use ($className) {
                $params = $this->buildParametersForConstructor($className, $__call_params);
                $ctrl = new $className($params);
                return $this([$ctrl, "on_post"], $__call_params);
            });
        }

        if ($ref->hasMethod("on_delete")) {
            $this->router->onDelete($route, function (array $__call_params) use ($className) {
                $params = $this->buildParametersForConstructor($className, $__call_params);
                $ctrl = new $className($params);
                return $this([$ctrl, "on_delete"], $__call_params);
            });
        }

        if ($ref->hasMethod("on_put")) {
            $this->router->onPut($route, function (array $__call_params) use ($className) {
                $params = $this->buildParametersForConstructor($className, $__call_params);
                $ctrl = new $className($params);
                return $this([$ctrl, "on_put"], $__call_params);
            });
        }
        return $this;

    }


}
