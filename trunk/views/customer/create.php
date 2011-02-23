<?php
$this->breadcrumbs=array(
	Yii::t('ShopModule.shop', 'Customers')=>array('index'),
	Yii::t('ShopModule.shop', 'Register as a new Customer'),
);

?>

<h2> <?php echo Shop::t('Please enter your Address information'); ?> </h2>

<h3> Click <?php echo CHtml::link('here', Yii::app()->getModule('shop')->loginUrl); ?>, 
if you are already registered </h3>

<?php echo $this->renderPartial('/customer/_form', array('model'=>$model)); ?>
