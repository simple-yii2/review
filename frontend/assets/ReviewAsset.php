<?php

namespace cms\review\frontend\assets;

use yii\web\AssetBundle;

class ReviewAsset extends AssetBundle
{

	public $css = [
		'review.css',
	];

	public function init()
	{
		parent::init();

		$this->sourcePath = __DIR__ . '/review';
	}

}
