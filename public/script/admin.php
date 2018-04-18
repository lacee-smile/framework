<?php

global $formName;
global $AjaxHandler;
$EnableAjax = true;
if(!isset($formName) || empty($formName))
{
	ConsoleAlert("Nincs meghatározva form név!");
	$EnableAjax = false;
}
if(!isset($AjaxHandler) || empty($AjaxHandler))
{
	ConsoleAlert("Nincs meghatározva oldal vezérlő!");
	$EnableAjax = false;
}
// 
echo '<script type="text/javascript">
function logout()
{
    window.location.href = "/home/login";
}
';
if($EnableAjax) : ?>

	$('[name="send"]').click(function(){AJAX()});
	function AJAX()
	{
		var queryString = $('#<?php echo $formName; ?>').serialize();
		$.ajax({
       	url: "<?php echo UrlBase.$AjaxHandler; ?>/ajax",
       	method: "POST",
       	data:
       	{
       		queryString,
       		ajax: true
       	},
       	success: function(data) {
       		data = $.parseJSON(data);
       		success(data);
       	},
       	error: function(xhr, data){
       		console.warn("XHR failed");
       		console.log(xhr);
       	}
       });
   }
   function success(retunObj)
	{
		console.log(retunObj);
	}
</script>
<?php
else: ?>

	$('[name="send"]').click(function(){alert("Probléma történt a kapcsolatban.")})

<?php endif; 
echo '</script>';?>