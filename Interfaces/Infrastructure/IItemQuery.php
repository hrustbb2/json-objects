<?php

namespace Src\Modules\JsonObjects\Interfaces\Infrastructure;

use Src\Common\Interfaces\Infrastructure\IQueryBase;

interface IItemQuery extends IQueryBase {
    /**
     * @return $this
     */
    public function select(array $fields = []);
    /**
     * @return $this
     */
    public function whereId(string $id);
    /**
     * @return $this
     */
    public function getByKey(string $key);
    /**
     * @return $this
     */
    public function whereKey(string $key);
    /**
     * @return $this
     */
    public function whereDirId(string $dirId);
}