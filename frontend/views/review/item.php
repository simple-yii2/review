<?php

use yii\helpers\Html;

$date = strtotime($model->date);

$options = [
	'itemscope' => "",
	'itemtype' => 'http://schema.org/Review',
];
if (!$model->active)
	Html::addCssClass($options, 'inactive');

$user = Yii::$app->getUser();
$a = [];
if ($user->can('Review')) {
	$a[] = Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $model->id], [
		'title' => Yii::t('yii', 'Update'),
	]);
	$a[] = Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
		'title' => Yii::t('yii', 'Delete'),
		'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
	]);
	$a[] = Html::a('<span class="glyphicon glyphicon-ok"></span>', ['active', 'id' => $model->id], [
		'title' => Yii::t('review', 'Activate'),
	]);
}

$actions = '';

if (!empty($a))
	$actions = Html::tag('div', implode('&nbsp;', $a), ['class' => 'pull-right']);

?>
<hr>

<?= Html::beginTag('div', $options) ?>
	<?= $actions ?>
	<p>
		<?= Html::tag('meta', '', [
			'itemprop' => 'datePublished',
			'content' => date('Y-m-d', $date),
		]) ?>
		<strong><?= Yii::$app->formatter->asDate($date, 'short') ?></strong>
		<span itemprop="author" itemscope itemtype="http://schema.org/Person">
			<span itemprop="name"><?= Html::encode($model->name) ?></span>
		</span>
	</p>
	<div itemprop="reviewBody" class="review-content">
		<p><?= Html::encode($model->content) ?></p>
	</div>
<?= Html::endTag('div') ?>
