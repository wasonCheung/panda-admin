<?php

declare(strict_types=1);

namespace generator\entity;

interface IRepository
{
    /**
     * @return string[]
     */
    public function getTables(): array;

    /**
     * @return Column[]
     */
    public function getTableColumns(string $table): array;

    public function createViewFromQuery(string $name, string $query): void;

    public function dropView(string $name): void;
}
