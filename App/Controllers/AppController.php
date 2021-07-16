<?php
namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action{

	public function timeline() 
	{
    $this->verifyAuth();
    $tweet = Container::getMoldel('Tweet');
    $this->view->tweets = $tweet->getTweets($_SESSION['id']);
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
  public function search_users()
  {
    $this->verifyAuth();
    $users = [];
    $search = isset($_GET['search'])?$_GET['search']:'';
    if ($search != '') 
    {
      $user = Container::getMoldel('Usuario');
      $user->__set('nome', $search);
      $user->__set('id', $_SESSION['id']);
      $users = $user->getSearchUsers();
    }
    $this->view->users = $users;
    $this->render('search_users');
  }
  public function follow()
  {
    $this->verifyAuth();
    $follow = isset($_GET['follow'])? (boolean) $_GET['follow']:'';
    $user_target_id = isset($_GET['user_Target_Id'])?$_GET['user_Target_Id']:'';
    $user_session = Container::getMoldel('Usuario');
    $user_session->__set('id', isset($_SESSION['id'])?$_SESSION['id']:'');
    $user_session->follow($follow,$user_target_id);
    header('Location: /search_users?' . $_GET['reloadSearch']);
  }
  public function removeTweet()
  {
    $this->verifyAuth();
    $tweet = Container::getMoldel('Tweet');
    $tweet->__set('id', $_GET['tweet']);
    $tweet->delete();
    header('Location: /timeline');
  }
}
?>