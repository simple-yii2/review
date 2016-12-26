<?php

use yii\helpers\Html;

use cms\feedback\frontend\assets\FeedbackAsset;

$date = strtotime($model->date);

$options = [
	'itemscope' => "",
	'itemtype' => 'http://schema.org/Review',
];
if (!$model->active)
	Html::addCssClass($options, 'inactive');

FeedbackAsset::register($this);

?>
<hr>

<?= Html::beginTag('div', $options) ?>
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
	<div itemprop="reviewBody" class="feedback-content">
		<p><?= Html::encode($model->content) ?></p>
	</div>
<?= Html::endTag('div') ?>
