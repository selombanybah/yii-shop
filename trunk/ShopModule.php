<?php

class ShopModule extends CWebModule
{
	// Is the Shop in debug Mode?
	public $debug = false;

  // Whether the installer should install some demo data
	public $installDemoData = true;

	// Name of the category Table
	public $categoryTable = 'ShopCategory';

	// Name of the products Table
	public $productsTable = 'ShopProducts';

	// Name of the shopping Cart Table
	public $shoppingCartTable = 'ShopShoppingCart';

	// Name of the order Table
	public $orderTable = 'ShopOrder';

	// Name of the customer Table
	public $customerTable = 'ShopCustomer';

	// Name of the image Table
	public $imageTable = 'ShopImage';

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
