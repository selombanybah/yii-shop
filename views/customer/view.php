<h2> <?php echo Shop::t('Customer information'); ?> </h2>
<?php
 $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'firstname',
		'lastname',
		'address',
		'zipcode',
		'city',
		'country',
		'email',
	),
)); 


if($model->delivery_address) {
	echo '<h2>'.Shop::t('Delivery address').'</h2>';
 $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'delivery_address',
		'delivery_zipcode',
		'delivery_city',
	),
)); 

}
if($model->billing_address) {
	echo '<h2>'.Shop::t('Billing address').'</h2>';
 $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'billing_address',
		'billing_zipcode',
		'billing_city',
	),
)); 

}



?>
