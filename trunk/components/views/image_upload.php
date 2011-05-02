<?php echo CHtml::beginForm( array('//shop/shoppingCart/create'), 'POST', array(
			'enctype' => 'multipart/form-data'
			)); ?>


<?php
if(count($products) == 1) {
	echo Shop::t('Product').':';
	echo $products[0]->title;
}
else {
	echo Shop::t('Select a Product').':';
	echo CHtml::dropDownList('product',
			0,
			CHtml::listData($products, 'product_id', 'title')); 
}
?>
<hr />

<div id="variations"> </div>
<div id="image_upload_loading" style="display: none;"> 
<?php echo CHtml::image(Yii::app()->assetManager->publish(
			Yii::getPathOfAlias('zii.widgets.assets.gridview').'/loading.gif')); ?>
&nbsp;
<?php echo Shop::t('Please wait while your image is being uploaded'); ?>
</div>

<?php
echo '<div style="clear: both;"></div>';
echo '<br />';
echo CHtml::label(Shop::t('Amount'), 'ShoppingCart_amount');
echo ': ';
echo CHtml::textField('amount', 1, array('size' => 3));
echo '<br />';

echo CHtml::submitButton(
		Shop::t('Add to shopping Cart'), array(
			'onclick' => "$('#image_upload_loading').show();",
			'class' => 'btn-add-cart'));
?>

<hr />

<?php echo CHtml::endForm(); ?>

<?php
if(count($products) > 1) {
	Yii::app()->clientScript->registerScript('product_selection', "
			$('#variations').load('".Yii::app()->controller->createUrl('//shop/products/getVariations')."', {'product': ".$products[$selected]->product_id."});
			$('#product').change(function() {
				$('#variations').load('".Yii::app()->controller->createUrl('//shop/products/getVariations')."', $(this));
				});
			");
}
?>
