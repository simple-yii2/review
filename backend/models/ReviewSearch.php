<?php

namespace cms\review\backend\models;

use Yii;
use yii\data\ActiveDataProvider;
use cms\review\common\models\Review;

/**
 * Search model
 */
class ReviewSearch extends Review
{

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'date' => Yii::t('review', 'Date'),
			'name' => Yii::t('review', 'Name'),
		];
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['name', 'string'],
		];
	}

	/**
	 * Search function
	 * @param array|null $params Attributes array
	 * @return ActiveDataProvider
	 */
	public function getDataProvider($params = null) {
		if ($params === null)
			$params = Yii::$app->getRequest()->get();

		//ActiveQuery
		$query = static::find()
		->orderBy(['active' => SORT_ASC, 'date' => SORT_DESC]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		//return data provider if no search
		if (!($this->load($params) && $this->validate()))
			return $dataProvider;

		//search
		$query->andFilterWhere(['like', 'name', $this->name]);

		return $dataProvider;
	}

}
