<?php echo CHtml::beginForm(
		array('//shop/shoppingCart/create'), 'POST', array(
'enctype' => 'multipart/form-data'
)); ?>

<?php
if(count($products) == 1) {
	echo Shop::t('Product').': ';
	echo $products[0]->title;
}
else {
	echo '<strong>'.Shop::t('Select a Product').': </strong>';
	echo CHtml::dropDownList('product',
			0,
			CHtml::listData($products, 'product_id', 'title')); 
}
?>
<hr />

<div id="please_select_a_image" style="display: none;"> 
<?php echo Shop::t('Please select a image from your hard drive'); ?>
</div>

<div id="variations"> </div>

<div id="image_upload_loading" style="display: none;"> 
<?php echo CHtml::image(Yii::app()->assetManager->publish(
			Yii::getPathOfAlias('application.modules.shop.assets').'/loading.gif')); ?>
<br />
<?php echo Shop::t('Please wait while your image is being uploaded'); ?>
</div>

<?php
echo '<div style="clear: both;"></div>';
echo '<div class="shop-variation-amount">';
echo '<strong>'.CHtml::label(Shop::t('Amount'), 'ShoppingCart_amount').'</strong>';
echo ': ';
echo CHtml::textField('amount', 1, array('size' => 3));
echo '</div>';

echo CHtml::submitButton(
		Shop::t('Add to shopping Cart'), array(
			'id' => 'btn-add-to-cart',
			'class' => 'btn-add-cart'));
			
echo '<div style="clear: both;"></div>';
?>

<hr />

<?php echo CHtml::endForm(); ?>

<?php
Yii::app()->clientScript->registerScript('btn-add-to-cart', "
		$('#btn-add-to-cart').click(function() {
			if($('input[type=file]').val()) {
			$('#image_upload_loading').show();
			} else {
			$('#please_select_a_image').show();

			event.preventDefault();
			}
			});
		");

if(count($products) > 1) {
	Yii::app()->clientScript->registerScript('product_selection', "
			$('#variations').load('".Yii::app()->controller->createUrl(
		'//shop/products/getVariations')."',
				{'product': ".@$products[$selected]->product_id."});

			$('#product').change(function() {
				$('#variations').load('".Yii::app()->controller->createUrl('//shop/products/getVariations')."', $(this));
				});
			", CClientScript::POS_READY);
}
?>
