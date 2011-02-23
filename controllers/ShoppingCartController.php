<?php

class ShoppingCartController extends Controller
{
	public function actionView()
	{
		session_start();
		$cart = array();

		$cart = json_decode(Yii::app()->user->getState('cart'), true);

		$this->render('view',array(
						'products'=>$cart
						));
	}

	public function actionCreate()
	{
		$cart = array();

		$cart = json_decode(Yii::app()->user->getState('cart'), true);

		unset($_POST['yt0']);
		$cart[] = $_POST;
	
		Yii::app()->user->setState('cart', json_encode($cart));
		$this->redirect(array('//shop/products/index'));
	}

	public function actionDelete($id)
	{
		$id = (int) $id;
		$cart = json_decode(Yii::app()->user->getState('cart'), true);

		unset($cart[$id]);
		Yii::app()->user->setState('cart', json_encode($cart));

			$this->redirect(array('//shop/shoppingCart/view'));
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
