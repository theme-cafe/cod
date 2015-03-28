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

class Themecafe_Cod_Block_Adminhtml_Cod_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'cod';
        $this->_controller = 'adminhtml_cod';
        
        $this->_updateButton('save', 'label', Mage::helper('cod')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('cod')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('cod_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'cod_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'cod_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('cod_data') && Mage::registry('cod_data')->getId() ) {
            return Mage::helper('cod')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('cod_data')->getTitle()));
        } else {
            return Mage::helper('cod')->__('Add Cod Details');
        }
    }
}
