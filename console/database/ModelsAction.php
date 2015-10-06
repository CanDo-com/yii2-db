<?php
/**
 * @link http://www.cando.com/
 * @copyright Copyright (c) 2015 Advertical LLC dba CanDo
 */

namespace cando\database\console\database;

use Yii;
use yii\base\Action;
use yii\db\Connection;

/**
 * A wrapper for Gii model generator.
 *
 * It creates two files per database table - a "base" file that contains all auto-generated content, this file will be
 * overridden every time the model generator is called, and the model class which can be modified by the developers,
 * it will only be generated if it does not exist.
 *
 * This way you can update model classes when the database schema is changed without losing the custom hand-written
 * code.
 *
 * @author Sergiy Misyura <sergiy@cando.com>
 */
class ModelsAction extends Action
{
	/**
	 * @var string ID
	 */
	public $db = 'db';
	public $ns = 'app\models';

	/**
	 * Iterates through database tables and invokes Gii model generator for each of them
	 */
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
		$basePath = Yii::getAlias('@' . str_replace('\\', '/', $this->ns)) . '/base/';
		$template = file_get_contents(__DIR__ . '/models/template.txt');

		foreach ($dbConnection->schema->getTableNames() as $tableName)
		{
			$modelName = $this->generateModelName($tableName);
			$baseModelName = $modelName . 'Base';
			$baseModelFile = $basePath . $baseModelName . '.php';

			$cmd = 'php yii gii/model' .
				' --interactive=0' .
				' --overwrite=1' .
				' --tableName=' . $tableName .
				' --modelClass=' . $baseModelName .
				' --ns="' . $baseNs . '"' .
				' --db=' . $this->db;

			echo $cmd . "\n";
			passthru($cmd);

			$baseContent = file_get_contents($baseModelFile);
			$matches = [];
			preg_match_all('/@property ([A-Z]\\w+)/', $baseContent, $matches);

			$classes = [];

			foreach ($matches[1] as $match)
			{
				$classes[$match] = true;
			}

			$useStatements = ['use Yii;'];

			foreach (array_keys($classes) as $className)
			{
				$useStatements[] = 'use ' . $this->ns . '\\' . $className . ';';
			}

			$baseContent = str_replace('use Yii;', implode("\n", $useStatements), $baseContent);
			file_put_contents($baseModelFile, $baseContent);

			$modelFile = $path . $modelName . '.php';
			if (!file_exists($modelFile))
			{
				$content = str_replace('##ns##', $this->ns, str_replace('##model##', $modelName, $template));
				file_put_contents($modelFile, $content);
			}
		}
	}

	/**
	 * Generates a name for the model class based on the table name
	 *
	 * @param   string  $tableName  Table name
	 *
	 * @return  string  Model name
	 */
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
