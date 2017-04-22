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
		$query = Review::find()->orderBy(['active' => SORT_ASC, 'date' => SORT_DESC]);

		$user = Yii::$app->getUser();

		if (!$user->can('Review')) {
			$condition = ['or', ['active' => true]];
			if (!$user->isGuest)
				$condition[] = ['user_id' => $user->getId()];

			$query->andWhere($condition);
		}

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

		$model = new Review(['active' => false]);
		if (!$user->isGuest)
			$model->user_id = $user->getId();
		if ($user->hasMethod('getUsername'))
			$model->name = $user->getUsername();

		$form = new ReviewForm($model);

		if ($form->load(Yii::$app->getRequest()->post()) && $form->save()) {
			Yii::$app->session->setFlash('success', Yii::t('review', 'Your review has been added and will be visible to others after verification.'));

			return $this->redirect(['index']);
		}

		return $this->render('create', [
			'form' => $form,
		]);
	}

	/**
	 * Update
	 * @param int $id 
	 * @return string
	 */
	public function actionUpdate($id)
	{
		$model = Review::findOne($id);
		if ($model === null)
			throw new BadRequestHttpException(Yii::t('review', 'Item not found.'));

		$user = Yii::$app->getUser();

		if (!$user->can('ReviewUpdate', [$model]))
			throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));

		$model->active = false;

		$form = new ReviewForm($model);

		if ($form->load(Yii::$app->getRequest()->post()) && $form->save()) {
			Yii::$app->session->setFlash('success', Yii::t('review', 'Changes saved successfully.'));

			return $this->redirect(['index']);
		}

		return $this->render('update', [
			'form' => $form,
		]);

	}

	/**
	 * Delete
	 * @param int $id 
	 * @return string
	 */
	public function actionDelete($id)
	{
		$model = Review::findOne($id);
		if ($model === null)
			throw new BadRequestHttpException(Yii::t('review', 'Item not found.'));

		$user = Yii::$app->getUser();

		if (!$user->can('ReviewUpdate', [$model]))
			throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));

		if ($model->delete())
			Yii::$app->session->setFlash('success', Yii::t('review', 'Review deleted successfully.'));

		return $this->redirect(['index']);
	}

	/**
	 * Activate/deactivate
	 * @param int $id 
	 * @return string
	 */
	public function actionActive($id)
	{
		$module = Review::findOne($id);
		if ($module === null)
			throw new BadRequestHttpException(Yii::t('review', 'Item not found.'));

		if (!Yii::$app->getUser()->can('Review'))
			throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));

		$module->active = !$module->active;
		
		if ($module->update(false, ['active']))
			Yii::$app->session->setFlash('success', Yii::t('review', 'Changes saved successfully.'));

		return $this->redirect(['index']);
	}

}
