<?php

namespace cms\feedback\backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

use cms\feedback\backend\models\FeedbackForm;
use cms\feedback\backend\models\FeedbackSearch;
use cms\feedback\common\models\Feedback;

class FeedbackController extends Controller
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
					['allow' => true, 'roles' => ['Feedback']],
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
		$model = new FeedbackSearch;

		return $this->render('index', [
			'dataProvider' => $model->search(Yii::$app->getRequest()->get()),
			'model' => $model,
		]);
	}

	/**
	 * Creating
	 * @return string
	 */
	public function actionCreate()
	{
		$model = new FeedbackForm(new Feedback);

		if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
			Yii::$app->session->setFlash('success', Yii::t('feedback', 'Changes saved successfully.'));
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
		$object = Feedback::findOne($id);
		if ($object === null)
			throw new BadRequestHttpException(Yii::t('feedback', 'Item not found.'));

		$model = new FeedbackForm($object);

		if ($model->load(Yii::$app->getRequest()->post()) && $model->save()) {
			Yii::$app->session->setFlash('success', Yii::t('feedback', 'Changes saved successfully.'));
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
		$object = Feedback::findOne($id);
		if ($object === null)
			throw new BadRequestHttpException(Yii::t('feedback', 'Item not found.'));

		if ($object->delete()) {
			Yii::$app->session->setFlash('success', Yii::t('feedback', 'Item deleted successfully.'));
		}

		return $this->redirect(['index']);
	}

}
