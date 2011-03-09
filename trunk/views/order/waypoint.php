<?php
$points = array(
		Shop::t('Customer information'),
		Shop::t('Shipping method'),
		Shop::t('Payment method'),
		Shop::t('Confirm'));

$links = array(
		array('//shop/customer/create'),
		array('//shop/shippingMethod/choose'),
		array('//shop/paymentMethod/choose'),
		array('//shop/order/create'));


echo '<div id="waypointarea" class="waypointarea">';
foreach ($points as $p => $pointText) 
{
	printf('<span class="waypoint%s">%s</span>',
			($point == ++$p) ? ' active' : '',
			$point < ++$p ? $pointText : CHtml::link($pointText, @$links[$p-2])
			);
}
echo '</div>';
?>
