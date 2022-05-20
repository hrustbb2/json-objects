<?php

namespace Src\Modules\JsonObjects\Dto\Item;

use Src\Modules\JsonObjects\Interfaces\Dto\Item\IPersistItem;
use Src\Common\Dto\Object\AbstractComposite;

class PersistItem extends AbstractItem implements IPersistItem {

    protected array $updatedAttrs = [];

    protected string $dirId = '';

    public function loadDir(array $dirData):void
    {
        $this->dirId = $dirData['id'];
    }

    public function setObject(AbstractComposite $obj)
    {
        $this->object = $obj;
    }

    public function getInsertAttrs():array
    {
        if(!$this->key){
            $this->key = uniqid();
        }
        return [
            'id' => $this->id,
            'dir_id' => $this->dirId ?? '',
            'key' => $this->key,
            'name' => $this->name,
            'description' => $this->description ?? '',
            'object' => json_encode($this->object->getAttributes()),
            'disabled' => $this->disabled,
        ];
    }

    public function update(array $data):void
    {
        if(key_exists('id', $data) && $this->id != $data['id']){
            $this->id = $data['id'];
            $this->updatedAttrs['id'] = $data['id'];
        }
        if(key_exists('key', $data) && $this->key != $data['key']){
            $this->key = $data['key'];
            $this->updatedAttrs['key'] = $data['key'];
        }
        if(key_exists('name', $data) && $this->name != $data['name']){
            $this->name = $data['name'];
            $this->updatedAttrs['name'] = $data['name'];
        }
        if(key_exists('description', $data) && $this->description != $data['description']){
            $this->description = $data['description'];
            $this->updatedAttrs['description'] = $data['description'];
        }
        if(key_exists('object', $data) && $this->object){
            $objectData = json_decode($data['object'], true);
            $this->object->loadAttributes($objectData);
            $this->updatedAttrs['object'] = json_encode($this->object->getAttributes());
        }
    }

    public function getUpdatedAttrs():array
    {
        return $this->updatedAttrs;
    }

}