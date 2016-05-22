<?php
	session_start();
	include 'stranice.php';
	include 'funkcije.php';
	$prijavljeniKorisnik = false;
	$sortiranje = 0; // Sortiranje po datumu
	$validacijaFormaLijevo = 0;
	$validacijaFormaDesno = 0;
	$validneEkstenzije = array("jpg", "jpeg", "bmp", "gif", "png");
	
	if(provjeriDaLiJePrijavljen())
	{
		$prijavljeniKorisnik = true;
		$username = $_SESSION['username'];
		$imeKorisnika = dajImeKorisnika($username);
	}
	
	if(trazenoPostavljanjeNovosti() == "lijevaSekcija")
	{
		$validacijaFormaLijevo = postaviNovostULijevuSekciju();
	}
	else if(trazenoPostavljanjeNovosti() == "desnaSekcija")
	{
		$validacijaFormaDesno = postaviNovostUDesnuSekciju();
	}
	
	if(isset($_GET['sortiranje']) && $_GET['sortiranje'] == "abecedno")
		$sortiranje = 1; // Abecedno sortiranje novosti po naslovu
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
								echo "Dobrodošao: " . $imeKorisnika . "! &nbsp&nbsp&nbsp <a href='" . $logoutPage . "'>Odjava</a>";
							}
							else
							{
								echo "Niste prijavljeni! &nbsp&nbsp&nbsp <a href='" . $loginPage . "'>Prijava</a>";
							}
				
				?></p>
			</div>
			
			<div id="filter">
			<p>Filter novosti:
			<select onchange='filtriraj(this.value);'>
				<option value="sve">Sve novosti</option>
				<option value="danas">Današnje novosti</option>
				<option value="ovasedmica">Novosti ove sedmice</option>
				<option value="ovajmjesec">Novosti ovog mjeseca</option>
			</select></p>
			
			</div>
			
			<div id="sorter">
				<p>Sortiraj novosti:
				<select onchange='posaljiPodatak(this.value);'>
					<option value="poDatumu" <?php 
												if($sortiranje == 0)
													echo "selected='selected'"
											?> >
					Po datumu objave</option>
					<option value="abecedno" <?php 
												if($sortiranje == 1)
													echo "selected='selected'"
											?> >
					Abecedno po naslovu</option>
				</select></p>
			
			</div>
			
			<nav id="navbar">		
			<ul>
				<li><a class="trenutnaStranica" href="<?php echo $homePage; ?>">Naslovnica</a></li>
				<li><a href="<?php echo $onama; ?>">O nama</a></li>
				<li><a href="<?php echo $fbihlinije; ?>">Federalne Linije</a></li>
				<li><a href="<?php echo $partneri; ?>">Partneri</a></li>
				<li><a href="<?php echo $kontakt; ?>">Kontakt</a></li>
				
			</ul>	
			
		</nav>
			
		</header>
		
		<div id="container">
		
		<section id="lijevaSekcija">
			<?php
				echo "<h2>Ljeto 2016!</h2>";	
			
			if($prijavljeniKorisnik)
			{
				echo "<div class='postLijevaSekcijaFormaZaPostavljanje'>";
				
					echo "<div id='formaZaPostavljanjeObavijesti'>";
							
						echo "<form id='formaNovost' action='index.php' onsubmit='return validirajFormuZaNovostLijevo();' method='POST' enctype='multipart/form-data'>";
							
								echo "<label for='naslov'>Naslov: </label>";
								echo "<input id='naslovLijevo' type='text' name='naslov' />";
								echo "<br><br>";
								echo "<label for='slika'>Odabir slike: </label>";
								echo "<input id='slikaLijevo' type='file' name='slika' />"; 
								echo "<br><br>";
								echo "<label for='opisSlike'>Opis slike: </label>"; 
								echo "<input id='opisSlikeLijevo' type='text' name='opisSlike' />";
								echo "<br><br>";
								echo "<label for='kodDrzave'>Kod države: </label>";
								echo "<input id='kodDrzaveLijevo' onblur='validirajTelefonLijevo(this.value);' type='text' name='kodDrzave' />";
								echo "<br><br>";
								echo "<label for='telBroj'>Tel autora: </label>";
								echo "<input id='telBrojLijevo' onblur='validirajKodDrzaveLijevo(this.value);' type='text' name='telBroj' />";
								echo "<input id='BrojLijevo' type='text' name='Broj' />";
								echo "<br><br>";
								echo "<label for='sadrzajLijevo'>Text: </label>"; 
								echo "<textarea id='sadrzajPostaLijevo' name='sadrzaj' rows='10' cols='50'></textarea>";
								echo "<br><br>";
								echo "<input type='submit' name='postaviObavijestLijevaSekcija' value='Postavi novost' />";
							
						echo "</form>";	
						
					
					
						switch($validacijaFormaLijevo)
						{
							case 1: {
									echo "<p id='porukaLijevo'>Naslov mora biti sačinjen bar od 3 znaka! </p>";
									break;
							}
							case 2:{
									echo "<p id='porukaLijevo'>Fajl nije izabran ili nema validnu ekstenziju! Validne ekstenzije su: " . implode(", ",$validneEkstenzije); 
									echo "</p>";
									break;
							}
							case 3:{
									echo "<p id='porukaLijevo'>Opis slike mora biti sačinjen bar od 3 znaka! </p>";
									break;
							}
							case 4:{
									echo "<p id='porukaLijevo'>Tekst novosti mora biti sačinjen bar od 10 znakova! </p>";
									break;
							}
							default:{
									echo "<p id='porukaLijevo'></p>";
									break;
							}
						} 
					
						
					echo "</div>";
			
				echo "</div>";
			
			}
			
			$novosti = dajNovostiLijeveSekcije($sortiranje);
				foreach($novosti as $novost)
				{
					echo "<div class='postLijevaSekcija'>";
					
					echo	"<div class='datumObjave'>". $novost[1] . "</div>";
						
					echo 	"<h3>". $novost[2] . "</h3>";
					echo	"<img src='". $novost[3] . "'  alt='". $novost[4] ."'/>";
					echo	"<p class='porukaODatumuObjave'></p>";
					echo	"<p>" . str_replace(";",",",$novost[5]) . "</p>";
					echo "</div>";
				}
			
			?>
			
		</section>
		
		<section id="desnaSekcija">
			<?php
				echo "<h2>Putovanja 2016!</h2>";	
			
				if($prijavljeniKorisnik)
				{
					echo "<div class='postDesnaSekcijaFormaZaPostavljanje'>";
					
						echo "<div id='formaZaPostavljanjeObavijesti'>";
							echo "<form id='formaNovost' action='index.php' onsubmit='return validirajFormuZaNovostDesno();' method='POST' enctype='multipart/form-data'>";
							
								echo "<label for='naslov'>Naslov: </label>";
								echo "<input id='naslovDesno' type='text' name='naslov' />";
								echo "<br><br>";
								echo "<label for='slika'>Odabir slike: </label>";
								echo "<input id='slikaDesno' type='file' name='slika' />"; 
								echo "<br><br>";
								echo "<label for='opisSlike'>Opis slike: </label>"; 
								echo "<input id='opisSlikeDesno' type='text' name='opisSlike' />";
								echo "<br><br>";
								echo "<label for='kodDrzave'>Kod države: </label>";
								echo "<input id='kodDrzaveDesno' onblur='validirajTelefonDesno(this.value);' type='text' name='kodDrzave' />";
								echo "<br><br>";
								echo "<label for='telBroj'>Tel autora: </label>";
								echo "<input id='telBrojDesno' onblur='validirajKodDrzaveDesno(this.value);' type='text' name='telBroj' />";
								echo "<input id='BrojDesno' type='text' name='Broj' />";
								echo "<br><br>";
								echo "<label for='sadrzajDesno'>Text: </label>"; 
								echo "<textarea id='sadrzajPostaDesno' name='sadrzaj' rows='10' cols='50'></textarea>";
								echo "<br><br>";
								echo "<input type='submit' name='postaviObavijestDesnaSekcija' value='Postavi novost' />";
							
							echo "</form>";	
						
						switch($validacijaFormaDesno)
						{
							case 1: {
									echo "<p id='porukaDesno'>Naslov mora biti sačinjen bar od 3 znaka! </p>";
									break;
							}
							case 2:{
									echo "<p id='porukaDesno'>Fajl nije izabran ili nema validnu ekstenziju! Validne ekstenzije su: " . implode(", ",$validneEkstenzije); 
									echo "</p>";
									break;
							}
							case 3:{
									echo "<p id='porukaDesno'>Opis slike mora biti sačinjen bar od 3 znaka! </p>";
									break;
							}
							case 4:{
									echo "<p id='porukaDesno'>Tekst novosti mora biti sačinjen bar od 10 znakova! </p>";
									break;
							}
							default:{
									echo "<p id='porukaDesno'></p>";
									break;
							}
						}						
						echo "</div>";
				
					echo "</div>";
				
				}
				
				$novosti = dajNovostiDesneSekcije($sortiranje);
				foreach($novosti as $novost)
				{
					echo "<div class='postDesnaSekcija'>";
					
					echo	"<div class='datumObjave'>". $novost[1] . "</div>";
						
					echo 	"<h3>". $novost[2] . "</h3>";
					echo	"<img src='". $novost[3] . "'  alt='". $novost[4] ."'/>";
					echo	"<p class='porukaODatumuObjave'></p>";
					echo	"<p>" . str_replace(";",",",$novost[5]) . "</p>";
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