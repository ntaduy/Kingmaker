<?php
class Kingmaker_Test_IndexController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction() {
        echo 'Hello, world!';
    }

    public function byeAction() {
        echo 'See you later alligator.';
    }

    public function paramsAction() {
        echo '<dl>';
        foreach($this->getRequest()->getParams() as $key=>$value) {
            echo '<dt><strong>Param: </strong>'.$key.'</dt>';
            echo '<dl><strong>Value: </strong>'.$value.'</dl>';
        }
        echo '</dl>';
    }
}