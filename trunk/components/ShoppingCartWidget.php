<?php

Yii::import('zii.widgets.CPortlet');

class ShoppingCartWidget extends CPortlet {
	public function	init() {
		return parent::init();
	}

	public function	run() {
		$this->render('shopping_cart', array('products' =>
			Shop::getCartContent()));
		return parent::run();
	}

}
?>
