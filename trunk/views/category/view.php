<?php
$this->breadcrumbs=array(
	Yii::t('ShopModule.shop', 'Shop')=>array('shop/index'),
	Yii::t('ShopModule.shop', 'Categories')=>array('index'),
	$model->title,
);

?>

<div class="prepend-1 span-8"> 
<?php $this->beginWidget('zii.widgets.CPortlet',
        array('title' => Yii::t('ShopModule.shop', 'Product Categories'))); ?>
<?php $this->renderPartial('/category/index'); ?>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('zii.widgets.CPortlet',
        array('title' => Yii::t('ShopModule.shop', 'Your Shopping Cart'))); ?>
<?php $this->renderPartial('/shoppingCart/index'); ?>
<?php $this->endWidget(); ?>
</div>


<div id="shopcontent" class="span-14 last"> 
<h1> <?php echo $model->title; ?></h1>

<?php
	foreach($model->Products as $product) {
		$this->renderPartial('/products/_view', array('data' => $product));
}
?>
</div>


<div class="clear"> </div>


