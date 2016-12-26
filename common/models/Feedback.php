<?php

namespace cms\feedback\common\models;

use yii\db\ActiveRecord;

class Feedback extends ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'Feedback';
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
