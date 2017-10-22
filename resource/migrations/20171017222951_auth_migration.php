<?php


use Phinx\Migration\AbstractMigration;

class AuthMigration extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $users = $this->table('users');
        $users->addColumn('login', 'string', ['limit' => 30])
              ->addColumn('password', 'string', ['limit' => 60])
              ->addColumn('email', 'string', ['limit' => 60])
              ->addColumn('first_name', 'string', ['limit' => 30])
              ->addColumn('last_name', 'string', ['limit' => 30])
              ->addColumn('admin_comment', 'string', ['limit' => 255])
              ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
              ->addColumn('updated_at', 'timestamp', ['null' => true])
              ->addColumn('active', 'boolean', ['default' => true])
              ->addColumn('verified', 'boolean', ['default' => false])
              ->addIndex(['login', 'email'], ['unique' => true])
              ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
