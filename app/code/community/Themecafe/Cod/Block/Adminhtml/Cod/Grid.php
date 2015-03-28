<?php
/**
 * Theme Cafe
 * http://www.theme-cafe.com
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@theme-cafe.com so we can send you a copy immediately.
 *
 * @category    Theme-cafe
 * @package     Cash on delivery service check
 * @author      Hemant Paliwal <support@mtheme-cafe.com>
 * @copyright   Copyright (c) 2015 (http://www.theme-cafe.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Themecafe_Cod_Block_Adminhtml_Cod_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('codGrid');
      $this->setDefaultSort('cod_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('cod/cod')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('cod_id', array(
          'header'    => Mage::helper('cod')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'cod_id',
      ));
	  
	  $this->addColumn('area', array(
			'header'    => Mage::helper('cod')->__('Area Name'),
			'width'     => '150px',
			'index'     => 'area',
      ));
	  
	  $this->addColumn('cityname', array(
			'header'    => Mage::helper('cod')->__('City'),
			'width'     => '150px',
			'index'     => 'cityname',
      ));

	  $this->addColumn('state', array(
			'header'    => Mage::helper('cod')->__('State'),
			'width'     => '150px',
			'index'     => 'state',
      ));
	
	  $this->addColumn('pincode', array(
          'header'    => Mage::helper('cod')->__('Pincode'),
          'align'     =>'left',
		  'type'      => 'integer',
          'index'     => 'pincode',
		  'value'     =>'pincode',
		  'width'     => '50px',
      ));
	  
      $this->addColumn('status', array(
          'header'    => Mage::helper('cod')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('cod')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('cod')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('cod')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('cod')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('cod_id');
        $this->getMassactionBlock()->setFormFieldName('cod');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('cod')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('cod')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('cod/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('cod')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('cod')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}
