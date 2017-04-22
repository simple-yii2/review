<?php

namespace cms\review\frontend\models;

use Yii;
use yii\base\Model;
use cms\review\common\models\Review;

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
	 * @var Review
	 */
	private $_model;

	/**
	 * @inheritdoc
	 * @param Review $model 
	 */
	public function __construct(Review $model = null, $config = [])
	{
		if ($model === null)
			$model = new Review;

		$this->_model = $model;

		//attributes
		$this->name = $model->name;
		$this->content = $model->content;

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
	 * Model getter
	 * @return Review
	 */
	public function getModel()
	{
		return $this->_model;
	}

	/**
	 * Saving object using model attributes
	 * @return boolean
	 */
	public function save()
	{
		if (!$this->validate())
			return false;

		$model = $this->_model;

		$model->name = $this->name;
		$model->content = $this->content;

		if (!$model->save(false))
			return false;

		return true;
	}

}
