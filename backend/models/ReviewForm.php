<?php

namespace cms\review\backend\models;

use Yii;
use yii\base\Model;
use cms\review\common\models\Review;

/**
 * Editing form
 */
class ReviewForm extends Model
{

	/**
	 * @var boolean Active
	 */
	public $active;

	/**
	 * @var datetime Date
	 */
	public $date;

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
	 * @param Review|null $model 
	 */
	public function __construct(Review $model = null, $config = [])
	{
		if ($model === null)
			$model = new Review;

		$this->_model = $model;

		//attributes
		$this->active = $model->active == 0 ? '0' : '1';
		$this->date = $model->date;
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
			'active' => Yii::t('review', 'Active'),
			'date' => Yii::t('review', 'Date'),
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
			['active', 'boolean'],
			['date', 'match', 'pattern' => '/^\d{4}\-\d{2}\-\d{2}\s\d{2}:\d{2}:\d{2}$/'],
			['name', 'string', 'max' => 50],
			['content', 'string', 'max' => 1000],
			[['date', 'name', 'content'], 'required'],
		];
	}

	/**
	 * Model getter
	 * @return ReviewForm
	 */
	public function getModel()
	{
		return $this->_model;
	}

	/**
	 * Saving model using model attributes
	 * @return boolean
	 */
	public function save()
	{
		if (!$this->validate())
			return false;

		$model = $this->_model;

		$model->active = $this->active == 1;
		$model->date = $this->date;
		$model->name = $this->name;
		$model->content = $this->content;

		if (!$model->save(false))
			return false;

		return true;
	}

}
