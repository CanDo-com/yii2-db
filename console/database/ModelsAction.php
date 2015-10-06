<?php

namespace cando\database\console\database;

use Yii;
use yii\base\Action;
use yii\db\Connection;

class ModelsAction extends Action
{
	public $db = 'db';
	public $ns = 'app\models';

	public function run()
	{
		/**
		 * @var  Connection  $dbConnection
		 */
		$dbConnection = Yii::$app->get($this->db, false);
		if ($dbConnection == null)
		{
			return;
		}

		$baseNs = $this->ns . '\\base';

		foreach ($dbConnection->schema->getTableNames() as $tableName)
		{
			$modelName = $this->generateModelName($tableName);
			$baseModelName = $modelName . 'Base';

			$cmd = 'php yii gii/model' .
				' --tableName=' . $tableName .
				' --modelName=' . $baseModelName .
				' --ns=' . $this->ns .
				' --db=' . $this->db;

			echo $cmd . "\n";
		}
	}

	private function generateModelName($tableName)
	{
		$parts = explode('_', $tableName);
		$capitalized = [];
		foreach ($parts as $part)
		{
			if ($part != '')
			{
				$capitalized[] = ucfirst($part);
			}
		}
		return implode($capitalized);
	}
}
