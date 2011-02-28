<?php

class ShopModule extends CWebModule
{
	// Is the Shop in debug Mode?
	public $debug = false;

  // Whether the installer should install some demo data
	public $installDemoData = true;

	// Names of the tables
	public $categoryTable = 'shop_category';
	public $productsTable = 'shop_products';
	public $orderTable = 'shop_order';
	public $orderPositionTable = 'shop_order_position';
	public $customerTable = 'shop_customer';
	public $addressTable = 'shop_address';
	public $imageTable = 'shop_image';
	public $productSpecificationTable = 'shop_product_specification';
	public $productVariationTable = 'shop_product_variation';
	public $currencySymbol = '$';

	public $termsView = '/order/terms';
	public $successAction = array('//shop/order/success');
	public $failureAction = array('//shop/order/failure');

	// some example payment methods. Most probably you want to override them in
	// the application configuration. See the docs/ folder for examples
	public $paymentMethods = array(
			1 => 'cash',
			2 => 'advance Payment',
			3 => 'cash on delivery',
			4 => 'invoice',
			5 => 'paypal');

	public $loginUrl = array('/site/login');

	// Where the uploaded product images are stored:
	public $productImagesFolder = 'productimages'; // Approot/...

	public $layout = '';

	public function init()
	{
		$this->setImport(array(
			'shop.models.*',
			'shop.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			return true;
		}
		else
			return false;
	}
}
