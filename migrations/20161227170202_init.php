<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Init extends AbstractMigration
{
	public function change()
	{
		$table = $this->table('bors_server_vars', ['id' => false, 'primary_key' => 'id']);
		$table
			->addColumn('id', 'integer', ['signed' => false, 'identity' => true, 'limit' => 10])
			->addColumn('user_ip', 'string', ['length' => 16, 'null' => true])
			->addColumn('user_class_name', 'string', ['length' => 64, 'null' => true])
			->addColumn('user_id', 'integer', ['signed' => false, 'limit' => 10, 'null' => true])
			->addColumn('url', 'string', ['length' => 4096])
			->addColumn('server_uri', 'string', ['length' => 4096])
			->addColumn('referer', 'string', ['length' => 4096])
			->addColumn('class_name', 'string', ['length' => 64, 'null' => true])
			->addColumn('object_id', 'string', ['length' => 255, 'null' => true])
			->addColumn('access_time', 'integer', ['signed' => false, 'limit' => 10])
			->addColumn('operation_time', 'float')
			->addColumn('has_bors', 'integer', ['signed' => false, 'limit' => MysqlAdapter::INT_TINY])
			->addColumn('has_bors_url', 'integer', ['signed' => false, 'limit' => MysqlAdapter::INT_TINY])
			->addColumn('user_agent', 'string', ['length' => 4096])
			->addColumn('is_bot', 'string', ['length' => 64])
			->addColumn('is_crowler', 'string', ['length' => 64])
			->addColumn('was_counted', 'integer', ['signed' => false, 'limit' => MysqlAdapter::INT_TINY])


			->addIndex('user_ip')
			->addIndex('access_time')
			->addIndex('was_counted')
			->addIndex(['user_ip', 'access_time'])

			->create();
	}
}
