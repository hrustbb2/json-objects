<?php

namespace Src\Modules\JsonObjects\Interfaces\Infrastructure;

interface IMigrations
{
    public function init(array $settings): void;
    public function create(): void;
    public function migrate(): void;
    public function rollback(): void;
}
