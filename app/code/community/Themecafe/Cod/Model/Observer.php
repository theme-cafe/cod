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

class Themecafe_Cod_Model_Observer {
   	
   public function filterPaymentMethod(Varien_Event_Observer $observer){
      if(Mage::getStoreConfigFlag('payment/cashondelivery/active')==1){
		if (Mage::helper('cod')->getIsEnabled() && Mage::getStoreConfig('cod/codcheck/paymentmethod')==1) {
		    $method = $observer->getEvent()->getMethodInstance();
		    $postDatas =  Mage::app()->getRequest()->getParams();
			$checkout = Mage::getSingleton('checkout/session')->getQuote();
		    $shipping = $checkout->getShippingAddress();
            $postcode = $shipping->getPostcode();	
		    if($method->getCode()=='cashondelivery'){
		       if(isset($postcode))
			   {
				    $collection = Mage::getModel('cod/cod')->getCollection()->addFieldToFilter('pincode', $postcode)->addFieldToFilter('status',1);
				    if(count($collection) > 0 ){
						$result = $observer->getEvent()->getResult();   
						$result->isAvailable = true; //It will keep enabled the COD payment method if pincode is found and enabled as COD active area
						return;
				    }
				    else{
						$result = $observer->getEvent()->getResult();   
						$result->isAvailable = false; //It will disable the COD payment method if pincode is not found or disabled for COD active area
				    }
			   
				}
		   
			  }
		    return;
		}
       }
	 }
     
     /*Function to observer the COD configuration save action*/
     public function adminSystemConfigChangedSection(Varien_Event_Observer $observer){ 
       if($_FILES['groups']['name']['codcheck']['fields']['file']['value'] != ""){ //check if the csv file is uploaded
            $filepath = Mage::getBaseUrl('media') .'cod'. DS .  Mage::getStoreConfig('cod/codcheck/file'); //This is the file path where new csv file is get uploads
	        Mage::getResourceModel('cod/cod')->saveImportData($filepath); //Resource function call to import the uploaded csv data
       }
     }
  
} 
