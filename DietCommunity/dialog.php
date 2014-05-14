<!DOCTYPE html> 
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css">
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
<script type="text/javascript">
	var id = 0;
</script>
<?php
require_once('dao/dao.php');
$id=$_GET['id'];

?>
</head>
<body>
<div data-role="page" data-close-btn="right" data-dialog="true">
		<div data-role="header">
		<h1>Commentaires</h1>
		</div>

		<div role="main" class="ui-content">
		<ul data-role="listview" id="maListe">
		
		<?php
		$comments = json_decode(encode(getCommentairesForPost($id)));
		foreach($comments as $c){
			echo "<li ><h2>$c->pseudo - $c->dateCreation</h2>";
			echo "<p>$c->value</p>";
			echo "</li>";
		}
		?>
		</ul>
		</div>
	</div>
</body>
</html>