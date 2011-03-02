<?php

class OrderController extends Controller
{
	public $_model;

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
		if($customer_id = Yii::app()->user->getState('customer_id')) {
			$this->render('/order/create', array(
						'customer' => Customer::model()->findByPk($customer_id)));
			Yii::app()->end();
		}

		if(Yii::app()->user->isGuest
				|| !Customer::model()->find('user_id = :uid', array(
						':uid' => Yii::app()->user->id))) {
			$this->render('/customer/create', array(
						'action' => array('//shop/customer/create'),
						'customer' => new Customer,
						'address' => new Address,
						));
		} else {
			$this->render('/order/create');
		}
	}

	public function actionConfirm() {
		if(isset($_POST['accept_terms']) && $_POST['accept_terms'] == 1) {
			$order = new Order();
			$customer = Shop::getCustomer();
			$cart = Shop::getCartContent();

			$order->customer_id = $customer->customer_id;

			$address = new Address();
			if($customer->deliveryAddress)
				$address->attributes = $customer->deliveryAddress->attributes;
			else
				$address->attributes = $customer->address->attributes;
			$address->save();
			$order->delivery_address_id = $address->id;

			$address = new Address();
			if($customer->billingAddress)
				$address->attributes = $customer->billingAddress->attributes;
			else
				$address->attributes = $customer->address->attributes;
			$address->save();
			$order->billing_address_id = $address->id;

			$order->ordering_date = time();
			$order->payment_method = 1;

			if($order->save()) {
				foreach($cart as $position => $product) {
					$position = new OrderPosition;
					$position->order_id = $order->order_id;
					$position->product_id = $product['product_id'];
					$position->amount = $product['amount'];
					$position->specifications = @json_encode($product['Variations']);
					$position->save();
					Yii::app()->user->setState('cart', array());
				}
				$this->redirect(Shop::module()->successAction);
			} else 
				$this->redirect(Shop::module()->failureAction);
		} else {
			Shop::setFlash(Shop::t('Please accept our Terms and Conditions to continue'));
			$this->redirect(array('//shop/order/create'));
		}
	}

	public function actionSuccess()
	{
		$this->render('/order/success');
	}

	public function actionFailure()
	{
		$this->render('/order/failure');
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
