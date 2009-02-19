<?php 
class ErrorController extends AppGlobalController {
	
	public function errorAction() { 
		$this->_helper->viewRenderer->setViewSuffix('phtml');
		$errors = $this->_getParam('error_handler'); 
		
		switch ($errors->type) { 
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER: 
			case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION: 
				$this->getResponse()->setHttpResponseCode(404); 
				$this->view->message = 'Page not found'; 
				break;
			default:
				$this->getResponse()->setHttpResponseCode(500); 
				$this->view->message = 'Application error'; 
				break; 
		} 
		
		$this->view->env       = $this->getInvokeArg('env'); 
		$this->view->exception = $errors->exception; 
		$this->view->request   = $errors->request; 
	} 
}
