<?php echo CHtml::beginForm( array(
			'//shop/shoppingCart/create'),
		'POST', array(
			'enctype' => 'multipart/form-data'
			)); ?>


<h2> <?php echo $product->title; ?> </h2>

<?php echo $product->description; ?>

<hr />

<?php
if($variations = $product->getVariations()) {
	foreach($variations as $variation) {
		$field = "Variations[{$variation[0]->specification_id}][]";
		echo CHtml::label($variation[0]->specification->title,
				$field, array(
					'class' => 'lbl-header'));

		if($variation[0]->specification->required)
			echo ' <span class="required">*</span>';

		echo  '<br />';
		if($variation[0]->specification->input_type == 'textfield') {
			echo CHtml::textField($field);
		} else if ($variation[0]->specification->input_type == 'select'){
			// If the specification is required, preselect the first field. Otherwise
			// let the customer choose which one to pick
			echo CHtml::radioButtonList($field,
					$variation[0]->specification->required ? $variation[0]->id : null,
					ProductVariation::listData($variation));
		} else if ($variation[0]->specification->input_type == 'image'){
			echo CHtml::fileField('filename');
		}
	}

}

echo '<div style="clear: both;"></div>';
echo '<br />';
echo CHtml::hiddenField('product_id', $product->product_id);
echo CHtml::label(Shop::t('Amount'), 'ShoppingCart_amount');
echo ': ';
echo CHtml::textField('amount', 1, array('size' => 3));
echo '<br />';

echo CHtml::submitButton(
		Shop::t('Add to shopping Cart'), array( 'class' => 'btn-add-cart'));

?>

<hr />

<?php echo CHtml::endForm(); ?>
