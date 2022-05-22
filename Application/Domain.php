<?php

namespace Src\Modules\JsonObjects\Application;

use Src\Common\Application\TraitDomain;
use Src\Common\Application\ResponsesCode;
use Src\Modules\JsonObjects\Interfaces\Application\IDomain;
use Src\Modules\JsonObjects\Interfaces\Application\IValidator;
use Src\Modules\JsonObjects\Interfaces\Dto\IFactory as IDtoFactory;
use Src\Modules\JsonObjects\Interfaces\Dto\Item\IResourceItem;
use Src\Modules\JsonObjects\Interfaces\Infrastructure\IItemPersistLayer;
use Src\Modules\JsonObjects\Interfaces\Infrastructure\IItemStorage;
use Src\Modules\JsonObjects\Interfaces\Application\IDataBuilder;
use Src\Lib\CategoriesTree\Interfaces\Application\IValidator as IDirValidator;
use Src\Lib\CategoriesTree\Interfaces\Application\IDomain as IDirDomain;
use Src\Lib\CategoriesTree\Interfaces\Infrastructure\IStorage as IDirStorage;

class Domain implements IDomain {

    use TraitDomain;

    protected IValidator $validator;

    protected IDtoFactory $dtoFactory;

    protected IItemPersistLayer $persistLayer;

    protected IItemStorage $storage;

    protected IResourceItem $item;

    protected IDataBuilder $dataBuilder;

    protected IDirValidator $dirValidator;

    protected IDirDomain $dirDomain;

    protected IDirStorage $dirStorage;

    public function setValidator(IValidator $validator):void
    {
        $this->validator = $validator;
    }

    public function setDtoFactory(IDtoFactory $factory):void
    {
        $this->dtoFactory = $factory;
    }

    public function setPersistLayer(IItemPersistLayer $layer):void
    {
        $this->persistLayer = $layer;
    }

    public function setStorage(IItemStorage $storage):void
    {
        $this->storage = $storage;
    }

    public function setDataBuilder(IDataBuilder $dataBuilder):void
    {
        $this->dataBuilder = $dataBuilder;
    }

    public function setDirValidator(IDirValidator $validator):void
    {
        $this->dirValidator = $validator;
    }

    public function setDirDomain(IDirDomain $domain):void
    {
        $this->dirDomain = $domain;
    }

    public function setDirStorage(IDirStorage $storage):void
    {
        $this->dirStorage = $storage;
    }

    public function createObject(array $data):bool
    {
        $this->item = $this->dtoFactory->getItemFactory()->createResource();
        if($this->validator->createObject($data)){
            $cleanData = $this->validator->getCleanData();
            $fullData = $this->dataBuilder->build($cleanData);
            $item = $this->dtoFactory->getItemFactory()->createPersist();
            $item->load($fullData);
            $this->item->load($item->getAttributes());
            if($this->item->validate()){
                $this->persistLayer->create($item);
                $this->item->getObject()->onSave();
                return true;
            }
            $this->responseCode = ResponsesCode::VALIDATION_FAILED_CODE;
            return false;
        }else{
            $this->errors = $this->validator->getErrors();
            $this->responseCode = ResponsesCode::VALIDATION_FAILED_CODE;
            return false;
        }
    }

    public function editObject(array $data):bool
    {
        $this->item = $this->dtoFactory->getItemFactory()->createResource();
        if($this->validator->editObject($data)){
            $cleanData = $this->validator->getCleanData();
            $itemData = $this->storage->getById($cleanData['id']);
            $item = $this->dtoFactory->getItemFactory()->createPersist();
            $item->load($itemData);
            $item->update($cleanData);
            $this->item->load($item->getAttributes());
            if($this->item->validate()){
                $this->persistLayer->update($item);
                $this->item->getObject()->onSave();
                return true;
            }
            $this->responseCode = ResponsesCode::VALIDATION_FAILED_CODE;
            return false;
        }else{
            $this->errors = $this->validator->getErrors();
            $this->responseCode = ResponsesCode::VALIDATION_FAILED_CODE;
            return false;
        }
    }

    public function renameObject(array $data):bool
    {
        $this->item = $this->dtoFactory->getItemFactory()->createResource();
        if($this->validator->renameObject($data)){
            $cleanData = $this->validator->getCleanData();
            $itemData = $this->storage->getById($cleanData['id']);
            $item = $this->dtoFactory->getItemFactory()->createPersist();
            $item->load($itemData);
            $item->update($cleanData);
            $this->persistLayer->update($item);
            $this->item->load($item->getAttributes());
            return true;
        }else{
            $this->errors = $this->validator->getErrors();
            $this->responseCode = ResponsesCode::VALIDATION_FAILED_CODE;
            return false;
        }
    }

    public function deleteObject(array $data):bool
    {
        if($this->validator->deleteObject($data)){
            $cleanData = $this->validator->getCleanData();
            $itemData = $this->storage->getById($cleanData['id']);
            if(!$itemData['disabled']){
                $this->persistLayer->delete($cleanData['id']);
                return true;
            }
            return false;
        }else{
            $this->errors = $this->validator->getErrors();
            $this->responseCode = ResponsesCode::VALIDATION_FAILED_CODE;
            return false;
        }
    }

    public function deleteDir(array $data):bool
    {
        if($this->dirValidator->deleteDir($data)){
            $cleanData = $this->dirValidator->getCleanData();
            $dirIds = $this->dirStorage->getIdsInDir($cleanData['id']);
            $dirIds[] = $cleanData['id'];
            $this->persistLayer->deleteInDirs($dirIds);
            $this->dirDomain->deleteDir($data);
            return true;
        }else{
            $this->errors = $this->dirValidator->getErrors();
            $this->responseCode = ResponsesCode::VALIDATION_FAILED_CODE;
            return false;
        }
    }

    public function getItem():IResourceItem
    {
        return $this->item;
    }

}