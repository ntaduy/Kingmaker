<?php
/**
 * Kingmaker CMS,  Show adminhtml edit form block
 *
 * @category   Kingmaker
 * @package    Kingmaker_Kmcms
 * @copyright  Copyright (c) Kingmaker, Inc.
 */

class Kingmaker_Kmcms_Block_Adminhtml_Show_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		if (Mage::getSingleton('adminhtml/session')->getShowData())
		{
			$data = Mage::getSingleton('adminhtml/session')->getShowData();
			Mage::getSingleton('adminhtml/session')->getShowData(null);
		}
		elseif (Mage::registry('show_data'))
		{
			$data = Mage::registry('show_data')->getData();
		}
		else
		{
			$data = array();
		}
		
		$activeStatus = 1;
		$videoId = '';
		if (!empty($data)) {
			$activeStatus = $data['is_active'];
		}
		
		$form = new Varien_Data_Form(array(
				'id' => 'edit_form',
				'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
				'method' => 'post',
				'enctype' => 'multipart/form-data',
		));

		$form->setUseContainer(true);

		$this->setForm($form);

		$fieldset = $form->addFieldset('show_form', array(
			'legend' =>Mage::helper('kmcms')->__('Show Information')
		));
		
		$fieldset->addField('host_id', 'text', array(
			'label'     => Mage::helper('kmcms')->__('Host ID'),
			'class'     => 'required-entry',
			'required'  => true,
			'name'      => 'host_id'
		));

		$aa = $fieldset->addField('host_blurb', 'textarea', array(
			'label'     => Mage::helper('kmcms')->__('Blurb'),
			'class'     => 'required-entry',
			'required'  => true,
			'style'		=> "height: 3em",
			'name'      => 'host_blurb'
		));
		
		$showCategories = array(
			'Makeup'	=> 'Makeup',
			'Fashion'	=> 'Fashion',
			'Hairstyle'	=> 'Hairstyle',
			'Nails'		=> 'Nails'
		); 
		
		$fieldset->addField('category', 'select', array(
				'label'     => Mage::helper('kmcms')->__('Category'),
				'class'     => 'required-entry',
				'required'  => false,
				'name'      => 'category',
				'options'	=> $showCategories
		));
		
		$fieldset->addField('is_active', 'checkbox', array(
				'label'     => Mage::helper('kmcms')->__('Is Show Active'),
				'required'  => false,
				'name'      => 'is_active',
				'checked'	=> $activeStatus
		));

		$form->setValues($data);

		return parent::_prepareForm();
	}
}