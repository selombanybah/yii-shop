<?php

class OrderController extends Controller
{
	private $_model;
	public $breadcrumbs;
//	public $layout = 'column2';

	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	public function actionCreate()
	{
		if(Yii::app()->User->getState('customer_id')) // User is Customer?
		{ 			$order=new Order;
			if(isset($_POST['Order'])) {

				$order->ordering_date = mktime();

				if($order->save()) {

					foreach(ShoppingCart::getCartsofOwner() as $Cart) {
						$productorder = new ProductOrder();
						$productorder->product_id = $Cart->product_id;
						$productorder->order_id = $order->order_id;
						$productorder->amount = $Cart->amount;
						$productorder->save();	
					}
				}

				$this->redirect(array('shop/index'));
			}
			$this->render('/order/create', array('model' => $order));
		} else {
			$Customer = new Customer();
			$this->render('/customer/create', array('model' => $Customer));
		}

	}

	public function actionSuccess()
	{
		$this->render('/order/success');
	}

	public function actionUpdate()
	{
		$model=$this->loadModel();

		 $this->performAjaxValidation($model);

		if(isset($_POST['Order']))
		{
			$model->attributes=$_POST['Order'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->order_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel()->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_POST['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Order');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Order('search');
		if(isset($_GET['Order']))
			$model->attributes=$_GET['Order'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
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

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='order-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
