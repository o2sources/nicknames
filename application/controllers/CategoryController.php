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
	
	public function editAction() {
		$this->view->id = $this->_getParam('id');
		if (is_null($this->view->id))
			throw new Zend_Exception('Please provide an id');		
		
		$this->view->form = new Form_Category();
		$this->view->form->populate(Category::getInstance()->fetch($this->view->id));
		$this->view->form->setAction('/category/update/id/'.$this->view->id);
		
		$this->render('add');
	}
	
	public function updateAction() {
		$form = new Form_Category();
		$request = $this->getRequest();
		$id = (int)$this->_getParam('id');
		
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Category::getInstance()->update($id, $request->getPost())) {
					$this->flash()->addMessage('La catégorie a correctement été mise à jour.');
					$this->_helper->redirector('list', 'admin');
				}
			} else {
				$this->view->form = $form;
				return $this->render('add');
			}
		} else
			return $this->_helper->redirector('edit', 'category', null, array('id' => $id));
	}
}