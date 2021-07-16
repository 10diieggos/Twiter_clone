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
    $sql = "SELECT id,nome,email FROM usuarios WHERE nome like :nome and id != :id_ususario";
    $binds['nome'] = '%' . $this->nome . '%';
    $binds['id_ususario'] = $this->id;
    $fetch = ['all', \PDO::FETCH_OBJ];
    return $this->sqlQuery($sql, $binds, $fetch);
  }
}
?>