<?php

namespace Src\Modules\JsonObjects\Laravel\Controllers;

use Illuminate\Routing\Controller;
use App\Providers\AppServiceProvider;
use Src\Modules\JsonObjects\Interfaces\IFactory as IModuleFactory;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class DirController extends Controller {

    /**
     * @var IModuleFactory
     */
    private $factory;

    public function __construct()
    {
        View::getFinder()
            ->setPaths([
                base_path() . '/src/Modules/JsonObjects/Laravel/Views',
            ]);
        $this->factory = app()->get(AppServiceProvider::ADMIN_MODULES)->getJsonObjectsFactory();
    }

    public function dir(Request $request)
    {
        $dirId = $request->get('dir-id') ?? '';
        $page = $this->factory->getPagesFactory()->createDirPage($dirId);
        return view('dir', ['page' => $page]);
    }

    public function newDir(Request $request)
    {
        $domain = $this->factory->getDirsTreeFactory()->getApplicationFactory()->getDomain();
        $data = $request->all();
        $resp = [
            'success' => $domain->createDir($data),
            'errors' => $domain->getErrors(),
            'dir' => $domain->getDir()->toArray(['id', 'name']),
        ];
        return response()->json($resp, $domain->getResponseCode());
    }

    public function renameDir(Request $request)
    {
        $domain = $this->factory->getDirsTreeFactory()->getApplicationFactory()->getDomain();
        $data = $request->all();
        $resp = [
            'success' => $domain->renameDir($data),
            'errors' => $domain->getErrors(),
            'dir' => $domain->getDir()->toArray(['id', 'name']),
        ];
        return response()->json($resp, $domain->getResponseCode());
    }

    public function deleteDir(Request $request)
    {
        $domain = $this->factory->getApplicationFactory()->getDomain();
        $data = $request->all();
        $resp = [
            'success' => $domain->deleteDir($data),
            'errors' => $domain->getErrors(),
        ];
        return response()->json($resp, $domain->getResponseCode());
    }

}