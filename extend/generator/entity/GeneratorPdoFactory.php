<?php

declare(strict_types=1);

namespace generator\entity;

use PDO;

class GeneratorPdoFactory
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(Config $config): Generator
    {
        $repository = new PdoRepository($this->pdo);

        return new Generator($repository, $config);
    }
}
