<?php

namespace Src\Modules\JsonObjects\Application;

use Src\Modules\JsonObjects\Interfaces\Application\IDataBuilder;
use Src\Lib\CategoriesTree\Interfaces\Infrastructure\IStorage as IDirStorage;

class DataBuilder implements IDataBuilder {

    protected IDirStorage $dirStorage;

    public function setDirStorage(IDirStorage $dirStorage):void
    {
        $this->dirStorage = $dirStorage;
    }

    public function build(array $data):array
    {
        $dirData = [];
        if(key_exists('dir-id', $data) && $data['dir-id']){
            $dirData = $this->dirStorage->getById($data['dir-id']);
            if(!$dirData){
                $dirData = ['id' => ''];
            }
            $data['dir'] = [
                $data['dir-id'] => $dirData,
            ];
        }
        return $data;
    }

}