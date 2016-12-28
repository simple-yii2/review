<?php

namespace cms\review\frontend\models;

use Yii;
use yii\base\Model;

/**
 * Editing form
 */
class ReviewForm extends Model
{

	/**
	 * @var string User name
	 */
	public $name;

	/**
	 * @var string Text
	 */
	public $content;

	/**
	 * @var cms\review\common\models\Review
	 */
	private $_object;

	/**
	 * @inheritdoc
	 * @param cms\review\common\models\Review $object 
	 */
	public function __construct(\cms\review\common\models\Review $object, $config = [])
	{
		$this->_object = $object;

		//attributes
		$this->name = $object->name;
		$this->content = $object->content;

		parent::__construct($config);
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'name' => Yii::t('review', 'Name'),
			'content' => Yii::t('review', 'Review'),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['name', 'string', 'max' => 50],
			['content', 'string', 'max' => 1000],
			[['name', 'content'], 'required'],
		];
	}

	/**
	 * Saving object using model attributes
	 * @return boolean
	 */
	public function save()
	{
		if (!$this->validate())
			return false;

		$object = $this->_object;

		$object->name = $this->name;
		$object->content = $this->content;

		if (!$object->save(false))
			return false;

		return true;
	}

}
