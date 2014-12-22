<?php
/**
 * Magestore
 * 
 * Online Magento Course
 * 
 */

/**
 * Lesson06 Grid Block
 * 
 * @category    Magestore
 * @package     Magestore_Lesson06
 * @author      Magestore Developer
 */
class Magestore_Lesson06_Block_Adminhtml_Lesson06_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('lesson06Grid');
        $this->setDefaultSort('lesson06_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }
    
    /**
     * prepare collection for block to display
     *
     * @return Magestore_Lesson06_Block_Adminhtml_Lesson06_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('lesson06/lesson06')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    
    /**
     * prepare columns for this grid
     *
     * @return Magestore_Lesson06_Block_Adminhtml_Lesson06_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('lesson06_id', array(
            'header'    => Mage::helper('lesson06')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'lesson06_id',
            'type'      => 'number',
        ));

        $this->addColumn('title', array(
            'header'    => Mage::helper('lesson06')->__('Title'),
            'align'     =>'left',
            'index'     => 'title',
        ));

        $this->addColumn('content', array(
            'header'    => Mage::helper('lesson06')->__('Item Content'),
            'width'     => '150px',
            'index'     => 'content',
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('lesson06')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'status',
            'type'        => 'options',
            'options'     => array(
                1 => 'Enabled',
                2 => 'Disabled',
            ),
        ));

        $this->addColumn('action',
            array(
                'header'    =>    Mage::helper('lesson06')->__('Action'),
                'width'        => '100',
                'type'        => 'action',
                'getter'    => 'getId',
                'actions'    => array(
                    array(
                        'caption'    => Mage::helper('lesson06')->__('Edit'),
                        'url'        => array('base'=> '*/*/edit'),
                        'field'        => 'id'
                    )),
                'filter'    => false,
                'sortable'    => false,
                'index'        => 'stores',
                'is_system'    => true,
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('lesson06')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('lesson06')->__('XML'));

        return parent::_prepareColumns();
    }
    
    /**
     * prepare mass action for this grid
     *
     * @return Magestore_Lesson06_Block_Adminhtml_Lesson06_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('lesson06_id');
        $this->getMassactionBlock()->setFormFieldName('lesson06');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'        => Mage::helper('lesson06')->__('Delete'),
            'url'        => $this->getUrl('*/*/massDelete'),
            'confirm'    => Mage::helper('lesson06')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('lesson06/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
            'label'=> Mage::helper('lesson06')->__('Change status'),
            'url'    => $this->getUrl('*/*/massStatus', array('_current'=>true)),
            'additional' => array(
                'visibility' => array(
                    'name'    => 'status',
                    'type'    => 'select',
                    'class'    => 'required-entry',
                    'label'    => Mage::helper('lesson06')->__('Status'),
                    'values'=> $statuses
                ))
        ));
        return $this;
    }
    
    /**
     * get url for each row in grid
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}