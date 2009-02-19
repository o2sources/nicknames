<?php
class Form_Category extends Zend_Form {	
	public function init() {
		$this->setMethod('post');
		
		$this->addElement('text', 'name', array(
			'label'      => 'Nom : ',
			'required'   => true,
			'filters'    => array('StringTrim')
		));
		
		$this->addElement('submit', 'submit', array());
	}
}
