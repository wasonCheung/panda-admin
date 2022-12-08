<?php

declare(strict_types=1);

namespace plugin\__entity\lib;

use Doctrine\Inflector\Inflector;
use Doctrine\Inflector\InflectorFactory;
use Exception;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PsrPrinter;
use Nette\SmartObject;
use Nette\Utils\Strings;
use ReflectionMethod;
use RuntimeException;

class __Generator
{
    use SmartObject;

    private IRepository $repository;

    private Config $config;

    private Inflector $inflector;

    public function __construct(IRepository $repository, Config $config)
    {

        $this->repository = $repository;
        $this->config = $config;
        $this->inflector = InflectorFactory::create()->build();
    }

    public function generate(?string $table = null, ?string $query = null): void
    {
        if ($query !== null) {
            if ($table === null) {
                throw new RuntimeException('When using query table argument has to be provided!');
            }

            $this->repository->createViewFromQuery($table, $query);
            $this->generateEntity($table);
            $this->repository->dropView($table);

            return;
        }

        if ($table !== null) {
            $this->generateEntity($table);

            return;
        }

        $tables = $this->repository->getTables();

        foreach ($tables as $oneTable) {
            $this->generateEntity($oneTable);
        }
    }

    public function generateEntity(string $table): void
    {
        $file = new PhpFile();
        if ($this->config->addDeclareStrictTypes) {
            $file->setStrictTypes($this->config->addDeclareStrictTypes);
        }


        $namespace = $file->addNamespace($this->config->namespace);
        if ($this->config->useNamespaces) {
            foreach ($this->config->useNamespaces as $useNamespace) {
                $namespace->addUse($useNamespace);
            }
        }

        $shortClassName = $this->getClassName($table);
        $fqnClassName = '\\' . $this->config->namespace . '\\' . $shortClassName;
        $entity = $namespace->addClass($shortClassName);


        if ($this->config->addTrait !== null) {
            $entity->addTrait($this->config->addTrait);
        }

        $phpDocProperties = [];

        if (!$this->config->rewrite && class_exists($fqnClassName)) {
            $this->cloneEntityFromExistingEntity($entity, ClassType::from($fqnClassName));
            $phpDocProperties = Helper::getPhpDocComments($entity->getComment() ?? '');
        }

        if ($this->config->tableConstant !== null) {
            $entity->addConstant($this->config->tableConstant, $table)->setVisibility('public');
        }

        if ($this->config->extends !== null) {
            $entity->setExtends($this->config->extends);
        }

        $columns = $this->repository->getTableColumns($table);
        $mapping = [];

        if ($this->config->construct) {
            $entity->addMethod('__construct')
                ->addBody('$this->setArray($fields);')
                ->addParameter('fields', [])->setType('array');
        }

        if ($this->config->generatePropertiesByArray) {
            $propertiesByArray = [];

            $entity->addMethod('toArray')->setReturnType('array')
                ->addBody('if (!$filtration){ return $this->fields; }')
                ->addBody('return array_filter($this->fields,static function ($item){ return $item !== null;});')
            ->addParameter('filtration')->setType('bool')->setDefaultValue(false);

            $entity->addMethod('setArray')
                ->addBody('if (empty($fields)){ return $this; }')
                ->addBody('foreach ($this->fields as $key => $value) {')
                ->addBody('   $this->fields[$key] = $fields[$key] ?? null;')
                ->addBody('}')
                ->addBody('return $this;')
                ->setReturnType('self')
                ->addParameter('fields')->setType('array');
            $entity->addMethod('restArray')
                ->addBody('foreach ($this->fields as $key => $value) {')
                ->addBody('   $this->fields[$key] = null;')
                ->addBody('}')
                ->addBody('return $this;')
                ->setReturnType('self');

            $setExtra = $entity->addMethod('setExtra');
            $setExtra  ->addBody('$this->extra[$name] = $value;')
                ->addBody('return $this;')
                ->setReturnType('self');
              $setExtra  ->addParameter('name')->setType('string');
               $setExtra ->addParameter('value');

            $getExtra = $entity->addMethod('getExtra');

            $getExtra
                ->addBody('if ($name === null) { return $this->extra; }')
                ->addBody('return $this->extra[$name] ?? $default; ')

                ->setReturnType('mixed');
                $getExtra->addParameter('name')->setType('string|null')->setDefaultValue(null);
               $getExtra ->addParameter('default')->setType('mixed')->setDefaultValue(null);
        }

        if ($this->config->tostring) {
            $entity->addMethod('__toString')
                ->addBody('return json_encode($this->toArray(), JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE );')->setReturnType('string');
        }

        if ($this->config->serialize) {
            $entity->addMethod('__serialize')
                ->addBody('return $this->toArray(true);')->setReturnType('array');
            $entity->addMethod('__unserialize')
                ->addBody('$this->setArray($fields);')->setReturnType('void')->addParameter('fields')->setType('array');
        }

        $entity->addMethod('__get')->setReturnType('mixed')
            ->addBody('if (\array_key_exists($name, $this->fields)) {')
            ->addBody('   return $this->fields[$name];')
            ->addBody('}')
            ->addBody('return $this->extra[$name] ?? null;')
            ->addParameter('name')->setType('string');

        $__set = $entity->addMethod('__set')->setReturnType('void')
            ->addBody('if (\array_key_exists($name, $this->fields)) {')
            ->addBody('   $this->fields[$name] = $value;')
            ->addBody('} else {')
            ->addBody('   $this->extra[$name] = $value;')
            ->addBody('}');
        $__set->addParameter('name')->setType('string');
        $__set->addParameter('value')->setType('mixed');


        foreach ($columns as $column) {
            $this->validateColumnName($table, $column);
            $this->generateColumnConstant($entity, $column);

            if (isset($entity->properties[$column->getField()]) || in_array($column->getField(), $phpDocProperties, true)) {
                continue;
            }

            if (isset($propertiesByArray)) {
                $propertiesByArray[$column->getField()] = null;
            }

            $mapping[$column->getField()] = $this->inflector->classify($column->getField());
            $this->generateColumn($entity, $column);
        }

        if (isset($propertiesByArray)) {
            $entity->addProperty('fields', $propertiesByArray)->setType('array')->setVisibility('protected');
            $entity->addProperty('extra', [])->setType('array')->setVisibility('protected');
        }

        if ($this->config->generateMapping) {
            if (isset($entity->properties['mapping'])) {
                $mapping += $entity->getProperty('mapping')->getValue();
            }

            $entity->addProperty('mapping', $mapping)->setVisibility('protected')
                ->addComment('')->addComment('@var string[]')->addComment('');
        }

        $printer = new PsrPrinter();

        //file_put_contents($this->config->path . '/' . $shortClassName . '.php', $file->__toString());
        file_put_contents($this->config->path . '/' . $shortClassName . '.php', $printer->printFile($file));
    }

    protected function getClassName(string $table): string
    {
        return $this->config->prefix . Helper::camelize($table, $this->config->replacements) . $this->config->suffix;
    }

    /**
     * @throws Exception
     */
    protected function validateColumnName(string $table, Column $column): void
    {
        if (Strings::contains($column->getField(), '(')) {
            throw new Exception('Bad naming for ' . $column->getField() . ' in table ' . $table .
                ', please change name in database or use AS in views');
        }
    }

    protected function generateColumn(ClassType $entity, Column $column): void
    {
        $type = $this->getColumnType($column);

        if ($this->config->generateProperties) {
            $property = $entity->addProperty($column->getField())
                ->setVisibility($this->config->propertyVisibility);

            // 增加数据库字段备注
            $property->addComment($column->getComment());
            if ($this->config->strictlyTypedProperties) {
                    $property->setType($type);
                    $property->setNullable()->setValue(null);
            }
        }

        if ($this->config->generatePhpDocProperties) {
            $entity->addComment($this->config->phpDocProperty . ' mixed'  . ' $' . $column->getField() . ' ' . $column->getComment());
        }

        if ($this->config->generateGetters) {
            $getter = $entity->addMethod('get' . $this->inflector->classify($column->getField()));
            $getter->setVisibility($this->config->getterVisibility)
                ->addBody(str_replace('__FIELD__', $column->getField(), $this->config->getterBody))
                ->setReturnType('mixed');
        }

        if ($this->config->generateSetters) {
            $setter = $entity->addMethod('set' . $this->inflector->classify($column->getField()));
            $setter->setVisibility($this->config->setterVisibility);
            $setter->addParameter('value')->setType($type === 'string' ? 'mixed' : $type);
            $setter->addBody(str_replace('__FIELD__', $column->getField(), $this->config->setterBody));
            $setter->setReturnType('self');
            $setter->addComment('@param ' . ($type === 'string' ? 'mixed' : $type) . ' $value ' . $column->getComment());
            $setter->addComment('@return self');
        }
    }

    protected function getColumnType(Column $column): string
    {
        $dbColumnType = $column->getType();

        if (Strings::contains($dbColumnType, '(')) {
            $dbColumnType = Strings::lower(Strings::before($dbColumnType, '(') ?? 'string');
        }

        /** @var array<string, string> $typeMapping */
        $typeMapping = Helper::multiArrayFlip($this->config->typeMapping);

        if (isset($typeMapping[$dbColumnType])) {
            return $typeMapping[$dbColumnType];
        }

        return 'string';
    }

    protected function generateColumnConstant(ClassType $entity, Column $column): void
    {
        if ($this->config->primaryKeyConstant !== null && $column->isPrimary()) {
            $entity->addConstant($this->config->primaryKeyConstant, $column->getField())
                ->setVisibility('public');
        }

        if ($this->config->generateColumnConstant) {
            $columnConstant = $this->config->prefix . Strings::upper($this->inflector->tableize($column->getField()));

            if ($columnConstant === 'CLASS') {
                $columnConstant = '_CLASS';
            }

            $constants = $entity->getConstants();

            if (!isset($constants[$column->getField()])) {
                $entity->addConstant($columnConstant, $column->getField())->setVisibility('public');
            }
        }
    }

    private function cloneEntityFromExistingEntity(ClassType $entity, ClassType $from): void
    {
        $entity->setProperties($from->getProperties());
        $entity->setComment($from->getComment());
        $entity->setMethods($from->getMethods());

        foreach ($entity->methods as $method) {
            $fqnClassName = '\\' . $this->config->namespace . '\\' . $entity->getName();
            $body = $this->getMethodBody($fqnClassName, $method->getName());
            $method->setBody($body);
        }
    }

    private function getMethodBody(string $class, string $name): string
    {
        $func = new ReflectionMethod($class, $name);
        $startLine = $func->getStartLine() + 1; //@phpstan-ignore-line
        $length = $func->getEndLine() - $startLine - 1; //@phpstan-ignore-line

        if ($func->getFileName() === false) {
            throw new Exception('Cannot get generated entity filename!');
        }

        $source = file($func->getFileName());

        if ($source === false) {
            throw new Exception('Cannot open generated entity file!');
        }

        $bodyLines = array_slice($source, $startLine, $length);
        $body = '';

        foreach ($bodyLines as $bodyLine) {
            $body .= Strings::after($bodyLine, "\t\t");
        }

        return $body;
    }
}
