<?php
namespace MindbodyAPI\structures;
class ShoppingCart {
	public $Action; // ActionCode
	public $ID; // string
	public $CartItems; // ArrayOfCartItem
	public $SubTotal; // double
	public $DiscountTotal; // double
	public $TaxTotal; // double
	public $GrandTotal; // double
	
}
?>