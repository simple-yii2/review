<?php

namespace cms\review\frontend;

use Yii;

/**
 * Frontend module
 */
class Module extends \yii\base\Module
{

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		if (!isset(Yii::$app->i18n->translations['review'])) {
			Yii::$app->i18n->translations['review'] = [
				'class' => 'yii\i18n\PhpMessageSource',
				'sourceLanguage' => 'en-US',
				'basePath' => dirname(__DIR__) . '/messages',
			];
		}
	}

}
