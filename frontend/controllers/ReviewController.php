<?php

namespace cms\review\frontend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\Controller;

use cms\review\common\models\Review;
use cms\review\frontend\models\ReviewForm;

class ReviewController extends Controller
{

	/**
	 * List
	 * @return string
	 */
	public function actionIndex()
	{
		$query = Review::find()->orderBy(['date' => SORT_DESC]);

		if (!Yii::$app->getUser()->can('Review'))
			$query->andWhere(['or',
				['user_id' => Yii::$app->getUser()->getId()],
				['active' => true],
			]);

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Create
	 * @return string
	 */
	public function actionCreate()
	{
		$user = Yii::$app->getUser();

		$object = new Review(['user_id' => $user->getId()]);
		$object->active = false;
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

	/**
	 * Update
	 * @param integer $id 
	 * @return string
	 */
	public function actionUpdate($id)
	{
		$object = Review::findOne($id);
		if ($object === null)
			throw new BadRequestHttpException(Yii::t('review', 'Item not found.'));

		$user = Yii::$app->getUser();

		if (!$user->can('Review'))
			throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));

		$object->active = false;

		$model = new ReviewForm($object);

		if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
			Yii::$app->session->setFlash('success', Yii::t('review', 'Changes saved successfully.'));
			return $this->redirect(['index']);
		}

		return $this->render('update', [
			'model' => $model,
		]);

	}

	/**
	 * Delete
	 * @param integer $id 
	 * @return string
	 */
	public function actionDelete($id)
	{
		$object = Review::findOne($id);
		if ($object === null)
			throw new BadRequestHttpException(Yii::t('review', 'Item not found.'));

		$user = Yii::$app->getUser();

		if (!$user->can('Review'))
			throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));

		if ($object->delete())
			Yii::$app->session->setFlash('success', Yii::t('review', 'Review deleted successfully.'));

		return $this->redirect(['index']);
	}

	/**
	 * Activate/deactivate
	 * @param integer $id 
	 * @return string
	 */
	public function actionActive($id)
	{
		$object = Review::findOne($id);
		if ($object === null)
			throw new BadRequestHttpException(Yii::t('review', 'Item not found.'));

		if (!Yii::$app->getUser()->can('Review'))
			throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));

		$object->active = !$object->active;
		
		if ($object->update(false, ['active']))
			Yii::$app->session->setFlash('success', Yii::t('review', 'Changes saved successfully.'));

		return $this->redirect(['index']);
	}

}
