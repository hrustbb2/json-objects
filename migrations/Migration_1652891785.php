<?php

use Phinx\Db\Table;
use hrustbb2\Migrations\AbstractMigrate;
use Src\Modules\JsonObjects\Interfaces\IFactory as IModuleFactory;
use App\Providers\AppServiceProvider;
use Src\Modules\JsonObjects\Interfaces\IFactory;

class Migration_1652891785 extends AbstractMigrate
{
    public function up(array $settings): void
    {
        $table = new Table($settings[IModuleFactory::OBJECTS_TABLE], ['id' => false, 'primary_key' => ['id']], $this->adapter);
        $table  ->addColumn('id', 'string')
                ->addColumn('dir_id', 'string')
                ->addColumn('key', 'string')
                ->addColumn('name', 'string')
                ->addColumn('description', 'string', ['null' => true])
                ->addColumn('object', 'json')
                ->addColumn('disabled', 'integer', ['default' => 0])
                ->create();

        /** @var IFactory */
        $factory = app(AppServiceProvider::ADMIN_MODULES)->getJsonObjectsFactory();
        $item = $factory->getDtoFactory()->getItemFactory()->createPersist(\Src\Common\Dto\Object\ExampleComposit::EXAMPLE_COMPOSIT);
        $item->load(['key' => 'key', 'name' => 'name']);
        $attrs = $item->getInsertAttrs();
        $table->insert($attrs)->save();
    }

    public function down(array $settings): void
    {
        $table = new Table($settings[IModuleFactory::OBJECTS_TABLE], ['id' => false, 'primary_key' => ['id']], $this->adapter);
        $table->drop()->save();
    }
}
