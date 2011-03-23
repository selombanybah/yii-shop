<?php

class Order extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return Yii::app()->controller->module->orderTable;
	}

	public function rules()
	{
		return array(
				array('customer_id, ordering_date, delivery_address_id, billing_address_id, payment_method', 'required'),
				array('status', 'in', 'range' => array('new', 'in_progress', 'done', 'cancelled')),
					array('customer_id', 'numerical', 'integerOnly'=>true),
			array('order_id, customer_id, ordering_date, status, comment', 'safe'),
		);
	}

	public static function statusOptions() {
		return array(
				'new' => Shop::t('New'),
				'in_progress' => Shop::t('In progress'),
				'done' => Shop::t('Done'),
				'cancelled' => Shop::t('Cancelled'));

	}

	public function relations()
	{
		return array(
			'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
			'products' => array(self::HAS_MANY, 'OrderPosition', 'order_id'),
			'address' => array(self::BELONGS_TO, 'Address', 'address_id'),
			'billingAddress' => array(self::BELONGS_TO, 'BillingAddress', 'billing_address_id'),
			'deliveryAddress' => array(self::BELONGS_TO, 'DeliveryAddress', 'delivery_address_id'),
			'paymentMethod' => array(self::BELONGS_TO, 'PaymentMethod', 'payment_method'),
			'shippingMethod' => array(self::BELONGS_TO, 'ShippingMethod', 'shipping_method'),

		);
	}

	public function attributeLabels()
	{
		return array(
			'order_id' => Shop::t('Order number'),
			'customer_id' => Shop::t('Customer number'),
			'ordering_date' => Shop::t('Ordering Date'),
			'status' => Shop::t('Status'),
		);
	}

	public function getTotalPrice() {
		$price = 0;
		if($this->products)
			foreach($this->products as $position)
				$price += $position->getPrice();

		if($this->shippingMethod)
			$price += $this->shippingMethod->price;

		return $price;
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('ordering_date',$this->ordering_date,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider('Order', array( 'criteria'=>$criteria,));
	}
}
