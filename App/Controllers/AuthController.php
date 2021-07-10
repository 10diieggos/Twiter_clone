<?php
namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action{

	public function autenticar() 
	{
    $usuario = Container::getMoldel('Usuario');
    $usuario->logon($_POST);
    $id = $usuario->__get('id');
    $nome = $usuario->__get('nome');
    if ($id != '' && $nome != '') {
      session_start();
      $_SESSION['id'] = $id;
      $_SESSION['nome'] = $nome;
      header('Location: /timeline');
    }
    else
    {
      header('Location: /?login=erro');
    }
	}
	public function sair() 
	{
    session_start();
    session_destroy();
    header('Location: /');
  }
}
