<?php
/**
 * Script for creating and loading database
 */

// use bootstrap (contains prepared db adapter and prepared table 
// component)
define('BOOTSTRAP', true);
include_once dirname(__FILE__) . '/../application/bootstrap.php';

// if any parameter is passed after the script name (like 1 or --withdata)
// load the data file after the schema has loaded.
$withData = isset($_SERVER['argv'][1]);

// pull the adapter out of the application registry
$dbAdapter = Zend_Registry::getInstance()->dbAdapter;

// let the user know whats going on (we are actually creating a 
// database here)
echo 'Writing Database Guestbook in (control-c to cancel): ' . PHP_EOL;
for ($x = 5; $x > 0; $x--) {
    echo $x . "\r"; sleep(1);
}

// this block executes the actual statements that were loaded from 
// the schema file.
try {
    $schemaSql = file_get_contents('./schema.sqlite.sql');
    // use the connection directly to load sql in batches
    $dbAdapter->getConnection()->exec($schemaSql);
    echo PHP_EOL;
    echo 'Database Created';
    echo PHP_EOL;
    
    if ($withData) {
        $dataSql = file_get_contents('./data.sqlite.sql');
        // use the connection directly to load sql in batches
        $dbAdapter->getConnection()->exec($dataSql);
        echo 'Data Loaded.';
        echo PHP_EOL;
    }
    
} catch (Exception $e) {
    echo 'AN ERROR HAS OCCURED:' . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
    return false;
}

// generally speaking, this script will be run from the command line
return true;
