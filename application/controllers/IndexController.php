<?php
class IndexController extends AppGlobalController  {
	
	public function indexAction() {
		
	}
	
	public function emailsAction() {
		$nb = $this->_getParam('nb');
		$this->setForm($nb);
	}
	
	public function sendAction() {
		$nb = $this->_getParam('nb');
		$form = new Form_Email($nb);
		$request = $this->getRequest();
		
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($request->getPost())) {
				$datas = $request->getPost();
				
				$emails = array();
				foreach($datas as $i => $uplet) {
					if (preg_match('`email([0-9]+)`', $i)) {
						$emails[] = $uplet;
					}
				}
				$nicknames = Nickname::getInstance()->get_rand($datas['category'], count($emails));
				
				if (count($emails) > count($nicknames)) {
					$this->setForm($form);
					return $this->render('emails');
				}
				
				foreach($emails as $i => $email) {
					//We send the email with the nickname
					$mail = new Mail(
						'Pseudonyme aléatoire',
						'Votre pseudonyme aléatoire est : '.$nicknames[$i]['name'],
						'noreply@quakerox.o2sources.com',
						'Nickname Mailer'
					);
					$mail->addTo($email)
					->send();
				}
				$this->flash()->addMessage('Les emails ont correctement été envoyés.');
				$this->_helper->redirector('index', 'index');
			} else {
				$this->setForm($form);
				return $this->render('emails');
			}
		} else
			return $this->_helper->redirector('emails', 'index');
	}
	
	protected function setForm($form) {
		if (ereg('([0-9]+)', $form))
			$form = new Form_Email($form);
			
		$form->setAction('/index/send?nb='.$form->number());
		$this->view->form = $form;
	}
}