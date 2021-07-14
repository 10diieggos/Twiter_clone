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
    $columns = ['id','nome','email'];
    $binds['senha'] = md5($binds['senha']);
    $where = "email = :email and senha = :senha";
    $user = $this->selectWhere($columns, $this->table, $where, $binds);
    if ($user[0]->id != '' && $user[0]->nome != '') 
    {
      $this->__set('id', $user[0]->id);
      $this->__set('nome', $user[0]->nome);
      $this->__set('email', $user[0]->email);
    }
    return $this;
  }
}
?>