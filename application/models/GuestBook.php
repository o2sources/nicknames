<?php

/**
 * This model class represents the business logic associated with a "guestbook" 
 * model.  While its easy to say that models are generally derived from 
 * database tables, this is not always the case.  Data sources for models are 
 * commonly web services, the filesystem, caching systems, and more.  That 
 * said, for the purposes of this guestbook applicaiton, we have split the 
 * buisness logic from its datasource (the dbTable).
 *
 * This particular class follows the Table Module pattern.  There are other 
 * patterns you might want to employ when modeling for your application, but 
 * for the purposes of this example application, this is the best choice.
 * To understand different Modeling Paradigms: 
 * 
 * @see http://martinfowler.com/eaaCatalog/tableModule.html [Table Module]
 * @see http://martinfowler.com/eaaCatalog/ [See Domain Logic Patterns and Data Source Arch. Patterns]
 */
class Model_GuestBook
{
    /** Model_Table_Guestbook */
    protected $_table;

    /**
     * Retrieve table object
     * 
     * @return Model_Guestbook_Table
     */
    public function getTable()
    {
        if (null === $this->_table) {
            // since the dbTable is not a library item but an application item,
            // we must require it to use it
            require_once APPLICATION_PATH . '/models/DbTable/GuestBook.php';
            $this->_table = new Model_DbTable_Guestbook;
        }
        return $this->_table;
    }

    /**
     * Save a new entry
     * 
     * @param  array $data 
     * @return int|string
     */
    public function save(array $data)
    {
        $table  = $this->getTable();
        $fields = $table->info(Zend_Db_Table_Abstract::COLS);
        foreach ($data as $field => $value) {
            if (!in_array($field, $fields)) {
                unset($data[$field]);
            }
        }
        return $table->insert($data);
    }

    /**
     * Fetch all entries
     * 
     * @return Zend_Db_Table_Rowset_Abstract
     */
    public function fetchEntries()
    {
        // we are gonna return just an array of the data since
        // we are abstracting the datasource from the application,
        // at current, only our model will be aware of how to manipulate
        // the data source (dbTable).
        // This ALSO means that if you pass this model
        return $this->getTable()->fetchAll('1')->toArray();
    }

    /**
     * Fetch an individual entry
     * 
     * @param  int|string $id 
     * @return null|Zend_Db_Table_Row_Abstract
     */
    public function fetchEntry($id)
    {
        $table = $this->getTable();
        $select = $table->select()->where('id = ?', $id);
        // see reasoning in fetchEntries() as to why we return only an array
        return $table->fetchRow($select)->toArray();
    }
}
