<?php
  
  $list = $dbMn->listPage();
?>
<section id="sitemap">
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
    <a class="tag" href="?p=search&tag=<?= $t ?>"><?= $t ?></a>
    <?php
        endforeach;
    ?>
<?php
  endforeach;
?>
</table>
</section>
