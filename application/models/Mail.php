<?php
class Mail extends Zend_Mail {
	
	public function __construct($subject, $message, $from_email, $from_name, $is_html = false) {
		parent::__construct();
		
		$this->setFrom($from_email, $from_name);
		$this->setSubject($subject);
		
		if (!$is_html)
			$this->setBodyText($message);
		else
			$this->setBodyHtml($message);
	}
}
