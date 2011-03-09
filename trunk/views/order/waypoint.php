<?php
$points = array(
		Shop::t('Customer information'),
		Shop::t('Payment method'),
		Shop::t('Shipping method'),
		Shop::t('Confirm'));

echo '<div id="waypointarea" class="waypointarea">';
foreach ($points as $p => $pointText) 
{
	printf('<span class="waypoint%s">%s</span>',
			($point == ++$p) ? ' active' : '',
			$point < ++$p ? $pointText : CHtml::linkButton($pointText, array(
					'submit' => array (
						'create', 'step' => --$p)
					)
				)
			);
}
echo '</div>';
?>