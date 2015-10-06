<?php
/**
 * @link http://www.cando.com/
 * @copyright Copyright (c) 2015 Advertical LLC dba CanDo
 */

namespace cando\database\console;

use Yii;
use yii\console\Controller;

/**
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
			'create' => '\cando\db\console\database\CreateAction',
			'models' => '\cando\db\console\database\ModelsAction',
		];
	}
}