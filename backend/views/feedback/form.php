<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<?php $form = ActiveForm::begin([
	'layout' => 'horizontal',
	'enableClientValidation' => false,
]); ?>

	<?= $form->field($model, 'active')->checkbox() ?>

	<?= $form->field($model, 'date') ?>

	<?= $form->field($model, 'name') ?>

	<?= $form->field($model, 'content')->textarea(['rows' => 5]) ?>

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-6">
			<?= Html::submitButton(Yii::t('feedback', 'Save'), ['class' => 'btn btn-primary']) ?>
			<?= Html::a(Yii::t('feedback', 'Cancel'), ['index'], ['class' => 'btn btn-default']) ?>
		</div>
	</div>

<?php ActiveForm::end(); ?>
