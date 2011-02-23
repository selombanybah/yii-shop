<?php
$this->breadcrumbs=array(
	Yii::t('shop', 'Products'),
);

?>

	<h1><?php echo Yii::t('shop', 'All Products'); ?></h1>

<div class="span-8"> 
<?php $this->beginWidget('zii.widgets.CPortlet', array(
			'title' => Yii::t('YiiShop', 'Product Categories'))); ?>
<?php $this->renderPartial('/category/index'); ?>
<?php $this->endWidget(); ?>

<?php echo CHtml::link(Shop::t('My shopping Cart'), array(
	'//shop/shoppingCart/view')); ?>
</div>

<div class="span-15 last"> 

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

</div>
