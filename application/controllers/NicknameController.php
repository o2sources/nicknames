<?php
class NicknameController extends AppGlobalController {
	
	public function addAction() {
		$this->view->form = new Form_Nickname();
		$this->view->form->setAction('/nickname/create');
	}
	
	public function createAction() {
		$form = new Form_Nickname();
		$request = $this->getRequest();
		
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Nickname::getInstance()->save($request->getPost())) {
					$this->flash()->addMessage('Le pseudonyme a correctement été créée.');
					$this->_helper->redirector('list', 'admin');
				}
			} else {
				$this->view->form = $form;
				return $this->render('add');
			}
		} else
			return $this->_helper->redirector('add', 'nickname');
	}
	
	public function editAction() {
		$this->view->id = $this->_getParam('id');
		if (is_null($this->view->id))
			throw new Zend_Exception('Please provide an id');		
		
		$this->view->form = new Form_Nickname();
		
		$this->view->form->populate(Nickname::getInstance()->fetch($this->view->id));
		$this->view->form->setAction('/nickname/update/id/'.$this->view->id);
		
		$this->render('add');
	}
	
	public function updateAction() {
		$form = new Form_Nickname();
		$request = $this->getRequest();
		$id = (int)$this->_getParam('id');
		
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($request->getPost())) {
				if (Nickname::getInstance()->update($id, $request->getPost())) {
					$this->flash()->addMessage('Le pseudonyme a correctement été mise à jour.');
					$this->_helper->redirector('list', 'admin');
				}
			} else {
				$this->view->form = $form;
				return $this->render('add');
			}
		} else
			return $this->_helper->redirector('edit', 'nickname', null, array('id' => $id));
	}
	
	public function deleteAction() {
		$id = (int)$this->_getParam('id');
		Nickname::getInstance()->delete($id);
		
		$this->flash()->addMessage('Le pseudonyme a correctement été supprimé.');
		$this->_helper->redirector('list', 'admin');
	}
}