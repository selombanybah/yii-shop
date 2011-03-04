<?php
$this->renderPartial('/order/waypoint', array('point' => 3));

if(!isset($customer))
	$customer = new Customer;

if(!isset($deliveryAddress))
	if(isset($customer->deliveryAddress))
		$deliveryAddress = $customer->deliveryAddress;
	else
		$deliveryAddress = new DeliveryAddress;

if(!isset($this->breadcrumbs))
	$this->breadcrumbs = array(
			Shop::t('Order'),
			Shop::t('Shipping method'));
?>

<h2> <?php echo Shop::t('Choose your Shipping method'); ?> </h2>

<?php
$i = 0;
$form=$this->beginWidget('CActiveForm', array(
			'id'=>'customer-form',
			'action' => array('//shop/order/create'),
			'enableAjaxValidation'=>false,
			)); 

foreach(ShippingMethod::model()->findAll() as $method) {
	echo CHtml::radioButton("ShippingMethod", $i == 0, array(
				'value' => $method->id));
	echo CHtml::label($method->title, 'ShippingMethod');
	echo CHtml::tag('p', array(), $method->description);
	echo CHtml::tag('p', array(), Shop::t('Price: ') . $method->price);
	echo '<br />';
	$i++;
}
	echo CHtml::checkBox('toggle_delivery',
			$customer->deliveryAddress !== NULL, array(
				'style' => 'float: left')); 
	echo CHtml::label(Shop::t('alternative delivery address'), 'toggle_delivery');
	?>

	<div class="form">
	<fieldset id="delivery_information" style="display: none;">
	<legend> <?php echo Shop::t('Delivery information'); ?> </legend>
	<div class="row">
		<?php echo $form->labelEx($deliveryAddress,'firstname'); ?>
		<?php echo $form->textField($deliveryAddress,'firstname',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($deliveryAddress,'firstname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($deliveryAddress,'lastname'); ?>
		<?php echo $form->textField($deliveryAddress,'lastname',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($deliveryAddress,'lastname'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($deliveryAddress,'street'); ?>
		<?php echo $form->textField($deliveryAddress,'street',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($deliveryAddress,'street'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($deliveryAddress,'city'); ?>
		<?php echo $form->textField($deliveryAddress,'zipcode',array('size'=>10,'maxlength'=>45)); ?>
		<?php echo $form->error($deliveryAddress,'zipcode'); ?>

		<?php echo $form->textField($deliveryAddress,'city',array('size'=>32,'maxlength'=>45)); ?>
		<?php echo $form->error($deliveryAddress,'city'); ?>

		<div class="row">
		<?php echo $form->labelEx($deliveryAddress,'country'); ?>
		<?php echo $form->textField($deliveryAddress,'country',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($deliveryAddress,'country'); ?>
		</div>

		</div>

	</fieldset>

<?php
 Yii::app()->clientScript->registerScript('toggle', "
	if($('#toggle_delivery').attr('checked'))
		$('#delivery_information').show();
	$('#toggle_delivery').click(function() { 
		$('#delivery_information').toggle(500);
	});
");
echo CHtml::submitButton(Shop::t('Continue'));
echo '</div>';
$this->endWidget(); 

