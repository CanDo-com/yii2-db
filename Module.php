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
 * This is the module class for CanDo database helpers for Yii2.
 *
 * To use them, include this module to your console application configuration file and add it to the bootstrap list:
 *
 * ~~~
 * if (YII_ENV_DEV) {
 *    $config['modules']['database'] = [
 *        'class' => '\cando\database\Module',
 *    ];
 *    $config['bootstrap'][] = 'database';
 * }
 * ~~~
 *
 * This code is intended to be used only in the development environment and should never be executed on the production
 * server.
 *
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
