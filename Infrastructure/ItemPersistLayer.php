<?php

namespace Src\Modules\JsonObjects\Infrastructure;

use Src\Modules\JsonObjects\Interfaces\Infrastructure\IItemPersistLayer;
use Src\Modules\JsonObjects\Interfaces\Dto\Item\IPersistItem;
use Illuminate\Support\Facades\DB;

class ItemPersistLayer implements IItemPersistLayer {

    protected string $tableName;

    public function setTableName(string $tableName)
    {
        $this->tableName = $tableName;
    }

    public function create(IPersistItem $dto):bool
    {
        $qb = DB::table($this->tableName);
        $attrs = $dto->getInsertAttrs();
        return $qb->insert($attrs);
    }

    public function update(IPersistItem $dto):int
    {
        $attrs = $dto->getUpdatedAttrs();
        if($attrs){
            $qb = DB::table($this->tableName);
            return $qb->where($this->tableName . '.id', '=', $dto->getId())->update($attrs);
        }
        return 0;
    }

    public function delete(string $itemId):int
    {
        $qb = DB::table($this->tableName);
        return $qb->where($this->tableName . '.id', '=', $itemId)->delete();
    }

    public function deleteInDirs(array $dirIds):int
    {
        $qb = DB::table($this->tableName);
        return $qb->whereIn($this->tableName . '.dir_id', $dirIds)->delete();
    }

}