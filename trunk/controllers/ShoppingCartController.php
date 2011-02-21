<?php

class ShoppingCartController extends CController
{
	public $breadcrumbs;
	private $_model;

	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	public function actionCreate()
	{
		if(Yii::app()->User->getState('cartowner') == '')
			Yii::app()->User->setState('cartowner', rand(1, 999999));

		$model=new ShoppingCart;

		$model->attributes=$_POST['ShoppingCart'];
		$model->cartowner = Yii::app()->User->getState('cartowner');

		// Check if the product sn't already in the Cart:
		// TODO: Raise an warning to the User
		if(!ShoppingCart::model()->find('cartowner = :a and product_id = :b', 
			array(':a' => $model->cartowner, ':b' => $model->product_id)))
		if($model->save()) 
			$this->redirect(array('category/view', 'id' => $model->Product->Category->category_id));


	}

	public function actionUpdate()
	{
		$model=$this->loadModel();

		// $this->performAjaxValidation($model);

		if(isset($_POST['ShoppingCart']))
		{
			$model->attributes=$_POST['ShoppingCart'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->cart_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete()
	{
			$this->loadModel()->delete();

			$this->redirect(array('shop/index'));
	}

	public function actionIndex()
	{
		if(isset($_SESSION['cartowner'])) {
			$carts = ShoppingCart::model()->findAll('cartowner = :cartowner', array(':cartowner' => $_SESSION['cartowner']));

			$this->render('index',array( 'carts'=>$carts,));
		} 
	}

	public function actionAdmin()
	{
		$model=new ShoppingCart('search');
		if(isset($_GET['ShoppingCart']))
			$model->attributes=$_GET['ShoppingCart'];
			$model->cartowner = Yii::app()->User->getState('cartowner');

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=ShoppingCart::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='shopping cart-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
