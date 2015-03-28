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

class Themecafe_Cod_Adminhtml_CodController extends Mage_Adminhtml_Controller_action
{
   	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('cod/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Details Manager'), Mage::helper('adminhtml')->__('Details Manager'));
		
		return $this;	
	}   
 
	public function indexAction() {
	   $this->_initAction()
			->renderLayout();
      
	}
	
	public function editAction() {
        if (Mage::helper('cod')->getIsEnabled()) {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('cod/cod')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('cod_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('cod/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Details Manager'), Mage::helper('adminhtml')->__('Details Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Details'), Mage::helper('adminhtml')->__('Details'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('cod/adminhtml_cod_edit'))
				->_addLeft($this->getLayout()->createBlock('cod/adminhtml_cod_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cod')->__('Details does not exist'));
			$this->_redirect('*/*/');
		}
      }
	}
	public function newAction() {
    	$this->_forward('edit');
	}
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			$model = Mage::getModel('cod/cod');
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('cod')->__('Details successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('cod')->__('Unable to find details to save'));
        $this->_redirect('*/*/');
	}

 	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('cod/cod');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $codIds = $this->getRequest()->getParam('cod');
        if(!is_array($codIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($codIds as $codId) {
                    $cod = Mage::getModel('cod/cod')->load($codId);
                    $cod->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($codIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }	
	
	public function massStatusAction()
    {
        $codIds = $this->getRequest()->getParam('cod');
        if(!is_array($codIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($codIds as $codId) {
                    $codId = Mage::getSingleton('cod/cod')
                        ->load($codId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($codIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
	public function exportCsvAction()
    {
        $fileName   = 'cod.csv';
        $content    = $this->getLayout()->createBlock('cod/adminhtml_cod_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'cod.xml';
        $content    = $this->getLayout()->createBlock('cod/adminhtml_cod_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }
	
	 protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}
