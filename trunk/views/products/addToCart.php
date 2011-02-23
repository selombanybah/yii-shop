<?php 
echo CHtml::beginForm(array('shoppingCart/create'));

echo CHtml::hiddenField('product_id', $model->product_id);
echo CHtml::label(Shop::t('Amount'), 'ShoppingCart_amount');
echo CHtml::textField('amount', 1, array('size' => 3));

echo '<br />';

$variations = $model->getVariations();
if($variations) {
	foreach($variations as $variation) {
		echo '<div style="float: left;margin: 10px;">';
		echo CHtml::radioButtonList("Variations[{$variation[0]->specification_id}][]", 0, CHtml::listData($variation, 'id', 'title'));
		echo '</div>';
	}

echo '<div style="clear: both;"></div>';

}
//echo CHtml::image($this->module->getIconsPath().'/addToCart.jpg');
echo CHtml::submitButton(Shop::t('Add to shopping Cart')); 

echo CHtml::endForm();
?>
