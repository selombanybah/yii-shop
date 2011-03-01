<?php
$this->breadcrumbs=array(
	'Order'=>array('index'),
	Shop::t('New Order'),
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

echo '<br />';
echo '<br />';
$this->renderPartial('application.modules.shop.views.order.payment_type');
echo '<br />';
echo '<br />';
echo CHtml::beginForm(array('//shop/order/confirm'));
$this->renderPartial(Shop::module()->termsView);
echo '<br />';
echo '<br />';

	?>

	<div class="row buttons">
	<?php echo CHtml::link(Shop::t('Edit customer Information'), array(
				'//shop/customer/update', 'order' => true)); ?>
	<?php echo CHtml::submitButton(Shop::t('Confirm Order'), array(
				'//shop/order/confirm')); ?>

<?php echo CHtml::endForm(); ?>
	</div>

