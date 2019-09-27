<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 07.03.19
 * Time: 14:01
 */

namespace Phore\StatusPage\Mod;


use Phore\MicroApp\App;
use Phore\MicroApp\AppModule;
use Phore\StatusPage\StatusPageApp;

class ModInterMicroServiceNavigaion implements AppModule
{

    private $configUrl;

    public function __construct(string $configUrl)
    {
        $this->configUrl = $configUrl;
    }

    /**
     * Called just after adding this to a app by calling
     * `$app->addModule(new SomeModule());`
     *
     * Here is the right place to add Routes, etc.
     *
     * @param App $app
     *
     * @return mixed
     */
    public function register(App $app)
    {
        if (!$app instanceof StatusPageApp)
            throw new \InvalidArgumentException("This app is no StatusPageApp");

        try {
            $data = phore_http_request($this->configUrl)->withTimeout(0.2, 1)->send()->getBodyJson();
            $app->theme->header_menu_main = $data;
        } catch (\ErrorException $e) {
            
            // Ignore error
        }

    }
}
