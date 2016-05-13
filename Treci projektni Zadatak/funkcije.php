<?php
		
	function provjeriDaLiJePrijavljen()
	{
		if(isset($_SESSION['username']))
			return true;
		else
			return false;
	}
	
	function redirekcija($url)
	{
		header("Location: " . $url);
	}
	
	function provjeriUserNamePass()
	{
		$korisnici = array_map('str_getcsv', file("korisnici.csv"));
		
		foreach($korisnici as $korisnik)
		{
			if($korisnik[0] == $_POST['username'])
			{
				$pass = sha1($_POST['password']);
				
				if($korisnik[1] == $pass)
				{
					$_SESSION['username'] = $_POST['username'];
					return true;
				}
			}
		}
		
		return false;
		
	}
	
	function sortirajPoDatumu($novosti)
	{
		$datumiNovosti = array();
		
		foreach($novosti as $novost)
		{
			$datumiNovosti[] = new DateTime($novost[1]);
		}
		
		array_multisort($datumiNovosti, SORT_DESC, $novosti);
		
		return $novosti;
	}
	
	function sortirajAbecednoPoNaslovu($novosti)
	{
		$nasloviNovosti = array();
		
		foreach($novosti as $novost)
		{
			$nasloviNovosti[] = $novost[2];
		}
		
		array_multisort($nasloviNovosti, $novosti);
		
		return $novosti;
	}
	
	function daLiSuPostavljeniUserNamePass()
	{
		if(isset($_POST['username']) && isset($_POST['password']))
			return true;
		return false;
	}
	
	function logout()
	{
		session_unset();
	}
	
	function dajImeKorisnika($username)
	{
		$korisnici = array_map('str_getcsv', file("korisnici.csv"));
		
		foreach($korisnici as $korisnik)
		{
			if($korisnik[0] == $username)
			{
				return $korisnik[2];
			}
		}
	}
	function dajSveNovosti()
	{
		return array_map('str_getcsv', file("novosti.csv"));
	}
	function dajNovostiLijeveSekcije($sortiranje)
	{
		$novosti = dajSveNovosti();
		$novostiLijeveSekcije = array();
		
		foreach($novosti as $novost)
		{
			
			if($novost[0] == "postLijevaSekcija")
			{
				$novostiLijeveSekcije[] = $novost;
			}
		}
		
		if($sortiranje == 0)
		{
			return sortirajPoDatumu($novostiLijeveSekcije);
		}
		else
			return sortirajAbecednoPoNaslovu($novostiLijeveSekcije);
	}
	
	function dajNovostiDesneSekcije($sortiranje)
	{
		$novosti = dajSveNovosti();
		$novostiDesneSekcije = array();
		
		foreach($novosti as $novost)
		{
			
			if($novost[0] == "postDesnaSekcija")
			{
				$novostiDesneSekcije[] = $novost;
			}
		}
		if($sortiranje == 0)
		{
			return sortirajPoDatumu($novostiDesneSekcije);
		}
		else
			return sortirajAbecednoPoNaslovu($novostiDesneSekcije);
	}
	
	function trazenoPostavljanjeNovosti()
	{
		if(isset($_POST['postaviObavijestLijevaSekcija']))
		{
			return "lijevaSekcija";
		}
		else if(isset($_POST['postaviObavijestDesnaSekcija']))
		{
			return "desnaSekcija";
		}
		else 
		{
			return "";
		}
	}
	
	function validacijaNaslova()
	{
		if(!isset($_POST['naslov']) || strlen($_POST['naslov']) < 3)
		{
			return false; 
		}
		return true;
	}
	
	function validacijaSlike()
	{
		
		if(!isset($_FILES['slika']))
		{
			return false; 
		}
		
		$validneEkstenzije = array('jpg', 'jpeg', 'bmp', 'gif', 'png');
		$nazivFajla = $_FILES['slika']['name'];
		$ekstenzija = strtolower(substr(strrchr($nazivFajla, "."), 1));;
		
		return in_array($ekstenzija, $validneEkstenzije);
	}	
	
	function validacijaOpisaSlike()
	{
		if(!isset($_POST['opisSlike']) || strlen($_POST['opisSlike']) < 3)
		{
			return false; 
		}
		return true;
	}
	
	function validacijaTextaNovosti()
	{
		if(!isset($_POST['sadrzaj']) || strlen($_POST['sadrzaj']) < 10)
		{
			return false; 
			
		}
		return true;
	}
	
	function validacijaForma()
	{
		
		if(!validacijaNaslova()) return 1; // Kod da sa naslovom nesto nije uredu..
		if(!validacijaSlike()) return 2; // Kod da sa slikom nesto nije uredu..
		if(!validacijaOpisaSlike()) return 3; // Kod da sa opisom slike nesto nije uredu..
		if(!validacijaTextaNovosti()) return 4; // Kod da sa textom novosti nesto nije uredu..
		
		return 0; // Kod da je sve uredu..
	}
	
	function izvrsiUploadSlike()
	{
		$nazivSlike = $_FILES['slika']['name'];
		$tipSlike = $_FILES['slika']['type'];
		$tmp = $_FILES['slika']['tmp_name'];
		move_uploaded_file($tmp, "images/$nazivSlike");
		
		return "images/" . $nazivSlike;
	}
	
	function onemoguciXSS($text)
	{
		return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
	}
	
	function dodajNovostUCSV($novost)
	{
		$novosti = fopen("novosti.csv", "a");
	    
		fputcsv($novosti, $novost);
			
		fclose($novosti);
	}
	
	function postaviNovostULijevuSekciju()
	{
		if(validacijaForma() != 0) return validacijaForma();
		
		$naslovNovosti = onemoguciXSS($_POST['naslov']);
		$putDoSlike = izvrsiUploadSlike();
		$opisSlike = onemoguciXSS($_POST['opisSlike']);
		$text = onemoguciXSS($_POST['sadrzaj']);
		$datum = date("Y-m-d G:i:s");
		
		str_replace(",",";",$text);
		$text = nl2br($text);
		$text = trim(preg_replace('/\s+/', ' ', $text));
		
		$novost = array("postLijevaSekcija", $datum, $naslovNovosti, $putDoSlike, $opisSlike, $text);
		
		dodajNovostUCSV($novost);
		
		return 0;
	}
	
	function postaviNovostUDesnuSekciju()
	{
		if(validacijaForma() != 0) return validacijaForma();
		
		$naslovNovosti = onemoguciXSS($_POST['naslov']);
		$putDoSlike = izvrsiUploadSlike();
		$opisSlike = onemoguciXSS($_POST['opisSlike']);
		$text = onemoguciXSS($_POST['sadrzaj']);
		$datum = date("Y-m-d G:i:s");
		
		str_replace(",",";",$text);
		$text = nl2br($text);
		$text = trim(preg_replace('/\s+/', ' ', $text));
		
		$novost = array("postDesnaSekcija", $datum, $naslovNovosti, $putDoSlike, $opisSlike, $text);
		
		dodajNovostUCSV($novost);
	}
	
	

?>