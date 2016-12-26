<?php

use yii\grid\GridView;
use yii\helpers\Html;

$title = Yii::t('feedback', 'Feedbacks');

$this->title = $title . ' | ' . Yii::$app->name;

$this->params['breadcrumbs'] = [
	$title,
];

?>
<h1><?= Html::encode($title) ?></h1>

<div class="btn-toolbar" role="toolbar">
	<?= Html::a(Yii::t('feedback', 'Create'), ['create'], ['class' => 'btn btn-primary']) ?>
</div>

<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $model,
	'summary' => '',
	'tableOptions' => ['class' => 'table table-condensed'],
	'rowOptions' => function ($model, $key, $index, $grid) {
		return !$model->active ? ['class' => 'warning'] : [];
	},
	'columns' => [
		[
			'attribute' => 'date',
			'format' => 'html',
			'value' => function ($model, $key, $index, $column) {
				$d = strtotime($model->date);
				$date = Yii::$app->formatter->asDate($d, 'short');
				$time = Yii::$app->formatter->asTime($d, 'short');

				return $date . ' ' . Html::tag('span', $time, ['class'=>'text-muted']);
			},
		],
		'name',
		[
			'class' => 'yii\grid\ActionColumn',
			'options' => ['style' => 'width: 50px;'],
			'template' => '{update} {delete}',
		],
	],
]) ?>
