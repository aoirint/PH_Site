<?php

  class DBManager
  {
    function __construct($dbFile)
    {
      $this->db = new SQLite3($dbFile);
    }
    
    function listPage()
    {
      $result = $this->db->query('SELECT id,title,tags FROM pages');
      
      $list = array();
      while ($page = $result->fetchArray(SQLITE3_ASSOC))
      {
        $list[] = $page;
      }
      
      return $list;
    }
    
    function loadPage($id)
    {
      $stmt = $this->db->prepare('SELECT * FROM pages WHERE id=:id');
      $stmt->bindValue(':id', $id, SQLITE3_TEXT);
      $result = $stmt->execute();
      
      $page = $result->fetchArray(SQLITE3_ASSOC);
      
      if (! $page)
      {
        $page = array(
          'id' => 'dummy',
          'title' => 'ダミー',
          'tags' => 'special',
          'flags' => 0,
          'contents' => 'ダミーページ'
        );
      }
      
      return $page;
    }
    
    function savePage($page)
    {
      if (! array_key_exists('id', $page)) return FALSE;
      if (! array_key_exists('title', $page)) return FALSE;
      if (! array_key_exists('tags', $page)) return FALSE;
      if (! array_key_exists('flags', $page)) $page['flags'] = 0;
      if (! array_key_exists('contents', $page)) return FALSE;
      
      $del_stmt = $this->db->prepare('DELETE FROM pages WHERE id=:id');
      $del_stmt->bindValue(':id', $page['id'], SQLITE3_TEXT);
      
      $del_stmt->execute();
      
      $ins_stmt = $this->db->prepare('INSERT INTO pages VALUES(:id, :title, :tags, :flags, :contents)');
      $ins_stmt->bindValue(':id', $page['id'], SQLITE3_TEXT);
      $ins_stmt->bindValue(':title', $page['title'], SQLITE3_TEXT);
      $ins_stmt->bindValue(':tags', $page['tags'], SQLITE3_TEXT);
      $ins_stmt->bindValue(':flags', $page['flags'], SQLITE3_INTEGER);
      $ins_stmt->bindValue(':contents', $page['contents'], SQLITE3_TEXT);
      
      $ins_stmt->execute();
      
      return TRUE;
    }
  }
