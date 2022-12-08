<?php


use think\migration\Migrator;

class RemoveFieldPidForAdminGroup extends Migrator
{
    public function up()
    {
        $this->execute($this->loadSqlFile(__FILE__, 'up'));
    }

    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */

    public function loadSqlFile(string $__FILE__, string $type): string
    {
        $sqlFile = str_replace('.php', DIRECTORY_SEPARATOR . $type . '.sql', $__FILE__);

        return str_replace(
            '{prefix}',
            $this->getDatabasePrefix(),
            file_get_contents($sqlFile)
        );
    }

    public function getDatabasePrefix(): string
    {
        return env('database.prefix', '');
    }

    public function down()
    {
        $this->execute($this->loadSqlFile(__FILE__, 'down'));
    }
}
