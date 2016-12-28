<?php

use yii\helpers\Html;
use yii\widgets\ListView;

$title = Yii::t('review', 'Reviews');

$this->title = $title . ' | ' . Yii::$app->name;

?>
<h1><?= Html::encode($title) ?></h1>

<div class="btn-toolbar" role="toolbar">
	<?= Html::a(Yii::t('review', 'Add review'), ['create'], ['class' => 'btn btn-primary']) ?>
</div>

<?= ListView::widget([
	'dataProvider' => $dataProvider,
	'itemView' => 'item',
	'layout' => "{items}\n{pager}",
	'options' => ['class' => 'review-list'],
]) ?>
