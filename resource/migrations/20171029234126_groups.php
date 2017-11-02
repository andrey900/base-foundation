<?php


use Phinx\Migration\AbstractMigration;

class Groups extends AbstractMigration
{
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
    public function change()
    {
        $groups = $this->table('groups');
        $groups->addColumn('code', 'string', ['limit' => 60])
              ->addColumn('name', 'string', ['limit' => 120])
              ->addColumn('description', 'string', ['limit' => 255])
              ->addColumn('active', 'boolean', ['default' => true])
              ->addColumn('default', 'boolean', ['default' => false])
              ->addIndex(['code'], ['unique' => true])
              ->save();
    }

    public function down()
    {
        $this->dropTable('groups');
    }
}
