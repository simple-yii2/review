<?php

use yii\helpers\Html;

$title = Yii::t('feedback', 'Create feedback');

$this->title = $title . ' | ' . Yii::$app->name;

$this->params['breadcrumbs'] = [
	['label' => Yii::t('feedback', 'Feedbacks'), 'url' => ['index']],
	$title,
];

?>
<h1><?= Html::encode($title) ?></h1>

<?= $this->render('form', [
	'model' => $model,
]) ?>
