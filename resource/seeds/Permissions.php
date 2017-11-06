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
            'group_id'    => 1,
            'module'      => 'users.model',
            'permissions' => 255,
        ];
        $data[] = [
            'group_id'    => 1,
            'module'      => 'groups.model',
            'permissions' => 255,
        ];
        $data[] = [
            'group_id'    => 1,
            'module'      => 'permissions.route.model',
            'permissions' => 255,
        ];
        $data[] = [
            'group_id'    => 1,
            'module'      => 'route.url',
            'permissions' => 128,
            'access_route'=> '^/admin/*'
        ];
        $data[] = [
            'group_id'    => 2,
            'module'      => 'users.model',
            'permissions' => 44,
        ];
        $data[] = [
            'group_id'    => 2,
            'module'      => 'groups.model',
            'permissions' => 2,
        ];

        $entity = $this->table('permissions');
        $entity->insert($data)->save();
    }
}
