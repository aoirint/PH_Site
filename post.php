<?php
	$authed = (include 'auth.php') === TRUE ? TRUE : FALSE;
  
  header('refresh:1;url=/ccc/');
  
  if ($authed !== TRUE)
  {
    print 'Failed. You don\'t have a permission. Redirecting...';
    return ;
  }

  require_once __DIR__ . '/DBManager.php';
  
  $id = $_REQUEST['p'];
  $title = $_REQUEST['title'];
  $tags = $_REQUEST['tags'];
  $flags = $_REQUEST['flags'];
  $contents = $_REQUEST['contents'];
  
  $page = array(
    'id' => $id,
    'title' => $title,
    'tags' => $tags,
    'flags' => $flags,
    'contents' => $contents
  );
  
  $dbMn = new DBManager(__DIR__ . '/data.db');
  $result = $dbMn->savePage($page);

  
  if ($result) print 'Success. Redirecting...';
  else print 'Failed. Redirecting...';
  