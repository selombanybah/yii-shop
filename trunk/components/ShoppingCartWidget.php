<?php

Yii::import('zii.widgets.CPortlet');

class ShoppingCartWidget extends CPortlet {
	public function	init() {
		$this->title = CHtml::link(Shop::t('Shopping cart'), array(
									'//shop/shoppingCart/view'));
		return parent::init();
	}

	public function	run() {
		$this->render('shopping_cart', array(
					'products' => Shop::getCartContent()));
		return parent::run();
	}

}
?>
