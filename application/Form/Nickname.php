<?php
class Form_Nickname extends Zend_Form {	
	public function init() {
		$this->setMethod('post');
		
		$this->addElement('text', 'name', array(
			'label'      => 'Nom : ',
			'required'   => true,
			'filters'    => array('StringTrim')
		));
		
		$this->addElement('select', 'category_id', array(
			'label'      => 'Catégorie : ',
			'required'   => true,
			'filters'    => array('StringTrim'),
			'multiOptions' => Category::getInstance()->fetch_select()
		));
		
		$this->addElement('submit', 'submit', array());
	}
}
