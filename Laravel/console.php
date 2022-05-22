<?php

use Illuminate\Support\Facades\Artisan;
use App\Providers\AppServiceProvider;
use Src\Modules\JsonObjects\Interfaces\IFactory as IModuleFactory;

Artisan::command('json-objects-migrate', function () {
    /** @var IModuleFactory */
    $factory = app()->get(AppServiceProvider::ADMIN_MODULES)->getJsonObjectsFactory();

    $migrations = $factory->getInfrastructureFactory()->getMigrations();
    $migrations->migrate();
});