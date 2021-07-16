<?php
namespace App\Models;
use MF\Model\Model;
class Usuario extends Model
{
  protected  $id;
  protected  $nome;
  protected  $email;
  protected  $senha;

  protected $table = 'usuarios';

  public function insertNewUser($post)
  {
    $binds = array('email'=> $post['email']);
    $sql = "SELECT 'nome', 'email' FROM $this->table WHERE email = :email";
    $fetch = ['all', \PDO::FETCH_OBJ];
    if (count($this->sqlQuery($sql, $binds, $fetch)) == 0 )
    {
      if ($this->validate($post)) {
        $sql = "INSERT INTO $this->table(nome, email, senha) VALUES (:nome, :email, :senha)";
        $post['senha'] = md5($post['senha']);
        return $this->sqlQuery($sql, $post);
       }
    }
  }
  public function logon($binds)
  {
    $sql = "SELECT id,nome,email FROM $this->table WHERE email = :email and senha = :senha";
    $binds['senha'] = md5($binds['senha']);
    $fetch = ['one', \PDO::FETCH_OBJ];
    $user = $this->sqlQuery($sql, $binds, $fetch);
    if ($user->id != '' && $user->nome != '') 
    {
      $this->__set('id', $user->id);
      $this->__set('nome', $user->nome);
      $this->__set('email', $user->email);
    }
    return $this;
  }
  public function getSearchUsers()
  {
    $subSql = "SELECT count(*) FROM followers as f WHERE f.id_usuario = :id_usuario and f.id_usuario_seguindo = u.id";
    $sql = "SELECT u.id, u.nome, u.email, ($subSql) as following FROM usuarios as u WHERE u.nome like :nome and u.id != :id_usuario";
    $binds['nome'] = '%' . $this->nome . '%';
    $binds['id_usuario'] = $this->id;
    $fetch = ['all', \PDO::FETCH_OBJ];
    return $this->sqlQuery($sql, $binds, $fetch);
  }
  public function follow($follow, $user_target_id)
  {
    if ($follow) {
      $sql = "INSERT INTO followers(id_usuario, id_usuario_seguindo) VALUES (:id_usuario, :id_usuario_seguindo)";
    }
    else
    {
      $sql = "DELETE FROM followers WHERE id_usuario = :id_usuario and id_usuario_seguindo = :id_usuario_seguindo ";
    }
    $binds['id_usuario'] = $this->id;
    $binds['id_usuario_seguindo'] = $user_target_id;
    return $this->sqlQuery($sql, $binds);
  }
  public function getInfoUser()
  {
    $info = [];
    $binds['id_usuario'] = $this->id;
    $fetch = ['one'];
    
    $sql = "SELECT count(id) as total_tweets FROM tweets WHERE id_usuario = :id_usuario";
    $info [] = $this->sqlQuery($sql, $binds, $fetch);
    $sql = "SELECT count(id_usuario_seguindo) as total_seguindo FROM followers WHERE id_usuario = :id_usuario";
    $info [] = $this->sqlQuery($sql, $binds, $fetch);
    $sql = "SELECT count(id_usuario) as total_seguidores FROM followers WHERE id_usuario_seguindo = :id_usuario";
    $info [] = $this->sqlQuery($sql, $binds, $fetch);

   $user_info = (object)[];
   foreach ($info as $key => $value) {
     foreach ($value as $k => $v) {
       $user_info->$k = $v;
     }
   }

    return $user_info;
  }
}
?>