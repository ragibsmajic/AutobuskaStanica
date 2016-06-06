<?php
	include 'funkcije.php';
	
	if(!isset($_GET['idKomentara']))
		die("Nemozeeee!!!!!");
	else if(!is_numeric($_GET['idKomentara']))
		die("Nemozeeee!!!!!");
	
	$odgovori = dajOdgovoreNaKomentar($_GET['idKomentara']);
	
	echo json_encode($odgovori);
?>