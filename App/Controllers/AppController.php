<?php
namespace App\Controllers;

use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action{

	public function timeline() 
	{
    $this->verifyAuth();
    $user = Container::getMoldel('Usuario');
    $user->__set('id', $_SESSION['id']);
    $tweet = Container::getMoldel('Tweet');
    $tweet->__set('id_usuario',$_SESSION['id']);

    $limit = 5;
    $page = isset($_GET['page'])?$_GET['page']:1;
    $offset = ($page - 1) * $limit;
    $totalForPagination = $tweet->totalForPagination();
    $this->view->pages = ceil($totalForPagination->total/$limit);
    $this->view->activePage = $page;    
    $this->view->tweets = $tweet->getTweets($limit, $offset);
    $this->view->user_info = $user->getInfoUser();
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
    $user = Container::getMoldel('Usuario');
    $user->__set('id', $_SESSION['id']);
    $user_info = $user->getInfoUser();
    $search = isset($_GET['search'])?$_GET['search']:'';
    if ($search != '') 
    {
      $user->__set('nome', $search);
      $users = $user->getSearchUsers();
    }
    $this->view->user_info = $user_info;
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