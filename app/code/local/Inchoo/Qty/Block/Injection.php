<?php

/**
 * @category   Inchoo
 * @package    Inchoo_Qty
 * @author     Mladen Lotar - mladen.lotar@surgeworks.com
 */

class Inchoo_Qty_Block_Injection extends Mage_Core_Block_Text
{
	protected $_nameInLayout = 'grouped.qty_javascript';
	protected $_alias = 'qty_javascript';

	public function setPassingTransport($transport)
	{
		$this->setData('text', $transport.$this->_generateJavaScript());
	}

	private function _generateJavaScript()
{
		$_extensionDirectory = dirname(dirname(__FILE__));
		$_javascriptFileName = 'javascript.phtml';
		$_templateDirectory = 'template';
		return file_get_contents($_extensionDirectory . DS . $_templateDirectory . DS . $_javascriptFileName);
	}
}