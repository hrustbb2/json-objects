<?php

namespace Src\Modules\JsonObjects\Interfaces\Application;

use Src\Lib\CategoriesTree\Interfaces\Infrastructure\IStorage as IDirStorage;

interface IDataBuilder {
    public function setDirStorage(IDirStorage $dirStorage):void;
    public function build(array $data):array;
}