<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 26.10.18
 * Time: 12:31
 */

namespace Phore\StatusPage;


use Phore\MicroApp\Auth\BasicUserProvider;
use Phore\MicroApp\Auth\HttpBasicAuthMech;
use Phore\Theme\CoreUI\CoreUi_Config_PageWithSidebar;

class BasicAuthStatusPageApp extends StatusPageApp
{

    /**
     * @var BasicUserProvider
     */
    public $basicUserProvider;





    public function __construct(bool $allowPlaintextPasswords = false)
    {
        parent::__construct();

        $this->authManager->setAuthMech(new HttpBasicAuthMech());
        $this->authManager->setUserProvider($this->basicUserProvider = new BasicUserProvider($allowPlaintextPasswords));

        $this->acl->addRule(aclRule()->role("@user")->ALLOW());
    }

    public function addAllowUser ($username, $password, $metaData=[]) : self
    {
        $this->basicUserProvider->addUser($username, $password, "@user", $metaData);
        return $this;
    }




}
