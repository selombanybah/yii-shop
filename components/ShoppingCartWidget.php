<?php

Yii::import('zii.widgets.CPortlet');

class ShoppingCartWidget extends CPortlet {
	public function	init() {
		$this->title = Shop::t('Shopping cart');
		return parent::init();
	}

	public function	run() {
		$this->render('shopping_cart', array('products' =>
			Shop::getCartContent()));

		return parent::run();
	}

}
?>
