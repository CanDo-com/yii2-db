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

		$path = Yii::getAlias('@' . str_replace('\\', '/', $this->ns)) . '/';
		$template = file_get_contents(__DIR__ . '/models/template.txt');

		foreach ($dbConnection->schema->getTableNames() as $tableName)
		{
			$modelName = $this->generateModelName($tableName);
			$baseModelName = $modelName . 'Base';

			$cmd = 'php yii gii/model' .
				' --interactive=0' .
				' --tableName=' . $tableName .
				' --modelClass=' . $baseModelName .
				' --ns="' . $baseNs . '"' .
				' --db=' . $this->db;

			echo $cmd . "\n";
			passthru($cmd);

			$modelFile = $path . $modelName . '.php';
			if (!file_exists($modelFile))
			{
				$content = str_replace('##ns##', $this->ns, str_replace('##model##', $modelName, $template));
				file_put_contents($modelFile, $content);
			}
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
