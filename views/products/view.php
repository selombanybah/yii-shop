<?php
$this->breadcrumbs=array(
	Shop::t('Products')=>array('index'),
	$model->title,
);

?>

<h2><?php echo $model->title; ?></h2>


<?php 
foreach($model->images as $image) {
	$this->renderPartial('/image/view', array( 'model' => $image)); 
}
?>

<h3> <?php echo $model->description; ?> </h3>

<?php 
$specs = $model->getSpecifications();
if($specs) {
	echo '<table>';
	foreach($specs as $key => $spec) {
		if($spec != '')
			printf('<tr> <td> %s </td> <td> %s </td> </td>', $key, $spec);
	}
	echo '</table>';

} 

?>
<br />
<br />
<?php $this->renderPartial('/products/addToCart', array(
			'model' => $model)); ?>

<div class="clear"> </div>


