<?php
/**
 * Created by PhpStorm.
 * User: Foss
 * Date: 2015-07-19
 * Time: 18:33
 */

abstract class Repository {

    protected $dbConnection;
    protected $dbTable;

    protected function connection() {
        if ($this->dbConnection == NULL) {
            $this->dbConnection = new \PDO(DBCONNECTION, DBUSERNAME, DBPASSWORD);
        }
        $this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $this->dbConnection;
    }
}