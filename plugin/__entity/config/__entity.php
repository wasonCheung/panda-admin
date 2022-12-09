<?php

use plugin\__kernel\abstracts\BaseEntity;

return [
    'typeMapping' => [
        'int' => ['int', 'bigint', 'mediumint', 'smallint', 'tinyint'],
        'float' => ['decimal', 'float'],
        'bool' => ['bit'],
    ],
    'primaryKeyConstant' => 'PRIMARY_KEY',
    'strictlyTypedProperties' => true,
    'generateProperties' => false,
    'extends' => BaseEntity::class,
    'rewrite' => true,
    'addDeclareStrictTypes' => true,
    'addPropertyVarComment' => false,
    'generatePhpDocProperties' => false,
    'suffix' => '',
    'generatePropertiesByArray' => true,
    'replacements' => [
        'panda' => ''
    ],
    'setterBody' => '$this->fields[\'__FIELD__\'] = $value;' . "\n" . 'return $this;',
    'getterBody' => 'return $this->fields[\'__FIELD__\'];',
    'path' => config('panda.plugin_path') . '__common/entity',
    'namespace' => config('panda.plugin_namespace') . '\\__common\\entity',
];
