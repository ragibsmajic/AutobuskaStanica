<?php
	session_start();
	include 'funkcije.php';
	include 'stranice.php';
	$prijavljeniKorisnik = false;
	$sortiranje = 0; // Sortiranje po datumu
	if(!provjeriDaLiJePrijavljen())
	{
		die("Greška: Nemate pravo pristupa ovoj stranici jer niste prijavljeni!");
	}
	else
		$prijavljeniKorisnik = true;
	
	if(isset($_GET['sortiranje']) && $_GET['sortiranje'] == "abecedno")
		$sortiranje = 1; // Abecedno sortiranje novosti po naslovu
?>

<!DOCTYPE html>
<html>

	<head>
		<title>ETF-Trans - Moje novosti</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="css/styles.css" />		
		<script src="skripte/skripta.js"></script>
	</head>

	<body onload="azurirajVrijemeObjave(); provjeriNevideneKomentare();">
	
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
				<p id="porukaOBrojuKomentara"></p>
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
				<li><a href="<?php echo $homePage; ?>">Naslovnica</a></li>
				<li><a href="<?php echo $onama; ?>">O nama</a></li>
				<li><a href="<?php echo $fbihlinije; ?>">Federalne Linije</a></li>
				<li><a href="<?php echo $partneri; ?>">Partneri</a></li>
				<li><a href="<?php echo $kontakt; ?>">Kontakt</a></li>
				<?php
					if(isset($_SESSION['username']))
					{
						echo "<li><a class='trenutnaStranica' href='$mojenovosti'>Moje novosti</a></li>";
						echo "<li><a href='$mojprofil'>Moj profil</a></li>";
					}
				?>
			</ul>	
			
		</nav>
			
		</header>
		
		<div id="container">
		
		<section id="lijevaSekcija">
			<?php
				echo "<h2>Ljeto 2016!</h2>";	
			
				$novosti = dajNovostiLijeveSekcijeAutora($sortiranje);
				
				foreach($novosti as $novost)
				{
					echo "<a class='linkDetaljanPrikazNovosti' href='javascript:prikaziNovostDetaljno(" . $novost[7] . ")' >";
					echo "<div class='postLijevaSekcija'>";
					
					echo	"<div class='datumObjave'>". $novost[1] . "</div>";
						
					echo 	"<h3>". $novost[2] . "</h3>";
					echo	"<img src='". $novost[3] . "'  alt='". $novost[4] ."'/>";
					echo	"<p class='porukaODatumuObjave'></p>";
					echo    "<p id='brojNevidenihKomentara$novost[7]' class='porukaNevideniKomentari'></p>";
					echo	"<p>" . $novost[5] . "</p>";
					echo "</div>";
					echo "</a>";
				}
			
			?>
			
		</section>
		
		<section id="desnaSekcija">
			<?php
				echo "<h2>Putovanja 2016!</h2>";	
				
				$novosti = dajNovostiDesneSekcijeAutora($sortiranje);
				foreach($novosti as $novost)
				{
					echo "<a class='linkDetaljanPrikazNovosti' href='javascript:prikaziNovostDetaljno(" . $novost[7] . ")' >";
					echo "<div class='postDesnaSekcija'>";
					
					echo	"<div class='datumObjave'>". $novost[1] . "</div>";
						
					echo 	"<h3>". $novost[2] . "</h3>";
					echo	"<img src='". $novost[3] . "'  alt='". $novost[4] ."'/>";
					echo	"<p class='porukaODatumuObjave'></p>";
					echo    "<p id='brojNevidenihKomentara$novost[7]' class='porukaNevideniKomentari'></p>";
					echo	"<p>" . $novost[5] . "</p>";
					echo "</div>";
					echo "</a>";
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