<?php

namespace cms\feedback\frontend\assets;

use yii\web\AssetBundle;

class FeedbackAsset extends AssetBundle
{

	public $css = [
		'feedback.css',
	];

	public function init()
	{
		parent::init();

		$this->sourcePath = __DIR__ . '/feedback';
	}

}
