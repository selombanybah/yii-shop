<?php 
$folder = Yii::app()->controller->module->productImagesFolder;
echo CHtml::Image($folder . '/' . $model->filename,
		$model->title,
		array(
			'width' => 200,
			'height' => 150)
		); ?>
<?php 

if(!Yii::app()->user->isGuest) 
	echo CHtml::link(Yii::t('ShopModule.shop', 'Delete Image'),
			array('delete', 'id' => $model->id)); ?>
