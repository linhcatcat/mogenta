<?php

class Inchoo_Alpha_Model_Alpha extends Mage_Core_Model_Abstract
{
	private $_modulePath;
	private $_tarStripOfPath;
	private $_params;
	
    protected function _construct()
    {
    	/* getcwd() => S:/WampDeveloper/Websites/magenti.co/webroot */
    	$this->_modulePath = getcwd().'/generated/app/code/local/';
        $this->_init('mve/user');
    }
    
    public function setModuleParamas($params)
    {
		$this->_params = $params;
		return $this;
    }
    
    public function getModuleParamas()
    {
		return $this->_params;
    }   

    public function create()
    {
    	
//		$tar = new Inchoo_Alpha_Model_Tar("alphatest4.tar");
//		
//		$files = array(
//			"app/code/community/Inchoo/Heloo/Block/Heloo.php",
//			"app/code/community/Inchoo/Heloo/controllers/IndexController.php",
//			"app/code/community/Inchoo/Heloo/etc/config.xml",
//		);
//		
//		$tar->create($files) or die("Could not create archive!");    	
//    	
//    	exit;
    	
    	
    	
    	
    	
    	
    	if(!empty($this->_params)) {
			
    		$companyName = ucfirst(strtolower($this->_params['company_name']));
    		$moduleName = ucfirst(strtolower($this->_params['module_name']));
    		
    		mkdir(getcwd().'/generated');
    		mkdir(getcwd().'/generated/'.$companyName.'_'.$moduleName);
    		mkdir(getcwd().'/generated/'.$companyName.'_'.$moduleName.'/app');
    		mkdir(getcwd().'/generated/'.$companyName.'_'.$moduleName.'/app/etc');
    		mkdir(getcwd().'/generated/'.$companyName.'_'.$moduleName.'/app/etc/modules');
    		mkdir(getcwd().'/generated/'.$companyName.'_'.$moduleName.'/app/code');
    		mkdir(getcwd().'/generated/'.$companyName.'_'.$moduleName.'/app/code/local');
    		mkdir(getcwd().'/generated/'.$companyName.'_'.$moduleName.'/app/etc');
    		
    		$this->_modulePath = getcwd().'/generated/'.$companyName.'_'.$moduleName.'/app/code/local/';
    		
    		//Create company folder
			
	    	$companyNamePath = $this->_modulePath.$companyName;
	    	mkdir($companyNamePath);
	    	
	    	
	    	//Create module folder
	    	$moduleNamePath = $companyNamePath.'/'.$moduleName;
			mkdir($moduleNamePath);

			
			
			//Create basic module subfolders folder
			mkdir($moduleNamePath.'/Block');
			mkdir($moduleNamePath.'/controllers');
			mkdir($moduleNamePath.'/etc');
			mkdir($moduleNamePath.'/Helper');
			mkdir($moduleNamePath.'/Model');
			mkdir($moduleNamePath.'/Model/Mysql4');
			mkdir($moduleNamePath.'/Model/Mysql4/'.$moduleName);
			mkdir($moduleNamePath.'/sql');
			mkdir($moduleNamePath.'/sql/'.strtolower($moduleName).'_setup');
			
			
			
			$tar = new Inchoo_Alpha_Model_Tar(getcwd().'/generated/'.$companyName."_".$moduleName.".tar");
			
			
			
			
			
			//Create IndexController
			$indexControllerPhp = fopen($moduleNamePath.'/controllers/IndexController.php', 'w');
			$indexControllerPhpContent = "<?php\n\nclass ".$companyName."_".$moduleName."_IndexController extends Mage_Core_Controller_Front_Action \n{\n\tpublic function indexAction()\n\t{\n\t\techo 'Inside ".$companyName."_".$moduleName."_IndexController::indexAction()'; exit;\n\t}\n\n\tpublic function testAction()\n\t{\n\t\techo 'Inside ".$companyName."_".$moduleName."_IndexController::testAction()'; exit;\n\t}\n}";
			fputs($indexControllerPhp, $indexControllerPhpContent);
			fclose($indexControllerPhp);	
			/* Add to TAR */ $files[] = str_replace(getcwd().'/', '', $moduleNamePath.'/controllers/IndexController.php');
			
			
			
			

			//Create sql install file
			$mysqlSetupPhp = fopen($moduleNamePath.'/sql/'.strtolower($moduleName).'_setup/mysql4-install-1.0.0.php', 'w');
			$mysqlSetupPhpContent = "<?php 

\$installer = \$this;
/* @var \$installer Mage_Core_Model_Resource_Setup */

\$installer->startSetup();

//Use {\$this->getTable('".strtolower($moduleName)."_".strtolower($moduleName)."')} for table name

\$installer->run(\"

//Add your SQL here...

\");

\$installer->endSetup();";
			fputs($mysqlSetupPhp, $mysqlSetupPhpContent);
			fclose($mysqlSetupPhp);		
			/* Add to TAR */ $files[] = str_replace(getcwd().'/', '', $moduleNamePath.'/sql/'.strtolower($moduleName).'_setup/mysql4-install-1.0.0.php');

			
			//Create Model file
			$modelPhp = fopen($moduleNamePath.'/Model/'.$moduleName.'.php', 'w');
			$modelPhpContent = "<?php 

class ".$companyName."_".$moduleName."_Model_".$moduleName." extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        \$this->_init('".strtolower($moduleName)."/".strtolower($moduleName)."');
    }	
}";
			fputs($modelPhp, $modelPhpContent);
			fclose($modelPhp);			
			/* Add to TAR */ $files[] = str_replace(getcwd().'/', '', $moduleNamePath.'/Model/'.$moduleName.'.php');

			
			
			//Create Model_Mysql4 file
			$modelMysql4Php = fopen($moduleNamePath.'/Model/Mysql4/'.$moduleName.'.php', 'w');
			$modelMysql4PhpContent = "<?php 

class ".$companyName."_".$moduleName."_Model_Mysql4_".$moduleName." extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        \$this->_init('".strtolower($moduleName)."/".strtolower($moduleName)."', '".strtolower($moduleName)."_id');
    }	
}";
			fputs($modelMysql4Php, $modelMysql4PhpContent);
			fclose($modelMysql4Php);	
			/* Add to TAR */ $files[] = str_replace(getcwd().'/', '', $moduleNamePath.'/Model/Mysql4/'.$moduleName.'.php');

			
			//Create Model_Mysql4_Collection file
			$modelMysql4CollectionPhp = fopen($moduleNamePath.'/Model/Mysql4/'.$moduleName.'/Collection.php', 'w');
			$modelMysql4CollectionPhpContent = "<?php 

class ".$companyName."_".$moduleName."_Model_Mysql4_".$moduleName."_Collection extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        \$this->_init('".strtolower($moduleName)."/".strtolower($moduleName)."');
    }	
}";
			fputs($modelMysql4CollectionPhp, $modelMysql4CollectionPhpContent);
			fclose($modelMysql4CollectionPhp);	
			/* Add to TAR */ $files[] = str_replace(getcwd().'/', '', $moduleNamePath.'/Model/Mysql4/'.$moduleName.'/Collection.php');	

			
			
			//Create Helper/Data file
			$helperDataPhp = fopen($moduleNamePath.'/Helper/Data.php', 'w');
			$helperDataContent = "<?php 

class ".$companyName."_".$moduleName."_Helper_Data extends Mage_Core_Helper_Abstract
{

}";
			fputs($helperDataPhp, $helperDataContent);
			fclose($helperDataPhp);				
			/* Add to TAR */ $files[] = str_replace(getcwd().'/', '', $moduleNamePath.'/Helper/Data.php');
			
			
			
			//Create Block file
			$blockPhp = fopen($moduleNamePath.'/Block/'.$moduleName.'.php', 'w');
			$blockPhpContent = "<?php 

class ".$companyName."_".$moduleName."_Block_".$moduleName." extends Mage_Core_Block_Template
{
    protected function _construct()
    {
        parent::_construct();
        \$this->setTemplate('".strtolower($companyName)."/".strtolower($moduleName)."/".strtolower($moduleName).".phtml');
    }
}";
			fputs($blockPhp, $blockPhpContent);
			fclose($blockPhp);				
			/* Add to TAR */ $files[] = str_replace(getcwd().'/', '', $moduleNamePath.'/Block/'.$moduleName.'.php');
			
			
			
			//Create /etc/config.xml
			$writer = new XMLWriter();
			
			$writer->openMemory();
			$writer->startDocument("1.0");
			$writer->text("\n");
			$writer->startElement("config");
				$writer->text("\n\t");
				$writer->startElement("modules");
					$writer->text("\n\t\t");
					$writer->startElement($companyName."_".$moduleName);
						$writer->text("\n\t\t\t");
						$writer->startElement("version");
							$writer->text('1.0.0');
						$writer->endElement(); /* "version" */
						$writer->text("\n\t\t");						
					$writer->endElement(); /* $companyName."_".$moduleName */
					$writer->text("\n\t");
				$writer->endElement(); /* modules */
				
				$writer->text("\n\t");
				$writer->startElement("global");
				
					$writer->text("\n\t\t");
					$writer->startElement("blocks");
						$writer->text("\n\t\t\t");
						$writer->startElement(strtolower($moduleName));
							$writer->text("\n\t\t\t\t");
							$writer->startElement("class");
								$writer->text($companyName."_".$moduleName."_Block");
							$writer->endElement(); /* class */
						$writer->text("\n\t\t\t");	
						$writer->endElement(); /* strtolower($moduleName) */
					$writer->text("\n\t\t");						
					$writer->endElement(); /* blocks */
					
					$writer->text("\n\t\t");
					$writer->startElement("helpers");
						$writer->text("\n\t\t\t");
						$writer->writeComment(" Mage::helper('".strtolower($moduleName)."') ");
						$writer->text("\n\t\t\t");						
						$writer->startElement(strtolower($moduleName));
							$writer->text("\n\t\t\t\t");	
							$writer->startElement("class");
								$writer->text($companyName."_".$moduleName."_Helper");
							$writer->endElement(); /* class */
						$writer->text("\n\t\t\t");	
						$writer->endElement(); /* strtolower($moduleName) */
					$writer->text("\n\t\t");						
					$writer->endElement(); /* helpers */

					$writer->text("\n\t\t");
					$writer->startElement("models");
						$writer->text("\n\t\t\t");
						$writer->writeComment(" Mage::getModel('".strtolower($moduleName)."/".strtolower($moduleName)."') ");
						$writer->text("\n\t\t\t");
						$writer->startElement(strtolower($moduleName));
							$writer->text("\n\t\t\t\t");
							$writer->startElement("class");
								$writer->text($companyName."_".$moduleName."_Model");
							$writer->endElement(); /* class */	
							$writer->text("\n\t\t\t\t");
							$writer->startElement("resourceModel");
								$writer->text(strtolower($moduleName)."_mysql4");
							$writer->endElement(); /* resourceModel */
						$writer->text("\n\t\t\t");								
						$writer->endElement(); /* strtolower($moduleName) */

						$writer->text("\n\t\t\t");
						$writer->startElement(strtolower($moduleName)."_mysql4");
							$writer->text("\n\t\t\t\t");	
							$writer->startElement("class");
								$writer->text($companyName."_".$moduleName."_Model_Mysql4");
							$writer->endElement(); /* class */	
							$writer->text("\n\t\t\t\t");
							$writer->startElement("entities");
								$writer->text("\n\t\t\t\t\t");
								$writer->startElement(strtolower($moduleName));
									$writer->text("\n\t\t\t\t\t\t");
									$writer->startElement("table");
										$writer->text(strtolower($moduleName)."_".strtolower($moduleName));
									$writer->endElement(); /* table */
								$writer->text("\n\t\t\t\t\t");
								$writer->endElement(); /* strtolower($moduleName) */
							$writer->text("\n\t\t\t\t");
							$writer->endElement(); /* entities */
						$writer->text("\n\t\t\t");								
						$writer->endElement(); /* strtolower($moduleName)."_mysql4" */						
						
					$writer->text("\n\t\t");
					$writer->endElement(); /* models */				

					
					$writer->text("\n\t\t");
					$writer->startElement("resources");
						$writer->text("\n\t\t\t");
						$writer->writeComment(" Mage::getResourceModel('".strtolower($moduleName)."/".strtolower($moduleName)."') or Mage::getResourceSingleton('".strtolower($moduleName)."/".strtolower($moduleName)."') ");
						$writer->text("\n\t\t\t");
						$writer->startElement(strtolower($moduleName)."_setup");
							$writer->text("\n\t\t\t\t");
							$writer->startElement("setup");
								$writer->text($companyName."_".$moduleName."_Model");
							$writer->endElement(); /* setup */	
							$writer->text("\n\t\t\t\t");
							$writer->startElement("connection");
								$writer->text("\n\t\t\t\t\t");
								$writer->startElement("use");
									$writer->text("core_setup");
								$writer->endElement(); /* use */
							$writer->text("\n\t\t\t\t");
							$writer->endElement(); /* connection */
						$writer->text("\n\t\t\t");								
						$writer->endElement(); /* strtolower($moduleName) */
						
						$writer->text("\n\t\t\t");
						$writer->startElement(strtolower($moduleName)."_read");
							$writer->text("\n\t\t\t\t");
							$writer->startElement("connection");
								$writer->text("\n\t\t\t\t\t");
								$writer->startElement("use");
									$writer->text("core_read");
								$writer->endElement(); /* use */
							$writer->text("\n\t\t\t\t");
							$writer->endElement(); /* connection */
						$writer->text("\n\t\t\t");								
						$writer->endElement(); /* strtolower($moduleName) */		

						$writer->text("\n\t\t\t");
						$writer->startElement(strtolower($moduleName)."_write");
							$writer->text("\n\t\t\t\t");
							$writer->startElement("connection");
								$writer->text("\n\t\t\t\t\t");
								$writer->startElement("use");
									$writer->text("core_write");
								$writer->endElement(); /* use */
							$writer->text("\n\t\t\t\t");
							$writer->endElement(); /* connection */
						$writer->text("\n\t\t\t");								
						$writer->endElement(); /* strtolower($moduleName) */						

						
					$writer->text("\n\t\t");
					$writer->endElement(); /* resources */							
				
				$writer->text("\n\t");
				$writer->endElement(); /* global */			

				
				
				$writer->text("\n\t");
				$writer->startElement("frontend");				
				
					$writer->text("\n\t\t");
					$writer->startElement("routers");
						$writer->text("\n\t\t\t");						
						$writer->startElement(strtolower($moduleName));
							$writer->text("\n\t\t\t\t");	
							$writer->startElement("use");
								$writer->text("standard");
							$writer->endElement(); /* use */
							$writer->text("\n\t\t\t\t");	
							$writer->startElement("args");
								$writer->text("\n\t\t\t\t\t");
								$writer->startElement("module");
									$writer->text($companyName."_".$moduleName);
								$writer->endElement(); /* module */
								$writer->text("\n\t\t\t\t\t");
								$writer->startElement("frontName");
									$writer->text(strtolower($moduleName));
								$writer->endElement(); /* frontName */								
							$writer->text("\n\t\t\t\t");	
							$writer->endElement(); /* args */							
						$writer->text("\n\t\t\t");	
						$writer->endElement(); /* strtolower($moduleName) */
					$writer->text("\n\t\t");						
					$writer->endElement(); /* routers */				
				
				$writer->text("\n\t");
				$writer->endElement(); /* frontend */							
				
				
				
			$writer->text("\n");
			$writer->endElement(); /* config */
			
			$writer->endDocument();
			
			$configXml = fopen($moduleNamePath.'/etc/config.xml', 'w');
			fputs($configXml, $writer->outputMemory());
			fclose($configXml);
			/* Add to TAR */ $files[] = str_replace(getcwd().'/', '', $moduleNamePath.'/etc/config.xml');
			
			$writer->flush();
			
			unset($writer);
			
			//Create /etc/config.xml
			$writer = new XMLWriter();
			
			$writer->openMemory();
			$writer->startDocument("1.0");
			$writer->text("\n");
			$writer->startElement("config");
				$writer->text("\n\t");
				$writer->startElement("modules");
					$writer->text("\n\t\t");
					$writer->startElement($companyName."_".$moduleName);
						$writer->text("\n\t\t\t");
						$writer->startElement("active");
							$writer->text('true');
						$writer->endElement(); /* "version" */
						$writer->text("\n\t\t\t");	
						$writer->startElement("codePool");
							$writer->text('local');
						$writer->endElement(); /* "version" */
						$writer->text("\n\t\t");											
					$writer->endElement(); /* $companyName."_".$moduleName */
					$writer->text("\n\t");
				$writer->endElement(); /* modules */			
			
			$writer->text("\n");
			$writer->endElement(); /* config */
			
			$writer->endDocument();		

			$configXml = fopen(getcwd().'/generated/'.$companyName.'_'.$moduleName.'/app/etc/modules/'.$companyName.'_'.$moduleName.'.xml', 'w');
			fputs($configXml, $writer->outputMemory());
			fclose($configXml);			
			/* Add to TAR */ $files[] = 'generated/'.$companyName.'_'.$moduleName.'/app/etc/modules/'.$companyName.'_'.$moduleName.'.xml';
			
			

			//Zend_Debug::dump($files, '$files');
			$tar->create($files);
			
			return "Download the <a href=\"".Mage::getBaseUrl()."generated/".$companyName."_".$moduleName.".tar\">".$companyName."_".$moduleName.".tar</a> module. Thank you.";
			
			
			
			
    		
    	} else {
    		throw new Mage_Core_Exception($this->__('Alpha module exception, missing paramas for module creation'));
    	}
    }
}