<?php
/**
 * Kingmaker CMS, Manage Show pages controller
 *
 * @category   Kingmaker
 * @package    Kingmaker_Kmcms
 * @copyright  Copyright (c) Kingmaker, Inc.
 */

class Kingmaker_Kmcms_Adminhtml_ShowController extends Mage_Adminhtml_Controller_Action
{
	/**
	 * Init actions
	 *
	 * @return Kingmaker_Kmcms_Adminhtml_ShowController
	 */
	protected function _initAction()
	{
		// load layout, set active menu and breadcrumbs
		$this->loadLayout()
		->_setActiveMenu('cms/page')
		->_addBreadcrumb(Mage::helper('kmcms')->__('CMS'), Mage::helper('kmcms')->__('CMS'))
		->_addBreadcrumb(Mage::helper('kmcms')->__('Manage Shows'), Mage::helper('kmcms')->__('Manage Shows'))
		;
		return $this;
	}
	
	/**
	 * Index action 
	 */
	public function indexAction()
	{
		$this->_initAction();
		$this->renderLayout();
	}

	/**
	 * Create new Show page
	 */
	public function newAction()
	{
		$this->_forward('edit');
	}

	/**
	 * Edit Show page
	 */
	public function editAction()
	{
		$id = $this->getRequest()->getParam('id', null);
		$model = Mage::getModel('kmcms/show');
		if ($id) {
			$model->load((int) $id);
			if ($model->getId()) {
				$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
				if ($data) {
					$model->setData($data)->setId($id);
				}
			} else {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('kmcms')->__('Show does not exist'));
				$this->_redirect('*/*/');
			}
		}
		Mage::register('show_data', $model);
		$this->loadLayout();
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		$this->renderLayout();
	}

	/**
	 * Save Show action
	 */
	public function saveAction()
	{
		if ($data = $this->getRequest()->getPost()) {
			$data = $this->_filterPostData($data);
			
			$model = Mage::getModel('kmcms/show');
			
			if ($id = $this->getRequest()->getParam('id')) {
				$model->load($id);
			}
			
			$model->setData($data);

			Mage::getSingleton('adminhtml/session')->setFormData($data);
			
			//validating
			if (!$this->_validatePostData($data)) {
				$this->_redirect('*/*/edit', array('id' => $id, '_current' => true));
				return;
			}
			
			try {
				if ($id) {
					$model->setId($id);
				}
				$model->save();

				if (!$model->getId()) {
					Mage::throwException(Mage::helper('kmcms')->__('Error saving show'));
				}
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('kmcms')->__('Show was successfully saved.'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				// The following line decides if it is a "save" or "save and continue"
				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
				} else {
					$this->_redirect('*/*/');
				}

			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				if ($model && $model->getId()) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
				} else {
					$this->_redirect('*/*/');
				}
			}

			return;
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('kmcms')->__('No data found to save'));
		$this->_redirect('*/*/');
	}

	/**
	 * Delete Show action
	 */
	public function deleteAction()
	{
		if ($id = $this->getRequest()->getParam('id')) {
			try {
				$model = Mage::getModel('kmcms/show');
				$model->setId($id);
				$model->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('kmcms')->__('The show has been deleted.'));
				$this->_redirect('*/*/');
				return;
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('kmcms')->__('Unable to find the show to delete.'));
		$this->_redirect('*/*/');
	}
	
	/**
	 * Filtering posted data. Converting localized data if needed
	 *
	 * @param array
	 * @return array
	 */
	protected function _filterPostData($data)
	{		
		if (!isset($data['is_active'])) {
			$data['is_active'] = 0;
		} else {
			$data['is_active'] = 1;
		}
		
		return $data;
	}
	
	/**
	 * Validate post data
	 *
	 * @param array $data
	 * @return bool     Return FALSE if someone item is invalid
	 */
	protected function _validatePostData($data)
	{
		return true;
	}
	
	/**
	 * Check the permission to run it
	 *
	 * @return boolean
	 */
	protected function _isAllowed()
	{
		return Mage::getSingleton('admin/session')->isAllowed('cms/show');
	}

}