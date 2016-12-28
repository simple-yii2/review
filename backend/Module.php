<?php

namespace cms\review\backend;

use Yii;

class Module extends \yii\base\Module {

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		$this->checkDatabase();
		self::addTranslation();
	}

	/**
	 * Database checking
	 * @return void
	 */
	protected function checkDatabase()
	{
		//schema
		$db = Yii::$app->db;
		$filename = dirname(__DIR__) . '/schema/' . $db->driverName . '.sql';
		$sql = explode(';', file_get_contents($filename));
		foreach ($sql as $s) {
			if (trim($s) !== '')
				$db->createCommand($s)->execute();
		}

		//rbac
		$auth = Yii::$app->getAuthManager();
		if ($auth->getRole('Review') === null) {
			//role
			$role = $auth->createRole('Review');
			$auth->add($role);
			
			//permission
			$permission = $auth->createPermission('ReviewUpdate');

			$own = $auth->getPermission('own');
			$auth->addChild($role, $permission);
			$auth->addChild($own, $permission);
		}
	}

	/**
	 * Adding translation to i18n
	 * @return void
	 */
	protected static function addTranslation()
	{
		if (!isset(Yii::$app->i18n->translations['review'])) {
			Yii::$app->i18n->translations['review'] = [
				'class' => 'yii\i18n\PhpMessageSource',
				'sourceLanguage' => 'en-US',
				'basePath' => dirname(__DIR__) . '/messages',
			];
		}
	}

	/**
	 * Making main menu item of module
	 * @param string $base route base
	 * @return array
	 */
	public static function getMenu($base)
	{
		self::addTranslation();

		if (Yii::$app->user->can('Review')) {
			return [
				['label' => Yii::t('review', 'Reviews'), 'url' => ["$base/review/review/index"]],
			];
		}
		
		return [];
	}

}
