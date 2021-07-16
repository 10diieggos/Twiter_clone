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

  public function insertTweet()
  {
    $sql = "INSERT INTO $this->table(id_usuario, tweet) VALUES (:id_usuario, :tweet)";
    $post['id_usuario'] = $this->id_usuario;
    $post['tweet'] = $this->tweet;
    if ($this->validate($this->tweet))
    {
      return $this->sqlQuery($sql, $post);
    }
  }

  public function getUserTweets($userSession)
  {
    $sql = "SELECT id, id_usuario, tweet, DATE_FORMAT(data, '%d/%m/%Y %H:%i') as data FROM tweets  WHERE id_usuario = :id_usuario ORDER BY tweets.data DESC";
    $bind['id_usuario'] = $userSession;
    $fetch = ['all', \PDO::FETCH_OBJ];
    return $this->sqlQuery($sql, $bind, $fetch);
  }
}
?>