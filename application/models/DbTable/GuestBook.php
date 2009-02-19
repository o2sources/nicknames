<?php

/**
 * This is the DbTable class for the guestbook table.
 */
class Model_DbTable_GuestBook extends Zend_Db_Table_Abstract
{
    /** Table name */
    protected $_name    = 'guestbook';

    /**
     * Insert new row
     *
     * Ensure that a timestamp is set for the created field.
     * 
     * @param  array $data 
     * @return int
     */
    public function insert(array $data)
    {
        $data['created'] = date('Y-m-d H:i:s');
        return parent::insert($data);
    }

    /**
     * Override updating
     *
     * Do not allow updating of entries
     * 
     * @param  array $data 
     * @param  mixed $where 
     * @return void
     * @throws Exception
     */
    public function update(array $data, $where)
    {
        throw new Exception('Cannot update guestbook entries');
    }
}
