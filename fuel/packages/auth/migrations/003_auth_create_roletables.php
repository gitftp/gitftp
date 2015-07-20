<?php

namespace Fuel\Migrations;

include __DIR__."/../normalizedrivertypes.php";

class Auth_Create_Roletables
{
	function up()
	{
		// get the drivers defined
		$drivers = normalize_driver_types();

		if (in_array('Ormauth', $drivers))
		{
			// get the tablename
			\Config::load('ormauth', true);
			$table = \Config::get('ormauth.table_name', 'users');

			// make sure the configured DB is used
			\DBUtil::set_connection(\Config::get('ormauth.db_connection', null));

			// table users_role
			\DBUtil::create_table($table.'_roles', array(
				'id' => array('type' => 'int', 'constraint' => 11, 'auto_increment' => true),
				'name' => array('type' => 'varchar', 'constraint' => 255),
				'filter' => array('type' => 'enum', 'constraint' => "'', 'A', 'D'", 'default' => ''),
				'user_id' => array('type' => 'int', 'constraint' => 11, 'default' => 0),
				'created_at' => array('type' => 'int', 'constraint' => 11, 'default' => 0),
				'updated_at' => array('type' => 'int', 'constraint' => 11, 'default' => 0),
			), array('id'));

			// table users_role_perms
			\DBUtil::create_table($table.'_role_permissions', array(
				'role_id' => array('type' => 'int', 'constraint' => 11),
				'perms_id' => array('type' => 'int', 'constraint' => 11),
			), array('role_id', 'perms_id'));
		}

		// reset any DBUtil connection set
		\DBUtil::set_connection(null);
	}

	function down()
	{
		// get the drivers defined
		$drivers = normalize_driver_types();

		if (in_array('Ormauth', $drivers))
		{
			// get the tablename
			\Config::load('ormauth', true);
			$table = \Config::get('ormauth.table_name', 'users');

			// make sure the configured DB is used
			\DBUtil::set_connection(\Config::get('ormauth.db_connection', null));

			// drop the admin_users_role table
			\DBUtil::drop_table($table.'_roles');

			// drop the admin_users_role_perms table
			\DBUtil::drop_table($table.'_role_permissions');
		}

		// reset any DBUtil connection set
		\DBUtil::set_connection(null);
	}
}
