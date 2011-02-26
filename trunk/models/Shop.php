<?php

class Shop {
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
