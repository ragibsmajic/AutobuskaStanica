<?php
	session_start();
	include 'funkcije.php';
	
	$komentari = array();
	
	if(!provjeriDaLiJePrijavljen())
	{
		echo json_encode($komentari);
	}
	else
	{
		$komentari = dajKomentareNaNovostiAutora();
		
		echo json_encode($komentari);
	}
?>