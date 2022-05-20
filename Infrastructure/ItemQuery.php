<?php

namespace Src\Modules\JsonObjects\Infrastructure;

use Src\Modules\JsonObjects\Interfaces\Infrastructure\IItemQuery;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Src\Common\Infrastructure\TraitSqlQuery;
use hrustbb2\arrayproc\ArrayProcessor;

class ItemQuery implements IItemQuery {

    use TraitSqlQuery;

    protected string $tableName;

    protected Builder $queryBuilder;

    protected array $arrayProcConf = [];

    public function setTableName(string $tableName)
    {
        $this->tableName = $tableName;
    }

    public function select(array $fields = [])
    {
        $this->queryBuilder = DB::table($this->tableName);
        $select = $this->getSelectSection($fields, ['id', 'dir_id', 'key', 'name', 'description', 'object', 'disabled'], $this->tableName, 'object_');
        $this->queryBuilder->select($select);
        $this->arrayProcConf = ['prefix' => 'object_'];
        return $this;
    }

    public function whereId(string $id)
    {
        $this->queryBuilder->where($this->tableName . '.id', '=', $id);
        return $this;
    }

    public function getByKey(string $key)
    {
        $this->queryBuilder->where($this->tableName . '.key', '=', $key);
        return $this;
    }

    public function whereKey(string $key)
    {
        $this->queryBuilder->where($this->tableName . '.key', '=', $key);
        return $this;
    }

    public function whereDirId(string $dirId)
    {
        $this->queryBuilder->where($this->tableName . '.dir_id', '=', $dirId);
        return $this;
    }

    public function all(): array
    {
        $arrayProc = new ArrayProcessor();
        $data = $this->queryBuilder->get()->toArray();
        return $arrayProc->process($this->arrayProcConf, $data)->resultArray();
    }

    public function one(): array
    {
        $arrayProc = new ArrayProcessor();
        $data = $this->queryBuilder->get()->toArray();
        $d = $arrayProc->process($this->arrayProcConf, $data)->resultArray();
        return array_pop($d) ?? [];
    }

}