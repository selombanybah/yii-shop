<?php function renderVariation($variation, $i) { 
	if(!ProductSpecification::model()->findByPk(1))
		return false;
	if(!$variation) {
		$variation = new ProductVariation;
		$variation->specification_id = 1;
	}

	$str = '<div class="row" style="float: left; margin: 5px; padding: 5px; border: 1px solid;">';
	$str .= CHtml::label($variation->specification->title, ""); 
	$str .= CHtml::textField("Variations[{$i}][title]", $variation->title); 

	$str .= CHtml::label(Shop::t("Specification"), ""); 
	$str .= CHtml::dropDownList("Variations[{$i}][specification_id]", $variation->specification_id, CHtml::listData(
				ProductSpecification::model()->findall(), "id", "title"));  

	$str .= CHtml::label(Shop::t('Price adjustion'), ""); 
	$str .= CHtml::textField("Variations[{$i}][price_adjustion]", $variation->price_adjustion);  
	$str .= "</div>";

	$str = str_replace('\n', '', $str);
	$str = str_replace('\r', '', $str);
	return $str;
} ?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
			'id'=>'products-form',
			'enableAjaxValidation'=>true,
			)); ?>

<?php echo $form->errorSummary($model); ?>

<div style="float: left;">
<fieldset>
<legend> <?php echo Shop::t('Article Information'); ?> </legend>
<div class="row">
<?php echo $form->labelEx($model,'category_id'); ?>
<?php $this->widget('application.modules.shop.components.Relation', array(
			'model' => $model,
			'relation' => 'category',
			'fields' => 'title',
			'showAddButton' => false)); ?>
<?php echo $form->error($model,'category_id'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'title'); ?>
<?php echo $form->textField($model,'title',array('size'=>45,'maxlength'=>45)); ?>
<?php echo $form->error($model,'title'); ?>
</div>

<div class="row">
<?php echo $form->labelEx($model,'description'); ?>
<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
<?php echo $form->error($model,'description'); ?>
</div>
</fieldset>
</div>


<fieldset>
<legend> <?php echo Yii::t('ShopModule.shop', 'Article Specifications'); ?> </legend>

<div class="row">
<?php echo $form->labelEx($model,'price'); ?>
<?php echo $form->textField($model,'price',array('size'=>45,'maxlength'=>45)); ?>
<?php echo $form->error($model,'price'); ?>
</div>

<?php foreach(ProductSpecification::model()->findAll() as $specification) { ?>
	<div class="row">
		<?php echo CHtml::label($specification->title, ''); ?>
		<?php echo CHtml::textField("Specifications[{$specification->title}]",
				$model->getSpecification($specification->title),array(
					'size'=>45,'maxlength'=>45)); ?>
		</div>
		<?php } ?>

		</fieldset>
		<fieldset>
		<legend> <?php echo Shop::t('Article Variations'); ?> </legend>
		<div id="variations">
		<?php 
		$i = 0;
		foreach($model->variations as $variation) { 
			echo renderVariation($variation, $i); 
			$i++;
		} ?>
			</div>
		
			<?php echo renderVariation(null, $i); ?>

				</fieldset>


				<div class="row buttons">
				<?php echo CHtml::submitButton($model->isNewRecord ?
						Yii::t('ShopModule.shop', 'Create') 
						: Yii::t('ShopModule.shop', 'Save')); ?>
				</div>

				<?php $this->endWidget(); ?>

				</div><!-- form -->
