<?php

namespace Src\Modules\JsonObjects\Dto;

use Src\Modules\JsonObjects\Interfaces\Dto\IFactory;
use Src\Modules\JsonObjects\Interfaces\IFactory as IModulesFactory;
use Src\Modules\JsonObjects\Interfaces\Dto\Item\IFactory as IItemFactory;
use Src\Modules\JsonObjects\Dto\Item\Factory as ItemFactory;

class Factory implements IFactory {

    protected IModulesFactory $modulesFactory;

    protected ?IItemFactory $itemFactory = null;

    protected array $conf;

    public function init(array $conf = []): void
    {
        $this->conf = [
            'item' => [
                'factory' => ItemFactory::class,
            ],
        ];
        $this->conf = array_merge_recursive($this->conf, $conf);
    }

    public function setModulesFactory(IModulesFactory $factory)
    {
        $this->modulesFactory = $factory;
    }

    public function getModulesFactory():IModulesFactory
    {
        return $this->modulesFactory;
    }

    public function getItemFactory():ItemFactory
    {
        if($this->itemFactory === null){
            $this->itemFactory = new $this->conf['item']['factory'];
            $this->itemFactory->init($this->conf['item']);
            $this->itemFactory->setDtoFactory($this);
        }
        return $this->itemFactory;
    }

}