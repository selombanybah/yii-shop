<?php
$this->breadcrumbs=array(
	'Orders'=>array('index'),
	Yii::t('ShopModule.shop', 'Manage'),
);

?>
<?php 

$model = new Order();

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'order-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'order_id',
		array('name' => 'ordering_date', 'value' => 'date("M j, Y", $data->ordering_date)'),
		array(
			'class'=>'CButtonColumn', 
			'viewButtonUrl' => 'Yii::app()->createUrl("/YiiShop/order/view", array("id" => $data->order_id))',
			'updateButtonUrl' => 'Yii::app()->createUrl("/YiiShop/order/update", array("id" => $data->order_id))',
			'deleteButtonUrl' => 'Yii::app()->createUrl("/YiiShop/order/delete", array("id" => $data->order_id))',
		),

	),
)); ?>
