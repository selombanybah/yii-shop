<?php

class Customer extends CActiveRecord
{
	public $terms_accepted = null;

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return Yii::app()->getModule('shop')->customerTable;
	}

	public function rules()
	{
		return array(
			array('firstname, lastname, email', 'required'),
			array('address_id, customer_id, user_id', 'numerical', 'integerOnly'=>true),
			array('email', 'CEmailValidator'),
			array('customer_id, user_id, firstname, lastname, email', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'Orders' => array(self::HAS_MANY, 'Order', 'customer_id'),
			'ShoppingCarts' => array(self::HAS_MANY, 'ShoppingCart', 'customer_id'),
			'address' => array(self::BELONGS_TO, 'Address', 'address_id'),
			'billingAddress' => array(self::BELONGS_TO, 'BillingAddress', 'billing_address_id'),
			'deliveryAddress' => array(self::BELONGS_TO, 'DeliveryAddress', 'delivery_address_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'customer_id' => Yii::t('ShopModule.shop', 'Customer'),
			'user_id' => Yii::t('ShopModule.shop', 'Userid'),
			'firstname' => Yii::t('ShopModule.shop', 'Firstname'),
			'lastname' => Yii::t('ShopModule.shop', 'Lastname'),
			'address' => Yii::t('ShopModule.shop', 'Address'),
			'zipcode' => Yii::t('ShopModule.shop', 'Zipcode'),
			'city' => Yii::t('ShopModule.shop', 'City'),
			'country' => Yii::t('ShopModule.shop', 'Country'),
			'email' => Yii::t('ShopModule.shop', 'Email'),
			'delivery_address' => Yii::t('ShopModule.shop', 'Delivery address'),
			'delivery_zipcode' => Yii::t('ShopModule.shop', 'Delivery zipcode'),
			'delivery_city' => Yii::t('ShopModule.shop', 'Delivery City'),
			'billing_address' => Yii::t('ShopModule.shop', 'Billing address'),
			'billing_zipcode' => Yii::t('ShopModule.shop', 'Billing zipcode'),
			'billing_city' => Yii::t('ShopModule.shop', 'Billing city'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('customer_id',$this->customer_id);

		$criteria->compare('user_id',$this->user_id);

		$criteria->compare('address',$this->address,true);

		$criteria->compare('zipcode',$this->zipcode,true);

		$criteria->compare('city',$this->city,true);

		$criteria->compare('country',$this->country,true);

		$criteria->compare('email',$this->email,true);

		return new CActiveDataProvider('Customer', array(
			'criteria'=>$criteria,
		));
	}
}
