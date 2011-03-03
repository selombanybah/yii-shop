<?php
Shop::register('shop.css');
if(!isset($products)) 
	$products = Shop::getCartContent();

if(!isset($this->breadcrumbs))
	$this->breadcrumbs = array(
			Shop::t('Shop') => array('//shop/products/'),
			Shop::t('Shopping Cart'));
	?>
	<h2> <?php echo Shop::t('Shopping cart'); ?> </h2>


<?php
if($products) {
	$price_total = 0;

	echo '<table class="shopping_cart">';
	printf('<tr><th>%s</th><th>%s</th><th>%s</th><th>%s</th><th>%s</th><th>%s</th></tr>',
			Shop::t('Image'),
			Shop::t('Amount'),
			Shop::t('Product'),
			Shop::t('Variation'),
			Shop::t('Price Single'),
			Shop::t('Price Total'),
			Shop::t('Actions')
);

	foreach($products as $position => $product) {
		if(@$model = Products::model()->findByPk($product['product_id'])) {
			$variations = '';
			if(isset($product['Variations'])) {
				foreach($product['Variations'] as $specification => $variation) {
					$specification = ProductSpecification::model()->findByPk($specification);
					if($specification->is_user_input)
						$variation = $variation[0];
					else
						$variation = ProductVariation::model()->findByPk($variation);

					$variations .= $specification . ': ' . $variation . '<br />';
				}
			}

			printf('<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s %s</td><td>%s %s</td><td>%s</td></tr>',
					$model->getImage(),
					CHtml::textField('amount_'.$position,
						$product['amount'], array(
							'size' => 4,
							)
						),
					$model->title,
					$variations,
					Shop::priceFormat($model->getPrice(@$product['Variations'])),
					Shop::module()->currencySymbol,
					Shop::priceFormat(@$product['amount'] * $model->getPrice(@$product['Variations'])),
					Shop::module()->currencySymbol,
					CHtml::link(Shop::t('Remove'), array(
							'//shop/shoppingCart/delete',
							'id' => $position), array(
								'confirm' => Shop::t('Are you sure?')))
					);
			$price_total += $model->getPrice(@$product['Variations']) * @$product['amount'];

			Yii::app()->clientScript->registerScript('amount_'.$position,"
					$('#amount_".$position."').change(function() {
						$.ajax({
							url:'".$this->createUrl('//shop/shoppingCart/updateAmount')."',
							data: $('#amount_".$position."'),
							success: function() {
							$('#amount_".$position."').css('background-color', 'lightgreen');
							},
							error: function() {
							$('#amount_".$position."').css('background-color', 'red');
							},

							});
				});
					");
			}
}
	echo '</table>';

	echo '<h2>' . Shop::t('Price total: {total} {currencySymbol}', array(
				'{total}' => Shop::priceFormat($price_total),
				'{currencySymbol}' => Shop::module()->currencySymbol,
				)) . '</h2>';
?>
<hr />

<?php
echo Shop::t('All prices are gross') . '<br />';
echo Shop::t('All prices excluding shipping costs') . '<br />';
 if(Yii::app()->controller->id != 'order') {
echo CHtml::link(Shop::t('Buy additional Products'), array(
			'//shop/products')) . '<br />'; 
echo CHtml::link(Shop::t('Buy this products'), array(
			'//shop/order/create')); 
}

} else echo Shop::t('Your shopping cart is empty'); ?>

