<?php
class Likipe_Utility_Block_Monblock extends Mage_Core_Block_Template
{
	public function _construct()
	{
		var_dump(123);
	}
	public function methodblock()
	{
		return "informations about my block AAA !!" ;
	}
}