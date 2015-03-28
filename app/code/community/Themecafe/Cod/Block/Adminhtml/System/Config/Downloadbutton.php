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


class Themecafe_Cod_Block_Adminhtml_System_Config_Downloadbutton extends Mage_Adminhtml_Block_System_Config_Form_Field  implements Varien_Data_Form_Element_Renderer_Interface{

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $buttonBlock = Mage::app()->getLayout()->createBlock('adminhtml/widget_button');

        $params = array(
            'website' => $buttonBlock->getRequest()->getParam('website')
        );

        $data = array(
            'label'     => Mage::helper('adminhtml')->__('Download'),
            'onclick'   => 'setLocation(\''.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).'cod/sample/sample.csv' . '\' )',
            'class'     => 'button',
        );

        $html = $buttonBlock->setData($data)->toHtml();

        return $html;
    }
}
