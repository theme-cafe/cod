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
class Themecafe_Cod_Block_Adminhtml_Cod extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_cod';
    $this->_blockGroup = 'cod';
    $this->_headerText = Mage::helper('cod')->__('Details Manager');
    $this->_addButtonLabel = Mage::helper('cod')->__('Add Details');
    parent::__construct();
  }
}
