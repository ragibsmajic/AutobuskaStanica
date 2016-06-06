<?php
	session_start();
	include 'stranice.php';
	include 'funkcije.php';
	$prijavljeniKorisnik = false;
	$korisnik = null;
	if(provjeriDaLiJePrijavljen())
	{
		$prijavljeniKorisnik = true;
		$username = $_SESSION['username'];
		$imeKorisnika = dajImeKorisnika($username);
		$korisnik = dajPrijavljenogKorisnika();
	}
	else
		die("Greska");
	
	if(isset($_POST['btnPromijeniPass']))
	{
		$pass = $_POST['password'];
		promijeniPasswordKorisnika($_SESSION['idAutora'], $pass);	
	}
?>
<!DOCTYPE html>
<html>

	<head>
		<title>ETF-Trans - O nama</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="css/styles.css" />
		<script src="skripte/skripta.js"></script>
	</head>

	<body>
	
		<header id="header">
			<a href="<?php echo $homePage; ?>">
				<div id="logo">
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
				
				</div>
			</a>
			
			<p class="slogan">Putujte sa osmjehom!</p>
			
			<div id="prijava_odjava">
				<p><?php 
							if($prijavljeniKorisnik)
							{
								echo "Dobrodošao: " . $imeKorisnika . "! &nbsp&nbsp&nbsp <a href='" . $logoutPage . "'>Odjava</a>";
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
							echo "<li><a class='trenutnaStranica' href='$mojprofil'>Moj profil</a></li>";
						}
					?>
				</ul>	
			
			</nav>
			
		</header>
		
		<div id="container">
		
		<div id="mojProfilContainer">
			<div id="mojProfil">
			
			<div id="mojProfilSadrzaj">
				<?php
					echo "<p>Ime i Prezime: $korisnik[1] $korisnik[2]</p>";
					echo "<p>Korisničko ime: $korisnik[3]</p>";
					echo "<p>Datum registracije: $korisnik[5]</p>";
					echo "<form action'#' onsubmit='return validirajPassworde();' method='POST'>";
					echo "<input type='hidden' name='idAutora' value='$korisnik[0]' />";
					echo "<label class='labelPassword' for='password'>Unesi novu šifru:</label>";
					echo "<input type='password' name='password' id='password' /><br>";
					echo "<label class='labelPassword' for='passwordPonovo'>Ponovni unos šifre:</label>";
					echo "<input type='password' name='passwordPonovo' id='passwordPonovo' /><br>";
					echo "<input type='submit' name='btnPromijeniPass' value='Promijeni šifru'/>";
					echo "<p id='porukaOUspjehu'></p>";
					echo "</form>";
				?>
			</div>
			</div>
		</div>
		
		
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