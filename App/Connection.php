<?php
namespace App;
class Connection
{

  public static function getDb()
  {
    try 
    {
      $conn = new \PDO(
        'mysql:host=127.0.0.1;dbname=twitter_clone;charset=utf8',
        'myuser',
        'mypass');
      return $conn;
    }
    catch (\PDOException $e)
    {
      echo '<p>' . $e->getMessage() . '</p>';
      phpinfo();
    }
  }
}


?>