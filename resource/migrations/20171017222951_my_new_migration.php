<?php


use Phinx\Migration\AbstractMigration;

class MyNewMigration extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $users = $this->table('users');
        $users->addColumn('username', 'string', ['limit' => 30])
              ->addColumn('password', 'string', ['limit' => 40])
              ->addColumn('email', 'string', ['limit' => 60])
              ->addColumn('first_name', 'string', ['limit' => 30])
              ->addColumn('last_name', 'string', ['limit' => 30])
              ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('updated_at', 'timestamp', ['null' => true])
              ->addColumn('active', 'boolean', ['default' => true])
              ->addColumn('verified', 'boolean', ['default' => false])
              ->addIndex(['username', 'email'], ['unique' => true])
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}
