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
     *
     * password: TestApp777
     */
    public function run()
    {
        $data = [
            [
                'email' => 'test@site.com',
                'password' => 'stHGdg4MhYOm/OVTWjpMJievIvJqafsQQ3WpWlUNDT6WfHupVWjBQaxdppMQkdCmYSXl6QQQXVYLGL/MDZi5Zw==',
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
