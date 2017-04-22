<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<?php $f = ActiveForm::begin([
	'layout' => 'horizontal',
	'enableClientValidation' => false,
]); ?>

	<fieldset>
		<?= $f->field($form, 'active')->checkbox() ?>
		<?= $f->field($form, 'date') ?>
		<?= $f->field($form, 'name') ?>
		<?= $f->field($form, 'content')->textarea(['rows' => 5]) ?>
	</fieldset>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-6">
			<?= Html::submitButton(Yii::t('review', 'Save'), ['class' => 'btn btn-primary']) ?>
			<?= Html::a(Yii::t('review', 'Cancel'), ['index'], ['class' => 'btn btn-default']) ?>
		</div>
	</div>

<?php ActiveForm::end(); ?>
