<?php

if($products) {
	$sum_price = 0;
	echo '<table class="cart">';	
	foreach($products as $position) { 
		$model = Products::model()->findByPk($position['product_id']);
		printf('<tr><td>%s</td><td>%s</td><td>%s %s</td>',
				$position['amount'],
				$model->title,
				$position['amount'] * $model->getPrice(@$position['Variations']),
				Shop::module()->currencySymbol
				);
		$sum_price += (float) $position['amount']* $model->getPrice(@$position['Variations']);
	}
	echo '</table>';	


	printf('%s %s %s',
			Shop::t('Price total:'),
			$sum_price,
			Shop::module()->currencySymbol);
}
?>
