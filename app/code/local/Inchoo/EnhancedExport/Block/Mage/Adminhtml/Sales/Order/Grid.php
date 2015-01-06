<?php
 
class Inchoo_EnhancedExport_Block_Mage_Adminhtml_Sales_Order_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid 
{
	/**
	 * Rows per page for import
	 *
	 * @var int
	 */
	protected $_exportPageSize = 500;
 
    public function __construct()
    {
        parent::__construct();
    }
 
    protected function _prepareColumns()
    {
        $this->addExportType('*/*/exportCsvEnhanced', Mage::helper('sales')->__('CSVe'));
        return parent::_prepareColumns();
    }
 
    public function getCsvFileEnhanced()
    {
    	$this->_isExport = true;
        $this->_prepareGrid();
 
        $io = new Varien_Io_File();
 
        $path = Mage::getBaseDir('var') . DS . 'export' . DS; //best would be to add exported path through config
        $name = md5(microtime());
        $file = $path . DS . $name . '.csv';
 
        /**
         * It is possible that you have name collision (summer/winter time +1/-1)
         * Try to create unique name for exported .csv file
         */
        while (file_exists($file)) {
        	sleep(1);
        	$name = md5(microtime());
        	$file = $path . DS . $name . '.csv';
        }
 
        $io->setAllowCreateFolders(true);
        $io->open(array('path' => $path));
        $io->streamOpen($file, 'w+');
        $io->streamLock(true);
        $io->streamWriteCsv($this->_getExportHeaders());
        //$this->_exportPageSize = load data from config
        $this->_exportIterateCollectionEnhanced('_exportCsvItem', array($io));
 
        if ($this->getCountTotals()) {
            $io->streamWriteCsv($this->_getExportTotals());
        }
 
        $io->streamUnlock();
        $io->streamClose();
 
        return array(
            'type'  => 'filename',
            'value' => $file,
            'rm'    => false // can delete file after use
        );
    }
    public function _exportIterateCollectionEnhanced($callback, array $args)
    {
    	$originalCollection = $this->getCollection();
    	$count = null;
    	$page  = 1;
    	$lPage = null;
    	$break = false;
 
    	$ourLastPage = 10;
 
    	while ($break !== true) {
    		$collection = clone $originalCollection;
    		$collection->setPageSize($this->_exportPageSize);
    		$collection->setCurPage($page);
    		$collection->load(/*true, true*/);
    		if (is_null($count)) {
    			$count = $collection->getSize();
    			$lPage = $collection->getLastPageNumber();
    		}
    		if ($lPage == $page || $ourLastPage == $page) {
    			$break = true;
    		}
    		$page ++;
 
    		foreach ($collection as $item) {
    			//$item->setState($item->getState(), 'processing'); $item->save();
    			call_user_func_array(array($this, $callback), array_merge(array($item), $args));
    		}
    	}
    	/*exit();*/
    }
}