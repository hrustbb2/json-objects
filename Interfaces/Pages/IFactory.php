<?php

namespace Src\Modules\JsonObjects\Interfaces\Pages;

use Src\Modules\JsonObjects\Interfaces\IFactory as IModuleFactory;

interface IFactory {
    public function init(array $conf = []): void;
    public function setModuleFactory(IModuleFactory $factory);
    public function createDirPage(string $currentDirId):IDir;
    public function createItemPage(string $itemId):IItem;
}