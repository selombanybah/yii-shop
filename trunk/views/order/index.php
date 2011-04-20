<?php
$this->breadcrumbs=array(
	Shop::t('Orders')=>array('admin'),
	Shop::t('Manage'),
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
	array('name' => 'status',
			'value' => '$data->status',
			'filter' => array(
				'new' => Shop::t('New'),
				'in_progress' => Shop::t('In progress'),
				'done' => Shop::t('Done'),
				'cancelled' => Shop::t('Cancelled'),
				),
		),
	array(
			'class'=>'CButtonColumn', 
			'template' => '{view}',
		),

	),
)); ?>
