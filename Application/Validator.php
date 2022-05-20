<?php

namespace Src\Modules\JsonObjects\Application;

use Src\Common\Application\TraitValidator;
use Src\Modules\JsonObjects\Interfaces\Application\IValidator;

class Validator implements IValidator {

    use TraitValidator {
        getCleanData as baseCleanData;
    }

    public function createObject(array $data):bool
    {
        $rules = [
            'dir-id' => [
                'nullable',
                'max:32',
            ],
            'object.type' => [
                'required',
                'max:32',
            ],
            'name' => [
                'required',
                'max:32',
            ],
        ];
        $messages = [

        ];
        return $this->validate($data, $rules, $messages);
    }

    public function editObject(array $data):bool
    {
        $rules = [
            'id' => [
                'required',
                'max:32',
            ],
            'key' => [
                'required',
                'max:32',
            ],
            'object' => [
                'required',
                'array',
            ]
        ];
        $messages = [

        ];
        return $this->validate($data, $rules, $messages);
    }

    public function renameObject(array $data):bool
    {
        $rules = [
            'id' => [
                'required',
                'max:32',
            ],
            'name' => [
                'required',
                'max:32',
            ],
        ];
        $messages = [

        ];
        return $this->validate($data, $rules, $messages);
    }

    public function deleteObject(array $data):bool
    {
        $rules = [
            'id' => [
                'required',
                'max:32',
            ],
        ];
        $messages = [

        ];
        return $this->validate($data, $rules, $messages);
    }

    public function getCleanData()
    {
        $cleanData = $this->baseCleanData();
        if(key_exists('object', $cleanData)){
            $cleanData['object'] = json_encode($cleanData['object']);
        }
        return $cleanData;
    }

}