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

class Themecafe_Cod_Model_Mysql4_Cod extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct(){
		$this->_init('cod/cod','cod_id');
	}	

	public function saveImportData(array $filepath){
			$handle = fopen($filepath, "r");
            $i = 0;
            while(! feof($handle))
			  {
              $data = fgetcsv($handle, ",");
              if($data[0]==="Area"){ continue; }
              $this->_getWriteAdapter()->insertOnDuplicate(
				    $this->getTable('cod'),
				    array(
				    'area' => $data[0],
				    'pincode' => $data[1],
				    'status' => $data[2],
                    'cityname'=> $data[3],
                    'state' => $data[4],
				     ),
				    array('area', 'pincode', 'status','cityname','state')
				);
			  } 
       return $this;
	}
}
