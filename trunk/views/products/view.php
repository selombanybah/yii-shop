<?php
$this->breadcrumbs=array(
	Yii::t('ShopModule.shop', 'Products')=>array('index'),
	$model->title,
);

?>

<div class="prepend-1 span-8" id="shopcontent">
<p> <?php echo Yii::t('ShopModule.shop', 'Product Properties'); ?> </p>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'product_id',
		'title',
		'description',
		'price',
		'color',
		'weight',
		'material',
		'size',
		'unit',
		'Category.title',
	),
)); ?>
<hr />
</div>

<div class="span-14 last" id="shopcontent">

<h1><?php echo $model->title; ?></h1>

<h2><?php echo $model->description; ?></h2>

<?php 
foreach($model->Images as $image) {
	$this->renderPartial('/image/view', array( 'model' => $image)); 
}
?>

<?php $this->renderPartial('/products/addToCart', array('model' => $model)); ?>

</div>

<div class="clear"> </div>


