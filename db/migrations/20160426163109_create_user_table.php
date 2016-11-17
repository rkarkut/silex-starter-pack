<?php

use Phinx\Migration\AbstractMigration;

/**
 * Class CreateUserTable
 */
class CreateUserTable extends AbstractMigration
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
    public function up()
    {
        $table = $this->table('users');
        $table
            ->addColumn('email', 'string', ['limit' => 255])
            ->addColumn('password', 'text')
            ->addColumn('is_active', 'boolean')
            ->addColumn('roles', 'string', ['limit' => 255])
            ->addColumn('ip_address', 'string', ['limit' => 64])
            ->addColumn('last_login_at', 'timestamp', ['null' => true])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['null' => true])
            ->addIndex(['email'], ['unique' => true])
            ->create();
    }

    /**
     *
     */
    public function down()
    {
        $this->dropTable('users');
    }
    
}
