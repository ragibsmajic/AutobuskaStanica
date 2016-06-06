<?php
	session_start();
	include 'stranice.php';
	include 'funkcije.php';
	
	$prijavljeniKorisnik = false;
	
	if(provjeriDaLiJePrijavljen())
	{
		$prijavljeniKorisnik = true;
	}
	
	$novosti = array();
	$idNovosti = null;
	
	if(isset($_POST['textKomentara']) && isset($_POST['idNovosti']))
		dodajKomentarNaNovost($_POST['idNovosti'], $_POST['textKomentara']);
	
	if(isset($_POST['btnOdgovori']))
		dodajOdgovorNaKomentar($_POST['textOdgovora'], $_POST['roditeljKomentar'], $_POST['idNovosti']);
	
	if(isset($_POST['idNovosti']) && is_numeric($_POST['idNovosti']))
	{
		$novosti = dajNovostPoId($_POST['idNovosti']);
		$idNovosti = $_POST['idNovosti'];
	}
	
	if(isset($_GET['idNovosti']) && is_numeric($_GET['idNovosti']))
	{
		$novosti = dajNovostPoId($_GET['idNovosti']);
		$idNovosti = $_GET['idNovosti'];
	}
	
	if($prijavljeniKorisnik && daLiJeAutorNovosti($idNovosti, $_SESSION['idAutora']))
	{
		postaviKomentareKaoVidene($idNovosti);
	}
?>

<!DOCTYPE html>
<html>

	<head>
		<title>ETF-Trans - Naslovnica</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="css/styles.css" />		
		<script src="skripte/skripta.js"></script>
	</head>

	<body onload="azurirajVrijemeObjave()">
	
		<header id="header">
		
			<a href="<?php echo $homePage; ?>"><div id="logo">
				<p class="okvirBusa"></p>
				
				<ul class="prozori">
					<li class="prozor1"></li>
					<li class="prozor2"></li>
					<li class="prozor3"></li>
					<li class="prozor4"></li>
				</ul>
				
				<ul class="tockovi">
					<li class="tocak1"></li>
					<li class="tocak2"></li>
				</ul>
				
				<p class="natpis">ETF-Trans</p>
				
			</div></a>
			
			<p class="slogan">Putujte sa osmjehom!</p>
			
			<div id="prijava_odjava">
				<p><?php 
							if($prijavljeniKorisnik)
							{
								echo "Dobrodošao: " . $_SESSION['imeAutora'] . " ". $_SESSION['prezimeAutora'] . "! &nbsp&nbsp&nbsp <a href='" . $logoutPage . "'>Odjava</a>";
							}
							else
							{
								echo "Niste prijavljeni! &nbsp&nbsp&nbsp <a href='" . $loginPage . "'>Prijava</a>";
							}
				
				?></p>
			</div>	
			<nav id="navbar">		
			<ul>
				<li><a href="<?php echo $homePage; ?>">Naslovnica</a></li>
				<li><a href="<?php echo $onama; ?>">O nama</a></li>
				<li><a href="<?php echo $fbihlinije; ?>">Federalne Linije</a></li>
				<li><a href="<?php echo $partneri; ?>">Partneri</a></li>
				<li><a href="<?php echo $kontakt; ?>">Kontakt</a></li>
				<?php
					if(isset($_SESSION['username']))
					{
						echo "<li><a href='$mojenovosti'>Moje novosti</a></li>";
						echo "<li><a href='$mojprofil'>Moj profil</a></li>";
					}
				?>
			</ul>	
			
		</nav>
			
		</header>
		
		<div id="container">
		
		<section id="sekcijaDetaljanPrikaz">
			<?php	
	
				foreach($novosti as $novost)
				{
					$autor = dajAutoraNovosti($novost[7]);
					$idAutora = $autor[0][0];
					$imeAutora = $autor[0][1];
					$prezimeAutora = $autor[0][2];
					echo "<div class='postDetaljanPrikaz'>";
					
					echo	"<div class='datumObjave'>". $novost[1] . "</div>";
						
					echo 	"<h3>". $novost[2] . "</h3>";
					echo    "<p id='nazivAutora'><a href='$homePage?autor=$idAutora'>Autor: $imeAutora $prezimeAutora</a></p>";
					echo	"<img src='". $novost[3] . "'  alt='". $novost[4] ."'/>";
					echo	"<p class='porukaODatumuObjave'></p>";
					echo	"<p>" . $novost[5] . "</p>";
					
					if($novost[8])
					{
						
						$komentariNaNovost = dajKomentareNaNovost($idNovosti);
						
						echo "<div id='komentariNaNovost' >";
								echo "<div class='komentar'>";
								echo "<form action='$detaljanPrikaz' method='POST'>";
									echo "<textarea id='poljeZaKomentar' name='textKomentara'></textarea>";
									echo "<input id='dugmeKomentarisi' type='submit' value='Komentariši' />";
									echo "<input type='hidden' name='idNovosti' value='".$idNovosti."' />";
								echo "</form>";
								echo "</div>";
							foreach($komentariNaNovost as $komentar)
							{
								echo "<div class='komentar'>";
								if(!is_null($komentar[1]))
									echo "<p class='imeAutora'>$komentar[1] $komentar[2]</p>";
								else
									echo "<p class='imeAutora'>Gost</p>";
								echo "<div class='textKomentara' >";
								echo "<p> $komentar[3]</p>";
								echo "</div>";
								echo "<p id='vrijemePostavljanja'>$komentar[4] <a id='linkNaOdgovore".$komentar[0]."' href='javascript:ucitajOdgovoreNaKomentar(". $komentar[0] .", " . $idNovosti . ");'>&nbsp;&nbsp;&nbsp; Odgovori(". $komentar[5] .")</a></p>";
								echo "</div>";
								echo "<div id='odgovoriNaKomentar". $komentar[0] . "'>";
								echo "</div>";
							}
						echo "</div>";
					}
					
					echo "</div>";
				}
			
			?>
			
		</section>
		
		<div class="clr">
		</div>
		
		<footer id="footer">
			
			<section class="footerNav">
				<h3>Stranice:</h3>
				<ul>
					<li><a href="<?php echo $homePage; ?>">Naslovnica</a></li>
					<li><a href="<?php echo $onama; ?>">O nama</a></li>
					<li><a href="<?php echo $fbihlinije; ?>">Federalne Linije</a></li>
					<li><a href="<?php echo $partneri; ?>">Partneri</a></li>
					<li><a href="<?php echo $kontakt; ?>">Kontakt</a></li>
				</ul>
			</section>
			
			<section class="footerSocialContent">
				<h3>Povežite se sa nama:</h3>
				<ul>
					<li><a href=""><img src="images/Facebook.png" alt="Facebook"/></a></li>
					<li><a href=""><img src="images/G+.png"  alt="Google Plus"/></a></li>
					<li><a href=""><img src="images/Twitter.png"  alt="Twitter"/></a></li>
					<li><a href=""><img src="images/YouTube.png"  alt="YouTube"/></a></li>
				</ul>
			</section>
			
			<div class="clr">
			</div>
			<div id="copyRight">
			<p>Copyright &copy; - 2016 Ragib Smajić - Web Tehnologije</p>
			</div>
			
		
		</footer>
		
		</div>
		
	</body>
	
</html>