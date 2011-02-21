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
			array('customer_id, ordering_date', 'required'),
			array('customer_id, ordering_done, ordering_confirmed', 'numerical', 'integerOnly'=>true),
			array('order_id, customer_id, ordering_date, ordering_done, ordering_confirmed', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'Customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
			'Products' => array(self::MANY_MANY, 'Products', 'YiiShopProductOrder(order_id, product_id)'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'order_id' => Yii::t('shop', 'Order'),
			'customer_id' => Yii::t('shop', 'Customer'),
			'ordering_date' => Yii::t('shop', 'Ordering Date'),
			'ordering_done' => Yii::t('shop', 'Ordering Done'),
			'ordering_confirmed' => Yii::t('shop', 'Ordering Confirmed'),
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('order_id',$this->order_id);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('ordering_date',$this->ordering_date,true);
		$criteria->compare('ordering_done',$this->ordering_done);
		$criteria->compare('ordering_confirmed',$this->ordering_confirmed);

		return new CActiveDataProvider('Order', array( 'criteria'=>$criteria,));
	}
}
