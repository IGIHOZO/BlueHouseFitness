<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
date_default_timezone_set('Africa/Kigali');
if(!isset($_SESSION['user'])){
    // header("Location: index.php");
}
//====================================================================================================== CONNECTION
    $dbname = 'bluehouse';
    $user = 'root';
    $pass = '';
    
    // $pass = 'password';


    $con = new PDO("mysql:host=localhost;dbname=$dbname", $user, $pass);

class DbConnect
{
    private $host='localhost';
    private $dbName = 'bluehouse';
    private $user = 'root';
    private $pass = '';
    // private $pass = 'password';

    public $conn;
    



    public function connect()
    {
        try {
         $conn = new PDO('mysql:host='.$this->host.';dbname='.$this->dbName, $this->user, $this->pass);
         return $conn;
        } catch (PDOException $e) {
            echo "Database Error ".$e->getMessage();
            return null;
        }
    }
}












?>