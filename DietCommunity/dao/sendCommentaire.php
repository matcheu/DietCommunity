<?php
include_once('dao.php');
	$id = $_POST['id'];
	$valuee = $_POST['valuee'];
	$idPersonne = $_POST['idPersonne'];
	echo encode(createCommentaire($valuee,$id,$idPersonne));
?>