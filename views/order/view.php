<?php
$this->breadcrumbs=array(
	Yii::t('ShopModule.shop', 'Orders')=>array('index'),
	$model->order_id,
);

?>

<h1> <?php echo Yii::t('ShopModule.shop', Order) ?> #<?php echo $model->order_id; ?></h1>

<div class="span-8">

<h3> <?php echo Yii::t('ShopModule.shop', 'Ordering Info'); ?> </h3>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'order_id',
		'customer_id',
		'ordering_date',
		'ordering_done',
		'ordering_confirmed',
	),
)); ?>

</div>

<div class="span-8">

<h3> <?php echo Yii::t('ShopModule.shop', 'Ordered Products'); ?> </h3>

<?php foreach($model->Products as $Product) {
$this->widget('zii.widgets.CDetailView', array(
	'data'=>$Product,
	'attributes'=>array(
		'title',
	),
)); 

}

?>

</div>

<div class="span-8 last">

<h3> <?php echo Yii::t('ShopModule.shop', 'Customer Info'); ?> </h3>
<?php

 $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model->Customer,
	'attributes'=>array(
		'customer_id',
		'address',
		'zipcode',
		'city',
	),
)); 

?>
</div>

<div style="clear:both;"> </div>

<?php echo CHtml::link(Yii::t('ShopModule.shop', 'Back to Administration'), array('shop/admin')); ?>
