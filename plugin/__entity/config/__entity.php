<?php

return [
    'typeMapping' => [
        'int' => ['int', 'bigint', 'mediumint', 'smallint', 'tinyint'],
        'float' => ['decimal', 'float'],
        'bool' => ['bit'],
    ],
    'primaryKeyConstant' => 'PRIMARY_KEY',
    'strictlyTypedProperties' => true,
    'generateProperties' => false,
    'extends' => null,
    'rewrite' => true,
    'addDeclareStrictTypes' => true,
    'addPropertyVarComment' => false,
    'generatePhpDocProperties' => false,
    'suffix' => 'Entity',
    'generatePropertiesByArray' => true,
    'replacements' => [
        'panda' => ''
    ],
    'setterBody' => '$this->fields[\'__FIELD__\'] = $value;' . "\n" . 'return $this;',
    'getterBody' => 'return $this->fields[\'__FIELD__\'];',
    'path' => app_path() . 'entity' . DIRECTORY_SEPARATOR,
    'namespace' => 'app\\entity',
];
