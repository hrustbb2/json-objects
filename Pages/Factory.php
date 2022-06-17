<?php

namespace Src\Modules\JsonObjects\Pages;

use Src\Modules\JsonObjects\Interfaces\Pages\IFactory;
use Src\Modules\JsonObjects\Interfaces\IFactory as IModuleFactory;
use Src\Modules\JsonObjects\Interfaces\Pages\IDir;
use Src\Modules\JsonObjects\Interfaces\Pages\IItem;

class Factory implements IFactory {

    protected IModuleFactory $moduleFactory;

    protected array $conf;

    public function init(array $conf = []): void
    {
        $this->conf = [
            'dir' => Dir::class,
            'item' => Item::class,
        ];
        $this->conf = array_replace_recursive($this->conf, $conf);
    }

    public function setModuleFactory(IModuleFactory $factory)
    {
        $this->moduleFactory = $factory;
    }

    public function createDirPage(string $currentDirId):Dir
    {
        $page = new $this->conf['dir'];
        $sidebarMenu = $this->moduleFactory->getSidebarFactory()->getMenu();
        $page->setSidebar($sidebarMenu);
        $dirsStorage = $this->moduleFactory->getDirsTreeFactory()->getInfrastructureFactory()->getStorage();
        $page->setDirsStorage($dirsStorage);
        $dirsDtoFactory = $this->moduleFactory->getDirsTreeFactory()->getDtoFactory();
        $page->setDirsDtoFactory($dirsDtoFactory);
        $itemStorage = $this->moduleFactory->getInfrastructureFactory()->getStorage();
        $page->setItemStorage($itemStorage);
        $itemDtoFactory = $this->moduleFactory->getDtoFactory()->getItemFactory();
        $page->setItemDtoFactory($itemDtoFactory);
        $routeAdapter = $this->moduleFactory->getCommonFactory()->getAdaptersFactory()->getRoute();
        $page->setRouteAdapter($routeAdapter);
        $itemsDropdown = $this->moduleFactory->getSetting(IModuleFactory::ITEMS_DROPDOWN);
        $page->setItemsDropdown($itemsDropdown);
        $page->init($currentDirId);
        return $page;
    }

    public function createItemPage(string $itemId):Item
    {
        $page = new $this->conf['item'];
        $sidebarMenu = $this->moduleFactory->getSidebarFactory()->getMenu();
        $page->setSidebar($sidebarMenu);
        $itemStorage = $this->moduleFactory->getInfrastructureFactory()->getStorage();
        $page->setItemStorage($itemStorage);
        $itemDtoFactory = $this->moduleFactory->getDtoFactory()->getItemFactory();
        $page->setItemDtoFactory($itemDtoFactory);
        $routeAdapter = $this->moduleFactory->getCommonFactory()->getAdaptersFactory()->getRoute();
        $page->setRouteAdapter($routeAdapter);
        $page->init($itemId);
        return $page;
    }

}