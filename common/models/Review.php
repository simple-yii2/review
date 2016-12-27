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
	public function init()
	{
		parent::init();

		$this->active = false;
		$this->date = date('Y-m-d H:i:s');
	}

}
