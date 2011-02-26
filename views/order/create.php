<?php
$this->breadcrumbs=array(
	'Order'=>array('index'),
	Yii::t('ShopModule.shop', 'New Order'),
);

?>

<?php 
$this->renderPartial('application.modules.shop.views.shoppingCart.view'); 

if(!Yii::app()->user->isGuest) 
	$this->renderPartial('application.modules.shop.views.customer.view', array(
				'model' => Customer::model()->find('user_id = :uid', array(
						':uid' => Yii::app()->user->id))));
elseif(isset($customer))
	$this->renderPartial('application.modules.shop.views.customer.view', array(
				'model' => $customer));

	?>


	<div class="row buttons">
		<?php echo CHtml::Button(Shop::t('Confirm Order')); ?>
		<?php echo CHtml::Button(Shop::t('Cancel')); ?>
	</div>

