<?php
namespace MF\Model;
abstract class Model
{
  protected $db;
  protected $attr;
  protected $valid = ['state'=> true];
  

  public function __construct(\PDO $db)
  {
    $this->db = $db;
  }

  public function __get($attr)
  {
    return $this->$attr;
  }
  public function __set($attr, $value)
  {
    $this->$attr = $value;
  }
  
  public function validate($post)
  {
    foreach ($post as $key => $value) {
      if (strlen($value) < 4) {
        $this->valid['state'] = false;
      }
    }
    return $this->valid['state'];
  }
  /************* QUERYS *************/
  /************* QUERYS *************/
  /************* QUERYS *************/
  public function selectWhere($columns, $table, $where, $binds)
  {
    $columns = implode(", ", $columns);
    $sql = "SELECT $columns FROM $table WHERE $where";
    $stmt = $this->db->prepare($sql);
    foreach ($binds as $key => $value) {
      $stmt->bindValue(":". $key, $value);
    }
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }
  
  public function insertInto($table, $post)
  { 
    $keys = implode(", ", array_keys($post));
    $_keys = ':'. str_replace(' ',' :',$keys);
    $sql = "INSERT INTO $table($keys) VALUES ($_keys)";
    $stmt = $this->db->prepare($sql);
    foreach ($post as $attr => $value) 
    {
      $stmt->bindValue(":$attr", $value);
    }
    $stmt->execute();
    return $this;
  }
  public function select($table, $columns)
  {
    $keys = implode(", ", $columns);
    $sql = "SELECT $keys FROM $table";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  public function sqlQuery($sql, $binds = null, $fetch = [null])
  {
    $stmt = $this->db->prepare($sql);
    if ($binds != null) {
      foreach ($binds as $key => $value) {
        $stmt->bindValue(":". $key, $value);
      }
    }
    $stmt->execute();
    switch ($fetch[0]) 
    {
      case null:
          return $this;
          break;            
      case 'one':
        return $stmt->fetch(\PDO::FETCH_OBJ);
        break;
      case 'all':
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
        break;
    }
  }
  /********************************/
  /********************************/
  /********************************/
}
?>