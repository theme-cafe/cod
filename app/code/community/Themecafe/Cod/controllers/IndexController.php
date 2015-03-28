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


class Themecafe_Cod_IndexController extends Mage_Core_Controller_Front_Action
{
	public function codAction(){
			$isajax = $this->getRequest()->getParam('isajax');
			if (Mage::helper('cod')->getIsEnabled()) {
            $pincode     = $_POST['pincode']; 
		    Mage::getSingleton('core/session')->setCodService($pincode);
			$collection = Mage::getModel('cod/cod')->getCollection()->addFieldToFilter('pincode', $pincode)->addFieldToFilter('status',1);
		    if($isajax){
					$response = array();
					$response['MSG']  = '';
					$response['FLAG'] = 1;
					if(count($collection) > 0 ){
					$response['MSG'] ='Cash On Delivery is available for area with pincode '.$pincode;
					Mage::getSingleton('core/session')->setCodMsg('Cash On Delivery is available for area with pincode '.$pincode);
					 }else{
						$response['MSG'] ='Sorry! Service is not available in area with pincode '.$pincode;
						Mage::getSingleton('core/session')->setCodMsg('Sorry! Service is not available in area with pincode '.$pincode);
						$response['FLAG'] = 0;
					 }
					echo json_encode($response);
			    }
			}

    }
}
