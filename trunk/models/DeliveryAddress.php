<?php

	class DeliveryAddress extends Address {

		// This address is not *required*
		public function rules()
		{
			return array(
					array('street, zipcode, city, country', 'length', 'max'=>255),
					array('id, street, zipcode, city, country', 'safe', 'on'=>'search'),
					);
		}

	}
?>
