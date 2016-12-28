<?php

use yii\helpers\Html;

$title = Yii::t('review', 'Add review');

$this->title = $title . ' | ' . Yii::$app->name;

?>
<h1><?= Html::encode($title) ?></h1>

<?= $this->render('form', [
	'model' => $model,
]) ?>
