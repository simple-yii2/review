<?php

use yii\helpers\Html;

$title = $model->name;

$this->title = $title . ' | ' . Yii::$app->name;

$this->params['breadcrumbs'] = [
	['label' => Yii::t('review', 'Reviews'), 'url' => ['index']],
	$title,
];

?>
<h1><?= Html::encode($title) ?></h1>

<?= $this->render('form', [
	'model' => $model,
]) ?>
