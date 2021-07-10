<?php
namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action{

	public function index() 
	{
		$this->view->login = isset($_GET['login']) ? $_GET['login']:'';
		$this->render('index');
	}
	public function inscreverse() 
	{
		$this->view->erroCadastro = false;
		$this->render('inscreverse');
	}
	public function registrar() 
	{
		$usuario = Container::getMoldel('Usuario');
		$success = $usuario->insertPOST($_POST);
		if ($success) {
			$this->render('cadastro');
		} else {
			$this->view->erroCadastro = true;
			$this->view->post = $_POST;
			$this->render('inscreverse');
		}
	}
}
?>