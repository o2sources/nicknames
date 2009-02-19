<?php
class AdminController extends Zend_Controller_Action  {
	
	/**
	 * Shows a list of every category and every nickname
	 * 
	 */
	public function listAction() {
		$this->view->liste = Category::getInstance()->fetch();
	}
}