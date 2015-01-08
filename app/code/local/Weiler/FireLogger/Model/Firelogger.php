<?php

if (!defined('FIRELOGGER_NO_CONFLICT')) define('FIRELOGGER_NO_CONFLICT', true);
if (!defined('FIRELOGGER_NO_EXCEPTION_HANDLER')) define('FIRELOGGER_NO_EXCEPTION_HANDLER', true);
if (!defined('FIRELOGGER_NO_ERROR_HANDLER')) define('FIRELOGGER_NO_ERROR_HANDLER', true);
//if (!defined('FIRELOGGER_NO_OUTPUT_HANDLER')) define('FIRELOGGER_NO_OUTPUT_HANDLER', true);
if (!defined('FIRELOGGER_NO_DEFAULT_LOGGER')) define('FIRELOGGER_NO_DEFAULT_LOGGER', true);

class Weiler_FireLogger_Model_Firelogger extends FireLogger
{

	public function __construct()
	{
		if(!(Mage::getStoreConfig('dev/debug/firelogger') && Mage::helper('core')->isDevAllowed())){
			FireLogger::$enabled = false;
		}

		parent::__construct('php', 'background-color: #767ab6');
	}

}