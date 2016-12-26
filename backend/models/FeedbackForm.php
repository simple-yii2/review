<?php

namespace cms\feedback\backend\models;

use Yii;
use yii\base\Model;

/**
 * Editing form
 */
class FeedbackForm extends Model
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
	 * @var cms\feedback\common\models\Feedback
	 */
	private $_object;

	/**
	 * @inheritdoc
	 * @param cms\feedback\common\models\Feedback $object 
	 */
	public function __construct(\cms\feedback\common\models\Feedback $object, $config = [])
	{
		$this->_object = $object;

		//attributes
		$this->active = $object->active == 0 ? '0' : '1';
		$this->date = $object->date;
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
			'active' => Yii::t('feedback', 'Active'),
			'date' => Yii::t('feedback', 'Date'),
			'name' => Yii::t('feedback', 'Name'),
			'content' => Yii::t('feedback', 'Content'),
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
	 * Saving object using model attributes
	 * @return boolean
	 */
	public function save()
	{
		if (!$this->validate())
			return false;

		$object = $this->_object;

		if ($object->getIsNewRecord())
			$object->user_id = Yii::$app->getUser()->getId();

		$object->active = $this->active == 1;
		$object->date = $this->date;
		$object->name = $this->name;
		$object->content = $this->content;

		if (!$object->save(false))
			return false;

		return true;
	}

}
