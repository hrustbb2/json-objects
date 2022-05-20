<?php

namespace Src\Modules\JsonObjects\Interfaces\Application;

use Src\Common\Interfaces\Application\IBaseDomain;
use Src\Modules\JsonObjects\Interfaces\Application\IValidator;
use Src\Modules\JsonObjects\Interfaces\Dto\IFactory as IDtoFactory;
use Src\Modules\JsonObjects\Interfaces\Infrastructure\IItemPersistLayer;
use Src\Modules\JsonObjects\Interfaces\Infrastructure\IItemStorage;
use Src\Modules\JsonObjects\Interfaces\Dto\Item\IResourceItem;
use Src\Modules\JsonObjects\Interfaces\Application\IDataBuilder;
use Src\Lib\CategoriesTree\Interfaces\Application\IValidator as IDirValidator;
use Src\Lib\CategoriesTree\Interfaces\Application\IDomain as IDirDomain;
use Src\Lib\CategoriesTree\Interfaces\Infrastructure\IStorage as IDirStorage;

interface IDomain extends IBaseDomain {
    public function setValidator(IValidator $validator):void;
    public function setDtoFactory(IDtoFactory $factory):void;
    public function setPersistLayer(IItemPersistLayer $layer):void;
    public function setStorage(IItemStorage $storage):void;
    public function setDataBuilder(IDataBuilder $dataBuilder):void;
    public function setDirValidator(IDirValidator $validator):void;
    public function setDirDomain(IDirDomain $domain):void;
    public function setDirStorage(IDirStorage $storage):void;
    public function createObject(array $data):bool;
    public function editObject(array $data):bool;
    public function renameObject(array $data):bool;
    public function deleteObject(array $data):bool;
    public function deleteDir(array $data):bool;
    public function getItem():IResourceItem;
}