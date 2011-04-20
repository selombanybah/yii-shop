<?php
Yii::import('zii.widgets.CPortlet');

/**
 *		
 **/
class ImageUploadWidget extends CPortlet
{
	public $products = null;
	public $view = 'image_upload';

	public function init()
	{
		if($this->products === null)
			throw new CException(
					Shop::t(
						'Please provide a product that can be bought with the ImageUploadWidget'));

		return parent::init();
	}

	public function run() {
		if(!is_array($this->products))
			$this->products = array($products);

		$products = array();
		foreach($this->products as $product) {
			if(is_numeric($product))
				$products[] = Products::model()->findByPk($product);
		}

		$this->render($this->view, array(
					'products' => $products));
		return parent::run();
	}

}
