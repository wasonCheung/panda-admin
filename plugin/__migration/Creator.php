<?php

namespace plugin\__migration;

use Phinx\Util\Util;

class Creator extends \think\migration\Creator
{
    public function create(string $className): string
    {
        $path = $this->ensureDirectory();
        $fileName = Util::mapClassNameToFileName($className);

        $dir = $path . DIRECTORY_SEPARATOR . str_replace('.php', DIRECTORY_SEPARATOR, $fileName);

        if (!mkdir($dir, 0777, true) && !is_dir($dir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
        }


        file_put_contents($dir . 'up.sql', '');
        file_put_contents($dir . 'down.sql', '');

        return parent::create($className);
    }

    protected function getTemplate(): string
    {
        return __DIR__ . '/stubs/migrate.stub';
    }
}
