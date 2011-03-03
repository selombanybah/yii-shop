<?php
if(!isset($this->breadcrumbs))
	$this->breadcrumbs = array(
			Shop::t('Order'),
			Shop::t('Payment method'));
?>

<h2> <?php echo Shop::t('Choose your Payment method'); ?> </h2>

<?php
$i = 0;
echo CHtml::Form(array('//shop/order/create'));

foreach(PaymentMethod::model()->findAll() as $method) {
	echo CHtml::radioButton("PaymentMethod", $i == 0, array(
				'value' => $method->id));
	echo CHtml::label($method->title, 'PaymentMethod');
	echo CHtml::tag('p', array(), $method->description);
	echo '<br />';
	$i++;
}
echo CHtml::submitButton(Shop::t('Continue'));
echo CHtml::endForm();
