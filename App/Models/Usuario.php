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

  public function insertPOST($post)
  {
    $columns = ['nome', 'email'];
    $where = "email = :email and senha = :senha";
    $binds = array('email'=> $post['email']);
    if (count($this->selectWhere($columns, $this->table, $where, $binds)) == 0 )
    {
      if ($this->validate($post)) {
        $post['senha'] = md5($post['senha']);
        return $this->insertInto($this->table, $post);
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