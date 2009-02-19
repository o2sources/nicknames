<?php
class AppGlobalController extends Zend_Controller_Action {
	private $config = null;
	
	#Shortcut to get the flash message in any controller.
	protected function flash() {
		return $this->_helper->getHelper('FlashMessenger');
	}
}