<p> <?php echo Shop::t('Shop'); ?> </p>
<ul>
<li> <?php echo CHtml::link('Artikelkategorien', array('//shop/category/admin')); ?> </li>
<li> <?php echo CHtml::link('Artikelspezifikationen', array('/shop/productSpecification/admin')); ?> </li>
<li> <?php echo CHtml::link('Artikel', array('/shop/products/admin')); ?> </li>
<li> <?php echo CHtml::link('Versandarten', array('/shop/shippingMethod/admin')); ?> </li>
<li> <?php echo CHtml::link('Zahlmethoden', array('/shop/paymentMethod/admin')); ?> </li>
<li> <?php echo CHtml::link('Steuer', array('/shop/tax/admin')); ?> </li>
<li> <?php echo CHtml::link('Bestellungen', array('/shop/order/admin')); ?> </li>
</ul>

