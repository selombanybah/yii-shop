<?php

if($products) {
	echo '<table>';	
	foreach($products as $position) { 
		$model = Products::model()->findByPk($position['product_id']);
		printf('<tr><td>%s</td><td>%s</td><td>%s %s</td>',
				$position['amount'],
				$model->title,
				$position['amount'] * $model->getPrice(@$position['Variations']),
				Shop::module()->currencySymbol
);
	}
	echo '</table>';	
}
?>
