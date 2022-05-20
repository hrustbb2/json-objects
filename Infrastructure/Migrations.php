<?php

namespace Src\Modules\JsonObjects\Infrastructure;

use Src\Modules\JsonObjects\Interfaces\Infrastructure\IMigrations;
use hrustbb2\Migrations\JSONManager;
use hrustbb2\Migrations\Interfaces\IManager;
use Src\Modules\JsonObjects\Interfaces\IFactory as IModuleFactory;
use hrustbb2\Migrations\MigrationCreator;
use hrustbb2\Migrations\Interfaces\IMigrationCreator;

class Migrations implements IMigrations
{

    protected IManager $manager;

    protected IMigrationCreator $creator;

    public function init(array $settings): void
    {
        $this->manager = new JSONManager();
        $this->manager->setDbHost($settings[IModuleFactory::DB_HOST]);
        $this->manager->setDbName($settings[IModuleFactory::DB_NAME]);
        $this->manager->setDbPassword($settings[IModuleFactory::DB_PASS]);
        $this->manager->setDbUser($settings[IModuleFactory::DB_USER]);
        $this->manager->setMigrationPath(__DIR__ . '/../migrations');
        $this->manager->setSettings($settings);
        $this->manager->init();

        $this->creator = new MigrationCreator();
        $this->creator->setMigrationPath(__DIR__ . '/../migrations');
    }

    public function create(): void
    {
        $this->creator->create('Migration');
    }

    public function migrate(): void
    {
        $migrations = $this->manager->getNewMigrations();
        $this->manager->migrate($migrations);
    }

    public function rollback(): void
    {
        $this->manager->rollback();
    }

}
