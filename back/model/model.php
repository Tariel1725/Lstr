<?php
require_once 'constants.php';
class model
{
    public $DB;

    public function __construct(){
        $stmt = 'mysql:host='.SQLSERVER.';dbname='.DBNAME;
        $this->DB = new PDO($stmt, DBUSER, DBPASSWORD);
    }
}