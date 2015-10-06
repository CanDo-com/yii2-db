<?php
/**
 * @link http://www.cando.com/
 * @copyright Copyright (c) 2015 Advertical LLC dba CanDo
 */

namespace cando\database;

use Yii;
use yii\base\BootstrapInterface;
use yii\console\Application;

/**
 * @author Sergiy Misyura <sergiy@cando.com>
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
	/**
	 * @inheritdoc
	 */
	public function bootstrap($app)
	{
		if ($app instanceof Application)
		{
			$app->controllerMap[$this->id] = [
				'class' => '\cando\database\console\DatabaseController',
				'module' => $app,
			];
		}
	}

	public function getControllerPath()
	{
		return '@vendor/cando/database/console';
	}
}
