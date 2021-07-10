<?php
namespace App\Models;
use MF\Model\Model;
class Usuario extends Model
{
  protected  $id;
  protected  $nome;
  protected  $email;
  protected  $senha;

  public function insertPOST($post)
  {
    $where = array('email'=> $post['email']);
    $sql = "SELECT nome,email FROM usuarios WHERE email = :email";
    if (count($this->selectWhere($sql, $where)) == 0 )
    {
      if ($this->validate($post)) {
        $post['senha'] = md5($post['senha']);
        $keys = implode(", ", array_keys($post));
        $_keys = ':'. str_replace(' ',' :',$keys);
        $sql = "INSERT INTO usuarios($keys) VALUES ($_keys)";
        return $this->insertInto($sql, $post);
       }
    }
  }
  public function logon($where)
  {
    $where['senha'] = md5($where['senha']);
    $sql = "SELECT id,nome,email FROM usuarios WHERE email = :email and senha = :senha";
    $user = $this->selectWhere($sql, $where);
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