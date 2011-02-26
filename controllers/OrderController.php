<?php

class OrderController extends Controller
{
	public function actionView()
	{
		$this->render('view',array(
					'model'=>$this->loadModel(),
					));
	}

	/** Creation of a new Order 
	* Before we create a new order, we need to gather Customer information.
	* If the user is logged in, we check if we already have customer information.
	* If so, we go directly to the Order confirmation page with the data passed
	* over. Otherwise we need the user to enter his data, and depending on
	* whether he is logged in into the system it is saved with his user 
	* account or once just for this order.	
	*/
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
			$this->render('/customer/create', array(
						'customer' => new Customer,
						'address' => new Address,
						));
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
