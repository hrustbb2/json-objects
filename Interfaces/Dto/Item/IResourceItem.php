<?php

namespace Src\Modules\JsonObjects\Interfaces\Dto\Item;

use Src\Lib\CategoriesTree\Interfaces\Dto\IResource as IDirResource;
use Src\Common\Dto\Object\AbstractComposite;

interface IResourceItem extends IAbstractItem {
    public function setDir(IDirResource $dir):void;
    public function toArray(array $fields = []):array;
    public function getDir():IDirResource;
    public function isDisabled():bool;
    public function getObject():AbstractComposite;
    public function getName():string;
}