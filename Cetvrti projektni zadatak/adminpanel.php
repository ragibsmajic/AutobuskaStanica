<?php
	session_start();
	include 'stranice.php';
	include 'funkcije.php';
	
	if(provjeriDaLiJePrijavljen())
	{
		if($_SESSION['administrator'] != 1)
			die("Samo administrator ima pristup ovom dijelu, vi ste prijavljeni kao autor!");
	}
	else
	{
		redirekcija($loginPage);
	}
	if(isset($_POST['btnObrisi']))
	{
		obrisiNovost($_POST['idNovosti']);
	}
	if(isset($_POST['btnPromijeni']))
	{
		promijeniPravoKomentarisanja($_POST['idNovosti'], $_POST['pravoKomentarisanja']);
	}
	$novosti = dajSveNovostiSaAutorima();
?>

<!DOCTYPE html>
<html>

	<head>
		<title>ETF-Trans - Admin Panel</title>
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
						
					echo "Dobrodošao: " . $_SESSION['imeAutora'] . " ". $_SESSION['prezimeAutora'] . "! &nbsp&nbsp&nbsp <a href='" . $logoutPage . "'>Odjava</a>";
						
				?></p>
			</div>
			
			<nav id="navbar">		
			<ul>
				<li><a class="trenutnaStranica" href="<?php echo $adminPanel; ?>">Novosti</a></li>
				<li><a href="<?php echo $adminautori; ?>">Autori</a></li>
				<li><a href="<?php echo $autorstranica; ?>">Dodavanje autora</a></li>
				<li><a href="<?php echo $adminkomentari; ?>">Komentari</a></li>
				
			</ul>	
			
		</nav>
			
		</header>
		
		<div id="container">
			
			<div id="adminPanelContainer">
			<div id="adminPanel">
			
				<div id="adminPanelSadrzaj">
					<?php
						//n.idNovosti, n.naslovNovosti, a.imeAutora, a.prezimeAutora, n.datumPostavljanja, n.imaKomentare
						echo "<table id='tabelaNovosti'>";
							echo "<tr id='zaglavljeTabele'>";
								echo "<th>Naslov novosti</th>";
								echo "<th>Autor</th>";
								echo "<th>Vrijeme postavljanja</th>";
								echo "<th>Omogućeno komentarisanje</th>";
							echo "</tr>";
						$i = 0;
						foreach($novosti as $novost)
						{
							$red = "parniRed";
							if($i%2 == 1) $red = "neparniRed";
							$i = $i+1;
							echo "<tr class='$red'>";
								echo "<td>$novost[1]</td>";
								echo "<td>$novost[2] $novost[3]</td>";
								echo "<td>$novost[4]</td>";
							if($novost[5] == 1)
								echo "<td>DA</td>";
							else
								echo "<td>NE</td>";
								echo "<form action='#' method=POST>";
									echo "<td><input type='hidden' name='idNovosti' value='$novost[0]' /><input type='submit' name='btnObrisi' value='Obriši novost' /></td>";
									echo "<td><input type='hidden' name='pravoKomentarisanja' value='$novost[5]' /><input type='submit' name='btnPromijeni' value='Promijeni pravo komentarisanja' /></td>";
								echo "</form>";
							echo "</tr>";
						}
						
						echo "</table>";	
							
						
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
						<li><a href="<?php echo $adminPanel; ?>">Novosti</a></li>
						<li><a href="<?php echo $adminautori; ?>">Autori</a></li>
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