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
						$transaction = $db->beginTransaction();

						// Assing table names
						$categoryTable = $_POST['categoryTable'];
						$productsTable = $_POST['productsTable'];
						$orderTable = $_POST['orderTable'];
						$orderPositionTable = $_POST['orderPositionTable'];
						$customerTable = $_POST['customerTable'];
						$addressTable = $_POST['addressTable'];
						$imageTable = $_POST['imageTable'];
						$specificationTable = $_POST['productSpecificationsTable'];
						$variationTable = $_POST['productVariationTable'];

						// Clean up existing Installation
						$sql = "SET FOREIGN_KEY_CHECKS=0;";
						$db->createCommand($sql)->execute();

						$db->createCommand(sprintf('drop table if exists %s, %s, %s, %s, `%s`, %s, %s',
									$categoryTable, 
									$productsTable, 
									$orderTable,
									$customerTable,
									$imageTable,
									$variationTable,
									$specificationTable)
								)->execute();

						$sql = "CREATE TABLE IF NOT EXISTS `".$specificationTable."` (
							`id` int(11) NOT NULL AUTO_INCREMENT,
							`title` varchar(255) NOT NULL,
							`is_user_input` tinyint(1),
							PRIMARY KEY (`id`)
								) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
						$db->createCommand($sql)->execute();

						$sql = "CREATE TABLE IF NOT EXISTS `".$variationTable."` (
							`id` int(11) NOT NULL AUTO_INCREMENT,
							`product_id` int(11) NOT NULL,
							`specification_id` int(11) NOT NULL,
							`title` varchar(255) NOT NULL,
							`price_adjustion` float NOT NULL,
							PRIMARY KEY (`id`)
								) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";

						$db->createCommand($sql)->execute();

						// Create Category Table
						$sql = "CREATE TABLE IF NOT EXISTS `".$categoryTable."` (
							`category_id` INT NOT NULL AUTO_INCREMENT ,
							`parent_id` INT NULL ,
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
							`language` VARCHAR(45) NULL ,
							`specifications` TEXT NULL ,
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
							`user_id` INT NULL ,
							`address_id` INT NOT NULL ,
							`delivery_address_id` INT NOT NULL ,
							`billing_address_id` INT NOT NULL ,
							`firstname` varchar(255) NOT NULL,
							`lastname` varchar(255) NOT NULL,
							`email` VARCHAR(45) NOT NULL ,
							PRIMARY KEY (`customer_id`) )
								ENGINE = InnoDB;";

						$db->createCommand($sql)->execute();


						// Create Order Table

						$sql = "CREATE TABLE IF NOT EXISTS `".$orderTable."` (
							`order_id` INT NOT NULL AUTO_INCREMENT ,
							`customer_id` INT NOT NULL ,
							`delivery_address_id` INT NOT NULL ,
							`billing_address_id` INT NOT NULL ,
							`ordering_date` INT NOT NULL ,
							`ordering_done` TINYINT(1) NULL ,
							`ordering_confirmed` TINYINT(1) NULL ,
							`payment_method` INT NOT NULL ,
							PRIMARY KEY (`order_id`) ,
							INDEX `fk_order_customer` (`customer_id` ASC) ,
							CONSTRAINT `fk_order_customer1`
								FOREIGN KEY (`customer_id` )
								REFERENCES `".$customerTable."` (`customer_id` )
								ON DELETE NO ACTION
								ON UPDATE NO ACTION)
								ENGINE = InnoDB; ";

						$db->createCommand($sql)->execute();

						$sql = "CREATE TABLE IF NOT EXISTS `".$orderPositionTable."` (
							`id` int(11) NOT NULL AUTO_INCREMENT,
							`order_id` int(11) NOT NULL,
							`product_id` int(11) NOT NULL,
							`amount` int(11) NOT NULL,
							`specifications` text NOT NULL,
							PRIMARY KEY (`id`)
								) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";

						$db->createCommand($sql)->execute();

						$sql = "CREATE TABLE IF NOT EXISTS `".$addressTable."` (
							`id` int(11) NOT NULL AUTO_INCREMENT,
							`street` varchar(255) NOT NULL,
							`zipcode` varchar(255) NOT NULL,
							`city` varchar(255) NOT NULL,
							`country` varchar(255) NOT NULL,
							PRIMARY KEY (`id`)
								) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";

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
							$sql = "INSERT INTO `".$categoryTable."` (`category_id`, `parent_id`, `title`) VALUES
								(1, 0, 'Primary Articles'),
								(2, 0, 'Secondary Articles'),
								(3, 1, 'Red Primary Articles'),
								(4, 1, 'Green Primary Articles'),
								(5, 2, 'Red Secondary Articles');";

							$db->createCommand($sql)->execute();


							$sql = "INSERT INTO `".$productsTable."` (`product_id`, `title`, `description`, `price`, `category_id`) VALUES (1, 'Demonstration of Article 1', 'Hello, World!', '19.99', 1), (2, 'Another Demo Article', '!!', '29.99', 1), (3, 'Demo3', '', '', 2), (4, 'Demo4', '', '7, 55', 4); ";


							$db->createCommand($sql)->execute();
						$sql = "SET FOREIGN_KEY_CHECKS=1;";
						$db->createCommand($sql)->execute();

						}

						// Do it
						$transaction->commit();

						// Victory
						$this->render('success');
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
