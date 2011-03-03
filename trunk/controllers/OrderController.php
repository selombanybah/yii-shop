<?php

class OrderController extends Controller
{
	public $_model;

	public function beforeAction($action) {
		$this->layout = Shop::module()->layout;
		return parent::beforeAction($action);
	}


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
	public function actionCreate(
			$customer = null,
			$payment_method = null,
			$shipping_method = null) {

		if(isset($_POST['PaymentMethod'])) 
			Yii::app()->user->setState('payment_method', $_POST['PaymentMethod']);
		if(isset($_POST['ShippingMethod'])) 
			Yii::app()->user->setState('shipping_method', $_POST['ShippingMethod']);
		if(isset($_POST['DeliveryAddress'])
				&& !Address::isEmpty($_POST['DeliveryAddress'])) {
			$deliveryAddress = new DeliveryAddress;
			$deliveryAddress->attributes = $_POST['DeliveryAddress'];
			if($deliveryAddress->save()) {
				$model = Shop::getCustomer();

				if(isset($_POST['toggle_delivery']))
					$model->delivery_address_id = $deliveryAddress->id;
				else
					$model->delivery_address_id = 0;
				$model->save(false, array('delivery_address_id'));
			}
		}
		if(isset($_POST['BillingAddress'])
				&& !Address::isEmpty($_POST['BillingAddress'])) {
			$BillingAddress = new BillingAddress;
			$BillingAddress->attributes = $_POST['BillingAddress'];
			if($BillingAddress->save()) {
				$model = Shop::getCustomer();
				if(isset($_POST['toggle_billing']))
					$model->billing_address_id = $BillingAddress->id;
				else
					$model->billing_address_id = 0;
				$model->save(false, array('billing_address_id'));
			}
		}

		if(!$customer)
			$customer = Yii::app()->user->getState('customer_id');
		if(!$payment_method)
			$payment_method = Yii::app()->user->getState('payment_method');
		if(!$shipping_method)
			$shipping_method = Yii::app()->user->getState('shipping_method');

		if(!$customer) {
			$this->render('/customer/create', array(
						'action' => array('//shop/customer/create')));
			Yii::app()->end();
		}
		if(!$payment_method) {
			$this->render('/paymentMethod/choose', array(
						'customer' => Shop::getCustomer()));
			Yii::app()->end();
		}
		if(!$shipping_method) {
			$this->render('/shippingMethod/choose', array(
						'customer' => Shop::getCustomer()));
			Yii::app()->end();
		}

		if($customer && $payment_method && $shipping_method)  
			$this->render('/order/create', array(
						'customer' => Customer::model()->findByPk($customer),
						'shippingMethod' => ShippingMethod::model()->findByPk($shipping_method),
						'paymentMethod' => PaymentMethod::model()->findByPk($payment_method),
						));
	}

	public function actionConfirm() {
		if(isset($_POST['accept_terms']) && $_POST['accept_terms'] == 1) {
			$order = new Order();
			$customer = Shop::getCustomer();
			$cart = Shop::getCartContent();

			$order->customer_id = $customer->customer_id;

			$address = new DeliveryAddress();
			if($customer->deliveryAddress)
				$address->attributes = $customer->deliveryAddress->attributes;
			else
				$address->attributes = $customer->address->attributes;
			$address->save();
			$order->delivery_address_id = $address->id;

			$address = new BillingAddress();
			if($customer->billingAddress)
				$address->attributes = $customer->billingAddress->attributes;
			else
				$address->attributes = $customer->address->attributes;
			$address->save();
			$order->billing_address_id = $address->id;

			$order->ordering_date = time();
			$order->payment_method = Yii::app()->user->getState('payment_method');
			$order->shipping_method = Yii::app()->user->getState('shipping_method');

			if($order->save()) {
				foreach($cart as $position => $product) {
					$position = new OrderPosition;
					$position->order_id = $order->order_id;
					$position->product_id = $product['product_id'];
					$position->amount = $product['amount'];
					$position->specifications = @json_encode($product['Variations']);
					$position->save();
					Yii::app()->user->setState('cart', array());
					Yii::app()->user->setState('shipping_method', null);
					Yii::app()->user->setState('payment_method', null);
				}
				$this->redirect(Shop::module()->successAction);
			} else var_dump($order->getErrors()); 
				$this->redirect(Shop::module()->failureAction);
		} else {
			Shop::setFlash(
					Shop::t(
						'Please accept our Terms and Conditions to continue'));
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
