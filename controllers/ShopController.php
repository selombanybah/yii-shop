<?php

class ShopController extends CController
{
	public $breadcrumbs;

	public function actionInstall() 
	{
		if($this->module->debug) 
		{
			if(Yii::app()->request->isPostRequest) 
			{
				if($db = Yii::app()->db) {

				} else {
					throw new CException(Yii::t('shop', 'Database Connection is not working'));	
				}
			}
			else {
				$this->render('install');
			}
		} else {
			throw new CException(Yii::t('shop', 'Webshop is not in Debug Mode'));	
		}
	}

	public function actionAdmin()
	{
		$this->render('admin', array( ));
	}

	public function actionIndex()
	{
		$this->render('index', array( 
			'products' => Products::model()->findAll(),
		  'Categories' => Category::model()->findAll()
		));
	}
}
