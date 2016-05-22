<?php
	session_start();
	include 'stranice.php';
	include 'funkcije.php';
	$prijavljeniKorisnik = false;
	
	if(provjeriDaLiJePrijavljen())
	{
		$prijavljeniKorisnik = true;
		$username = $_SESSION['username'];
		$imeKorisnika = dajImeKorisnika($username);
	}
?>
<!DOCTYPE html>
<html>

	<head>
		<title>ETF-Trans - Kontakt</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="css/styles.css" />
		<script src="skripte/skripta.js"></script>

	</head>

	<body>
	
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
					<li><a class="trenutnaStranica" href="<?php echo $kontakt; ?>">Kontakt</a></li>
				
			</ul>	
			
		</nav>
			
		</header>
		
		<div id="container">
		
		<div class="mainContentKontakt">
			<div class="contentKontakt">
				<h1>Ukoliko imate bilo kakva pitanja, kontaktirajte nas:</h1>
				
				<div class="formaContainer">
				
				<form class="forma">
					<div class="redForme">
						<label for="ime" >Ime:</label>
						<input type="text" id="ime" onkeyup="validacijaImena(this.value);" />
					</div>
					
					<div class="redForme">
						<label class="osobniPodaci" for="prezime" >Prezime:</label>
						<input type="text" id="prezime" onkeyup="validacijaPrezimena(this.value);" />
					</div>
					
					<div class="redForme">
						<label for="email" >Email:</label>
						<input type="email" id="email" onkeyup="validacijaEmaila(this.value);" />
					</div>
					
					<div class="redForme">
						<label for="ponovniMail" >Ponovite email:</label>
						<input type="text" id="ponovniMail" onkeyup="validacijaPonovljenogMaila(this.value);" />
					</div>
					
					<div class="redForme">
						<label for="poruka" >Poruka:</label>
						<textarea id="poruka" onkeyup="validacijaPoruke(this.value);"></textarea>
			
					</div>
					
					<div class="redForme">
						<button type="button" onclick="validirajNakonSubmita();">Pošalji</button>
					</div>
					
					</form>
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