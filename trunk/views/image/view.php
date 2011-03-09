<?php 
$folder = Yii::app()->controller->module->productImagesFolder;

echo CHtml::image(Yii::app()->baseUrl. '/' . $folder . '/' . $model->filename,
		$model->title,
		array(
			'title' => $model->title,
			'style' => 'margin: 10px;',
			'width' => Shop::module()->imageWidthThumb)
		); ?>
<?php 

if(Yii::app()->user->isAdmin()) 
	echo CHtml::link(Yii::t('ShopModule.shop', 'Delete Image'),
			array('delete', 'id' => $model->id)); ?>
