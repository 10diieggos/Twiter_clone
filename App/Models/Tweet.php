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

  public function getTweets($userSession)
  {
    $sql = "SELECT
              t.id,
              t.id_usuario,
              u.nome,
              t.tweet,
              DATE_FORMAT(t.data, '%d/%m/%Y %H:%i') as date
            FROM
              tweets as t
              left join usuarios as u on (t.id_usuario = u.id)
            WHERE
              t.id_usuario = :id_usuario
              or t.id_usuario in (SELECT id_usuario_seguindo FROM followers WHERE id_usuario = :id_usuario)
            ORDER BY 
              t.data DESC";
    $bind['id_usuario'] = $userSession;
    $fetch = ['all', \PDO::FETCH_OBJ];
    return $this->sqlQuery($sql, $bind, $fetch);
  }
  public function delete()
  {
    $sql = "DELETE FROM `tweets` WHERE `id` = :id";
    $binds['id'] = $this->id;
    return $this->sqlQuery($sql, $binds);
  }
}
?>