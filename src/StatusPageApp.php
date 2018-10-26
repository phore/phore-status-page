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
use Phore\Theme\CoreUI\CoreUi_Config_PageWithSidebar;
use Phore\Theme\CoreUI\CoreUiModule;

class StatusPageApp extends App
{

    /**
     * @var CoreUi_Config_PageWithSidebar
     */
    public $theme;

    public function __construct(string $title = "unnamed system")
    {
        parent::__construct();

        $this->activateExceptionErrorHandlers();
        $this->setOnExceptionHandler(new JsonExceptionHandler());

        $this->addModule(new CoreUiModule());

        if (get_class($this) == StatusPageApp::class) {
            $this->acl->addRule(aclRule()->ALLOW());
        }
        $this->theme = new CoreUi_Config_PageWithSidebar();

        $this->theme->title = $title;
        $this->theme->brandName = $title;
        $this->theme->sidebarMenu = [];
        $this->theme->header_menu_main = [];
        $this->theme->header_badgebar = [];
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




}
