<?php
namespace App\Models;
use MF\Model\Model;
class Tweet extends Model
{
  protected $id;
  protected $id_usuario;
  protected $tweet;
  protected $data;
  
  protected $table = 'tweets';

  public function insert()
  {
    $post['id_usuario'] = $this->id_usuario;
    $post['tweet'] = $this->tweet;
    if ($this->validate($this->tweet)){
      return $this->insertInto($this->table, $post);
    }
  }
  public function getUserTweets($userSession)
  {
    $data = "DATE_FORMAT(data, '%d/%m/%Y %H:%i') as data";
    $columns = ['id', 'id_usuario', 'tweet', $data];
    $where = "id_usuario = :id_usuario ORDER BY data DESC";
    $bind['id_usuario'] = $userSession;
    return $this->selectWhere($columns, $this->table, $where, $bind);
  }
}
?>