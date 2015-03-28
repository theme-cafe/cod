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

class Themecafe_Cod_Block_Adminhtml_Cod_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('cod_form', array('legend'=>Mage::helper('cod')->__('COD Information')));
     
      $fieldset->addField('area', 'text', array(
          'label'     => Mage::helper('cod')->__('Area Name'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'area',
      ));

	  $fieldset->addField('cityname', 'text', array(
          'label'     => Mage::helper('cod')->__('City'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'cityname',
      ));

	  $fieldset->addField('state', 'text', array(
          'label'     => Mage::helper('cod')->__('State'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'state',
      ));	
	  $fieldset->addField('pincode', 'text', array(
          'name'      => 'pincode',
          'label'     => Mage::helper('cod')->__('Pincode'),
          'required'  => true,
		 
      ));	
	 
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('cod')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('cod')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('cod')->__('Disabled'),
              ),
          ),
      ));
     
      if ( Mage::getSingleton('adminhtml/session')->getCodData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getCodData());
          Mage::getSingleton('adminhtml/session')->setCodData(null);
      } elseif ( Mage::registry('cod_data') ) {
          $form->setValues(Mage::registry('cod_data')->getData());
      }
      return parent::_prepareForm();
  }
}
