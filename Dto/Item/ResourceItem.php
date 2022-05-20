<?php

namespace Src\Modules\JsonObjects\Dto\Item;

use Src\Modules\JsonObjects\Interfaces\Dto\Item\IResourceItem;
use Src\Lib\CategoriesTree\Interfaces\Dto\IResource as IDirResource;
use Src\Common\Dto\Object\AbstractComposite;

class ResourceItem extends AbstractItem implements IResourceItem {

    protected IDirResource $dir;

    public function setDir(IDirResource $dir):void
    {
        $this->dir = $dir;
    }

    public function loadDir(array $dirData): void
    {
        $this->dir->load($dirData);
    }
    
    public function toArray(array $fields = []):array
    {
        $result = [];
        if(!$fields){
            $fields = ['id', 'key', 'name', 'description', 'object'];
        }
        foreach($fields as $key=>$field){
            if($field == 'id'){
                $result['id'] = $this->id;
            }
            if($field == 'key'){
                $result['key'] = $this->key;
            }
            if($field == 'name'){
                $result['name'] = $this->name;
            }
            if($field == 'description'){
                $result['description'] = $this->description;
            }
            if($field == 'object'){
                $result['object'] = $this->object->getJson();
            }
        }
        return $result;
    }

    public function getDir():IDirResource
    {
        return $this->dir;
    }

    public function isDisabled():bool
    {
        return (bool) $this->disabled;
    }

    public function getObject():AbstractComposite
    {
        return $this->object;
    }

    public function getName():string
    {
        return $this->name;
    }

}