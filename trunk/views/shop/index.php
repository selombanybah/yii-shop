<?php
$this->breadcrumbs=array(
	$this->module->id,
);
?>

<div class="prepend-1 span-8"> 
<?php $this->beginWidget('zii.widgets.CPortlet', array('title' => Yii::t('ShopModule.shop', 'Product Categories'))); ?>
<?php $this->renderPartial('/category/index'); ?>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('zii.widgets.CPortlet', array('title' => Yii::t('ShopModule.shop', 'Your Shopping Cart'))); ?>
<?php $this->renderPartial('/shoppingCart/index', array()); ?>
<?php $this->endWidget(); ?>
</div>


<div id="shopcontent" class="span-14 last"> 
<h1> <?php echo Yii::t('ShopModule.shop', 'Welcome to my Webshop'); ?> </h1>

<?php $this->renderPartial('/shop/welcome'); ?>
</div>


<div class="clear"> </div>

