<?php


use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
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
            'password'      => sha1('admin'),
            'email'         => "admin@localhost",
            'first_name'    => "admin",
            'last_name'     => "admin"
        ];
        $users = $this->table('users');
        $users->insert($data)->save();
    }
}
