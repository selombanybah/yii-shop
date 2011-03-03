<div class="form">

<?php
if(isset($action) && $action !== null) 
	$form=$this->beginWidget('CActiveForm', array(
				'id'=>'customer-form',
				'action' => $action,
				'enableAjaxValidation'=>false,
				)); 
else
$form=$this->beginWidget('CActiveForm', array(
			'id'=>'customer-form',
			'enableAjaxValidation'=>false,
			)); ?>

<?php echo $form->errorSummary(array($customer, $address)); ?>

		<?php echo $form->hiddenField($customer, 'user_id', array('value'=> Yii::app()->user->id)); ?>

	<div class="row">
		<?php echo $form->labelEx($customer,'firstname'); ?>
		<?php echo $form->textField($customer,'firstname',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($customer,'firstname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($customer,'lastname'); ?>
		<?php echo $form->textField($customer,'lastname',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($customer,'lastname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($customer,'email'); ?>
		<?php echo $form->textField($customer,'email',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($customer,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($address,'street'); ?>
		<?php echo $form->textField($address,'street',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($address,'street'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($address,'city'); ?>
		<?php echo $form->textField($address,'zipcode',array('size'=>10,'maxlength'=>45)); ?>
		<?php echo $form->error($address,'zipcode'); ?>

		<?php echo $form->textField($address,'city',array('size'=>32,'maxlength'=>45)); ?>
		<?php echo $form->error($address,'city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($address,'country'); ?>
		<?php echo $form->textField($address,'country',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($address,'country'); ?>
	</div>

	<?php 
	echo CHtml::checkBox('toggle_delivery',
			$customer->deliveryAddress !== NULL, array(
				'style' => 'float: left')); 
	echo CHtml::label(Shop::t('alternative delivery address'), 'toggle_delivery');
	?>
	<fieldset id="delivery_information" style="display: none;">
	<legend> <?php echo Shop::t('Delivery information'); ?> </legend>
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

	<div style="clear: both;"> </div>

	<?php 
	echo CHtml::checkBox('toggle_billing',
			$customer->billingAddress !== NULL, array(
				'style' => 'float: left')); 
	echo CHtml::label(Shop::t('alternative billing address'), 'toggle_billing');
	?>
	<fieldset id="billing_information" style="display: none;" >
	<legend> <?php echo Shop::t('Billing information'); ?> </legend>
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


<?php Yii::app()->clientScript->registerScript('toggle', "
	if($('#toggle_billing').attr('checked'))
		$('#billing_information').show();

	if($('#toggle_delivery').attr('checked'))
		$('#delivery_information').show();

	$('#toggle_billing').click(function() { 
		$('#billing_information').toggle(500);
	});
	$('#toggle_delivery').click(function() { 
		$('#delivery_information').toggle(500);
	});
"); ?>

	<div class="row buttons">
	<?php echo CHtml::submitButton($customer->isNewRecord 
			? Yii::t('ShopModule.shop', 'Register') 
			: Yii::t('ShopModule.shop', 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
