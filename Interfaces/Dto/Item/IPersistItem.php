<?php

namespace Src\Modules\JsonObjects\Interfaces\Dto\Item;

use Src\Common\Dto\Object\AbstractComposite;

interface IPersistItem extends IAbstractItem {
    public function setObject(AbstractComposite $obj);
    public function getInsertAttrs():array;
    public function update(array $data):void;
    public function getUpdatedAttrs():array;
}