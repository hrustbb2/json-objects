<?php

namespace Src\Modules\JsonObjects\Interfaces\Application;

use Src\Common\Interfaces\Application\IBaseValidator;

interface IValidator extends IBaseValidator {
    public function createObject(array $data):bool;
    public function editObject(array $data):bool;
    public function renameObject(array $data):bool;
    public function deleteObject(array $data):bool;
}