<?php
$this->breadcrumbs=array(
		Shop::t('Orders')=>array('index'),
		$model->order_id,
		);

?>

<h2> <?php echo Shop::t('Order') ?> #<?php echo $model->order_id; ?></h2>

<h3> <?php echo Shop::t('Ordering Info'); ?> </h3>

<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				'order_id',
				'customer_id',
					array(
						'label' => Shop::t('Ordering Date'),
						'value' => date('d. m. Y G:i',$model->ordering_date)
					),
				'ordering_done',
				'ordering_confirmed',
				),
			)); ?>


<h3> <?php echo Shop::t('Delivery address'); ?> </h3>
<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model->deliveryAddress,
			'attributes'=>array(
				'street',
				'zipcode',
				'city',
				'country'
				),
			)); ?>

<h3> <?php echo Shop::t('Billing address'); ?> </h3>
<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model->billingAddress,
			'attributes'=>array(
				'street',
				'zipcode',
				'city',
				'country'
				),
			)); ?>




<h3> <?php echo Shop::t('Ordered Products'); ?> </h3>

<?php foreach($model->products as $product) {
	$this->widget('zii.widgets.CDetailView', array(
				'data'=>$product,
				'attributes'=> array(
					'product.title',
					'amount',
					array(
						'label' => Shop::t('Specifications'),
						'type' => 'raw',
						'value' => $product->renderSpecifications())
					)
				)
			); 
	echo '<br />';
	echo '<hr />';
}

?>

<div style="clear:both;"> </div>

<?php echo CHtml::link(Yii::t('ShopModule.shop', 'Back to Administration'), array('shop/admin')); ?>
