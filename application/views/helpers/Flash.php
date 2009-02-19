<?php
/**
 * RefStats
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   RefStats
 * @package    FlashHelper
 * @copyright  Copyright (c) 2009 Damien MATHIEU
 * @license    http://www.opensource.org/licenses/bsd-license.php     New BSD License
 */

class Helper_Flash {
	private $messenger = null;
	
	#Retrives the messenger
	private function m() {
		if ($this->messenger == null)
			$this->messenger = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');
		return $this->messenger;
	}
	
	public function flash($object = false) {
		if ($object == true)
			return $this;
		
		if (!$this->has_messages())
			return '';
			
		$messages = $this->m()->getMessages();
		
		if (count($messages) == 1)
			$ret = $messages[0];
		else {
			$ret = '<ul>';
			foreach($messages as $message) {
				$ret .= '<li>'.$message.'</li>';
			}
			$ret .= '</ul>';
		}
		
		$this->m()->clearMessages();
		return $ret;
	}
	
	public function has_messages() {
		return count($this->m()->getMessages()) > 0;
	}
}