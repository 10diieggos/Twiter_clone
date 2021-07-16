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
    $tweet->__set('tweet', $_POST['tweet']);
    $tweet->insertTweet();
    header('Location: /timeline');
	}
  public function follow()
  {
    $this->verifyAuth();
    $users = [];
    $search = isset($_GET['search'])?$_GET['search']:'';
    if ($search != '') 
    {
      $user = Container::getMoldel('Usuario');
      $user->__set('nome', $search);
      $users = $user->getSearchUsers();
    }
    $this->view->users = $users;
    $this->render('follow');
  }
}
?>