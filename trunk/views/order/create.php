<?php
$this->breadcrumbs=array(
	'Order'=>array('index'),
	Yii::t('ShopModule.shop', 'New Order'),
);

?>

<h1>I want to buy this Items </h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-form',
	'enableAjaxValidation'=>true,
)); ?>

<?php

$Carts = ShoppingCart::getCartsofOwner();


echo '<table>';
foreach($Carts as $Cart) {
	$price = (float) $Cart->Product->price;
	printf('<tr><td> %s %s %s (%s * %s = %s) </td></tr>',
		$Cart->amount,
		Yii::t('ShopModule.shop', 'of'),
		$Cart->Product->title,
		$price,	
		$Cart->amount,
		$Cart->amount * $price	);
}

echo '</table>';
?>

<?php echo $form->hiddenField($model,'customer_id', array('value' => $customer_id)); ?>
<?php echo $form->hiddenField($model,'cartowner', array('value' => Yii::app()->User->getState('cartowner'))); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('ShopModule.shop', 'Confirm Order')); ?>
		<?php echo CHtml::Button(Yii::t('ShopModule.shop', 'Cancel')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
