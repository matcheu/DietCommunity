<?php
function encode($s){
	if (json_encode($s)!='false'){
		return json_encode($s);
	}
	else
	{
		return null;
	}
}
function connectPersonne($pseudo,$password){
	$connexion = getConnexion();
	$sql="
		SELECT id from personne where (pseudo = ? and password= ?) or (email = ? and password = ?)";
	$sth=$connexion->prepare($sql);
	$sth->execute(array($pseudo,$password,$pseudo,$password));
	$retour = $sth->fetchColumn();
	echo $retour;
	return $retour;
}
function getPersonnes(){
	$connexion = getConnexion();
	$sql="
		SELECT id,dateNaissance,pseudo,depart,sexe,password,email,taille from personne ORDER BY id desc";
	$sth=$connexion->prepare($sql);
	$sth->execute();
	$us = array();
	while ($row=$sth->fetch()){
		traiteResultPersonne($row);
		array_push($us,$row);
	}
	return $us;
}
function getPersonne($id){
	$connexion = getConnexion();
	$sql="
		SELECT id,dateNaissance,pseudo,depart,sexe,password,email,taille from personne where id = ?";
	$sth=$connexion->prepare($sql);
	$sth->execute(array($id));
	$row=$sth->fetch();
	if($row!=null){
		traiteResultPersonne($row);
	}
	return $row;
}
function getAnnonceForPersonne($id){
	$connexion = getConnexion();
	$sql="
		SELECT * from annonce where idPersonne = ?";
	$sth=$connexion->prepare($sql);
	$sth->execute(array($id));
	$row=$sth->fetch();
	if($row!=null){
		traiteAnnonce($row);
	}
	return $row;
}
function getPostsForPersonne($id){
	$connexion = getConnexion();
	$sql="
		SELECT * from post where idPersonne = ? order by id desc";
	$sth=$connexion->prepare($sql);
	$sth->execute(array($id));
	$us = array();
	while ($row=$sth->fetch()){
		traitePost($row);
		array_push($us,$row);
	}
	return $us;
}
function getCommentairesForPost($id){
	$connexion = getConnexion();
	$sql="
		SELECT * from commentaire where idPost = ? order by id desc";
	$sth=$connexion->prepare($sql);
	$sth->execute(array($id));
	$us = array();
	while ($row=$sth->fetch()){
		traiteCommentaire($row);
		array_push($us,$row);
	}
	return $us;
}
function getCommentaire($id){
	$connexion = getConnexion();
	$sql="
		SELECT * from commentaire where id = $id order by id desc";
	$sth=$connexion->prepare($sql);
	$sth->execute();
	$row=$sth->fetch();

	traiteCommentaire($row);

	return $row;
}
function createCommentaire($value,$idPost,$idPersonne){
	$connexion = getConnexion();
	$sql = "insert into commentaire (idPersonne,value,dateCreation,idPost) values (?,?,?,?)";
	$sth=$connexion->prepare($sql);
	$sth->execute(array($idPersonne,$value,mktime(),$idPost));
	$sql = "select id from commentaire where idPost = $idPost order by id desc limit 1";
	$sth=$connexion->prepare($sql);
	$sth->execute();
	$idDernier =  $sth->fetchColumn();
	return getCommentaire($idDernier);
}
function getFavorisForPersonne($id){
	$connexion = getConnexion();
	$sql="
		SELECT * from favori where idFrom = ?";
	$sth=$connexion->prepare($sql);
	$sth->execute(array($id));
	$us = array();
	while ($row=$sth->fetch()){
		$personneTo = getPersonne($row['idTo']);
		$row['personneTo']=$personneTo;
		array_push($us,$row);
	}
	return $us;
}
function getNbrCommentaires($id){
	$connexion = getConnexion();
	$sql="
		SELECT count(*) from commentaire where idPost = ?";
	$sth=$connexion->prepare($sql);
	$sth->execute(array($id));
	return $sth->fetchColumn();

}
function traiteResultPersonne(&$row){
	$row['objectif']=getObjectif($row['id']);
	$row['actuel']=getPoidsActuel($row['id']);
	$row['dateNaissance']=formatDate($row['dateNaissance']);
	if ($row['sexe']==1){
		$row['sexe']='Garcon';
	}
	else
	{
		$row['sexe']='Fille';
	}
}
function traiteCommentaire(&$row){
	$personne = getPersonne($row['idPersonne']);
	$row['pseudo']=$personne['pseudo'];
	$row['dateCreation']=formatDateTime($row['dateCreation']);
}
function traiteAnnonce(&$row){
	$row['dateCreation']=formatDate($row['dateCreation']);
	$row['value']=$row['value'];
}
function traitePost(&$row){
	$row['nbrCommentaires']=getNbrCommentaires($row['id']);
	$row['dateCreation']=formatDate($row['dateCreation']);
	$row['poidsActuel']=getPoidsActuelForPost($row['idActuel']);
}
function formatDate($da){
	return date("d/m/Y",$da);
}
function formatDateTime($da){
	return date("d/m/Y H:i",$da);
}
function getPoidsActuel($id){
	$connexion = getConnexion();
	$sqlActuel ="select poids from actuel where personneId=? order by id desc limit 1";
	$sthActuel = $connexion->prepare($sqlActuel);
	$sthActuel->execute(array($id));
	$resultActuel = $sthActuel->fetch();
	return $resultActuel['poids'];
}
function getPoidsActuelForPost($id){
	$connexion = getConnexion();
	$sqlActuel ="select poids from actuel where id=?";
	$sthActuel = $connexion->prepare($sqlActuel);
	$sthActuel->execute(array($id));
	$resultActuel = $sthActuel->fetch();
	return $resultActuel['poids'];
}
function getObjectif($id){
	$connexion = getConnexion();
	$sqlActuel ="select poids from objectif where personneId=? order by id desc limit 1";
	$sthActuel = $connexion->prepare($sqlActuel);
	$sthActuel->execute(array($id));
	$resultActuel = $sthActuel->fetch();
	return $resultActuel['poids'];
}
function getConnexion(){
	$PARAM_hote="localhost";
	$PARAM_nom_db="regime";
	$PARAM_utilisateur="regime";
	$PARAM_mot_passe="regime";
	$connexion = new PDO('mysql:host='.$PARAM_hote.';dbname='.$PARAM_nom_db, $PARAM_utilisateur, $PARAM_mot_passe);
	return $connexion;
}

?>