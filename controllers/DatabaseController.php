<?php
/**
 * @link http://www.cando.com/
 * @copyright Copyright (c) 2015 Advertical LLC dba CanDo
 */

namespace cando\db\controllers;

use Yii;
use yii\console\Controller;

/**
 * Provides several helpers that (supposedly) make your work with the database easier.
 *
 * @author Sergiy Misyura <sergiy@cando.com>
 */
class DatabaseController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			'create' => '\cando\db\controllers\database\CreateAction',
			'models' => '\cando\db\controllers\database\ModelsAction',
		];
	}
}
