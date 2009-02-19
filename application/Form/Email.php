<?php
class Form_Email extends Zend_Form {
	protected $_number;
	
	public function __construct($number) {
		$this->_number = $number;
		parent::__construct();
	}
	
	public function init() {
		$this->setMethod('post');
		
		for($i=0;$i<$this->_number;$i++) {
			$this->addElement('text', 'email'.$i, array(
				'label'      => 'Email : ',
				'required'   => true,
				'filters'    => array('StringTrim'),
				'validators' => array(
					'EmailAddress',
				)
			));
		}
		$this->addElement('select', 'category', array(
			'label'      => 'Catégorie : ',
			'required'   => true,
			'filters'    => array('StringTrim'),
			'multiOptions' => Category::getInstance()->fetch_select()
		));
		
		$this->addElement('submit', 'submit', array());
	}
	
	public function number() {
		return $this->_number;
	}
}
