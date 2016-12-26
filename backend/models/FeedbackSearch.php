<?php

namespace cms\feedback\backend\models;

use Yii;
use yii\data\ActiveDataProvider;

use cms\feedback\common\models\Feedback;

/**
 * Search model
 */
class FeedbackSearch extends Feedback {

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
			'date' => Yii::t('feedback', 'Date'),
			'name' => Yii::t('feedback', 'Name'),
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
