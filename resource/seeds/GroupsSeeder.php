<?php


use Phinx\Seed\AbstractSeed;

class GroupsSeeder extends AbstractSeed
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
            'code'          => 'admin',
            'name'          => 'Administrators',
            'description'   => "Allow access to all functions in site",
            'default'       => false,
            'active'        => true
        ];
        $data[] = [
            'code'          => 'registered',
            'name'          => 'Registered users',
            'description'   => "All registered and authorized users",
            'default'       => false,
            'active'        => true
        ];
        $data[] = [
            'code'          => 'guest',
            'name'          => 'All other users',
            'description'   => "All users, this defaults groups",
            'default'       => true,
            'active'        => true
        ];
        $entity = $this->table('groups');
        $entity->insert($data)->save();
    }
}
