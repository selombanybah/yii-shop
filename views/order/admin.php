<?php
$this->breadcrumbs=array(
	'Orders'=>array('index'),
	Yii::t('ShopModule.shop', 'Manage'),
);

?>
<?php 

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'order-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'order_id',
		'customer.address.firstname',
		'customer.address.lastname',
		array('name' => 'ordering_date',
			'value' => 'date("M j, Y", $data->ordering_date)',
			'filter' => false
			),
	array('name' => 'ordering_done',
			'value' => '$data->ordering_done ? Shop::t("Yes") : Shop::t("No")',
			'filter' => array(
				0 => Shop::t('No'),
				1 => Shop::t('Yes'))
		),
	array('name' => 'ordering_confirmed',
		'value' => '$data->ordering_confirmed ? Shop::t("Yes") : Shop::t("No")',
		'filter' => array(
			0 => Shop::t('No'),
			1 => Shop::t('Yes'))
		),
	array(
			'class'=>'CButtonColumn', 
			'template' => '{view}',
		),

	),
)); ?>
