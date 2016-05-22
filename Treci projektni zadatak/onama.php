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
		<title>ETF-Trans - O nama</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="css/styles.css" />
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
					<li><a class="trenutnaStranica" href="<?php echo $onama; ?>">O nama</a></li>
					<li><a href="<?php echo $fbihlinije; ?>">Federalne Linije</a></li>
					<li><a href="<?php echo $partneri; ?>">Partneri</a></li>
					<li><a href="<?php echo $kontakt; ?>">Kontakt</a></li>
				</ul>	
			
			</nav>
			
		</header>
		
		<div id="container">
		
			<div class="mainContentOnama">
				<div class="contentOnama">
					<h1>O nama:</h1>
					<img src="images/etf-stanica.jpg" alt="Slika stanice"/>
					<p> ETF-Trans osnovan je 1994. godine zadužen za pružanje usluga prijevoza putnika. <br>
						Kroz dugogodišnji rad ETF-Trans je prošao razne faze organizacionih promjena koje, uprkos izmjenama društvenih prilika, nisu uticale na uspješnost poslovanja. <br>

						Danas je ETF-Trans sa svojim voznim parkom, koji broji više od 200 autobusa koji zadovoljavaju stroge sigurnosne evropske i svjetske tehničko-eksploatacione standarde, vodeća firma za autobuski saobraćaj u Bosni i Hercegovini. U našem vlasništvu su savremene auto-baze, pet poslovnih jedinica, osam autobuskih stanica te četiri savremeno opremljene turističke agencije.
					</p>
					
					<p> Misija ETF-Trans-a je: <br><br>
						• Da se osigura trajno i kvalitetno obavljanje djelatnosti prijevoza putnika korištenjem vlastitih ljudskih i tehničkih potencijala na principima održivog razvoja i stalnog praćenja europskih trendova kvalitete na području prijevozne djelatnosti,
							<br><br>
						• Da kompanija i njeni uposlenici održavaju sve prijevozne kapacitete u stanju funkcionalne sposobnosti uz maksimalno poštivanje zaštite okoliša, održivog razvoja i javnog interesa lokalne zajednice u kojima djelujemo,
							<br><br>
						• Da kontinuirano jačamo sistem kontrole poslovanja uz poštivanje europskih standarda transparentnosti poslovanja,
							<br><br>
						• Da podižemo kvalitet usluge i odnos prema putniku, tako da omogućimo optimalnu popunjenost i iskorištenost prijevoznih kapaciteta i da obezbjedimo prihode kojima se, kroz isplate plaća i dividendi, stvara zadovoljstvo uposlenih i vlasnika kompanije.
					</p>
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