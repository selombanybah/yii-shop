<div class="view">
<h2> <?php echo CHtml::link(CHtml::encode($data->title), array('products/view', 'id' => $data->product_id)); ?> </h2>

	<p> <?php echo CHtml::encode($data->description); ?> </p>
	<br />

<div style="float:left;margin-right:20px;">
<?php foreach($data->Images as $image) {
	$this->renderPartial('/image/view', array( 'model' => $image)); 
} ?>
</div>


<div style="float:left;margin-right:100px;">
	<b><?php echo CHtml::encode($data->getAttributeLabel('weight')); ?>:</b>
	<?php echo CHtml::encode($data->weight); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('material')); ?>:</b>
	<?php echo CHtml::encode($data->material); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('color')); ?>:</b>
	<?php echo CHtml::encode($data->color); ?>
	<br />

</div>
<div>

	<b><?php echo CHtml::encode($data->getAttributeLabel('size')); ?>:</b>
	<?php echo CHtml::encode($data->size); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('unit')); ?>:</b>
	<?php echo CHtml::encode($data->unit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price) . " €"; ?>
	<br />


</div>


<hr />
<?php $this->renderPartial('/products/addToCart', array('model' => $data)); ?>
</div>
