<?php

namespace cms\feedback\frontend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

use cms\feedback\common\models\Feedback;

class FeedbackController extends Controller
{

	public function actionIndex()
	{
		$query = Feedback::find()
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
