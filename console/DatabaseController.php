<?php
/**
 * @link http://www.cando.com/
 * @copyright Copyright (c) 2015 Advertical LLC dba CanDo
 */

namespace cando\database\console;

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
			'create' => '\cando\database\console\database\CreateAction',
			'models' => '\cando\database\console\database\ModelsAction',
		];
	}
}
