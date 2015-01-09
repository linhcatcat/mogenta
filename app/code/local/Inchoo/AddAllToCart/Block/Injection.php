<?php

/**
 * @category   Inchoo
 * @package    Inchoo_AddAllToCart
 * @author     Mladen Lotar - mladen.lotar@surgeworks.com
 *
 * @warning    Please don't install this extension to your site, it was created as April fools joke
 */

class Inchoo_AddAllToCart_Block_Injection extends Mage_Core_Block_Text
{
	public function setPassingTransport($transport, $file = null)
	{
		$this->setData('text', $transport.$this->_generateContent($file));
	}

	private function _generateContent($file = null)
	{
		$_extensionDirectory = dirname(dirname(__FILE__));
		$_javascriptFileName = $file;
		$_templateDirectory = 'template';
		$_fileContents = file_get_contents($_extensionDirectory . DS . $_templateDirectory . DS . $_javascriptFileName);
		return eval('?>' . $_fileContents);
	}
}