<?php

class ConectionDBMysql
{
    private $conn;

    public function __construct()
    {
        //$this->conn = new mysqli('75.126.161.90', 'usermod2', 'passmod2', 'mod2');
        $this->conn = new mysqli('localhost', 'root', '','mod2');
    }

    public function executeQuery( $query = '' )
    {
        if ( !empty($query) && $query != '' ) {

            $return = $this->conn->query($query);

            if ( $this->conn->affected_rows  < 0 ) {

                return $this->arrayReturn($return);
            } else {

                return $return;
            }

        } else { return array(); }
    }

    private function arrayReturn( $arrayQuery = array() )
    {
        $arrayReturn = Array();

        if ( !empty($arrayQuery) ) {

             while ($row = $arrayQuery->fetch_assoc()) {
                $arrayReturn[] = $row;
            }
            $arrayQuery->free();
            $arrayQuery->close();
        }
        
        return $arrayReturn;
    }

    public function autocommit() 
    {
        $this->conn->autocommit(FALSE);
    }

    public function commit() 
    {
        $this->conn->commit();
    }

    public function rollback() 
    {
        $this->conn->rollback();
    }

    public function error()
    {
        return $this->conn->error;
    }

    public function closeConection() 
    {
        $this->conn->close();
    }
}