<?php
/**
 * Kingmaker CMS, Episode adminhtml form container block
 *
 * @category   Kingmaker
 * @package    Kingmaker_Kmcms
 * @copyright  Copyright (c) Kingmaker, Inc.
 */

class Kingmaker_Kmcms_Block_Adminhtml_Show_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
	{
		parent::__construct();

		$this->_objectId = 'id';
		$this->_blockGroup = 'kmcms';
		$this->_controller = 'adminhtml_show';
		$this->_mode = 'edit';

		$this->_addButton('save_and_continue', array(
				'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
				'onclick' => 'saveAndContinueEdit()',
				'class' => 'save',
		), -100);
		
		$this->_updateButton('save', 'label', Mage::helper('kmcms')->__('Save Show'));

		$this->_formScripts[] = "
			function toggleEditor() {
				if (tinyMCE.getInstanceById('form_content') == null) {
					tinyMCE.execCommand('mceAddControl', false, 'edit_form');
				} else {
					tinyMCE.execCommand('mceRemoveControl', false, 'edit_form');
				}
			}

			function saveAndContinueEdit(){
				editForm.submit($('edit_form').action+'back/edit/');
			}
		";
	}
	
	protected function _prepareLayout() {
		parent::_prepareLayout();
		if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
			$this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
		}
	}

	public function getHeaderText()
	{
		if (Mage::registry('show_data') && Mage::registry('show_data')->getId())
		{
			return Mage::helper('kmcms')->__('Edit Show "%s"', $this->htmlEscape(Mage::registry('show_data')->getTitle()));
		} else {
			return Mage::helper('kmcms')->__('New Show');
		}
	}

}