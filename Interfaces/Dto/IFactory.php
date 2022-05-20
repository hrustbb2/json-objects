<?php

namespace Src\Modules\JsonObjects\Interfaces\Dto;

use Src\Modules\JsonObjects\Interfaces\IFactory as IModulesFactory;
use Src\Modules\JsonObjects\Interfaces\Dto\Item\IFactory as IItemFactory;

interface IFactory {
    public function init(array $conf = []): void;
    public function setModulesFactory(IModulesFactory $factory);
    public function getModulesFactory():IModulesFactory;
    public function getItemFactory():IItemFactory;
}