<?php
if(!isset($customer))
	$customer = new Customer;

if(!isset($address))
	$address = new Address;

$this->breadcrumbs=array(
		Yii::t('ShopModule.shop', 'Customers')=>array('index'),
		Yii::t('ShopModule.shop', 'Register as a new Customer'),
		);

?>

<h2> <?php echo Shop::t('Please enter your Address information'); ?> </h2>

<h3> Click <?php echo CHtml::link('here', Yii::app()->getModule('shop')->loginUrl); ?>, 
	if you are already registered </h3>

	<?php

if($address === null)
	$address = new Address;

if(!isset($deliveryAddress) || $deliveryAddress === null)
	$deliveryAddress = new DeliveryAddress;

if(!isset($billingAddress) || $billingAddress === null)
	$billingAddress = new BillingAddress;



 echo $this->renderPartial('/customer/_form', array(
				'action' => isset($action) ? $action : null,
				'customer'=>$customer,
				'address' =>$address,
				'deliveryAddress' => $deliveryAddress,
				'billingAddress' => $billingAddress,
				)); ?>
