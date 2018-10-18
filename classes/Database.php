<?php

class Database
{

    private $servername = "localhost";
    private $username = "username";
    private $password = "password";
    private $database = "databasename";


  public function connect()
  {
    try
    {
        $conn = new PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
    catch(PDOException $e)
    {

        echo "Connection failed: " . $e->getMessage();
    }
  }
  public function signUp($username,$password)
  {
    $conn = $this->connect();
    try
    {
      $password = password_hash($password,PASSWORD_DEFAULT);
      $sql = "INSERT INTO `users` (`username`, `password`) VALUES (:uname, :pass)";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':uname',$username);
      $stmt->bindParam(':pass',$password);
      return $stmt->execute() ? true : false;
    }
     catch(PDOException $e)
     {
       echo $sql . "<br>" . $e->getMessage();
     }

     $conn = null;
  }
  public function signIn($username,$password)
  {
    $conn = $this->connect();
    try
    {
      $sql = "SELECT `user_id`, `username`, `password` FROM `users` WHERE `username` = :uname";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':uname',$username, PDO::PARAM_STR );
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $password_hash = password_hash($password,PASSWORD_DEFAULT);
      if($result = password_verify($password,$row['password'])){
        return $row;
      }
      else {
        return false;
      }
    }
     catch(PDOException $e)
     {
       echo $sql . "<br>" . $e->getMessage();
     }

     $conn = null;
  }
  public function isUserUnique($username)
  {
    $conn = $this->connect();
    try{
      $sql = "SELECT `username` FROM `users` WHERE `username` = :uname";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':uname',$username);
      $stmt->execute();
      if(!$stmt->fetch())
        return true;
      else
        return false;
    }
    catch(PDOException $e)
    {
       echo $sql . "<br>" . $e->getMessage();
    }
     $conn = null;
  }
}
