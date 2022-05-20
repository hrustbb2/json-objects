<?php

namespace Src\Modules\JsonObjects\Interfaces\Application;

use Src\Modules\JsonObjects\Interfaces\IFactory as IModuleFactory;
use Src\Modules\JsonObjects\Interfaces\Application\IDomain;

interface IFactory {
    public function init(array $conf = []): void;
    public function setModuleFactory(IModuleFactory $factorory):void;
    public function getDomain():IDomain;
}