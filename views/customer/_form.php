<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'customer-form',
	'action' => array('customer/create'),
	'enableAjaxValidation'=>true,
)); ?>

	<?php echo $form->errorSummary($model); ?>

		<?php echo $form->hiddenField($model, 'user_id', array('value'=> Yii::app()->user->id)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'firstname'); ?>
		<?php echo $form->textField($model,'firstname',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'firstname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'lastname'); ?>
		<?php echo $form->textField($model,'lastname',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'lastname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model,'zipcode',array('size'=>10,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'zipcode'); ?>

		<?php echo $form->textField($model,'city',array('size'=>32,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'country'); ?>
		<?php echo $form->textField($model,'country',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'country'); ?>
	</div>

	<?php 
	echo CHtml::checkBox('toggle_delivery', 0, array('style' => 'float: left')); 
	echo CHtml::label(Shop::t('alternative delivery address'), 'toggle_delivery');
	?>
	<fieldset id="delivery_information">
	<legend> <?php echo Shop::t('Delivery information'); ?> </legend>
	<div class="row">
		<?php echo $form->labelEx($model,'delivery_address'); ?>
		<?php echo $form->textField($model,'delivery_address',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'delivery_address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'delivery_city'); ?>
		<?php echo $form->textField($model,'delivery_zipcode',array('size'=>10,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'delivery_zipcode'); ?>

		<?php echo $form->textField($model,'delivery_city',array('size'=>32,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'delivery_city'); ?>
	</div>

	</fieldset>

	<?php 
	echo CHtml::checkBox('toggle_billing',
			$model->alternativeBillingAddress(), array(
				'style' => 'float: left')); 
	echo CHtml::label(Shop::t('Alternative billing address'), 'toggle_billing');
	?>
	<fieldset id="billing_information">
	<legend> <?php echo Shop::t('Billing information'); ?> </legend>
	<div class="row">
		<?php echo $form->labelEx($model,'billing_address'); ?>
		<?php echo $form->textField($model,'billing_address',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'billing_address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'billing_city'); ?>
		<?php echo $form->textField($model,'billing_zipcode',array('size'=>10,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'billing_zipcode'); ?>

		<?php echo $form->textField($model,'billing_city',array('size'=>32,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'billing_city'); ?>
	</div>

	</fieldset>


<?php Yii::app()->clientScript->registerScript('toggle', "
	$('#toggle_billing').click(function() { 
		$('#billing_information').toggle(500);
	});
	$('#toggle_delivery').click(function() { 
		$('#delivery_information').toggle(500);
	});
"); ?>


	


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('ShopModule.shop', 'Register') : Yii::t('ShopModule.shop', 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
