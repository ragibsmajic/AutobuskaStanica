<?php
	session_start();
	include 'stranice.php';
	include 'funkcije.php';
	
	$neispravniPodaci = false;
	
	if(provjeriDaLiJePrijavljen() && $_SESSION['administrator'] == 0) // Ako je već prijavljen, postoji sesija uradi redirekciju na naslovnicu
		redirekcija($homePage);
	else if(provjeriDaLiJePrijavljen() && $_SESSION['administrator'] == 1)
		redirekcija($adminPanel);
	
	else if(daLiSuPostavljeniUserNamePass())
	{		
		if(provjeriUserNamePass())
		{
			if($_SESSION['administrator'] == 0)
				redirekcija($homePage);
			else
				redirekcija($adminPanel);
		}
		else
		{
			$neispravniPodaci = true;
		}
	}		
?>
<!DOCTYPE html>
<html>
<head>
	<title>ETF-Trans Prijava</title>
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

			<nav id="navbar">		
			<ul>
					<li><a href="<?php echo $homePage; ?>">Naslovnica</a></li>
					<li><a href="<?php echo $onama; ?>">O nama</a></li>
					<li><a href="<?php echo $fbihlinije; ?>">Federalne Linije</a></li>
					<li><a href="<?php echo $partneri; ?>">Partneri</a></li>
					<li><a href="<?php echo $kontakt; ?>">Kontakt</a></li>
				
			</ul>	
			
			</nav>
		</header>
		
		<div id="container">
		
		<div id="formaZaPrijavu">
			<form action="login.php" onsubmit="return validirajUserNamePass();" method="POST">
			
			<label for="username">Korisničko ime:</label>
			<input id="txtLoginUserName" type="text" name="username" />
		
			
			
			<label for="password">Lozinka:</label>
			<input id="txtLoginPass" type="password" name="password" />
			
			
			<input type="submit" name="submit" value="Prijava" />
			
			<p id="poruka"><?php if($neispravniPodaci) echo "Podaci za prijavu nisu ispravni!" ?> </p>
			</form>
		</div>
		
		</div>

</body>
</html>