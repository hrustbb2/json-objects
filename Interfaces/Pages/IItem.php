<?php

namespace Src\Modules\JsonObjects\Interfaces\Pages;

use Src\Common\Interfaces\Pages\IAbstractPage;
use Src\Common\Interfaces\Adapters\IRoute;
use Src\Modules\JsonObjects\Interfaces\Dto\Item\IResourceItem;

interface IItem extends IAbstractPage {
    public function setRouteAdapter(IRoute $adapter):void;
    public function getBreadcrumbs():array;
    public function getItem():IResourceItem;
}