<nav id="sidebar">
	<ul id="page-nav">
<?php
	if ($mode == 'read'):
?>
		<li><a href="#info" onClick="My.setOverlay(My.OverlayType.INFO); return false;">Info</a>
<?php
	endif;
?>
	
<?php
	if ($authed === TRUE):
?>
		<li><a href="#new" onClick="My.setOverlay(My.OverlayType.NEW); return false;">New</a>
		<li><a href="#edit" onClick="My.setOverlay(My.OverlayType.EDIT); return false;">Edit</a>
<?php
	endif;
?>
	</ul>
	
	<ul id="site-nav">
		<li><a href="/ccc/">Index</a><!--
		<li><a href="?mode=project">Project</a>
		<li><a href="?mode=recent">Recent</a>
		<li><a href="?mode=crowd">Crowd</a>-->
		<li><a href="?p=search">Search</a>
		<li><a href="?p=sitemap">Sitemap</a>
	</ul>
</nav>