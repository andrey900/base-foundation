<?php


use Phinx\Seed\AbstractSeed;

class Permissions extends AbstractSeed
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
            'group_id'    => 2,
            'module'      => 'route.name',
            'permissions' => 128,
            'route'       => 'page.home'
        ];
        $data[] = [
            'group_id'    => 2,
            'module'      => 'route.name',
            'permissions' => 128,
            'route'       => 'adminpanel.login'
        ];
        $data[] = [
            'group_id'    => 2,
            'module'      => 'route.name',
            'permissions' => 128,
            'route'       => 'adminpanel.signin'
        ];
        $data[] = [
            'group_id'    => 2,
            'module'      => 'route.name',
            'permissions' => 128,
            'route'       => 'adminpanel.logout'
        ];

        $entity = $this->table('permissions');
        $entity->insert($data)->save();
    }
}
