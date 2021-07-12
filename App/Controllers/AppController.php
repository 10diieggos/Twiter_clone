<?php
namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action{

	public function timeline() 
	{
    $this->verifyAuth();
    $tweet = Container::getMoldel('Tweet');
    $this->view->tweets = $tweet->getUserTweets($_SESSION['id']);
    $this->render('timeline');
	}
  public function tweet() 
	{
    $this->verifyAuth();
    $tweet = Container::getMoldel('Tweet');
    $tweet->__set('id_usuario', $_SESSION['id']);
    $tweet->insert();
    header('Location: /timeline');
	}
}
?>