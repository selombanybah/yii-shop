<?php

class Customer extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return Yii::app()->controller->module->customerTable;
	}

	public function rules()
	{
		return array(
			array('firstname, lastname, email, address, zipcode, city, country', 'required'),
			array('customer_id, user_id', 'numerical', 'integerOnly'=>true),
			array('address, zipcode, city, country, email', 'length', 'max'=>45),
			array('delivery_address, delivery_zipcode, delivery_city, billing_address, billing_zipcode, billing_city', 'length', 'max' => 255),
			array('email', 'CEmailValidator'),
			array('customer_id, user_id, address, zipcode, city, country, email', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'Orders' => array(self::HAS_MANY, 'Order', 'customer_id'),
			'ShoppingCarts' => array(self::HAS_MANY, 'ShoppingCart', 'customer_id'),
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
			'delivery_address' => Yii::t('ShopModule.shop', 'delivery_address'),
			'delivery_zipcode' => Yii::t('ShopModule.shop', 'delivery_zipcode'),
			'delivery_city' => Yii::t('ShopModule.shop', 'delivery_city'),
			'billing_address' => Yii::t('ShopModule.shop', 'billing_address'),
			'billing_zipcode' => Yii::t('ShopModule.shop', 'billing_zipcode'),
			'billing_city' => Yii::t('ShopModule.shop', 'billing_city'),
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
