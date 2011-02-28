<?php
$this->breadcrumbs=array(
	'Order'=>array('index'),
	Yii::t('ShopModule.shop', 'New Order'),
);

?>

<?php 
$this->renderPartial('application.modules.shop.views.shoppingCart.view'); 

// If the customer is not passed over to the view, we assume the user is 
// logged in and we fetch the customer data from the customer table
if(!isset($customer))
	$customer = Shop::getCustomer();

$this->renderPartial('application.modules.shop.views.customer.view', array(
				'model' => $customer));


	?>

	<div class="row buttons">
	<?php echo CHtml::link(Shop::t('Edit customer Information'), array(
				'//shop/customer/update', 'order' => true)); ?>
	<?php echo CHtml::link(Shop::t('Confirm Order'), array(
				'//shop/order/confirm')); ?>
	</div>

