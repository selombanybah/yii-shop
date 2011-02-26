<h2> <?php echo Shop::t('Customer information'); ?> </h2>
<?php
 $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'firstname',
		'lastname',
		'email',
	),
)); 


if($model->address) {
	echo '<h2>'.Shop::t('Address').'</h2>';
 $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model->address,
	'attributes'=>array(
		'street',
		'zipcode',
		'city',
	),
)); 

}

if($model->deliveryAddress) {
	echo '<h2>'.Shop::t('Delivery address').'</h2>';
 $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model->deliveryAddress,
	'attributes'=>array(
		'street',
		'zipcode',
		'city',
	),
)); 

}
if($model->billingAddress) {
	echo '<h2>'.Shop::t('Billing address').'</h2>';
 $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model->billingAddress,
	'attributes'=>array(
		'street',
		'zipcode',
		'city',
	),
)); 

}



?>
