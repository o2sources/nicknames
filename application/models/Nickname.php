<?php
class Nickname {
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
			require_once APPLICATION_PATH . '/models/DbTable/Nickname.php';
			$this->_table = new Models_DbTable_Nickname;
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
	* Updates an entry
	*
	* @param int $id, array $data
	* @return int|string
	*/
	public function update($id, array $data) {
		if (!ereg('([0-9]+)', $id))
			return false;
		
		$fields = $this->getTable()->info(Zend_Db_Table_Abstract::COLS);
		
		foreach ($data as $field => $value) {
			if (!in_array($field, $fields)) {
				unset($data[$field]);
			}
		}
		
		print_r($data);
		return $this->getTable()->update($data, 'id = '.$id);
	}
	
	/**
	* deletes an entry
	*
	* @param int $id
	* @return int|string
	*/
	public function delete($id) {
		return $this->getTable()->delete('id = '.$id);
	}
	
	/**
	 * Fetch all entries
	 * 
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function fetch($id = null) {
		if ($id == null)
			return $this->getTable()->fetchAll('1')->toArray();
		else {
			$select = $this->getTable()->select()->where('id = ?', $id);
			return $this->getTable()->fetchRow($select)->toArray();
		}
	}
	
	/**
	 * Fetch all entries for a specified category
	 * 
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function fetch_by_category($id) {
		$select = $this->getTable()->select()->where('category_id = ?', $id);
		return $this->getTable()->fetchAll($select)->toArray();
	}
	
	public function get_rand($category, $number) {
		$number = 3;
		
		$select = $this->getTable()->select()->where('category_id = ?', $category)->order('rand()')->limit($number, 0);
		return $this->getTable()->fetchAll($select)->toArray();
	}
}
