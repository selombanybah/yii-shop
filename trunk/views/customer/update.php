<?php
$this->breadcrumbs=array(
	'Customers'=>array('index'),
	$customer->customer_id=>array('view','id'=>$customer->customer_id),
	Yii::t('ShopModule.shop', 'Update'),
);

?>
<h2> <?php echo Shop::t('Update Customer Information'); ?> </h2>

<?php echo $this->renderPartial('_form', array(
			'customer'=>$customer,
			'address' => $address, 
			'deliveryAddress' => $deliveryAddress,
			'billingAddress' => $billingAddress,
			)); ?>
