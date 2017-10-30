<?php


use Phinx\Seed\AbstractSeed;

class UsersSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data[] = [
            'login'      => 'admin',
            'password'      => '$2y$10$q21.vBALVSrM.hQb7uxMJ.rgv/4TkFt./YLZo4VBdSJji3xTX53/2',
            'email'         => "admin@localhost",
            'first_name'    => "admin",
            'last_name'     => "admin",
            'verified'      => true,
            'active'        => true
        ];
        $users = $this->table('users');
        $users->insert($data)->save();
    }
}
