<?php
/**
 * Kingmaker CMS, Manage Episode pages controller
 *
 * @category   Kingmaker
 * @package    Kingmaker_Kmcms
 * @copyright  Copyright (c) Kingmaker, Inc.
 */

class Kingmaker_Kmcms_Adminhtml_EpisodeController extends Mage_Adminhtml_Controller_Action
{
	/**
	 * Init actions
	 *
	 * @return Kingmaker_Kmcms_Adminhtml_EpisodeController
	 */
	protected function _initAction()
	{
		// load layout, set active menu and breadcrumbs
		$this->loadLayout()
		->_setActiveMenu('cms/page')
		->_addBreadcrumb(Mage::helper('kmcms')->__('CMS'), Mage::helper('kmcms')->__('CMS'))
		->_addBreadcrumb(Mage::helper('kmcms')->__('Manage Episodes'), Mage::helper('kmcms')->__('Manage Episodes'))
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
	 * Create new Episode page
	 */
	public function newAction()
	{
		$this->_forward('edit');
	}

	/**
	 * Edit Episode page
	 */
	public function editAction()
	{
		$id = $this->getRequest()->getParam('id', null);
		$model = Mage::getModel('kmcms/episode');
		if ($id) {
			$model->load((int) $id);
			if ($model->getId()) {
				$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
				if ($data) {
					$model->setData($data)->setId($id);
				}
			} else {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('kmcms')->__('Episode does not exist'));
				$this->_redirect('*/*/');
			}
		}
		Mage::register('episode_data', $model);
		$this->loadLayout();
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		$this->renderLayout();
	}

	/**
	 * Save Episode action
	 */
	public function saveAction()
	{
		if ($data = $this->getRequest()->getPost()) {
			$data = $this->_filterPostData($data);
			
			$model = Mage::getModel('kmcms/episode');
			
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
					Mage::throwException(Mage::helper('kmcms')->__('Error saving episode'));
				}
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('kmcms')->__('Episode was successfully saved.'));
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
	 * Delete Episode action
	 */
	public function deleteAction()
	{
		if ($id = $this->getRequest()->getParam('id')) {
			try {
				$model = Mage::getModel('kmcms/episode');
				$model->setId($id);
				$model->delete();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('kmcms')->__('The episode has been deleted.'));
				$this->_redirect('*/*/');
				return;
			}
			catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				return;
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('kmcms')->__('Unable to find the episode to delete.'));
		$this->_redirect('*/*/');
	}
	
	public function getVideoMetaAction()
	{
		$result = array(
			'status'	=> "failure",
			'data'		=> "This video does not exist"
		);
		
		if ($videoId = $this->getRequest()->getParam('videoId')) {
		
			$video = Mage::helper("kmcms/vidyard")->getVideo($videoId);

			if (!isset($video["error"])) {
				$result['status']	= "success";
				$result['data'] 	= array(
					'title' => $video['name'],
					'description' => $video['description']
				);
			}
		}
		
		$this->getResponse()->setBody(Zend_Json::encode($result));
		
	}
	
	/**
	 * Filtering posted data. Converting localized data if needed
	 *
	 * @param array
	 * @return array
	 */
	protected function _filterPostData($data)
	{
		$data = $this->_filterDates($data, array('publish_time_date'));
		
		$data['publish_time'] = $data['publish_time_date'] . " "
			. $data['publish_time_time'][0] . ":"
			. $data['publish_time_time'][1] . ":"
			. $data['publish_time_time'][2];
			
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
		return Mage::getSingleton('admin/session')->isAllowed('cms/episode');
	}

}