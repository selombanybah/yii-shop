<?php
$this->renderPartial('/order/waypoint', array('point' => 2));

if(!isset($customer))
	$customer = new Customer;

	if(!isset($billingAddress))
		if(isset($customer->billingAddress))
			$billingAddress = $customer->billingAddress;
		else
			$billingAddress = new BillingAddress;

if(!isset($this->breadcrumbs))
	$this->breadcrumbs = array(
			Shop::t('Order'),
			Shop::t('Payment method'));
?>

<h2> <?php echo Shop::t('Choose your Payment method'); ?> </h2>

<?php
$i = 0;
$form=$this->beginWidget('CActiveForm', array(
			'id'=>'customer-form',
			'action' => array('//shop/order/create'),
			'enableAjaxValidation'=>false,
			)); 


foreach(PaymentMethod::model()->findAll() as $method) {
	echo CHtml::radioButton("PaymentMethod", $i == 0, array(
				'value' => $method->id));
	echo CHtml::label($method->title, 'PaymentMethod');
	echo CHtml::tag('p', array(), $method->description);
	echo '<br />';
	$i++;
}
	echo CHtml::checkBox('toggle_billing',
			$customer->billingAddress !== NULL, array(
				'style' => 'float: left')); 
	echo CHtml::label(Shop::t('alternative billing address'), 'toggle_billing');
	?>

<div class="form">
	<fieldset id="billing_information" style="display: none;" >
	<legend> <?php echo Shop::t('Billing information'); ?> </legend>
	<div class="row">
		<?php echo $form->labelEx($billingAddress,'firstname'); ?>
		<?php echo $form->textField($billingAddress,'firstname',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($billingAddress,'firstname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($billingAddress,'lastname'); ?>
		<?php echo $form->textField($billingAddress,'lastname',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($billingAddress,'lastname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($billingAddress,'street'); ?>
		<?php echo $form->textField($billingAddress,'street',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($billingAddress,'street'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($billingAddress,'city'); ?>
		<?php echo $form->textField($billingAddress,'zipcode',array('size'=>10,'maxlength'=>45)); ?>
		<?php echo $form->error($billingAddress,'zipcode'); ?>

		<?php echo $form->textField($billingAddress,'city',array('size'=>32,'maxlength'=>45)); ?>
		<?php echo $form->error($billingAddress,'city'); ?>
	</div>

	<div class="row">
	<?php echo $form->labelEx($billingAddress,'country'); ?>
	<?php echo $form->textField($billingAddress,'country',array('size'=>45,'maxlength'=>45)); ?>
	<?php echo $form->error($billingAddress,'country'); ?>
	</div>

	</fieldset>
<div class="row buttons">
<?php
echo CHtml::submitButton(Shop::t('Continue'),array('id'=>'next'));
?>
</div>

<?php
echo '</div>';
$this->endWidget(); 
Yii::app()->clientScript->registerScript('toggle', "
	if($('#toggle_billing').attr('checked'))
		$('#billing_information').show();

	$('#toggle_billing').click(function() { 
		$('#billing_information').toggle(500);
	});
"); 

