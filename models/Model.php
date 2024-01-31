<?php

class Model 
{
    protected $table;
    protected $host = "localhost";
    protected $database = "inventory";
    protected $username = "root";
    protected $password = "";

    protected $dev_host = "localhost";
    protected $dev_database = "u542620504_supplyims";
    protected $dev_username = "u542620504_supplyimsAdmin";
    protected $dev_password = "Supplyinformationsystem@2024";

    public $pdo;
    public $stmt;
    public $qry;

    public function __construct(){
        // $this->connect(); //localDatabase
        $this->connectToDevSite(); //devsiteDatabase
    }
    
    public function connect(){
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->database};charset=utf8", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function connectToDevSite(){
        try {
            $this->pdo = new PDO("mysql:host={$this->dev_host};dbname={$this->dev_database};charset=utf8", $this->dev_username, $this->dev_password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    
    public function setTable($table){
        $this->table = $table;
        return $this; // for method chaining
    }
    
    public function setQuery($qry, $params = []){
        $this->qry = $qry;
        $this->stmt = $this->pdo->prepare($this->qry);
        $this->stmt->execute($params);
        return $this;
    }
    
    public function getAll(){
        try {
            return $this->stmt->fetchAll();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
    public function getFirst(){
        try {
            $data = $this->stmt->fetch();
            return (object) $data; // convert to object
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
    
    // Queries
    public function all(){
        $this->qry = "SELECT * FROM $this->table";
        $this->stmt = $this->pdo->prepare($this->qry);
        $this->stmt->execute();
        $data = $this->getAll();
        return $data;
    }
    
    public function allWithOutTrash(){
        $this->qry = "SELECT * FROM $this->table WHERE `deleted_at` IS NULL";
        $this->stmt = $this->pdo->prepare($this->qry);
        $this->stmt->execute();
        $data = $this->getAll();
        return $data;
    }

    public function allWithOutTrashDescending() {
        $this->qry = "SELECT * FROM $this->table WHERE `deleted_at` IS NULL ORDER BY `created_at` DESC";
        $this->stmt = $this->pdo->prepare($this->qry);
        $this->stmt->execute();
        $data = $this->getAll();
        return $data;
    }
    
    
    public function find($primaryKey){
        $data = $this->setQuery("SELECT * FROM $this->table WHERE id = ? AND `deleted_at` IS NULL", [$primaryKey])->getFirst();
        return $data;
    }
    
    public function getLastInsertedId(){
        $data = $this->setQuery("SELECT LAST_INSERT_ID() as id")->getFirst();
        return (int) $data->id;
    }
}
