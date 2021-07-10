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
  public function selectWhere($sql, $where)
  {
    $stmt = $this->db->prepare($sql);
    foreach ($where as $key => $value) {
      $stmt->bindValue(":". $key, $value);
    }
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }
  
  public function insertInto($sql, $post)
  {
    $stmt = $this->db->prepare($sql);
    foreach ($post as $attr => $value) 
    {
      $stmt->bindValue(":$attr", $value);
    }
    $stmt->execute();
    return $this;
  }
  /********************************/
  /********************************/
  /********************************/
}
?>