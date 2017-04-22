<?php

namespace cms\review\backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use cms\review\backend\models\ReviewForm;
use cms\review\backend\models\ReviewSearch;
use cms\review\common\models\Review;

class ReviewController extends Controller
{

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					['allow' => true, 'roles' => ['Review']],
				],
			],
		];
	}

	/**
	 * List
	 * @return string
	 */
	public function actionIndex()
	{
		$search = new ReviewSearch;

		return $this->render('index', [
			'search' => $search,
		]);
	}

	/**
	 * Create
	 * @return string
	 */
	public function actionCreate()
	{
		$form = new ReviewForm;

		if ($form->load(Yii::$app->getRequest()->post()) && $form->save()) {
			Yii::$app->session->setFlash('success', Yii::t('review', 'Changes saved successfully.'));

			return $this->redirect(['index']);
		}

		return $this->render('create', [
			'form' => $form,
		]);
	}

	/**
	 * Update
	 * @param integer $id
	 * @return string
	 */
	public function actionUpdate($id)
	{
		$model = Review::findOne($id);
		if ($model === null)
			throw new BadRequestHttpException(Yii::t('review', 'Item not found.'));

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
	 * @param integer $id
	 * @return string
	 */
	public function actionDelete($id)
	{
		$model = Review::findOne($id);
		if ($model === null)
			throw new BadRequestHttpException(Yii::t('review', 'Item not found.'));

		if ($model->delete()) {
			Yii::$app->session->setFlash('success', Yii::t('review', 'Item deleted successfully.'));
		}

		return $this->redirect(['index']);
	}

}
