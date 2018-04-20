<?php
/*
* Mysql database class - only one connection alowed
*/
class Database {

    private static $_instance = null; //The single instance
    private $_pdo,
        $_error = false,
        $_results,
        $_query,
        $_count = 0;

    /*
    Get an instance of the Database
    @return Instance
    */
    public static function getInstance() {
        if(!self::$_instance) { // If no instance then make one
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    // Constructor
    private function __construct() {
        try{
            $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/dbname'), Config::get('mysql/username'), Config::get('mysql/password'));
            /*** echo a message saying we have connected ***/
            // echo "Connected successfully";
        }catch (PDOException $e){
            die($e->getMessage());
        }
    }

    // Magic method clone is empty to prevent duplication of connection
    private function __clone() { }

    // Get mysqli connection
    public function getConnection() {
        return $this->_pdo;
    }


    public function query($sql, $params = array()){
        $this->_error = false;
        if ($this->_query = $this->_pdo->prepare($sql)){

            $x = 1;
            if (count($params)){
                foreach ($params as $param ){
                    $this->_query->bindValue( $x, $param );
                    $x++;
                }
            }

            if ($this->_query->execute()){
                //echo 'success';
                $this->_results = $this->_query->fetchAll( PDO::FETCH_OBJ );
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = true;
            }
        }
        return $this;
    }

    public function action($action, $table, $where = array()){
        if (count($where) === 3){
            $operators = array('=', '>', '<', '>=', '<=');

            $field      = $where[0];
            $operator   = $where[1];
            $value      = $where[2];

            if (in_array($operator, $operators)){
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

                if (!$this->query($sql, array($value))->error()){
                    return $this;
                }
            }

        }
        return false;
    }

    public function get($table, $where){
        return $this->action('SELECT * ', $table, $where );
    }

    public function delete($table, $where){
        return $this->action('DELETE', $table, $where );
    }

    public function results(){
        return $this->_results;
    }

    public function first(){
        return $this->results()[0];
    }

    public function error(){
        return $this->_error;
    }

    public function count(){
        return $this->_count;
    }

    public function insert($table, $fields = array()){
        if (count($fields)){
            $keys = array_keys( $fields );
            $values = '';
            $x = 1;

            foreach ( $fields as $field){
                $values .= '?';
                if ($x < count($fields)){
                    $values .= ', ';
                }
                $x++;
            }

            $sql = "INSERT INTO {$table} (`" . implode('`, `', $keys ). "`) VALUES ({$values})";

            if (!$this->query($sql, $fields)->error()){
                return true;
            }
        }
        return false;
    }


    public function update($table, $id, $fields){
        $set = '';
        $x = 1;

        foreach ($fields as $name => $value){
            $set .= "{$name} = ?";
            if ($x < count($fields)){
                $set .= ',  ';
            }
            $x++;
        }

        $sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";

        if (!$this->query($sql, $fields)->error()){
            return true;
        }

        return false;
    }

    public function checkEmail($email, $table, $where=array()){
    }
} /* end of Database class */