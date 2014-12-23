<?php
class Likipe_Utility_Block_Adminhtml_Utility_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('contactGrid');
		$this->setDefaultSort('id_likipe_utility');
		$this->setDefaultDir('DESC');
		$this->setSaveParametersInSession(true);
	}
	protected function _prepareCollection()
	{
		$collection = Mage::getModel('utility/utility')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	protected function _prepareColumns()
	{
	   $this->addColumn('id_likipe_utility',
			array(
				'header' => 'ID',
				'align' =>'right',
				'width' => '50px',
				'index' => 'id_likipe_utility',
			));
		$this->addColumn('nom',
			array(
				'header' => 'nom',
				'align' =>'left',
				'index' => 'nom',
			));
		$this->addColumn('prenom', array(
				'header' => 'prenom',
				'align' =>'left',
				'index' => 'prenom',
			));
		$this->addColumn('telephone', array(
				'header' => 'telephone',
				'align' =>'left',
				'index' => 'telephone',
			));
		$this->addColumn('action',
			array(
				'header'    => 'Action',
				'width'     => '100',
				'type'      => 'action',
				'getter'    => 'getId',
				'actions'   => array(
					array(
						'caption'   => 'Edit',
						'url'       => array('base'=> '*/*/edit'),
						'field'     => 'id'
					)
				),
				'filter'    => false,
				'sortable'  => false,
				'index'     => 'stores',
				'is_system' => true,
		));
		$this->addExportType('*/*/exportCsv', 'CSV');
		$this->addExportType('*/*/exportXml', 'XML');
		return parent::_prepareColumns();
	}
	public function getRowUrl($row)
	{
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}
}