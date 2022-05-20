# Модуль для хранения различных данных в БД в виде JSON объектов.

Некоторые статические данные, например, такие как контактные данные, различные настройки, тексты различных соглашений (условия доставки, политика конфеденциальности) и т.п. удобно хранить в виде json.

Для того, чтобы максимально удобно работать с такими данными, добавлять, редактировать их предназначен данный модуль.

Клонируем: ```git clone https://github.com/hrustbb2/json-objects.git ./src/Modules/JsonObjects```

Подключение в ```ModulesProvider.php```:
```
use Src\Common\Interfaces\IModulesProvider as ICommonProvider;
use Src\Common\Interfaces\IFactory as ICommonFactory;
use Src\Common\Factory as CommonFactory;
use Src\Sidebar\Interfaces\IModulesProvider as ISidebarProvider;
use Src\Sidebar\Interfaces\IFactory as ISidebarFactory;
use Src\Sidebar\Factory as SidebarFactory;
use Src\Modules\JsonObjects\Interfaces\IModulesProvider as IJSONProvider;
use Src\Modules\JsonObjects\Interfaces\IFactory as IJSONFactory;
use Src\Modules\JsonObjects\Factory as JSONFactory;
use Src\Lib\CategoriesTree\Interfaces\IFactory as IDirTreeFactory;
use Src\Lib\CategoriesTree\Factory as DirTreeFactory;

class ModulesProvider implements IJSONProvider {

    protected ?ICommonFactory $commonFactory = null;

    protected ?ISidebarFactory $sidebarFactory = null;

    protected ?IJSONFactory $jsonFactory = null;

    public function getSidebarFactory(): SidebarFactory
    {
        if($this->sidebarFactory === null){
            $this->sidebarFactory = new SidebarFactory();
            $this->sidebarFactory->init();
            $this->sidebarFactory->injectModules($this);
        }
        return $this->sidebarFactory;
    }

    public function getCommonFactory(): CommonFactory
    {
        if($this->commonFactory === null){
            $this->commonFactory = new CommonFactory();
            $this->commonFactory->init();
            $this->commonFactory->setFrameworkName(ICommonFactory::LARAVEL);
        }
        return $this->commonFactory;
    }

    protected function createDirTreeFactory(string $dirsTable): DirTreeFactory
    {
        $factory = new DirTreeFactory();
        $factory->loadSettings([
            IDirTreeFactory::DB_CHARSET => 'utf8',
            IDirTreeFactory::DB_HOST => 'db',
            IDirTreeFactory::DB_NAME => 'dbname',
            IDirTreeFactory::DB_PASS => 'password',
            IDirTreeFactory::DB_USER => 'user',
            IDirTreeFactory::TABLE_NAME => $dirsTable,
        ]);
        $factory->init();
        $factory->setCommonFactory($this->getCommonFactory());
        return $factory;
    }

    public function getJsonObjectsFactory(): JSONFactory
    {
        if($this->jsonFactory === null){
            $this->jsonFactory = new JSONFactory();
            $this->jsonFactory->init();
            $objFactory = new \Src\Common\Dto\Object\Factory();
            $this->jsonFactory->loadSettings([
                IJSONFactory::DB_CHARSET => 'utf8',
                IJSONFactory::DB_HOST => 'db',
                IJSONFactory::DB_NAME => 'dbname',
                IJSONFactory::DB_PASS => 'password',
                IJSONFactory::DB_USER => 'user',
                IJSONFactory::ITEMS_DROPDOWN => [
                    [
                        IJSONFactory::ITEM_TITLE => 'Example',
                        IJSONFactory::ITEM_TYPE => \Src\Common\Dto\Object\ExampleComposit::EXAMPLE_COMPOSIT,
                    ]
                ],
                IJSONFactory::OBJECTS_FACTORY => $objFactory,
                IJSONFactory::OBJECTS_TABLE => 'json_obj_items',
            ]);
            $dirTreeFactory = $this->createDirTreeFactory('json_obj_dirs');
            $this->jsonFactory->setDirsTreeFactory($dirTreeFactory);
            $this->jsonFactory->injectModules($this);
        }
        return $this->jsonFactory;
    }

}
```
Подключение в routes/web.php (для Laravel)
```
require __DIR__ . '/../src/Modules/JsonObjects/Laravel/routes.php';
```
Подключение в routes/console.php (для Laravel)
```
require __DIR__ . '/../src/Modules/JsonObjects/Laravel/console.php';
```
После того как подключили необходимо установить пакеты:
```
composer required hrustbb2/arrayproc
composer required hrustbb2/migrations
```
И накатить миграции
```
php artisan json-objects-migrate
```

Пример настройки объекта [здесь](https://github.com/hrustbb2/common-src/blob/master/Common/Dto/Object/ExampleComposit.php "https://github.com/hrustbb2/common-src/blob/master/Common/Dto/Object/ExampleComposit.php")