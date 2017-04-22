<?php

namespace cms\review\backend;

use Yii;
use cms\components\BackendModule;

class Module extends BackendModule {

	/**
	 * @inheritdoc
	 */
	public static function moduleName()
	{
		return 'review';
	}

	/**
	 * @inheritdoc
	 */
	public static function cmsSecurity()
	{
		$auth = Yii::$app->getAuthManager();

		if ($auth->getRole('Review') === null) {
			//role
			$role = $auth->createRole('Review');
			$role->description = Yii::t('review', 'Reviews');
			$auth->add($role);
		}
	}

	/**
	 * @inheritdoc
	 */
	public static function cmsMenu($base)
	{
		if (!Yii::$app->user->can('Estate'))
			return [];

		return [
			['label' => Yii::t('review', 'Reviews'), 'url' => ["$base/review/review/index"]],
		];
	}

}
