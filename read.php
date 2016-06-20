<!DOCTYPE html>
<meta charset="utf-8">
<title><?= $title ?></title>
<link rel="stylesheet" href="style.css">

<script src="vendor/jquery-2.2.3.min.js"></script>

<?php
  if (isFlag(17)): // MathJax
?>
<script src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML"></script>
<?php
  endif;
?>

<script>

var My = {};

My.OverlayType = {};
My.OverlayType.NONE = 0;
My.OverlayType.INFO = 1;
My.OverlayType.NEW = 3;
My.OverlayType.EDIT = 2;

My.data = <?= $jsonPage ?>

// My.overlayCache = {};

My.setOverlay = function (type)
{
  if (type === undefined) type = My.OverlayType.NONE;

  switch (type)
  {
  case My.OverlayType.NONE:
    delete overlay.dataset.visible;
    return ;
  case My.OverlayType.INFO:
    $(overlayItem).load('pageInfo.php?p=' + My.data['id']);
    break;
  case My.OverlayType.NEW:
    $(overlayItem).load('postForm.html');
    break;
  case My.OverlayType.EDIT:
    $.get('postForm.html', function(data, status, xhr)
    {
      $(overlayItem).html(data);
      
      var form = $(overlayItem).children('#postForm')[0];
      
      $(form).find('[name=p]').val(My.data['id']);
      $(form).find('[name=tags]').val(My.data['tags']);
      $(form).find('[name=title]').val(My.data['title']);
      $(form).find('[name=flags]').val(My.data['flags']);
      $(form).find('[name=contents]').val(My.data['contents']);
      
      $(overlayItem).find('#flagTable [name^=f]').each(function()
      {
        var name = $(this).attr('name');
        var nmMatch = name.match(/f(\d+)/);
        
        if (nmMatch)
        {
          var val = (My.data['flags'] >> (nmMatch[1] -1)) & 1;
          $(this).prop('checked', val == 1 ? true : false);
        }
      });
      
    });
    
    break;
  }
  
  overlay.dataset.visible = '';
}

$(function()
{
  My.overlay = $('#overlay')[0];
  My.overlayItem = $(My.overlay).children('#overlayItem')[0];
  
  $(My.overlay).children().on('click', function(e)
  {
    e.stopPropagation();
  });

  $(My.overlay).on('click', function(e)
  {
    My.setOverlay(My.OverlayType.NONE);
  });
});
</script>


<main><?= $main ?></main>



<?php include __DIR__ . '/sidebar.php'; ?>

<div id="overlay">
<div id="overlayItem"></div>
</div>

