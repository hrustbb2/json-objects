<?php

namespace Src\Modules\JsonObjects\Infrastructure;

use Src\Modules\JsonObjects\Interfaces\Infrastructure\IFactory;
use Src\Modules\JsonObjects\Interfaces\IFactory as IModuleFactory;
use Src\Modules\JsonObjects\Interfaces\Infrastructure\IItemQuery;
use Src\Modules\JsonObjects\Infrastructure\ItemQuery;
use Src\Modules\JsonObjects\Interfaces\Infrastructure\IItemStorage;
use Src\Modules\JsonObjects\Infrastructure\ItemStorage;
use Src\Modules\JsonObjects\Interfaces\Infrastructure\IItemPersistLayer;
use Src\Modules\JsonObjects\Infrastructure\ItemPersistLayer;
use Src\Modules\JsonObjects\Interfaces\Infrastructure\IMigrations;

class Factory implements IFactory {

    protected IModuleFactory $moduleFactory;

    protected ?IItemStorage $storage = null;

    protected ?IItemPersistLayer $persistLayer = null;

    protected ?IMigrations $migration = null;

    protected array $conf;

    public function init(array $conf = []): void
    {
        $this->conf = [
            'itemQuery' => ItemQuery::class,
            'itemStorage' => ItemStorage::class,
            'itemPersistLayer' => ItemPersistLayer::class,
        ];
        $this->conf = array_replace_recursive($this->conf, $conf);
    }

    public function setModuleFactory(IModuleFactory $factory)
    {
        $this->moduleFactory = $factory;
    }

    protected function createQuery(): ItemQuery
    {
        $query = new $this->conf['itemQuery'];
        $tableName = $this->moduleFactory->getSetting(IModuleFactory::OBJECTS_TABLE);
        $query->setTableName($tableName);
        return $query;
    }

    public function getStorage():ItemStorage
    {
        if($this->storage === null){
            $this->storage = new $this->conf['itemStorage'];
            $query = $this->createQuery();
            $this->storage->setObjectsQuery($query);
            $dirStorage = $this->moduleFactory->getDirsTreeFactory()->getInfrastructureFactory()->getStorage();
            $this->storage->setDirStorage($dirStorage);
        }
        return $this->storage;
    }

    public function getPersistLayer():ItemPersistLayer
    {
        if($this->persistLayer === null){
            $this->persistLayer = new $this->conf['itemPersistLayer'];
            $tableName = $this->moduleFactory->getSetting(IModuleFactory::OBJECTS_TABLE);
            $this->persistLayer->setTableName($tableName);
        }
        return $this->persistLayer;
    }

    public function getMigrations(): Migrations
    {
        if($this->migration === null){
            $this->migration = new Migrations();
            $settings = $this->moduleFactory->getSettings();
            $this->migration->init($settings);
        }
        return $this->migration;
    }

}