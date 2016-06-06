<?php
	session_start();
	include 'stranice.php';
	include 'funkcije.php';
	
	$izmjenaAutora = 0;
	$autorZaIzmjenu = null;
	
	if(provjeriDaLiJePrijavljen())
	{
		if($_SESSION['administrator'] != 1)
			die("Samo administrator ima pristup ovom dijelu, vi ste prijavljeni kao autor!");
	}
	else
	{
		redirekcija($loginPage);
	}
	$porukaIzmjena = "";
	if(isset($_POST['btnSpremiPromjene']))
	{
		$idAutoraZaSpremit = $_POST['idAutora'];
		$userName = $_POST['txtUserName'];
		if(provjeriDaLiVecPostojiBez($userName, $idAutoraZaSpremit))
		{
			$porukaIzmjena = "Autor sa tim korisničkim imenom postoji, odaberite drugo!";
		}
		else
		{
			$porukaIzmjena = "Promjene uspješne!";
			$ime = $_POST['txtIme'];
			$prezime = $_POST['txtPrezime'];
			$_GET['idAutora'] = $_POST['idAutora'];
			spremiPromjeneAutora($idAutoraZaSpremit, $userName, $ime, $prezime);
		}
	}
	
	if(isset($_GET['idAutora']) && is_numeric($_GET['idAutora']))
	{
		$izmjenaAutora = 1;
		$autorZaIzmjenu = dajAutoraPoId($_GET['idAutora']);
	}
	
	$poruka = "";
	if(isset($_POST['btnDodajAutora']))
	{
		$userName = $_POST['txtUserName'];
		
		if(provjeriDaLiVecPostoji($userName))
		{
			$poruka = "Autor sa tim korisničkim imenom postoji, odaberite drugo!";
		}
		else
		{
			$poruka = "Autor uspješno dodan!";
			spremiAutora($_POST['txtUserName'], $_POST['txtIme'], $_POST['txtPrezime'], $_POST['txtPassword']);
		}
	}	
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
				<li><a href="<?php echo $adminPanel; ?>">Novosti</a></li>
				<li><a href="<?php echo $adminautori; ?>">Autori</a></li>
				<li><a class="trenutnaStranica" href="<?php echo $autorstranica; ?>">Dodavanje autora</a></li>
				<li><a href="<?php echo $adminkomentari; ?>">Komentari</a></li>
			</ul>	
			
		</nav>
			
		</header>
		
		<div id="container">
			
			<div id="adminPanelContainer">
			<div id="adminPanel">
			
				<div id="adminPanelSadrzaj">
				
					<div id="formaZaUnosAutora" >
					<?php
					
					if($izmjenaAutora == 1)
					{
						echo "<form action='#' onsubmit='return validirajIzmjenuAutora();' method='POST'>";
						echo "<label for='txtIme'>Ime:</label>";
						echo "<input id='txtIme' type='text' name='txtIme' value='$autorZaIzmjenu[1]' /><br>";
						echo "<label for='txtPrezime'>Prezime:</label>";
						echo "<input id='txtPrezime' type='text' name='txtPrezime' value='$autorZaIzmjenu[2]' /><br>";
						echo "<label for='txtUserName'>Korisničko ime:</label>";
						echo "<input id='txtUserName' type='text' name='txtUserName' value='$autorZaIzmjenu[3]' /><br>";
						echo "<input type='hidden' name='idAutora' value='$autorZaIzmjenu[0]' /><br>";
						echo "<input type='submit' name='btnSpremiPromjene' value='Spremi' />";
						echo "<p id='porukaOUspjehu'>$porukaIzmjena</p>";
						echo "</form>";
					}
					else
					{
						echo "<form action='#' onsubmit='return validirajAutora();' method='POST'>";
						echo "<label for='txtIme'>Ime:</label>";
						echo "<input id='txtIme' type='text' name='txtIme' /><br>";
						echo "<label for='txtPrezime'>Prezime:</label>";
						echo "<input id='txtPrezime' type='text' name='txtPrezime' /><br>";
						echo "<label for='txtUserName'>Korisničko ime:</label>";
						echo "<input id='txtUserName' type='text' name='txtUserName' /><br>";
						echo "<label for='txtPassword'>Lozinka:</label>";
						echo "<input id='txtPassword' type='password' name='txtPassword' /><br>";
						echo "<label for='txtPasswordPonovo'>Lozinka ponovo:</label>";
						echo "<input id='txtPasswordPonovo' type='password' name='txtPasswordPonovo' /><br>";
						echo "<input type='submit' name='btnDodajAutora' value='Dodaj autora' />";
						echo "<p id='porukaOUspjehu'>$poruka</p>";
						echo "</form>";
					}
					?>
					</div>
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