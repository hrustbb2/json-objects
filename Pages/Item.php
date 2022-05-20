<?php

namespace Src\Modules\JsonObjects\Pages;

use Src\Common\Pages\Page;
use Src\Modules\JsonObjects\Interfaces\Pages\IItem;
use Src\Modules\JsonObjects\Interfaces\Infrastructure\IItemStorage;
use Src\Modules\JsonObjects\Interfaces\Dto\Item\IFactory as IItemDtoFactory;
use Src\Modules\JsonObjects\Interfaces\Dto\Item\IResourceItem;

class Item extends Page implements IItem {

    protected IItemStorage $itemStorage;

    protected IItemDtoFactory $itemDtoFactory;

    protected IResourceItem $item;

    public function setItemStorage(IItemStorage $storage)
    {
        $this->itemStorage = $storage;
    }

    public function setItemDtoFactory(IItemDtoFactory $factory)
    {
        $this->itemDtoFactory = $factory;
    }

    public function init(string $itemId)
    {
        $this->item = $this->itemDtoFactory->createResource();
        $dsl = [
            '*',
            'dir' => ['*', 'path' => ['*'], 'parent' => ['*']],
        ];
        $itemData = $this->itemStorage->getById($itemId, $dsl);
        $this->item->load($itemData);
    }

    public function getItem():IResourceItem
    {
        return $this->item;
    }
    
    public function getCssStack():array
    {
        return [
            '<link rel="stylesheet" href="/admin-css/json-objects-item.css?' . self::CSS_VERSION . '">',
        ];
    }

    public function getJsStack():array
    {
        return [
            '<script src="/admin-js/json-objects-item.js?' . self::JS_VERSION . '"></script>',
        ];
    }

    public function getJsSettings():array
    {
        return [
            'fileInputSettings' => [
                'getDirUrl' => $this->routeAdapter->getRoute('admin.common.filesBrowser.dir'),
                'deleteFileUrl' => $this->routeAdapter->getRoute('admin.common.filesBrowser.deleteFile'),
                'renameFileUrl' => $this->routeAdapter->getRoute('admin.common.filesBrowser.renameFile'),
                'createDirUrl' => $this->routeAdapter->getRoute('admin.common.filesBrowser.createDir'),
                'uploadFileUrl' => $this->routeAdapter->getRoute('admin.common.filesBrowser.uploadFile'),
            ],
            'item' => $this->item->toArray(),
            'editObjUrl' => $this->routeAdapter->getRoute('admin.jsonObjects.editItem'),
            'successUrl' => $this->routeAdapter->getRoute('admin.jsonObjects.dir', ['dir-id' => $this->item->getDir()->getId()]),
        ];
    }

    public function getTitle():string
    {
        return '';
    }

    public function getBreadcrumbs():array
    {
        $bc = [
            [
                'title' => 'jsonObjects',
                'href' => $this->routeAdapter->getRoute('admin.jsonObjects.dir'),
            ],
        ];
        foreach($this->item->getDir()->getPath() as $pathItem){
            $bc[] = [
                'title' => $pathItem->getName(),
                'href' => $this->routeAdapter->getRoute('admin.jsonObjects.dir', ['dir-id' => $pathItem->getId()]),
            ];
        }
        if($this->item->getDir()->getParent()){
            $bc[] = [
                'title' => $this->item->getDir()->getParent()->getName(),
                'href' => $this->routeAdapter->getRoute('admin.jsonObjects.dir', ['dir-id' => $this->item->getDir()->getParent()->getId()]),
            ];
        }  
        $bc[] = [
            'title' => $this->item->getName(),
            'href' => $this->routeAdapter->getRoute('admin.jsonObjects.editItem', ['item-id' => $this->item->getId()]),
        ];
        return $bc;
    }

}