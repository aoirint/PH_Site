<?php

  class DBManager
  {
    function __construct($dbFile)
    {
      $this->db = new SQLite3($dbFile);
    }
    
    function listPage($tags=NULL)
    {
      if ($tags !== NULL)
      {
        $result = $this->db->query('SELECT id,title,tags FROM pages WHERE tags=\''.SQLite3::escapeString($tags).'\'');
      } else 
      {
        $result = $this->db->query('SELECT id,title,tags FROM pages');
      }
      
      $list = array();
      while ($page = $result->fetchArray(SQLITE3_ASSOC))
      {
        $list[] = $page;
      }
      
      return $list;
    }
    
    function loadPage($id)
    {
      $result = $this->db->query('SELECT * FROM pages WHERE id=\''.SQLite3::escapeString($id).'\'');
      
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
      
      $query = '\''.SQLite3::escapeString($page['id']).'\',\''.SQLite3::escapeString($page['title']).'\',\''.SQLite3::escapeString($page['tags']).'\','.$page['flags'].',\''.SQLite3::escapeString($page['contents']).'\'';
      
      $this->db->query('DELETE FROM pages WHERE id=\''.SQLite3::escapeString($page['id']).'\'');
      
      $this->db->query('INSERT INTO pages VALUES('.$query.')');
      
      return TRUE;
    }
  }
