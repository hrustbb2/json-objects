<?php

namespace Src\Modules\JsonObjects\Infrastructure;

use Src\Modules\JsonObjects\Interfaces\Infrastructure\IItemStorage;
use Src\Modules\JsonObjects\Interfaces\Infrastructure\IItemQuery;
use Src\Lib\CategoriesTree\Interfaces\Infrastructure\IStorage as IDirStorage;
use Src\Common\Infrastructure\TraitStorage;

class ItemStorage implements IItemStorage {

    use TraitStorage;

    protected IItemQuery $objectsQuery;

    protected IDirStorage $dirStorage;

    public function setObjectsQuery(IItemQuery $query)
    {
        $this->objectsQuery = $query;
    }

    public function setDirStorage(IDirStorage $storage):void
    {
        $this->dirStorage = $storage;
    }

    public function getById(string $itemId, array $dsl = []):array
    {
        $itemData = $this->objectsQuery->select($dsl)->whereId($itemId)->one();
        if(empty($itemData)){
            return [];
        }
        if(key_exists('dir', $dsl)){
            $dirId = $itemData['dir_id'];
            $dirData = $this->dirStorage->getById($dirId, $dsl['dir']);
            $itemData['dir'] = [
                $dirId => $dirData,
            ];
        }
        return $itemData;
    }

    public function getByKey(string $key, array $dsl = []):array
    {
        return $this->objectsQuery->select($dsl)->whereKey($key)->one();
    }

    public function getByDirId(string $dirId, array $dsl = []):array
    {
        return $this->objectsQuery->select($dsl)->whereDirId($dirId)->all();
    }

}