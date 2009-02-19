<?php
class CategoryController extends AppGlobalController  {
	
	public function addAction() {
		$this->view->form = new Form_Category();
		$this->view->form->setAction('/category/create');
	}
	
	public function createAction() {
		$form = new Form_Category();
		$request = $this->getRequest();
		
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Category::getInstance()->save($request->getPost())) {
					$this->flash()->addMessage('La catégorie a correctement été créée.');
					$this->_helper->redirector('list', 'admin');
				}
			} else {
				$this->view->form = $form;
				return $this->render('add');
			}
		} else
			return $this->_helper->redirector('add', 'category');
	}
}