<?php
class AdminController extends AppGlobalController {
	
	/**
	 * Shows a list of every category and every nickname
	 * 
	 */
	public function listAction() {
		$this->view->liste = Category::getInstance()->fetch();
	}
}