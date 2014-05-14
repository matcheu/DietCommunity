<?php
include_once('dao.php');
$id=$_GET['id'];
echo encode(getPersonne($id));
echo encode(getAnnonceForPersonne($id));
echo encode(getPostsForPersonne($id));
echo encode(getCommentairesForPost(3));
echo encode(getFavorisForPersonne(1));
?>