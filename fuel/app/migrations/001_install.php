<?php

namespace Fuel\Migrations;

use Fuel\Core\DBUtil;

class Install {
    function up () {

        DBUtil::create_table('users', [
            'id'             => [
                'type'           => 'int',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'username'       => [
                'type'       => 'varchar',
                'constraint' => 50,
            ],
            'password'       => [
                'type'       => 'varchar',
                'constraint' => 50,
            ],
            'group'          => [
                'type'       => 'int',
                'constraint' => 11,
            ],
            'account_active' => [
                'type'       => 'int',
                'constraint' => 1,
            ],
            'email'          => [
                'type'       => 'varchar',
                'constraint' => 50,
            ],
            'last_login'     => [
                'type'       => 'varchar',
                'constraint' => 11,
            ],
            'login_hash'     => [
                'type'       => 'varchar',
                'constraint' => 50,
            ],
            'profile_fields' => [
                'type' => 'mediumtext',
            ],
            'created_at'     => [
                'type'       => 'int',
                'constraint' => 11,
            ],
            'updated_at'     => [
                'type'       => 'int',
                'constraint' => 11,
            ],
            'invite_pending' => [
                'type'       => 'int',
                'constraint' => 1,
            ],
        ], ['id'], true, 'InnoDB', 'utf8_unicode_ci');

        DBUtil::create_index('users', 'email', 'UNIQUE EMAIL', 'unique');

        DBUtil::create_table('users_git_providers', [
            'id'            => [
                'type'           => 'int',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'parent_id'     => [
                'type'       => 'int',
                'constraint' => 11,
            ],
            'provider'      => [
                'type'       => 'varchar',
                'constraint' => 50,
            ],
            'uid'           => [
                'type'       => 'varchar',
                'constraint' => 255,
            ],
            'username'      => [
                'type'       => 'varchar',
                'constraint' => 255,
            ],
            'secret'        => [
                'null'       => true,
                'type'       => 'varchar',
                'constraint' => 255,
            ],
            'access_token'  => [
                'null' => true,
                'type' => 'longtext',
            ],
            'expires'       => [
                'null'       => true,
                'type'       => 'int',
                'constraint' => 12,
            ],
            'refresh_token' => [
                'null'       => true,
                'type'       => 'varchar',
                'constraint' => 255,
            ],
            'user_id'       => [
                'type'       => 'int',
                'constraint' => 11,
            ],
            'created_at'    => [
                'type'       => 'int',
                'constraint' => 11,
            ],
            'updated_at'    => [
                'type'       => 'int',
                'constraint' => 11,
            ],
        ], ['id'], true, 'InnoDB', 'utf8_unicode_ci', [
            [
                'constraint' => 'constraint3',
                'name'       => "FK_2asd",
                'key'        => 'parent_id',
                'reference'  => [
                    'table'  => 'users',
                    'column' => 'id',
                ],
                'on_delete'  => 'CASCADE',
            ],
        ]);

        DBUtil::create_table('user_login_history', [
            'id'         => [
                'type'           => 'int',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'session_id' => [
                'type'       => 'varchar',
                'constraint' => 40,
            ],
            'medium'     => [
                'type'       => 'varchar',
                'constraint' => 50,
            ],
            'medium_os'  => [
                'type'       => 'varchar',
                'constraint' => 50,
            ],
            'platform'   => [
                'type'       => 'varchar',
                'constraint' => 50,
            ],
            'ip_address' => [
                'type'       => 'varchar',
                'constraint' => 50,
            ],
            'login_at'   => [
                'type'       => 'int',
                'constraint' => 11,
            ],
            'active'     => [
                'type'       => 'int',
                'constraint' => 1,
            ],
            'user_id'    => [
                'type'       => 'int',
                'constraint' => 11,
            ],
        ], [
            'id',
        ], true, 'InnoDB', 'utf8_unicode_ci', [
            [
                'constraint' => 'constraint23',
                'key'        => 'user_id',
                'reference'  => [
                    'table'  => 'users',
                    'column' => 'id',
                ],
                'on_delete'  => 'CASCADE',
            ],
        ]);

        DBUtil::create_table('keys', [
            'id'         => [
                'type'           => 'int',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'public'     => [
                'type' => 'text',
                'null' => true,
            ],
            'private'    => [
                'type' => 'text',
                'null' => true,
            ],
            'created_at' => [
                'type'       => 'int',
                'constraint' => 11,
            ],
        ], [
            'id',
        ], true, 'InnoDB', 'utf8_unicode_ci', []);

        DBUtil::create_table('options', [
            'id'    => [
                'type'           => 'int',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'name'  => [
                'type'       => 'varchar',
                'constraint' => 50,
            ],
            'value' => [
                'type' => 'longtext',
                'null' => true,
            ],
        ], [
            'id',
        ], true, 'InnoDB', 'utf8_unicode_ci');

        DBUtil::create_table('records', [
            'id'              => [
                'type'           => 'int',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'server_id'       => [
                'type'       => 'int',
                'constraint' => 11,
                'null'       => true,
            ],
            'project_id'      => [
                'type'       => 'int',
                'constraint' => 11,
            ],
            'type'            => [
                'type'       => 'int',
                'constraint' => 2,
            ],
            'status'          => [
                'type'       => 'int',
                'constraint' => 2,
            ],
            'created_at'      => [
                'type'       => 'int',
                'constraint' => 11,
            ],
            'failed_reason'   => [
                'null' => true,
                'type' => 'mediumtext',
            ],
            'log'             => [
                'null'       => true,
                'type'       => 'varchar',
                'constraint' => 150,
            ],
            'log_file'        => [
                'null'       => true,
                'type'       => 'varchar',
                'constraint' => 50,
            ],
            'revision'        => [
                'null'       => true,
                'type'       => 'varchar',
                'constraint' => 32,
            ],
            'target_revision' => [
                'null'       => true,
                'type'       => 'varchar',
                'constraint' => 32,
            ],
            'commit'          => [
                'null' => true,
                'type' => 'mediumtext',
            ],
            'total_files'     => [
                'type'       => 'int',
                'constraint' => 11,
                'default'    => 0,
            ],
            'processed_files' => [
                'type'       => 'int',
                'constraint' => 11,
                'default'    => 0,
            ],
            'edited_files'    => [
                'type'       => 'int',
                'constraint' => 11,
                'default'    => 0,
            ],
            'added_files'     => [
                'type'       => 'int',
                'constraint' => 11,
                'default'    => 0,
            ],
            'deleted_files'   => [
                'type'       => 'int',
                'constraint' => 11,
                'default'    => 0,
            ],
        ], [
            'id',
        ], true, 'InnoDB', 'utf8_unicode_ci');

        DBUtil::create_table('projects', [
            'id'           => [
                'type'           => 'int',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'name'         => [
                'type'       => 'varchar',
                'constraint' => 50,
            ],
            'path'         => [
                'type'       => 'varchar',
                'constraint' => 300,
            ],
            'uri'          => [
                'type'       => 'varchar',
                'constraint' => 300,
            ],
            'clone_uri'    => [
                'type'       => 'varchar',
                'constraint' => 300,
            ],
            'git_username' => [
                'type'       => 'varchar',
                'constraint' => 300,
            ],
            'git_name'     => [
                'type'       => 'varchar',
                'constraint' => 50,
            ],
            'git_id'       => [
                'type'       => 'varchar',
                'constraint' => 150,
            ],
            'sh_name'      => [
                'type'       => 'varchar',
                'constraint' => 10,
                'null'       => true,
            ],
            'hook_id'      => [
                'type'       => 'varchar',
                'constraint' => 50,
                'null'       => true,
            ],
            'hook_key'     => [
                'type'       => 'varchar',
                'constraint' => 10,
                'null'       => true,
            ],
            'owner_id'     => [
                'type'       => 'int',
                'constraint' => 11,
            ],
            'provider'     => [
                'type'       => 'varchar',
                'constraint' => 50,
            ],
            'created_at'   => [
                'type'       => 'int',
                'constraint' => 11,
            ],
            'clone_state'  => [
                'type'       => 'int',
                'constraint' => 1,
                'default'    => 1,
            ],
            'pull_state'   => [
                'type'       => 'int',
                'constraint' => 1,
                'default'    => 1,
            ],
            'last_updated' => [
                'type'       => 'int',
                'constraint' => 11,
                'null'       => true,
            ],
            'status'       => [
                'type'       => 'varchar',
                'constraint' => 50,
                'default'    => 1,
            ],
        ], [
            'id',
        ], true, 'InnoDB', 'utf8_unicode_ci');

        DBUtil::create_table('servers', [
            'id'          => [
                'type'           => 'int',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'name'        => [
                'type'       => 'varchar',
                'constraint' => 50,
            ],
            'project_id'  => [
                'type'       => 'int',
                'constraint' => 11,
            ],
            'branch'      => [
                'type'       => 'varchar',
                'constraint' => 50,
            ],
            'type'        => [
                'type'       => 'int',
                'constraint' => 11,
            ],
            'secure'      => [
                'type'       => 'int',
                'constraint' => 1,
                'null'       => true,
            ],
            'host'        => [
                'type'       => 'varchar',
                'constraint' => 50,
                'null'       => true,
            ],
            'port'        => [
                'type'       => 'int',
                'constraint' => 11,
                'null'       => true,
            ],
            'username'    => [
                'type'       => 'varchar',
                'constraint' => 50,
                'null'       => true,
            ],
            'password'    => [
                'type'       => 'varchar',
                'constraint' => 50,
                'null'       => true,
            ],
            'path'        => [
                'type'       => 'varchar',
                'constraint' => 150,
            ],
            'key_id'      => [
                'type'       => 'int',
                'constraint' => 11,
                'null'       => true,
            ],
            'added_by'    => [
                'type'       => 'int',
                'constraint' => 11,
            ],
            'auto_deploy' => [
                'type'       => 'int',
                'constraint' => 1,
            ],
            'created_at'  => [
                'type'       => 'int',
                'constraint' => 11,
            ],
            'updated_at'  => [
                'type'       => 'int',
                'constraint' => 11,
            ],
            'revision'    => [
                'type'       => 'varchar',
                'constraint' => 50,
            ],
        ], [
            'id',
        ], true, 'InnoDB', 'utf8_unicode_ci', [
        ]);

        DBUtil::create_table('exception_logs', [
            'id'             => [
                'type'           => 'int',
                'constraint'     => 11,
                'auto_increment' => true,
            ],
            'created_at'     => [
                'type'       => 'int',
                'constraint' => 11,
            ],
            'message'        => [
                'type'       => 'varchar',
                'constraint' => 600,
            ],
            'code'           => [
                'null'       => true,
                'type'       => 'int',
                'constraint' => 11,
            ],
            'url'            => [
                'null'       => true,
                'type'       => 'varchar',
                'constraint' => 300,
            ],
            'file'           => [
                'null'       => true,
                'type'       => 'varchar',
                'constraint' => 100,
            ],
            'line'           => [
                'null'       => true,
                'type'       => 'varchar',
                'constraint' => 100,
            ],
            'backtrace'      => [
                'null' => true,
                'type' => 'longtext',
            ],
            'headers'        => [
                'null' => true,
                'type' => 'longtext',
            ],
            'included_files' => [
                'null' => true,
                'type' => 'longtext',
            ],
            'user'           => [
                'null' => true,
                'type' => 'longtext',
            ],
            'env'            => [
                'null' => true,
                'type' => 'longtext',
            ],
            'params'         => [
                'null' => true,
                'type' => 'longtext',
            ],
            'dump'           => [
                'null' => true,
                'type' => 'longtext',
            ],
            'archived'       => [
                'type'       => 'int',
                'constraint' => 1,
                'default'    => 0,
            ],
        ], [
            'id',
        ], true, 'InnoDB', 'utf8_unicode_ci');
    }

    function down () {
        DBUtil::drop_table('exception_logs');
        DBUtil::drop_table('servers');
        DBUtil::drop_table('projects');
        DBUtil::drop_table('records');
        DBUtil::drop_table('options');
        DBUtil::drop_table('keys');
        DBUtil::drop_table('user_login_history');
        DBUtil::drop_table('users_git_providers');
        DBUtil::drop_table('users');
    }
}