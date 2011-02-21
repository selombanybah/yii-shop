<?php

class InstallController extends Controller
{
	public function actionInstall() 
	{
		if($this->module->debug) 
		{
			if(Yii::app()->request->isPostRequest) 
			{
				if($db = Yii::app()->db) {
					try {
						$transaction = $db->beginTransaction();

						// Assing table names
						$categoryTable = $_POST['categoryTable'];
						$productsTable = $_POST['productsTable'];
						$shoppingCartTable = $_POST['shoppingCartTable'];
						$orderTable = $_POST['orderTable'];
						$customerTable = $_POST['customerTable'];
						$imageTable = $_POST['imageTable'];

						// Clean up existing Installation
						$db->createCommand(sprintf('drop table if exists %s, %s, %s, %s, %s, %s',
									$shoppingCartTable,
									$categoryTable, 
									$productsTable, 
									$orderTable,
									$customerTable,
									$imageTable
									)
								)->execute();

						// Create Category Table
						$sql = "CREATE TABLE IF NOT EXISTS `".$categoryTable."` (
							`category_id` INT NOT NULL AUTO_INCREMENT ,
							`parent` INT NULL ,
							`title` VARCHAR(45) NOT NULL ,
							`description` TEXT NULL ,
							`language` VARCHAR(45) NULL ,
							PRIMARY KEY (`category_id`) )
								ENGINE = InnoDB; ";

						$db->createCommand($sql)->execute();

						// Create Products Table
						$sql = "CREATE  TABLE IF NOT EXISTS `".$productsTable."` (
							`product_id` INT NOT NULL AUTO_INCREMENT ,
							`category_id` INT NOT NULL ,
							`title` VARCHAR(45) NOT NULL ,
							`description` TEXT NULL ,
							`price` VARCHAR(45) NULL ,
							`color` VARCHAR(45) NULL ,
							`weight` VARCHAR(45) NULL ,
							`material` VARCHAR(45) NULL ,
							`size` VARCHAR(45) NULL ,
							`unit` VARCHAR(45) NULL ,
							`language` VARCHAR(45) NULL ,
							PRIMARY KEY (`product_id`) ,
							INDEX `fk_products_category` (`category_id` ASC) ,
							CONSTRAINT `fk_products_category`
								FOREIGN KEY (`category_id` )
								REFERENCES  `".$categoryTable."` (`category_id` )
								ON DELETE NO ACTION
								ON UPDATE NO ACTION)
								ENGINE = InnoDB;";


						$db->createCommand($sql)->execute();


						// Create Customer Table
						$sql = "CREATE  TABLE IF NOT EXISTS   `".$customerTable."` (
							`customer_id` INT NOT NULL AUTO_INCREMENT ,
							`userid` INT NOT NULL ,
							`address` VARCHAR(45) NOT NULL ,
							`zipcode` VARCHAR(45) NOT NULL ,
							`city` VARCHAR(45) NOT NULL ,
							`country` VARCHAR(45) NOT NULL ,
							`email` VARCHAR(45) NOT NULL ,
							PRIMARY KEY (`customer_id`) )
								ENGINE = InnoDB;";

						$db->createCommand($sql)->execute();


						// Create Shopping Cart Table
						$sql = "CREATE  TABLE IF NOT EXISTS `".$shoppingCartTable."`  (
							`cart_id` INT NOT NULL AUTO_INCREMENT ,
							`amount` FLOAT NULL ,
							`product_id` INT NOT NULL ,
							`customer_id` INT NULL ,
							`cartowner` INT UNSIGNED NOT NULL ,
							PRIMARY KEY (`cart_id`) ,
							INDEX `fk_shopping_cart_products` (`product_id` ASC) ,
							INDEX `fk_shopping_cart_customer` (`customer_id` ASC) ,
							CONSTRAINT `fk_shopping_cart_products`
								FOREIGN KEY (`product_id` )
								REFERENCES `".$productsTable."` (`product_id` )
								ON DELETE NO ACTION
								ON UPDATE NO ACTION,
							CONSTRAINT `fk_shopping_cart_customer`
								FOREIGN KEY (`customer_id` )
								REFERENCES `".$customerTable."` (`customer_id` )
								ON DELETE NO ACTION
								ON UPDATE NO ACTION)
								ENGINE = InnoDB;";

						$db->createCommand($sql)->execute();

						// Create Order Table

						$sql = "CREATE  TABLE IF NOT EXISTS `".$orderTable."` (
							`order_id` INT NOT NULL AUTO_INCREMENT ,
							`customer_id` INT NOT NULL ,
							`ordering_date` INT NOT NULL ,
							`ordering_done` TINYINT(1) NULL ,
							`ordering_confirmed` TINYINT(1) NULL ,
							PRIMARY KEY (`order_id`) ,
							INDEX `fk_order_customer` (`customer_id` ASC) ,
							CONSTRAINT `fk_order_customer1`
								FOREIGN KEY (`customer_id` )
								REFERENCES `".$customerTable."` (`customer_id` )
								ON DELETE NO ACTION
								ON UPDATE NO ACTION)
								ENGINE = InnoDB; ";

						$db->createCommand($sql)->execute();

						// Create Products Table

						$sql = "CREATE TABLE IF NOT EXISTS `".$productsTable."` (
							`order_id` INT NOT NULL ,
							`product_id` INT NOT NULL ,
							`amount` FLOAT NOT NULL ,
							`product_shipped` TINYINT(1) NULL ,
							`product_arrived` TINYINT(1) NULL ,
							PRIMARY KEY (`product_id`, `order_id`) ,
							INDEX `fk_order_has_products_order` (`order_id` ASC) ,
							INDEX `fk_order_has_products_products` (`product_id` ASC) ,
							CONSTRAINT `fk_order_has_products_order`
								FOREIGN KEY (`order_id` )
								REFERENCES `".$orderTable."` (`order_id` )
								ON DELETE NO ACTION
								ON UPDATE NO ACTION,
							CONSTRAINT `fk_order_has_products_products`
								FOREIGN KEY (`product_id` )
								REFERENCES `".$productsTable."` (`product_id` )
								ON DELETE NO ACTION
								ON UPDATE NO ACTION)
								ENGINE = InnoDB; ";

						$db->createCommand($sql)->execute();

						$sql = "CREATE  TABLE IF NOT EXISTS `".$imageTable."` (
							`id` INT NOT NULL AUTO_INCREMENT ,
							`title` VARCHAR(45) NOT NULL ,
							`filename` VARCHAR(45) NOT NULL ,
							`product_id` INT NOT NULL ,
							PRIMARY KEY (`id`) ,
							INDEX `fk_Image_Products` (`product_id` ASC) ,
							CONSTRAINT `fk_Image_Products`
								FOREIGN KEY (`product_id` )
								REFERENCES `".$productsTable."` (`product_id` )
								ON DELETE NO ACTION
								ON UPDATE NO ACTION)
								ENGINE = InnoDB;";


						$db->createCommand($sql)->execute();

						if($this->module->installDemoData) 
						{
							$sql = "INSERT INTO `".$categoryTable."` (`category_id`, `parent`, `title`) VALUES
								(1, 0, 'Primary Articles'),
								(2, 0, 'Secondary Articles'),
								(3, 1, 'Red Primary Articles'),
								(4, 1, 'Green Primary Articles'),
								(5, 2, 'Red Secondary Articles');";

							$db->createCommand($sql)->execute();

							$sql = "INSERT INTO `".$customerTable."` (`customer_id`, `userid`, `address`, `zipcode`, `city`, `country`, `email`) VALUES (1, 1, 'Adress', '11111', 'Perth', 'Australia', 'demo@demo.de');";

							$db->createCommand($sql)->execute();

							$sql = "INSERT INTO `".$productsTable."` (`product_id`, `title`, `description`, `price`, `color`, `weight`, `material`, `size`, `unit`, `category_id`) VALUES (1, 'Demonstration of Article 1', 'Hello, World!', '19.99', 'White', '12 Kilo', 'Steel', '5cm x 5cm x 5cm', 'Piece', 1), (2, 'Another Demo Article', '!!', '29.99', 'Yellow', 'unliftable', 'Gold', '1 meter', 'pieces', 1), (3, 'Demo3', '', '', '', '', '', '', '', 2), (4, 'Demo4', '', '7, 55', 'Grau', '12 Gramm', 'Edelstahl', '5cm x 5cm x 5cm', 'Gramm', 4); ";


							$db->createCommand($sql)->execute();
						}

						// Do it
						$transaction->commit();

						// Victory
						$this->render('success');
					} catch (CDbException $exception) {
						$transaction->rollback();
						throw new CException(Yii::t('ShopModule.shop', 'Error while installing Webshop'));	
					}
				} else {
					throw new CException(Yii::t('ShopModule.shop', 'Database Connection is not working'));	
				}
			}
			else {
				$this->render('start');
			}
		} else {
			throw new CException(Yii::t('ShopModule.shop', 'Webshop is not in Debug Mode'));	
		}
		}

		public function actionIndex()
		{
			$this->actionInstall();
		}
}
