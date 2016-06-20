<?php

  require_once __DIR__ . '/DBManager.php';
  
  $id = $_REQUEST['p'];
  
  $dbMn = new DBManager(__DIR__ . '/data.db');
  $page = $dbMn->loadPage($id);
  
?>
<table class="pageTable pageInfo">
	<tr>
		<th>タイトル
		<td><?= $page['title'] ?>
	<tr>
		<th>タグ
		<td><?php
			$splitedTag = explode(',', $page['tags']);
			
				foreach ($splitedTag as $t):
	?>
	<a class="tag" href="?p=search&tag=<?= $t ?>"><?= $t ?></a>
	<?php
				endforeach;
	?>
</table>
