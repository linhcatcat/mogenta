<?php
/**
*
* @author      Inchoo <ivan.galambos@inchoo.net>
*/
class Inchoo_XmlMethodCall_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		$orders = array();
		$orders[] = array (
			'order_no'    => 101,
			'method'    => 'checkmo',
			'amount'    => 99
		);
		$orders[] = array (
			'order_no'    => 102,
			'method'    => 'ccsave',
			'amount'    => 100
		);
		$orders[] = array (
			'order_no'    => 101,
			'method'    => 'checkmo',
			'amount'    => 199
		);
 
		foreach ($orders as $row) {
			$orderNo = $row['order_no'];
			$conf = Mage::getSingleton('core/config')->init()
				->getXpath('global/xml_method_call//code[.="' . $row['method'] . '"]/..');

			if ($conf) {
				$conf = new Varien_Object(current($conf)->asArray());
				$add = new Varien_Object($conf->getAdd());
				$code = new Varien_Object($conf->getReturn());
 
				if (method_exists(Mage::getModel($add->getModel()), $add->getMethod())) {
					$amountValue = $row['amount'] + Mage::getModel($add->getModel())->{$add->getMethod()}();
				}
				if (method_exists(Mage::getModel($code->getModel()), $code->getMethod())) {
					$codeValue = Mage::getModel($code->getModel())->{$code->getMethod()}();
				}
			} else {
				//throw an error
				die("or exit... or something goes wrong...");
			}
			echo "<pre>"                     . PHP_EOL;
			echo 'ID: '     . $orderNo         . PHP_EOL;
			echo 'VALUE: '     . $amountValue     . PHP_EOL;
			echo 'CODE: '     . $codeValue     . PHP_EOL;
		}
		print_r($orders);
	}
}