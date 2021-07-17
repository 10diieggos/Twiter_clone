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

  public function totalForPagination()
  {
    $bind['id_usuario'] = $this->id_usuario;
    $sql = "SELECT count(t.id) as total
    FROM tweets as t
    LEFT JOIN usuarios as u on (t.id_usuario = u.id)
    WHERE t.id_usuario = :id_usuario 
          or 
          t.id_usuario in (SELECT id_usuario_seguindo FROM followers WHERE id_usuario = :id_usuario)";
    return $this->sqlQuery($sql, $bind, ['one', \PDO::FETCH_OBJ]);
  }

  public function getTweets($limit, $offset)
  {
    $bind['id_usuario'] = $this->id_usuario;
    $sql = "SELECT t.id, t.id_usuario, u.nome, t.tweet, DATE_FORMAT(t.data, '%d/%m/%Y %H:%i') as date
            FROM tweets as t
            LEFT JOIN usuarios as u on (t.id_usuario = u.id)
            WHERE t.id_usuario = :id_usuario 
                  or 
                  t.id_usuario in (SELECT id_usuario_seguindo FROM followers WHERE id_usuario = :id_usuario)
            ORDER BY t.data DESC
            LIMIT $limit OFFSET $offset";

    return $this->sqlQuery($sql, $bind, ['all', \PDO::FETCH_OBJ]);
  }

  public function delete()
  {
    $sql = "DELETE FROM `tweets` WHERE `id` = :id";
    $binds['id'] = $this->id;
    return $this->sqlQuery($sql, $binds);
  }
}
?>