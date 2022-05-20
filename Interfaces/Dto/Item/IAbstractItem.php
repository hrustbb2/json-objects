<?php

namespace Src\Modules\JsonObjects\Interfaces\Dto\Item;

use Src\Common\Interfaces\Dto\Object\IFactory as IObjectsFactory;

interface IAbstractItem {
    public function setObjectsFactory(IObjectsFactory $factory):void;
    public function getId();
    public function getAttributes():array;
    public function load(array $data):void;
    public function loadDir(array $dirData):void;
    public function validate():bool;
}