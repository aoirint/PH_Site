<?php
  require_once __DIR__ . '/DBManager.php';
  
  $id = array_key_exists('p', $_GET) ? $_GET['p'] : 'index';
  
  $dbMn = new DBManager(__DIR__ . '/data.db');
  $page = $dbMn->loadPage($id);
  
  function isFlag($index)
  {
    global $page;
    return ($page['flags'] >> ($index -1)) & 1 == 1;
  }

  $title = $page['title'];
  if (! isFlag(1)) $title .= ' | '.'CCC Web';

  $mode = 'read';
	$authed = (include 'auth.php') === TRUE ? TRUE : FALSE;
  
  /*
  if (array_key_exists('x', $_GET))
  {
    $dbMn->savePage(array(
      'id' => 'test',
      'tags' => '',
      'title' => 'テスト',
      'flags' => 0,
      'contents' => '<h3>テストページ</h3>'
    ));
  }
  */
  
  $jsonPage = json_encode($page, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
  
  $main = $page['contents'];

  if (isFlag(9)) // インクルードページ
  {
    ob_start();
    include __DIR__ . '/' . basename($page['contents']);
    $main = ob_get_clean();
  }

  if (isFlag(18)) // Marked
  {
    require_once __DIR__ . '/vendor/Michelf/MarkdownExtra.inc.php';
    
    $mdparser = new \Michelf\MarkdownExtra();
    $main = $mdparser->transform($main);
  }
  
  if (! isFlag(2))
  {
    $main = '<h1>'.$page['title'].'</h1>'.$main;
  }
  
  include __DIR__ . '/read.php';
?>