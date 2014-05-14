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
$p = json_decode(encode(getPersonne($id)));
$annonce = json_decode(encode(getAnnonceForPersonne($id)));
?>
</head>
<body>
<div data-role="page" id="showItem">

  <div data-role="header">
    <h1>MyRegime | Partagez votre perte de poids</h1>
		<div data-role="navbar">
    <ul>
      <li><a href="index.php">Accueil</a></li>
      <li><a href="my.php">Ma page</a></li>
    </ul>
  </div>
  </div>

  <div data-role="main" class="ui-content">
    <h3 class="ui-body ui-body-a ui-corner-all"><?php echo "$p->pseudo - Poids de d&eacute;part : $p->depart kg";?></h3>
	<div class="ui-body">
		<?php
		echo "<h4>Sexe : $p->sexe - Poids actuel : $p->actuel kg - Objectif : $p->objectif kg - Taille : $p->taille cm</h4>";
		echo "<p>$annonce->value</p>";
		echo "<hr/>";
		
		?>
		<ul data-role="listview" id="maListe">
		<?php
		$posts = json_decode(encode(getPostsForPersonne($id)));
		foreach($posts as $post){
			echo "<li ><h2>$post->dateCreation - Poids : $post->poidsActuel kg</h2>";
			echo "<p>$post->value</p>";
			echo "<p><a href='dialog.php?id=$post->id' data-transition='pop'>$post->nbrCommentaires commentaire(s)</a></p>";
			echo "</li>";
		}
		?>
		</ul>
	</div>
  </div>

  </div>
</body>
</html>