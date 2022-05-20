<?php

namespace Src\Modules\JsonObjects\Interfaces\Infrastructure;

use Src\Modules\JsonObjects\Interfaces\IFactory as IModuleFactory;
use Src\Modules\JsonObjects\Interfaces\Infrastructure\IItemStorage;
use Src\Modules\JsonObjects\Interfaces\Infrastructure\IItemPersistLayer;

interface IFactory {
    public function init(array $conf = []): void;
    public function setModuleFactory(IModuleFactory $factory);
    public function getStorage():IItemStorage;
    public function getPersistLayer():IItemPersistLayer;
    public function getMigrations(): IMigrations;
}