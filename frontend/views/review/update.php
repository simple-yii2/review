<?php

use yii\helpers\Html;

$title = $form->getModel()->name;

$this->title = $title . ' | ' . Yii::$app->name;

?>
<h1><?= Html::encode($title) ?></h1>

<?= $this->render('form', [
	'form' => $form,
]) ?>
