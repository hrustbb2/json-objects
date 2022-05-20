<?php

namespace Src\Modules\JsonObjects\Interfaces\Dto\Item;

use Src\Modules\JsonObjects\Interfaces\Dto\IFactory as IDtoFactory;

interface IFactory {
    public function init(array $conf = []): void;
    public function setDtoFactory(IDtoFactory $factory):void;
    public function createPersist(string $type = ''):IPersistItem;
    public function createResource():IResourceItem;
}