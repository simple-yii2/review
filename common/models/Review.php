<?php

namespace cms\review\common\models;

use yii\db\ActiveRecord;

class Review extends ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'Review';
	}

	/**
	 * @inheritdoc
	 */
	public function __construct($config = [])
	{
		//default values
		if (!array_key_exists('active', $config))
			$config['active'] = true;
		if (!array_key_exists('date', $config))
			$config['date'] = gmdate('Y-m-d H:i:s');

		parent::__construct($config);
	}

}
