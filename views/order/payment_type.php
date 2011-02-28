<h2> <?php echo Shop::t('Payment Method'); ?> </h2>

<?php

echo CHtml::radioButtonList('payment_method',
		Shop::getPaymentMethod() ? Shop::getPaymentMethod() : 1,
		Shop::module()->paymentMethods);
