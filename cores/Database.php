<?php
class Database {
    private static $db = null;
    private $dblink;

    private function __construct() {
        try {
            $dbStr = "mysql:host=".DB::dbhost.";dbname=".DB::dbname.";dbport=".DB::dbport.";";
            $this->dblink = new PDO( $dbStr, DB::dbuser, DB::dbpass);
            $this->dblink->query("SET NAMES utf8");
        } catch( PDOException $e ) {
            print "<script> console.log(Error!: " . $e->getMessage() . ")<script/>";
            $this->dblink = null;
        }
    }

    public function __destruct() {
        $this->dblink = null;
    }

    public static function getDatabase() {
        if( self::$db == null || self::$db->dblink == null ) {
            $db = new Database();
        }
        return $db->dblink;
    }
}