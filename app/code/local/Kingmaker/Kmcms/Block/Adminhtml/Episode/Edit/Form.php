<?php
/**
 * Kingmaker CMS, Episode adminhtml edit form block
 *
 * @category   Kingmaker
 * @package    Kingmaker_Kmcms
 * @copyright  Copyright (c) Kingmaker, Inc.
 */

class Kingmaker_Kmcms_Block_Adminhtml_Episode_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		if (Mage::getSingleton('adminhtml/session')->getEpisodeData())
		{
			$data = Mage::getSingleton('adminhtml/session')->getEpisodeData();
			Mage::getSingleton('adminhtml/session')->getEpisodeData(null);
		}
		elseif (Mage::registry('episode_data'))
		{
			$data = Mage::registry('episode_data')->getData();
		}
		else
		{
			$data = array();
		}
		
		$getVideoUrl = $this->getUrl('/episode/getVideoMeta');
		
		$activeStatus = 1;
		
		$videoPlayerUuid = '';
		
		if (!empty($data)) {
			list($date, $time) = explode(' ', $data['publish_time']);
			$data['publish_time_date'] = date('m/d/Y', strtotime($date));
			$data['publish_time_time'] = str_replace(':', ',', $time);
			
			$activeStatus = $data['is_active'];
			$videoPlayerUuid = $data['video_player_uuid'];
		}
		
		$form = new Varien_Data_Form(array(
				'id' => 'edit_form',
				'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
				'method' => 'post',
				'enctype' => 'multipart/form-data',
		));

		$form->setUseContainer(true);

		$this->setForm($form);

		$fieldset = $form->addFieldset('episode_form', array(
				'legend' =>Mage::helper('kmcms')->__('Episode Information')
		));
		
		$fieldset->addField('video_id', 'text', array(
				'label'     => Mage::helper('kmcms')->__('Video ID'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'video_id',
				'style'		=> 'margin-bottom: 0.5em;'
		))->setAfterElementHtml("
			<script type='text/javascript'>
				Event.observe('video_id', 'blur', function(event) {
					
					new Ajax.Request('$getVideoUrl', {
						method: 'post',
						parameters: 'videoId=' + $('video_id').getValue(),
						onSuccess: function(transport){
							var json = transport.responseText.evalJSON();
							if (json.status == 'failure') {
								alert(json.data);
							} else {
								$('title').setValue(json.data.title);
								$('description').setValue(json.data.description);
							}
							
						},
						onFailure: function(){ alert('Something went wrong...') }
					});
				});
			</script>
		");
		
		$fieldset->addField('video_player_uuid', 'text', array(
				'label'     => Mage::helper('kmcms')->__('Embedded Player ID'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'video_player_uuid',
				'style'		=> 'margin-bottom: 0.5em;'
		))->setAfterElementHtml("
				<script type='text/javascript'>
					Event.observe('video_player_uuid', 'blur', function(event) {
						var vidyardEmbedScript = document.createElement('script');
						vidyardEmbedScript.type = 'text/javascript';
						vidyardEmbedScript.id = 'vidyard_embed_code_' + $('video_player_uuid').getValue();
						vidyardEmbedScript.src = '//embed.vidyard.com/embed/' + $('video_player_uuid').getValue() + '/iframe?v=2.0';
						$('vidyard_embed_code').update('');
						$('vidyard_embed_code').insert(vidyardEmbedScript);
					});
				</script>
				<div id='vidyard_embed_code'>
					<script type='text/javascript'
						id='vidyard_embed_code_" . $videoPlayerUuid . "'
						src='//embed.vidyard.com/embed/" . $videoPlayerUuid . "/iframe?v=2.0'>
					</script>
				</div>
				");

		$fieldset->addField('title', 'text', array(
				'label'     => Mage::helper('kmcms')->__('Title'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'title',
				'onblur' 	=> 'updateUrlKey()',
				'note'     => Mage::helper('kmcms')->__('The title of the episode.')
		))->setAfterElementHtml("
			<script type='text/javascript'>
				Event.observe('title', 'blur', function(event) {
					if ( $('url_key').getValue() == '' ) {
						var tmpStr = $('title').getValue(); 
						tmpStr = tmpStr.replace(/ /g, '_');
				    	$('url_key').setValue(tmpStr.toLowerCase());
					}
				});
			</script>
		");
		
		$fieldset->addField('url_key', 'text', array(
				'label'     => Mage::helper('kmcms')->__('URL Key'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'url_key'
		));

		$fieldset->addField('description', 'textarea', array(
				'label'     => Mage::helper('kmcms')->__('Video Description'),
				'required'  => false,
				'name'      => 'description',
				'style'		=> "height: 10em"
		));
		
		$fieldset->addField('directions', 'editor', array(
				'label'     => Mage::helper('kmcms')->__('Step-by-Step Directions'),
				'required'  => false,
				'name'      => 'directions',
				'config'    => Mage::getSingleton('cms/wysiwyg_config')->getConfig(),
				'wysiwyg'   => true
		));
		
		$showCollection = Mage::getModel('kmcms/show')->getCollection()
						->addFieldToSelect('id')
    					->addFieldToSelect('host_blurb')
						->getData();
		$showOptions = array();
		if (!empty($showCollection)) {
			foreach ($showCollection as $show) {
				$showOptions[$show['id']] = $show['host_blurb'];
			}
		}
		
		$fieldset->addField('show_id', 'select', array(
				'label'     => Mage::helper('kmcms')->__('Select Show'),
				'class'     => 'required-entry',
				'required'  => false,
				'name'      => 'show_id',
				'options'	=> $showOptions
		));

		$dateFormatIso = Mage::app()->getLocale()->getDateFormat(
				Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
		);
		
		$fieldset->addField('publish_time_date', 'date', array(
				'label'     => Mage::helper('kmcms')->__('Publish On'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'publish_time_date',
				'format'	=> $dateFormatIso,
				'image'  	=> $this->getSkinUrl('images/grid-cal.gif')
		));
		
		$fieldset->addField('publish_time_time', 'time', array(
				'label'     => Mage::helper('kmcms')->__(''),
				'class'     => 'required-entry',
				'required'  => false,
				'name'      => 'publish_time_time',
				'style'		=> 'width: 4em;'
		));
		
		$fieldset->addField('is_active', 'checkbox', array(
				'label'     => Mage::helper('kmcms')->__('Is Episode Active'),
				'required'  => false,
				'name'      => 'is_active',
				'checked'	=> $activeStatus
		));

		$form->setValues($data);

		return parent::_prepareForm();
	}
}