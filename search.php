<?php
  
  $s_title = array_key_exists('title', $_REQUEST) ? $_REQUEST['title'] : NULL;
  $s_tags = array_key_exists('tags', $_REQUEST) ? $_REQUEST['tags'] : NULL;
  # $contents = array_key_exists('contents', $_REQUEST) ? $_REQUEST['contents'] ? NULL;
  
  $list = $dbMn->listPage();
  
  if ($s_title != NULL)
  {
    $list = array_filter($list, function($item)
    {
      global $s_title;
      
      return strpos($item['title'], $s_title) !== FALSE;
    });
  }

  if ($s_tags != NULL)
  {
    $splTags = explode(',', $s_tags);
    
    $list = array_filter($list, function($item)
    {
      global $splTags;
      
      $itemSplTags = explode(',', $item['tags']);
      return 0 < count(array_intersect($splTags, $itemSplTags));
    });
  }
  
  
  
?>

<section id="search">

<form id="searchForm">
  <table>
  <tr><td><input type="hidden" name="p"><label for="title">タイトル</label><td><input name="title" size="80" value="<?= $s_title ?>">
  <tr><td><label for="tags">タグ</label><td><input name="tags" size="80" value="<?= $s_tags ?>">
  </table>
  
  <p>
  <input type="submit">
  <input id="btnReset" type="button" value="リセット">
</form>

<table>
<tr>
  <td>タイトル
  <td>タグ
<?php
  foreach ($list as $p):
    $linkUri = '//'.$_SERVER['HTTP_HOST'].preg_replace('/index.php$/', '', $_SERVER['SCRIPT_NAME']).'?p='.$p['id'];
    
    $link = '<a href="'.$linkUri.'">'.$p['title'].'</a>';
?>
  <tr>
    <td><?=$link ?>
    <td><?php
      $splitedTag = explode(',', $p['tags']);
			
				foreach ($splitedTag as $t):
    ?>
    <a class="tag" href="?p=search&tags=<?= $t ?>"><?= $t ?></a>
    <?php
        endforeach;
    ?>
<?php
  endforeach;
?>
</table>
</section>

<script>
  $(function()
  {
    var form = $('#searchForm');
    form.find('[name=p]').val(My.data['id']);
    form.find('#btnReset').on('click', function()
    {
      location.href = '?p=' + My.data['id'];
    });
  });
</script>
