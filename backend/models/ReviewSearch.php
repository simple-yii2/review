<?php

namespace cms\review\backend\models;

use Yii;
use yii\data\ActiveDataProvider;

use cms\review\common\models\Review;

/**
 * Search model
 */
class ReviewSearch extends Review {

	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			['name', 'string'],
		];
	}

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
	 * Search function
	 * @param array $params Attributes array
	 * @return yii\data\ActiveDataProvider
	 */
	public function search($params) {
		//ActiveQuery
		$query = static::find()->orderBy(['active' => SORT_ASC]);

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
