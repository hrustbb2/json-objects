<?php

namespace Src\Modules\JsonObjects\Application;

use Src\Modules\JsonObjects\Interfaces\Application\IFactory;
use Src\Modules\JsonObjects\Interfaces\IFactory as IModuleFactory;
use Src\Modules\JsonObjects\Interfaces\Application\IValidator;
use Src\Modules\JsonObjects\Interfaces\Application\IDomain;
use Src\Modules\JsonObjects\Interfaces\Application\IDataBuilder;

class Factory implements IFactory {

    protected IModuleFactory $moduleFactory;

    protected ?IDomain $domain = null;

    protected array $conf;

    public function init(array $conf = []): void
    {
        $this->conf = [
            'validator' => Validator::class,
            'dataBuilder' => DataBuilder::class,
            'domain' => Domain::class,
        ];
        $this->conf = array_replace_recursive($this->conf, $conf);
    }

    public function setModuleFactory(IModuleFactory $factorory):void
    {
        $this->moduleFactory = $factorory;
    }

    protected function createValidator(): Validator
    {
        return new $this->conf['validator'];
    }

    protected function creteDataBuilder(): DataBuilder
    {
        $dataBuilder = new $this->conf['dataBuilder'];
        $storage = $this->moduleFactory->getDirsTreeFactory()->getInfrastructureFactory()->getStorage();
        $dataBuilder->setDirStorage($storage);
        return $dataBuilder;
    }

    public function getDomain(): Domain
    {
        if($this->domain === null){
            $this->domain = new $this->conf['domain'];
            $validator = $this->createValidator();
            $this->domain->setValidator($validator);
            $dtoFactory = $this->moduleFactory->getDtoFactory();
            $this->domain->setDtoFactory($dtoFactory);
            $persistLayer = $this->moduleFactory->getInfrastructureFactory()->getPersistLayer();
            $this->domain->setPersistLayer($persistLayer);
            $storage = $this->moduleFactory->getInfrastructureFactory()->getStorage();
            $this->domain->setStorage($storage);
            $dataBuilder = $this->creteDataBuilder();
            $this->domain->setDataBuilder($dataBuilder);
            $dirValidator = $this->moduleFactory->getDirsTreeFactory()->getApplicationFactory()->createValidator();
            $this->domain->setDirValidator($dirValidator);
            $dirDomain = $this->moduleFactory->getDirsTreeFactory()->getApplicationFactory()->getDomain();
            $this->domain->setDirDomain($dirDomain);
            $dirStorage = $this->moduleFactory->getDirsTreeFactory()->getInfrastructureFactory()->getStorage();
            $this->domain->setDirStorage($dirStorage);
        }
        return $this->domain;
    }

}