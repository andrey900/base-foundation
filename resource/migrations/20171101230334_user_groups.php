<?php


use Phinx\Migration\AbstractMigration;

class UserGroups extends AbstractMigration
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
        $user_group = $this->table('group_user');
        
        if ($user_group) {
            $this->dropTable('group_user');
        }

        $user_group->addColumn('group_id', 'integer', ['null' => false])
                    ->addColumn('user_id', 'integer', ['null' => false])
                    ->save();
    }
}