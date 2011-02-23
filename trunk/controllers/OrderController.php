<?php

class OrderController extends Controller
{
	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	public function actionCreate($customer = null)
	{
		if($customer) {
			$this->render('/order/create', array(
						'customer' => Customer::model()->findByPk($customer)));
			Yii::app()->end();
		}

		if(Yii::app()->user->isGuest
				|| !Customer::model()->find('user_id = :uid', array(
						':uid' => Yii::app()->user->id))) {
			$this->render('/customer/create', array('model' => new Customer));
		} else {
			$this->render('/order/create');
		}
	}

	public function actionSuccess()
	{
		$this->render('/order/success');
	}

	public function actionAdmin()
	{
		$model=new Order('search');
		if(isset($_GET['Order']))
			$model->attributes=$_GET['Order'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Order::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

}
