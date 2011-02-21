<?php 

echo CHtml::beginForm(array('shoppingCart/create'));
echo CHtml::textField('ShoppingCart[amount]', 1, array('size' => 3));
echo CHtml::hiddenField('ShoppingCart[product_id]', $model->product_id);
echo CHtml::hiddenField('ShoppingCart[customer_id]', 1);
//echo CHtml::image($this->module->getIconsPath().'/addToCart.jpg');
echo CHtml::submitButton(Yii::t('ShopModule.shop', 'Add to shopping Cart')); 

echo CHtml::endForm();
?>
