<?php

namespace plugin\__database\think;

use InvalidArgumentException;
use plugin\__database\phinx\util\Util;
use RuntimeException;
use think\App;

class Creator
{
    protected $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

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

        return $this->__create($className);
    }

    private function __create(string $className): string
    {
        $path = $this->ensureDirectory();

        if (!Util::isValidPhinxClassName($className)) {
            throw new InvalidArgumentException(
                sprintf('The migration class name "%s" is invalid. Please use CamelCase format.', $className)
            );
        }

        if (!Util::isUniqueMigrationClassName($className, $path)) {
            throw new InvalidArgumentException(sprintf('The migration class name "%s" already exists', $className));
        }

        // Compute the file path
        $fileName = Util::mapClassNameToFileName($className);
        $filePath = $path . DIRECTORY_SEPARATOR . $fileName;

        if (is_file($filePath)) {
            throw new InvalidArgumentException(sprintf('The file "%s" already exists', $filePath));
        }

        $aliasedClassName = null;

        // Load the alternative template if it is defined.
        $contents = file_get_contents($this->getTemplate());

        // inject the class names appropriate to this migration
        $contents = strtr($contents, [
            'MigratorClass' => $className,
        ]);

        if (file_put_contents($filePath, $contents) === false) {
            throw new RuntimeException(sprintf('The file "%s" could not be written to', $path));
        }

        return $filePath;
    }

    protected function ensureDirectory(): string
    {
        $path = __DIR__ . '/../database/migrations';

        if (!is_dir($path) && !mkdir($path, 0755, true) && !is_dir($path)) {
            throw new InvalidArgumentException(sprintf('directory "%s" does not exist', $path));
        }

        if (!is_writable($path)) {
            throw new InvalidArgumentException(sprintf('directory "%s" is not writable', $path));
        }

        return $path;
    }

    protected function getTemplate(): string
    {
        return __DIR__ . '/command/stubs/__migrate.stub';
    }
}
