<?php

namespace cms\review\frontend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

use cms\review\common\models\Review;

class ReviewController extends Controller
{

	/**
	 * List
	 * @return string
	 */
	public function actionIndex()
	{
		$query = Review::find()
			->andWhere(['or',
				['user_id' => Yii::$app->getUser()->getId()],
				['active' => true],
			])->orderBy(['date' => SORT_DESC]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

}
