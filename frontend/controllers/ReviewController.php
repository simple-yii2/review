<?php

namespace cms\review\frontend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

use cms\review\frontend\models\ReviewForm;
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

	public function actionCreate()
	{
		$user = Yii::$app->getUser();

		$object = new Review(['user_id' => $user->getId()]);
		$object->active = $user->can('Review');
		if ($user->hasMethod('getUsername'))
			$object->name = $user->getUsername();

		$model = new ReviewForm($object);

		if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
			Yii::$app->session->setFlash('success', Yii::t('review', 'Your review added and will be visible to others after checking.'));
			return $this->redirect(['index']);
		}

		return $this->render('create', [
			'model' => $model,
		]);
	}

}
