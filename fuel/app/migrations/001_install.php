<?php

namespace Fuel\Migrations;

class Install {
    function up () {
        \DBUtil::create_table('users2', [
            'id'             => ['type' => 'int', 'constraint' => 11, 'auto_increment' => true],
            'username'       => ['type' => 'varchar', 'constraint' => 50, 'charset' => 'latin1_swedish_ci'],
            'password'       => ['type' => 'varchar', 'constraint' => 50, 'charset' => 'latin1_swedish_ci'],
            'group'          => ['type' => 'int', 'constraint' => 11],
            'account_active' => ['type' => 'int', 'constraint' => 1],
            'email'          => ['type' => 'varchar', 'constraint' => 50, 'charset' => 'latin1_swedish_ci'],
            'last_login'     => ['type' => 'varchar', 'constraint' => 11, 'charset' => 'latin1_swedish_ci'],
            'login_hash'     => ['type' => 'varchar', 'constraint' => 50, 'charset' => 'latin1_swedish_ci'],
            'profile_fields' => ['type' => 'mediumtext', 'charset' => 'latin1_swedish_ci'],
            'created_at'     => ['type' => 'int', 'constraint' => 11],
            'updated_at'     => ['type' => 'int', 'constraint' => 11],
        ], ['id'], true);
    }

    function down () {
        \DBUtil::drop_table('users2');
    }
}