<?php

class Shop {
	public static function register($file)
	{
		$url = Yii::app()->getAssetManager()->publish(
				Yii::getPathOfAlias('application.modules.shop.assets.css'));

		$path = $url . '/' . $file;
		if(strpos($file, 'js') !== false)
			return Yii::app()->clientScript->registerScriptFile($path);
		else if(strpos($file, 'css') !== false)
			return Yii::app()->clientScript->registerCssFile($path);

		return $path;
	}

	public static function t($string, $params = array())
	{
		Yii::import('application.modules.shop.ShopModule');

		return Yii::t('ShopModule.shop', $string, $params);
	}
	/* set a flash message to display after the request is done */
	public static function setFlash($message) 
	{
		Yii::app()->user->setFlash('yiishop',Yum::t($message));
	}

	public static function hasFlash() 
	{
		return Yii::app()->user->hasFlash('yiishop');
	}

	/* retrieve the flash message again */
	public static function getFlash() {
		if(Yii::app()->user->hasFlash('yiishop')) {
			return Yii::app()->user->getFlash('yiishop');
		}
	}

	public static function renderFlash()
	{
		if(Yii::app()->user->hasFlash('yiishop')) {
			echo '<div class="info">';
			echo Shop::getFlash();
			echo '</div>';
			Yii::app()->clientScript->registerScript('fade',"
					setTimeout(function() { $('.info').fadeOut('slow'); }, 5000);	
					"); 
		}
	}
}
