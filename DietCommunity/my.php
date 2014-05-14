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
$er = array();
require_once('dao/dao.php');

if (isset($_POST['pseudo'])){
	$pseudo = $_POST['pseudo'];
	$password = $_POST['password'];
	$retour = connectPersonne($pseudo,$password);
	if ($retour!='0'){
		$_SESSION['id']=$retour;
	}
	else
	{
		array_push($er,"Impossible de vous trouvez dans notre base de donnée");
	}
}

?>
</head>
<body>
<div data-role="page" id="my">

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
	<?php
		if (isset($_SESSION['id'])){
			// connecté
		?>
		<?php
			$p = json_decode(encode(getPersonne($_SESSION['id'])));
		?>
		<h2>Bonjour <?php echo $p->pseudo ?></h2>
		<?php
		}
		else
		{
			// pas connecté
		?>
		<h2>Page de connexion</h2>
		<?php
			if (count($er)>0){
				foreach($er as $e){
					echo $e."<br/>";
				}
			}
		?>
		<form method="post" id="form" action="my.php">
			<label for="pseudo">Votre pseudo ou email :</label>
			<input type="text" name="pseudo"/>
			<label for="password">Votre mot de passe :</label>
			<input type="password" name="password"/>
			<input type="submit" value="Envoyer">
		</form>
		<?php
		}
	?>
  </div>


  <!--div data-role="footer">
    <h1>Footer Text</h1>
  </div-->

</div>
</body>
</html>