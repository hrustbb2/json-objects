<?php

namespace Src\Modules\JsonObjects\Dto\Item;

use Src\Common\Dto\Object\AbstractComposite;
use Src\Common\Interfaces\Dto\Object\IFactory as IObjectsFactory;

abstract class AbstractItem {

    protected ?string $id = null;

    protected ?string $key = null;

    protected string $name;

    protected string $description;

    protected AbstractComposite $object;

    protected int $disabled = 0;

    protected IObjectsFactory $objectsFactory;

    public function setObjectsFactory(IObjectsFactory $factory):void
    {
        $this->objectsFactory = $factory;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function getAttributes():array
    {
        $attrs = [
            'id' => $this->id,
            'key' => $this->key,
            'name' => $this->name,
            'description' => $this->description,
            'disabled' => $this->disabled,
        ];
        if($this->object){
            $attrs['object'] = json_encode($this->object->getAttributes());
        }
        return $attrs;
    }

    public function load(array $data):void
    {
        $this->id = $data['id'] ?? uniqid();
        $this->key = $data['key'] ?? '';
        $this->name = $data['name'] ?? '';
        $this->description = $data['description'] ?? '';
        $this->disabled = $data['disabled'] ?? 0;
        if(key_exists('object', $data)){
            $objectData = json_decode($data['object'], true);
            $type = $objectData['type'];
            $this->object = $this->objectsFactory->createObjectField($type);
            $this->object->loadAttributes($objectData);
        }
        if(key_exists('dir', $data)){
            $dirData = array_pop($data['dir']);
            $this->loadDir($dirData);
        }
    }

    public function validate():bool
    {
        return $this->object->validate();
    }

    abstract public function loadDir(array $dirData):void;

}