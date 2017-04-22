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
	 * Creating
	 * @return string
	 */
	public function actionCreate()
	{
		$object = new Review([
			'user_id' => Yii::$app->getUser()->getId(),
		]);

		$model = new ReviewForm($object);

		if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
			Yii::$app->session->setFlash('success', Yii::t('review', 'Changes saved successfully.'));
			return $this->redirect(['index']);
		}

		return $this->render('create', [
			'model' => $model,
		]);
	}

	/**
	 * Updating
	 * @param integer $id
	 * @return string
	 */
	public function actionUpdate($id)
	{
		$object = Review::findOne($id);
		if ($object === null)
			throw new BadRequestHttpException(Yii::t('review', 'Item not found.'));

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
	 * Deleting
	 * @param integer $id
	 * @return string
	 */
	public function actionDelete($id)
	{
		$object = Review::findOne($id);
		if ($object === null)
			throw new BadRequestHttpException(Yii::t('review', 'Item not found.'));

		if ($object->delete()) {
			Yii::$app->session->setFlash('success', Yii::t('review', 'Item deleted successfully.'));
		}

		return $this->redirect(['index']);
	}

}
