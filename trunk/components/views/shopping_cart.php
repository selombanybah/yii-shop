<div id="shopping-cart">
	<div id="shopping-cart-content">
		<?php
        if($products) {
            $sum_price = 0;
						echo '<h3>'.CHtml::link(Shop::t('Shopping cart'), array(
									'//shop/shoppingCart/view')).'</h3>';
						echo '<table cellpadding="0" cellspacing="0">';	
            foreach($products as $position) { 
                $model = Products::model()->findByPk($position['product_id']);
                printf('<tr><td class="cart-left">%s</td><td class="cart-middle">%s</td><td class="cart-right">%s %s</td></tr>',
                        $position['amount'],
                        $model->title,
                        Shop::priceFormat($position['amount'] * $model->getPrice(@$position['Variations'])),
                        Shop::module()->currencySymbol
                        );
                $sum_price += (float) $position['amount']* $model->getPrice(@$position['Variations']);
            }
           	
        
        
            printf('<tr><td colspan="2" class="cart-left cart-sum"><strong>%s</strong></td><td class="cart-sum cart-right">%s %s</td></tr>',
                    Shop::t('Price total:'),
                    Shop::priceFormat($sum_price),
                    Shop::module()->currencySymbol);
			 echo '</table>';
        }
        ?>
	</div>
    <div id="shopping-cart-footer"></div>
</div>
