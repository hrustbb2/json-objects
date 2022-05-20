<?php

namespace Src\Modules\JsonObjects\Pages;

use Src\Common\Pages\Page;
use Src\Modules\JsonObjects\Interfaces\Pages\IDir;
use Src\Lib\CategoriesTree\Interfaces\Infrastructure\IStorage as IDirsStorage;
use Src\Lib\CategoriesTree\Interfaces\Dto\IFactory as IDirsDtoFactory;
use Src\Lib\CategoriesTree\Interfaces\Dto\IResource as IDirResource;
use Src\Modules\JsonObjects\Interfaces\Infrastructure\IItemStorage;
use Src\Modules\JsonObjects\Interfaces\Dto\Item\IFactory as IItemDtoFactory;
use Src\Modules\JsonObjects\Interfaces\Dto\Item\IResourceItem;

class Dir extends Page implements IDir {

    protected IItemStorage $itemSorage;

    protected IItemDtoFactory $itemDtoFactory;

    /**
     * @var IResourceItem
     */
    protected array $items = [];
    
    protected IDirsStorage $dirsStorage;

    protected IDirsDtoFactory $dirsDtoFactory;

    /**
     * @var IDirResource[]
     */
    protected array $dirs = [];

    protected IDirResource $currentDir;

    protected array $itemsDropdown = [];

    public function setDirsStorage(IDirsStorage $storage):void
    {
        $this->dirsStorage = $storage;
    }

    public function setDirsDtoFactory(IDirsDtoFactory $factory):void
    {
        $this->dirsDtoFactory = $factory;
    }

    public function setItemStorage(IItemStorage $storage):void
    {
        $this->itemSorage = $storage;
    }

    public function setItemDtoFactory(IItemDtoFactory $factory):void
    {
        $this->itemDtoFactory = $factory;
    }

    public function setItemsDropdown(array $dropDown):void
    {
        $this->itemsDropdown = $dropDown;
    }
    
    public function init(string $currentDirId):void
    {
        $this->currentDir = $this->dirsDtoFactory->createResource();
        $currentDirData = $this->dirsStorage->getById($currentDirId, ['*', 'path' => ['*'], 'parent' => ['*']]);
        $this->currentDir->load($currentDirData);
        $dirsData = $this->dirsStorage->getByParentId($currentDirId);
        foreach($dirsData as $dirData){
            $dir = $this->dirsDtoFactory->createResource();
            $dir->load($dirData);
            $this->dirs[$dir->getId()] = $dir;
        }
        $itemsData = $this->itemSorage->getByDirId($currentDirId);
        foreach($itemsData as $data){
            $item = $this->itemDtoFactory->createResource();
            $item->load($data);
            $this->items[$item->getId()] = $item;
        }   
    }
    
    public function getCssStack():array
    {
        return [
            '<link rel="stylesheet" href="/admin-css/json-objects-dir.css?' . self::CSS_VERSION . '">',
        ];
    }

    public function getJsStack():array
    {
        return [
            '<script src="/admin-js/json-objects-dir.js?' . self::JS_VERSION . '"></script>',
        ];
    }

    public function getJsSettings():array
    {
        $dirs = array_map(function(IDirResource $dir){
            return $dir->toArray(['id', 'name']);
        }, $this->dirs);
        $items = array_map(function(IResourceItem $item){
            return $item->toArray(['id', 'name']);
        }, $this->items);
        return [
            'currentId' => $this->currentDir->getId(),
            'dirs' => $dirs,
            'items' => $items,
            'url' => $this->routeAdapter->getRoute('admin.jsonObjects.dir'),
            'itemUrl' => $this->routeAdapter->getRoute('admin.jsonObjects.item'),
            'newDirUrl' => $this->routeAdapter->getRoute('admin.jsonObjects.newDir'),
            'newItemUrl' => $this->routeAdapter->getRoute('admin.jsonObjects.newItem'),
            'renameItemUrl' => $this->routeAdapter->getRoute('admin.jsonObjects.renameItem'),
            'deleteItemUrl' => $this->routeAdapter->getRoute('admin.jsonObjects.deleteItem'),
            'renameDirUrl' => $this->routeAdapter->getRoute('admin.jsonObjects.renameDir'),
            'deleteDirUrl' => $this->routeAdapter->getRoute('admin.jsonObjects.deleteDir'),
        ];
    }

    public function getTitle():string
    {
        return 'JSON Objects';
    }

    public function getBreadcrumbs():array
    {
        $bc = [
            [
                'title' => 'jsonObjects',
                'href' => $this->routeAdapter->getRoute('admin.jsonObjects.dir'),
            ],
        ];
        foreach($this->currentDir->getPath() as $pathItem){
            $bc[] = [
                'title' => $pathItem->getName(),
                'href' => $this->routeAdapter->getRoute('admin.jsonObjects.dir', ['dir-id' => $pathItem->getId()]),
            ];
        }
        if($this->currentDir->getParent()){
            $bc[] = [
                'title' => $this->currentDir->getParent()->getName(),
                'href' => $this->routeAdapter->getRoute('admin.jsonObjects.dir', ['dir-id' => $this->currentDir->getParent()->getId()]),
            ];
        }   
        return $bc;
    }

    public function getItemsDropdown():array
    {
        return $this->itemsDropdown;
    }

}