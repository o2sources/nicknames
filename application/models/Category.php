<?php
class Category {
	protected $_table;
	protected static $_instance;
		
	# Instantiate the object and return it.
	public static function getInstance() {
		if (is_null(self::$_instance))
			self::$_instance = new self;
		return self::$_instance;
	}
	
	
	/**
	 * Retrieve table object
	 * 
	 * @return Model_Guestbook_Table
	 */
	public function getTable() {
		if (is_null($this->_table)) {
			require_once APPLICATION_PATH . '/models/DbTable/Category.php';
			$this->_table = new Models_DbTable_Category;
		}
		return $this->_table;
	}
	
	/**
	 * Save a new entry
	 * 
	 * @param  array $data
	 * @return int|string
	 */
	public function save(array $data) {
		$fields = $this->getTable()->info(Zend_Db_Table_Abstract::COLS);
		
		foreach ($data as $field => $value) {
			if (!in_array($field, $fields)) {
				unset($data[$field]);
			}
		}
		return $this->getTable()->insert($data);
	}
	
	/**
	 * Fetch all entries
	 * 
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function fetch($id = null) {
		if ($id == null) {
			$return = $this->getTable()->fetchAll('1')->toArray();
			foreach($return as $i => $uplet) {
				$return[$i]['nicknames'] = Nickname::getInstance()->fetch_by_category($return[$i]['id']);
			}
		} else {
			$select = $this->getTable()->select()->where('id = ?', $id);
			$return = $this->getTable()->fetchRow($select)->toArray();
			$return['nicknames'] = Nickname::getInstance()->fetch_by_category($return['id']);
		}
		
		return $return;
	}
}