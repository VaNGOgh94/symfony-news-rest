<?php
/**
 * Created by PhpStorm.
 * User: deeplearning
 * Date: 2/15/18
 * Time: 9:08 PM
 */

namespace App;


use PHPUnit\Framework\MockObject\RuntimeException;

/**
 * Class DatabaseInterface
 * @package App
 *
 * Note that SQL Injection protection wasn't implemented
 */
class DatabaseInterface{
    const server = 'localhost';
    const username = 'root';
    const password = '';
    const db = 'civcija_task_db';
    const charset= 'utf8';

    private $conn = NULL;

    function connect()
    {
        $this->conn = new \mysqli(self::server, self::username,self::password, self::db);
        if($this->conn->connect_errno)
        {
//            echo "Connect err !" . $this->conn->connect_error;
            throw new RuntimeException("Couldn't connect to db");
        }
        else
        {
            mysqli_set_charset($this->conn, self::charset);
        }
    }

    function selectQuery($query){
        $data = mysqli_query($this->conn, $query);
        if (!$data) {
            //echo "Select err: ".mysqli_errno($this->conn). "<br>MSG: ".mysqli_error($this->conn)."<br>QUERY: $query<br>";
            $data = null;
        }
        return $data;
    }

    /*
    function selectListQuery($query){
        $rez = $this->selectQuery($query);
        if($rez === null)
            return null;
        else{
            $rows = array();
            while($red = mysqli_fetch_assoc($rez))
                $rows[] = $red;
            return $rows;
        }
    }
    */

    function selectOneValue($query){
        $rez = $this->selectQuery($query);
        if($rez == null || $rez->num_rows == 0) return null;
        else{
            $val = mysqli_query($this->conn, $query);
            $val = $val->fetch_row();
            return $val[0];
        }
    }

    /**
     * @param $query
     * @return null
     *
     * Inserts data and returns id
     */
    function insertQuery($query) {
        mysqli_autocommit($this->conn, false);
        $rezultat = mysqli_query($this->conn, $query);
        //var_dump($rezultat);
        if ($rezultat === false) {
            mysqli_rollback($this->conn);
//            echo "Insert err: ".mysqli_errno($this->conn). "  ".mysqli_error($this->conn)."<br>QUERY: $query<br>";
            return null;
        }
        else {
            mysqli_commit($this->conn);
            $id = mysqli_query($this->conn, "SELECT LAST_INSERT_ID();");
//            echo "AJDI".$id;
            $id = $id->fetch_row();
            return $id[0];
        }
    }

    function deleteQuery($query)
    {
        $rezultat = mysqli_query($this->conn, $query);
        if (!$rezultat) {
//            echo "Delete err: ".mysqli_errno($this->conn). "<br>MSG: ".mysqli_error($this->conn)."<br>QUERY: $query";
            $podaci = null;
            return false;
        }else{
            var_dump($rezultat);
            mysqli_commit($this->conn);
            return mysqli_affected_rows($this->conn);
        }
    }

    function otherQuery($query) {
        $rezultat = mysqli_query($this->conn, $query);
        if (!$rezultat) {
//            echo "Other err: ".mysqli_errno($this->conn). "<br>MSG: ".mysqli_error($this->conn)."<br>QUERY: $query";
            $podaci = null;
            return false;
        }else{
            var_dump($rezultat);
            mysqli_commit($this->conn);
            return true;
        }
    }

    function disconnect(){
        mysqli_close($this->conn);
    }


}
