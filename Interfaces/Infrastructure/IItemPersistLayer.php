<?php

namespace Src\Modules\JsonObjects\Interfaces\Infrastructure;

use Src\Modules\JsonObjects\Interfaces\Dto\Item\IPersistItem;

interface IItemPersistLayer {
    public function setTableName(string $tableName);
    public function create(IPersistItem $dto):bool;
    public function update(IPersistItem $dto):int;
    public function delete(string $itemId):int;
    public function deleteInDirs(array $dirIds):int;
}