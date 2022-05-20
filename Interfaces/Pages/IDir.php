<?php

namespace Src\Modules\JsonObjects\Interfaces\Pages;

use Src\Common\Interfaces\Pages\IAbstractPage;
use Src\Lib\CategoriesTree\Interfaces\Infrastructure\IStorage as IDirsStorage;
use Src\Lib\CategoriesTree\Interfaces\Dto\IFactory as IDirsDtoFactory;
use Src\Modules\JsonObjects\Interfaces\Infrastructure\IItemStorage;
use Src\Modules\JsonObjects\Interfaces\Dto\Item\IFactory as IItemDtoFactory;

interface IDir extends IAbstractPage {
    public function setDirsStorage(IDirsStorage $storage):void;
    public function setDirsDtoFactory(IDirsDtoFactory $factory):void;
    public function setItemStorage(IItemStorage $storage):void;
    public function setItemDtoFactory(IItemDtoFactory $factory):void;
    public function setItemsDropdown(array $dropDown):void;
    public function init(string $currentDirId):void;
    public function getBreadcrumbs():array;
    public function getItemsDropdown():array;
}