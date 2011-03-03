<?php

class CustomerController extends Controller
{
	public $_model;

	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	public function actionCreate()
	{
		$model=new Customer;

		if(isset($_POST['Customer']))
		{
			$model->attributes = $_POST['Customer'];
				if(isset($_POST['Address'])) {
					$address = new Address;
					$address->attributes = $_POST['Address'];
					if($address->save())
						$model->address_id = $address->id;
				}
				if(isset($_POST['DeliveryAddress'])
						&& !Address::isEmpty($_POST['DeliveryAddress'])) {
					$deliveryAddress = new DeliveryAddress;
					$deliveryAddress->attributes = $_POST['DeliveryAddress'];
					if($deliveryAddress->save())
						$model->delivery_address_id = $deliveryAddress->id;
				}
				if(isset($_POST['BillingAddress']) 
						&& !Address::isEmpty($_POST['BillingAddress'])) {
					$billingAddress = new BillingAddress;
					$billingAddress->attributes = $_POST['BillingAddress'];
					if($billingAddress->save())
						$model->billing_address_id = $billingAddress->id;
				}

				if(!Yii::app()->user->isGuest)
					$model->user_id = Yii::app()->user->id;

				if($model->save()) {
					Yii::app()->user->setState('customer_id', $model->customer_id);
					$this->redirect(
							array(
								'//shop/order/create', 'customer'=>$model->customer_id));
					}
		}

		$this->render('create',array(
			'customer'=>$model,
			'address'=>isset($address) ? $address : new Address,
			'deliveryAddress'=>isset($deliveryAddress) ? $deliveryAddress : new DeliveryAddress,
			'billingAddress'=>isset($billingAddress) ? $billingAddress : new BillingAddress,
		));
	}

	public function actionUpdate($order = null)
	{
		if(Yii::app()->user->isGuest) {
			$id = Yii::app()->user->getState('customer_id');
			$model = Customer::model()->findByPk($id);
		}
		else
			$model = Customer::model()->find('user_id = :uid', array(
				':uid' => Yii::app()->user->id));

		if(isset($_POST['Customer']))
		{
			$model->attributes=$_POST['Customer'];
			if(isset($_POST['Address'])) {
				$address = $model->address;
				$address->attributes = $_POST['Address'];
				if($address->save())
					$model->address_id = $address->id;
			}
			if(isset($_POST['DeliveryAddress'])
					&& isset($_POST['toggle_delivery'])
					&& !Address::isEmpty($_POST['DeliveryAddress'])) {
				$deliveryAddress = $model->deliveryAddress 
					? $model->deliveryAddress 
					: new DeliveryAddress;
				$deliveryAddress->attributes = $_POST['DeliveryAddress'];
				if($deliveryAddress->save())
					$model->delivery_address_id = $deliveryAddress->id;
			}
			if(isset($_POST['BillingAddress']) 
					&& isset($_POST['toggle_billing'])
					&& !Address::isEmpty($_POST['BillingAddress'])) {
				$billingAddress = $model->billingAddress 
					? $model->billingAddress
					: new BillingAddress;
				$billingAddress->attributes = $_POST['BillingAddress'];
				if($billingAddress->save())
					$model->billing_address_id = $billingAddress->id;
			}
			if(!isset($_POST['toggle_delivery']))
				$model->delivery_address_id = 0;

			if(!isset($_POST['toggle_billing']))
				$model->billing_address_id = 0;

			if($model->save()) {
				if($order !== null)
					$this->redirect(
							array(
								'//shop/order/create', 'customer'=>$model->customer_id));
				else
					$this->redirect(array('view','id'=>$model->customer_id));
			}
		} 
		$address = $model->address;
		$deliveryAddress = $model->deliveryAddress;
		$billingAddress = $model->billingAddress;	

		$this->render('update',array(
			'customer'=>$model,
			'address'=>isset($address) ? $address : new Address,
			'deliveryAddress'=>isset($deliveryAddress) ? $deliveryAddress : new DeliveryAddress,
			'billingAddress'=>isset($billingAddress) ? $billingAddress : new BillingAddress,

		));
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel()->delete();

			if(!isset($_POST['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Customer');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionAdmin()
	{
		$model=new Customer('search');
		if(isset($_GET['Customer']))
			$model->attributes=$_GET['Customer'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Customer::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='customer-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
