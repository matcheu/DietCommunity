<?php @session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.css">
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.2/jquery.mobile-1.4.2.min.js"></script>
<script type="text/javascript">
	var id = 0;

function sendCommentaire() {
	var formData = {
			'id' 				: $('input[name=id]').val(),
			'idPersonne' 			: $('input[name=idPersonne]').val(),
			'valuee' 	: $('textarea[name=addinfo]').val()
	};
	$.ajax({
			type 		: 'POST', // define the type of HTTP verb we want to use (POST for our form)
			url 		: 'dao/sendCommentaire.php', // the url where we want to POST
			data 		: formData, // our data object
			dataType 	: 'json' // what type of data do we expect back from the server
	})
	.done(function(data) {

		var output = "<li><h2>" + data.pseudo + " - " + data.dateCreation + "</h2>";
		output +="<p>" + data.value + "</p>";
		output +="</li>";
		$('#maListe').prepend(output).listview('refresh');
	});
}

</script>
<?php
require_once('dao/dao.php');
$id=$_GET['id'];



if (isset($_POST['id'])){
	$id = $_POST['id'];
	$value = $_POST['addinfo'];
	$idPersonne = $_POST['idPersonne'];
	createCommentaire($value,$id,$idPersonne);
}
?>

</head>
<body>
<div data-role="page" data-close-btn="right" data-dialog="true">
		<div data-role="header">
		<h1>Commentaires</h1>
		</div>

		<div role="main" class="ui-content">
		<form method="post" id="form" action="dialog.php?id=<?php echo $id;?>">
			<label for="info">Votre commentaire :</label>
			<textarea name="addinfo" id="info"></textarea>
			<input type="hidden" name="id" value="<?php echo $id;?>"/>
			<input type="hidden" name="idPersonne" value="<?php echo $_SESSION['id'];?>"/>
			<input type="button" onclick="sendCommentaire()" id="buttonSend" value="Envoyer">
		</form>
		<br/>

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