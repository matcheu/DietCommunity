<?php
@session_start();
?>
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

?>
</head>
<body>
<div data-role="page" id="list">

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
    <h2>Liste :</h2>
    <ul data-role="listview" id="maListe">
		<?php
		$personnes = json_decode(encode(getPersonnes()));
		foreach($personnes as $p){
			echo "<li id='$p->id'><a href='showItem.php?id=$p->id'><h2>$p->pseudo - Poids de d&eacute;part : $p->depart kg</h2>";
			echo "<p>Sexe : $p->sexe - Poids actuel : $p->actuel kg - Objectif : $p->objectif kg</p>";
			echo "</a></li>";
		}
		?>
    </ul>
  </div>


  <!--div data-role="footer">
    <h1>Footer Text</h1>
  </div-->

</div>
</body>
</html>