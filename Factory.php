<?php

namespace Src\Modules\JsonObjects;

use Src\Modules\JsonObjects\Interfaces\IFactory;
use Src\Modules\JsonObjects\Interfaces\IModulesProvider;
use Src\Lib\CategoriesTree\Interfaces\IFactory as IDirsTreeFactory;
use Src\Sidebar\Interfaces\IFactory as ISidebarFactory;
use Src\Common\Interfaces\IFactory as ICommonFactory;
use Src\Modules\JsonObjects\Interfaces\Dto\IFactory as IDtoFactory;
use Src\Modules\JsonObjects\Dto\Factory as DtoFactory;
use Src\Modules\JsonObjects\Interfaces\Pages\IFactory as IPagesFactory;
use Src\Modules\JsonObjects\Pages\Factory as PagesFactory;
use Src\Modules\JsonObjects\Interfaces\Infrastructure\IFactory as IInfrastructureFactory;
use Src\Modules\JsonObjects\Infrastructure\Factory as InfrastructureFactory;
use Src\Modules\JsonObjects\Interfaces\Application\IFactory as IApplicationFactory;
use Src\Modules\JsonObjects\Application\Factory as ApplicationFactory;

class Factory implements IFactory {

    protected IDirsTreeFactory $dirsTreeFactory;

    protected ISidebarFactory $sidebarFactory;

    protected ICommonFactory $commonFactory;
    
    protected ?IDtoFactory $dtoFactory = null;

    protected ?IPagesFactory $pagesFactory = null;

    protected ?IApplicationFactory $applicationFactory = null;

    protected ?IInfrastructureFactory $infrastructureFactory = null;

    protected array $settings = [];

    protected array $conf;

    public function init(array $conf = []): void
    {
        $this->conf = [
            IDtoFactory::class => [
                'class' => DtoFactory::class,
                'conf' => [],
            ],
            IPagesFactory::class => [
                'class' => PagesFactory::class,
                'conf' => [],
            ],
            IInfrastructureFactory::class => [
                'class' => InfrastructureFactory::class,
                'conf' => [],
            ],
            IApplicationFactory::class => [
                'class' => ApplicationFactory::class,
                'conf' => [],
            ],
        ];
        $this->conf = array_replace($this->conf, $conf);
    }

    public function injectModules(IModulesProvider $provider)
    {
        $this->sidebarFactory = $provider->getSidebarFactory();
        $this->commonFactory = $provider->getCommonFactory();
    }

    public function getSidebarFactory():ISidebarFactory
    {
        return $this->sidebarFactory;
    }

    public function getCommonFactory():ICommonFactory
    {
        return $this->commonFactory;
    }

    public function setDirsTreeFactory(IDirsTreeFactory $factory)
    {
        $this->dirsTreeFactory = $factory;
    }

    public function getDirsTreeFactory():IDirsTreeFactory
    {
        return $this->dirsTreeFactory;
    }

    public function loadSettings(array $settings)
    {
        $this->settings = $settings;
    }

    public function getSetting(string $key)
    {
        return $this->settings[$key];
    }

    public function getSettings(): array
    {
        return $this->settings;
    }

    public function getDtoFactory():DtoFactory
    {
        if($this->dtoFactory === null){
            $this->dtoFactory = new $this->conf[IDtoFactory::class]['class'];
            $this->dtoFactory->init($this->conf[IDtoFactory::class]['conf']);
            $this->dtoFactory->setModulesFactory($this);
        }
        return $this->dtoFactory;
    }

    public function getPagesFactory():PagesFactory
    {
        if($this->pagesFactory === null){
            $this->pagesFactory = new $this->conf[IPagesFactory::class]['class'];
            $this->pagesFactory->init($this->conf[IPagesFactory::class]['conf']);
            $this->pagesFactory->setModuleFactory($this);
        }
        return $this->pagesFactory;
    }

    public function getInfrastructureFactory():InfrastructureFactory
    {
        if($this->infrastructureFactory === null){
            $this->infrastructureFactory = new $this->conf[IInfrastructureFactory::class]['class'];
            $this->infrastructureFactory->init($this->conf[IInfrastructureFactory::class]['conf']);
            $this->infrastructureFactory->setModuleFactory($this);
        }
        return $this->infrastructureFactory;
    }

    public function getApplicationFactory():ApplicationFactory
    {
        if($this->applicationFactory === null){
            $this->applicationFactory = new $this->conf[IApplicationFactory::class]['class'];
            $this->applicationFactory->init($this->conf[IApplicationFactory::class]['conf']);
            $this->applicationFactory->setModuleFactory($this);
        }
        return $this->applicationFactory;
    }

}