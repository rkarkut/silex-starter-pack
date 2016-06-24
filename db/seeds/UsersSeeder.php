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
        $data = [
            [
                'email' => 'radek@rkarkut.pl',
                'password' => 'riW1d/+hN8fawJq6V7EGPCfn2it4s8xQDAPEwGJgYjGJ8vXu6j1xZnk65g/6/ZKvOw4Um4LeAayeDU2OX+Pcow==',
                'roles' => 'ROLE_USER',
                'is_active' => 1,
                'last_login_date' => date('Y-m-d H:i:s'),
                'last_login_ip' => '127.0.0.1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $users = $this->table('users');
        $users->insert($data)->save();
    }
}
