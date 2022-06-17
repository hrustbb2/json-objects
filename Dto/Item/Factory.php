<?php

namespace Src\Modules\JsonObjects\Dto\Item;

use Src\Modules\JsonObjects\Interfaces\IFactory as IModuleFactory;
use Src\Modules\JsonObjects\Interfaces\Dto\Item\IFactory;
use Src\Modules\JsonObjects\Interfaces\Dto\IFactory as IDtoFactory;

class Factory implements IFactory {

    protected ?IDtoFactory $dtoFactory = null;

    protected array $conf;

    public function init(array $conf = []): void
    {
        $this->conf = [
            'persistItem' => PersistItem::class,
            'resourceItem' => ResourceItem::class,
        ];
        $this->conf = array_merge_recursive($this->conf, $conf);
    }

    public function setDtoFactory(IDtoFactory $factory):void
    {
        $this->dtoFactory = $factory;
    }

    public function createPersist(string $type = ''):PersistItem
    {
        $persist = new $this->conf['persistItem'];
        $objFactory = $this->dtoFactory->getModulesFactory()->getSetting(IModuleFactory::OBJECTS_FACTORY);
        $persist->setObjectsFactory($objFactory);
        if($type){
            $obj = $objFactory->createObjectField($type);
            $persist->setObject($obj);
        }
        return $persist;
    }

    public function createResource():ResourceItem
    {
        $resource = new $this->conf['resourceItem'];
        $dirResource = $this->dtoFactory->getModulesFactory()->getDirsTreeFactory()->getDtoFactory()->createResource();
        $resource->setDir($dirResource);
        $objFactory = $this->dtoFactory->getModulesFactory()->getSetting(IModuleFactory::OBJECTS_FACTORY);
        $resource->setObjectsFactory($objFactory);
        return $resource;
    }

}