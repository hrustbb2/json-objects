<?php

namespace Src\Modules\JsonObjects\Interfaces;

use Src\Sidebar\Interfaces\IFactory as ISidebarFactory;
use Src\Common\Interfaces\IFactory as ICommonFactory;

interface IModulesProvider {
    public function getSidebarFactory():ISidebarFactory;
    public function getCommonFactory():ICommonFactory;
    public function getJsonObjectsFactory():IFactory;
}