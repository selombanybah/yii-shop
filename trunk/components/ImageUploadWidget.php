<?php
Yii::import('zii.widgets.CPortlet');

/**
 *		
 **/
class ImageUploadWidget extends CPortlet
{
	public $product_id = null;
	public $view = 'image_upload';

	public function init()
	{
		if(!$this->product_id)
			throw new CException(
					Shop::t(
						'Please provide a product that can be bought with the ImageUploadWidget'));

		$this->title = Shop::t('Upload a Image');
		return parent::init();
	}

	public function run() {
		$this->render($this->view, array(
					'product' => Products::model()->findByPk($this->product_id)));
		return parent::run();
	}

}
