<h2> <?php echo Shop::t('Customer information'); ?> </h2>
<?php
 $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'email',
	),
)); 


if($model->address && !isset($hideAddress)) {
	echo '<h2>'.Shop::t('Address').'</h2>';
 $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model->address,
	'attributes'=>array(
		'firstname',
		'lastname',
		'street',
		'zipcode',
		'city',
		'country',
	),
)); 

}
echo '<h2>'.Shop::t('Delivery address').'</h2>';
 $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model->deliveryAddress ? $model->deliveryAddress : $model->address,
	'attributes'=>array(
		'firstname',
		'lastname',
		'street',
		'zipcode',
		'city',
		'country',
	),
)); 

	echo '<h2>'.Shop::t('Billing address').'</h2>';
 $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model->billingAddress ? $model->billingAddress : $model->address,
	'attributes'=>array(
		'firstname',
		'lastname',
		'street',
		'zipcode',
		'city',
		'country',
	),
)); 




?>
