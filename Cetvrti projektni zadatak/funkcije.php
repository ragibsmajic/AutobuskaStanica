<?php
	
	include 'db_konfiguracija.php';
	
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
	
	function dajImeKorisnika()
	{
		return $_SESSION['imeAutora'] . " " . $_SESSION['prezimeAutora'];
	}
	
	function provjeriUserNamePass()
	{
		$userName = $_POST['username'];
		$pass = sha1($_POST['password']);
		
		global $db_conn;
		
		$stmt = $db_conn->prepare("SELECT * FROM korisnici WHERE userName = ? AND password = ?");
		$stmt->bind_param("ss", $userName, $pass);
		
		$stmt->execute();
		
		$result = $stmt->get_result();
		
		if ($result) 
		{
			if($result->num_rows != 0)
			{
					$autor = $result->fetch_row();
					$_SESSION['username'] = $_POST['username'];
					$_SESSION['idAutora'] = $autor[0];
					$_SESSION['imeAutora'] = $autor[1];
					$_SESSION['prezimeAutora'] = $autor[2];
					$_SESSION['administrator'] = $autor[6];
					return true;
			}
		
		} else {
				die("Greška u čitanju podataka: " . $sql . $db_conn->error);	
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
	
	function sortirajKomentare($komentari)
	{
		$datumiKomentara = array();
		
		foreach($komentari as $komentar)
		{
			$datumiKomentara[] = $komentar[4];
		}
		
		array_multisort($datumiKomentara, SORT_DESC, $komentari);
		
		return $komentari;
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
	
	function dajNovostiLijeveSekcije($sortiranje)
	{
		
		$novostiLijeveSekcije = array();
		
		global $db_conn;
		$sql = "SELECT * FROM novosti WHERE nazivSekcije = 'postLijevaSekcija'";
		
		if ($result = $db_conn->query($sql)) 
		{
			while($red = $result->fetch_row()) 
			$novostiLijeveSekcije[]=$red;
		
		} else {
				die("Greška u čitanju podataka: " . $sql . $db_conn->error);
				
		}
		
		if($sortiranje == 0)
		{
			return sortirajPoDatumu($novostiLijeveSekcije);
		}
		else
			return sortirajAbecednoPoNaslovu($novostiLijeveSekcije);
	}
	
	function dajNovostiLijeveSekcijeAutoraPoID($idAutora, $sortiranje)
	{
		
		$novostiLijeveSekcije = array();
		
		global $db_conn;
		$sql = "SELECT * FROM novosti WHERE nazivSekcije = 'postLijevaSekcija' AND idAutora=$idAutora";
		
		if ($result = $db_conn->query($sql)) 
		{
			while($red = $result->fetch_row()) 
			$novostiLijeveSekcije[]=$red;
		
		} else {
				die("Greška u čitanju podataka: " . $sql . $db_conn->error);
				
		}
		
		if($sortiranje == 0)
		{
			return sortirajPoDatumu($novostiLijeveSekcije);
		}
		else
			return sortirajAbecednoPoNaslovu($novostiLijeveSekcije);
	}
	
	function dajNovostiLijeveSekcijeAutora($sortiranje)
	{
		
		$novostiLijeveSekcije = array();
		$idAutora = $_SESSION['idAutora'];
		global $db_conn;
		$sql = "SELECT * FROM novosti WHERE nazivSekcije = 'postLijevaSekcija' AND idAutora = $idAutora";
		
		if ($result = $db_conn->query($sql)) 
		{
			while($red = $result->fetch_row()) 
			$novostiLijeveSekcije[]=$red;
		
		} else {
				die("Greška u čitanju podataka: " . $sql . $db_conn->error);
				
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
		$novostiDesneSekcije = array();
		
		global $db_conn;
		$sql = "SELECT * FROM novosti WHERE nazivSekcije = 'postDesnaSekcija'";
		
		if ($result = $db_conn->query($sql)) 
		{
			while($red = $result->fetch_row()) 
			$novostiDesneSekcije[]=$red;
		
		} else {
				die("Greška u čitanju podataka: " . $sql . $db_conn->error);
				
		}
		
		if($sortiranje == 0)
		{
			return sortirajPoDatumu($novostiDesneSekcije);
		}
		else
			return sortirajAbecednoPoNaslovu($novostiDesneSekcije);
	}
	
	function dajNovostiDesneSekcijeAutoraPoID($idAutora, $sortiranje)
	{
		$novostiDesneSekcije = array();
		
		global $db_conn;
		$sql = "SELECT * FROM novosti WHERE nazivSekcije = 'postDesnaSekcija' AND idAutora = $idAutora";
		
		if ($result = $db_conn->query($sql)) 
		{
			while($red = $result->fetch_row()) 
			$novostiDesneSekcije[]=$red;
		
		} else {
				die("Greška u čitanju podataka: " . $sql . $db_conn->error);
				
		}
		
		if($sortiranje == 0)
		{
			return sortirajPoDatumu($novostiDesneSekcije);
		}
		else
			return sortirajAbecednoPoNaslovu($novostiDesneSekcije);
	}
	
	function dajNovostiDesneSekcijeAutora($sortiranje)
	{
		$novostiDesneSekcije = array();
		$idAutora = $_SESSION['idAutora'];
		global $db_conn;
		$sql = "SELECT * FROM novosti WHERE nazivSekcije = 'postDesnaSekcija' AND idAutora = $idAutora";
		
		if ($result = $db_conn->query($sql)) 
		{
			while($red = $result->fetch_row()) 
			$novostiDesneSekcije[]=$red;
		
		} else {
				die("Greška u čitanju podataka: " . $sql . $db_conn->error);
				
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
	
	function dodajNovostUBazu($sekcija, $naslov, $putDoSlike, $opisSlike, $textNovosti, $datum, $moguciKomentari)
	{
		global $db_conn;
		$idAutora = $_SESSION['idAutora'];

		$sql = "INSERT INTO novosti (nazivSekcije, naslovNovosti, putDoSlike, opisSlike, textNovosti, datumPostavljanja, idAutora, imaKomentare)
					VALUES('$sekcija', '$naslov', '$putDoSlike', '$opisSlike', '$textNovosti', '$datum', $idAutora, $moguciKomentari)";
		
		if ($db_conn->query($sql) === FALSE)
			"Greška: " . $sql . "<br>" . $db_conn->error;
	}
	
	function postaviNovostULijevuSekciju()
	{
		if(validacijaForma() != 0) return validacijaForma();
		
		$naslovNovosti = onemoguciXSS($_POST['naslov']);
		$putDoSlike = izvrsiUploadSlike();
		$opisSlike = onemoguciXSS($_POST['opisSlike']);
		$text = onemoguciXSS($_POST['sadrzaj']);
		
		$moguciKomentari = 0;
		
		if(isset($_POST['otvorenoZaKomentare']))
			$moguciKomentari = 1; 
			
		date_default_timezone_set("Europe/Sarajevo");
		$datum = date("Y-m-d G:i:s");
		
		$text = nl2br($text);
		$text = trim(preg_replace('/\s+/', ' ', $text));
		
		dodajNovostUBazu("postLijevaSekcija", $naslovNovosti, $putDoSlike, $opisSlike, $text, $datum, $moguciKomentari);
		
		return 0;
	}
	
	function postaviNovostUDesnuSekciju()
	{
		if(validacijaForma() != 0) return validacijaForma();
		
		$naslovNovosti = onemoguciXSS($_POST['naslov']);
		$putDoSlike = izvrsiUploadSlike();
		$opisSlike = onemoguciXSS($_POST['opisSlike']);
		$text = onemoguciXSS($_POST['sadrzaj']);
		
		$moguciKomentari = 0;
		
		if(isset($_POST['otvorenoZaKomentare']))
			$moguciKomentari = 1; 
		
		date_default_timezone_set("Europe/Sarajevo");
		$datum = date("Y-m-d G:i:s");

		$text = nl2br($text);
		$text = trim(preg_replace('/\s+/', ' ', $text));
		
		dodajNovostUBazu("postDesnaSekcija", $naslovNovosti, $putDoSlike, $opisSlike, $text, $datum, $moguciKomentari);

	}
	
	function dajNovostPoId($idNovosti)
	{
		$novosti = array();
		
		global $db_conn;
		$sql = "SELECT * FROM novosti WHERE idNovosti = $idNovosti";
		
		if ($result = $db_conn->query($sql)) 
		{
			while($red = $result->fetch_row()) 
			$novosti[]=$red;
		
		} else {
				die("Greška u čitanju podataka: " . $sql . $db_conn->error);		
		}
		
		return $novosti;
	}
	
	function dajKomentareNaNovost($idNovosti)
	{
		$komentariAutora = array();
		
		global $db_conn;
	
		$sql = "SELECT k.idKomentara idKomentara, a.imeAutora, a.prezimeAutora, 
					   k.textKomentara textKom, k.vrijemePostavljanja vrijemePost, ( select Count(k1.idKomentara)
																					 from komentari k1
																					 where k1.roditeljKomentar = k.idKomentara 
																					) brojOdgovora
				FROM korisnici a, komentari k
				WHERE a.idAutora = k.idAutora AND k.roditeljKomentar IS NULL AND k.idNovosti = $idNovosti";
		
		if ($result = $db_conn->query($sql)) 
		{
			while($red = $result->fetch_row()) 
			$komentariAutora[]=$red;
		
		} else {
				die("Greška u čitanju podataka: " . $sql . $db_conn->error);		
		}
		
		$sql = "SELECT k.idKomentara idKomentara, k.idKomentara, k.idKomentara, 
					   k.textKomentara textKom, k.vrijemePostavljanja vrijemePost, ( select Count(k1.idKomentara)
																					 from komentari k1
																					 where k1.roditeljKomentar = k.idKomentara 
																					) brojOdgovora
				FROM komentari k
				WHERE k.idAutora IS NULL AND k.roditeljKomentar IS NULL AND k.idNovosti = $idNovosti";
		
		$komentariGostiju = array();
		if ($result = $db_conn->query($sql)) 
		{
			while($red = $result->fetch_row()) 
			$komentariGostiju[]=$red;
		
		} else {
				die("Greška u čitanju podataka: " . $sql . $db_conn->error);		
		}
		
		$komentari = array();
		
		foreach($komentariAutora as $komentar)
		$komentari[] = $komentar;
		
		foreach($komentariGostiju as $komentar)
		{
			$komentar[1] = null;
			$komentar[2] = null;
			$komentari[] = $komentar;
		}
		
		return sortirajKomentare($komentari);
		
	}
	
	function dajOdgovoreNaKomentar($idKomentara)
	{
		$komentariAutora = array();
		
		global $db_conn;
		
		$sql = "SELECT k.idKomentara idKomentara, a.imeAutora, a.prezimeAutora, 
					   k.textKomentara textKom, k.vrijemePostavljanja vrijemePost
				FROM korisnici a, komentari k
				WHERE a.idAutora = k.idAutora AND k.roditeljKomentar = $idKomentara";
		
		if ($result = $db_conn->query($sql)) 
		{
			while($red = $result->fetch_row()) 
			$komentariAutora[]=$red;
		
		} else {
				die("Greška u čitanju podataka: " . $sql . $db_conn->error);		
		}
		
		$komentariGostiju = array();
		
		$sql = "SELECT k.idKomentara idKomentara, k.idKomentara, k.idKomentara, 
					   k.textKomentara textKom, k.vrijemePostavljanja vrijemePost
				FROM  komentari k
				WHERE k.idAutora IS NULL AND k.roditeljKomentar = $idKomentara";
		
		if ($result = $db_conn->query($sql)) 
		{
			while($red = $result->fetch_row()) 
			$komentariGostiju[]=$red;
		
		} else {
				die("Greška u čitanju podataka: " . $sql . $db_conn->error);		
		}
		
		$komentari = array();
		
		foreach($komentariAutora as $komentar)
		$komentari[] = $komentar;
		
		foreach($komentariGostiju as $komentar)
		{
			$komentar[1] = null;
			$komentar[2] = null;
			$komentari[] = $komentar;
		}
		
		return sortirajKomentare($komentari);

	}
	
	function dodajKomentarNaNovost($idNovosti, $textKomentara)
	{
		date_default_timezone_set("Europe/Sarajevo");
		$datum = date("Y-m-d G:i:s");
		$idAutora = null;
		global $db_conn;
		if(provjeriDaLiJePrijavljen())
		$idAutora = $_SESSION['idAutora'];
		if($idAutora!= null)
		$sql = "INSERT INTO komentari (idNovosti, idAutora, textKomentara, vrijemePostavljanja)
					VALUES('$idNovosti', '$idAutora', '$textKomentara', '$datum')";
		else
			$sql = "INSERT INTO komentari (idNovosti, textKomentara, vrijemePostavljanja)
					VALUES('$idNovosti', '$textKomentara', '$datum')";
		
		if ($db_conn->query($sql) === FALSE)
			"Greška: " . $sql . "<br>" . $db_conn->error;
	}
	
	function dodajOdgovorNaKomentar($textOdgovora, $roditeljKomentar, $idNovosti)
	{
		date_default_timezone_set("Europe/Sarajevo");
		$datum = date("Y-m-d G:i:s");
		$idAutora = null;
		global $db_conn;
		if(provjeriDaLiJePrijavljen())
			$idAutora = $_SESSION['idAutora'];
		
		if(!is_null($idAutora))
			$sql = "INSERT INTO komentari (idNovosti, idAutora, textKomentara,roditeljKomentar, vrijemePostavljanja)
					VALUES('$idNovosti', '$idAutora', '$textOdgovora', '$roditeljKomentar', '$datum')";
		else
			$sql = "INSERT INTO komentari (idNovosti, textKomentara,roditeljKomentar, vrijemePostavljanja)
					VALUES('$idNovosti', '$textOdgovora', '$roditeljKomentar', '$datum')";
		
		if ($db_conn->query($sql) === FALSE)
			"Greška: " . $sql . "<br>" . $db_conn->error;
	}
	
	function dajKomentareNaNovostiAutora()
	{
		$idAutora = $_SESSION['idAutora'];
		
		$brojNevidenih = array();
		
		global $db_conn;
		
		$sql = "SELECT Count(k.idKomentara), n.idNovosti
				FROM novosti n, komentari k
				WHERE n.idNovosti = k.idNovosti AND k.komentarViden = 0 AND n.idAutora = $idAutora
				GROUP BY n.idNovosti";
		
		if ($result = $db_conn->query($sql)) 
		{
			while($red = $result->fetch_row()) 
			$brojNevidenih[]=$red;
		
		} else {
				die("Greška u čitanju podataka: " . $sql . $db_conn->error);		
		}
		
		return $brojNevidenih;
	}
	
	function daLiJeAutorNovosti($idNovosti, $idAutora)
	{
		global $db_conn;
		
		$sql = "SELECT *
				FROM novosti
				WHERE idNovosti = $idNovosti AND idAutora = $idAutora";
		
		$novosti = array();
		
		if ($result = $db_conn->query($sql)) 
		{
			while($red = $result->fetch_row()) 
			$novosti[]=$red;
		
		} else {
				die("Greška u čitanju podataka");		
		}
		
		if(count($novosti) > 0) 
			return true;
		else 
			return false;
	}
	
	function postaviKomentareKaoVidene($idNovosti)
	{
		global $db_conn;
		
		$sql = "UPDATE komentari SET komentarViden = 1
				WHERE idNovosti = $idNovosti";
		
		if (!$db_conn->query($sql)) 
		{
			die("Greska!");
		}
	}
	
	function dajAutoraNovosti($idNovosti)
	{
		global $db_conn;
		
		$sql = "SELECT a.*
				FROM novosti n, korisnici a
				WHERE n.idNovosti = $idNovosti AND n.idAutora = a.idAutora";
		
		$autor = array();
		
		if ($result = $db_conn->query($sql)) 
		{
			while($red = $result->fetch_row()) 
			$autor[]=$red;
		
		} else {
				die("Greška u čitanju podataka");		
		}
		
		return $autor;
	}
	
	function dajPrijavljenogKorisnika()
	{
		global $db_conn;
		$idAutora = $_SESSION['idAutora'];
		
		$sql = "SELECT *
				FROM korisnici
				WHERE idAutora = $idAutora";
		
		$autor = array();
		
		if ($result = $db_conn->query($sql)) 
		{
			while($red = $result->fetch_row()) 
			$autor[]=$red;
		
		} else {
				die("Greška u čitanju podataka");		
		}
		
		return $autor[0];
	}
	
	function promijeniPasswordKorisnika($idAutora, $pass)
	{
		$sha1pass = sha1($pass);
		global $db_conn;
		$sql = "UPDATE korisnici SET password = '$sha1pass'
				WHERE idAutora = $idAutora";
		
		if (!$db_conn->query($sql)) 
		{
			die("Greska");
		} 
	}
	
	function dajSveNovostiSaAutorima()
	{
		global $db_conn;
		
		$sql = "SELECT n.idNovosti, n.naslovNovosti, a.imeAutora, a.prezimeAutora, n.datumPostavljanja, n.imaKomentare 
				FROM novosti n, korisnici a
				WHERE n.idAutora = a.idAutora";
		
		$novosti = array();
		
		if ($result = $db_conn->query($sql)) 
		{
			while($red = $result->fetch_row()) 
			$novosti[]=$red;
		
		} else {
				die("Greška u čitanju podataka");		
		}
		
		return $novosti;
	}
	
	function obrisiNovost($idNovosti)
	{
		global $db_conn;
		
		$sql = "DELETE FROM komentari WHERE idNovosti = $idNovosti AND roditeljKomentar IS NOT NULL";
		
		if (!$db_conn->query($sql)) 
		{
			die("Greška u brisanju komentara novosti!");
		} 
		
		$sql = "DELETE FROM komentari WHERE idNovosti = $idNovosti";
		
		if (!$db_conn->query($sql)) 
		{
			die("Greška u brisanju komentara novosti!");
		} 
		
		$sql = "DELETE FROM novosti WHERE idNovosti = $idNovosti";
		
		if (!$db_conn->query($sql)) 
		{
			die("Greška u brisanju novosti!");
		} 
	}
	
	function promijeniPravoKomentarisanja($idNovosti, $pravoKomentarisanja)
	{
		global $db_conn;
		$novoPravo = abs($pravoKomentarisanja - 1);
		$sql = "UPDATE novosti SET imaKomentare = $novoPravo WHERE idNovosti = $idNovosti";
		
		if (!$db_conn->query($sql)) 
		{
			die("Greška u brisanju komentara novosti!");
		} 
	}
	
	function dajSveAutore()
	{
		global $db_conn;
		
		$sql = "SELECT idAutora, userName, imeAutora, prezimeAutora, datumRegistracije 
				FROM korisnici
				WHERE administrator = 0";
		
		$autori = array();
		
		if ($result = $db_conn->query($sql)) 
		{
			while($red = $result->fetch_row()) 
			$autori[]=$red;
		
		} else {
				die("Greška u čitanju podataka");		
		}
		
		return $autori;
	}
	
	function obrisiAutora($idAutora)
	{
		global $db_conn;
		
		$sql = "DELETE FROM komentari WHERE idAutora = $idAutora AND roditeljKomentar IS NOT NULL";
		
		if (!$db_conn->query($sql)) 
		{
			die("Greška u brisanju komentara novosti!");
		} 
		
		$sql = "DELETE FROM komentari WHERE idAutora = $idAutora";
		
		if (!$db_conn->query($sql)) 
		{
			die("Greška u brisanju komentara novosti!");
		} 
		
		$sql = "DELETE FROM novosti WHERE idAutora = $idAutora";
		
		if (!$db_conn->query($sql)) 
		{
			die("Greška u brisanju novosti!");
		} 
		
		$sql = "DELETE FROM korisnici WHERE idAutora = $idAutora";
		
		if (!$db_conn->query($sql)) 
		{
			die("Greška u brisanju autora!");
		} 
	}
	
	function dajAutoraPoId($idAutora)
	{
		global $db_conn;
		
		$sql = "SELECT idAutora, imeAutora, prezimeAutora, userName, datumRegistracije 
				FROM korisnici
				WHERE idAutora = $idAutora";
		
		$autori = array();
		
		if ($result = $db_conn->query($sql)) 
		{
			while($red = $result->fetch_row()) 
			$autori[]=$red;
		
		} else {
				die("Greška u čitanju podataka");		
		}
		
		return $autori[0];
	}
	
	function spremiPromjeneAutora($idAutoraZaSpremit, $userName, $ime, $prezime)
	{
		global $db_conn;
		
		$sql = "UPDATE korisnici 
				SET userName = '$userName', imeAutora = '$ime', prezimeAutora = '$prezime'
				WHERE idAutora = $idAutoraZaSpremit";
		
		if (!$db_conn->query($sql)) 
		{
			die("Greška!");
		} 
	}
	
	function provjeriDaLiVecPostoji($userName)
	{
		global $db_conn;
		
		$sql = "SELECT * 
				FROM korisnici
				WHERE userName = '$userName'";
		
		$autori = array();
		
		if ($result = $db_conn->query($sql)) 
		{
			while($red = $result->fetch_row()) 
			$autori[]=$red;
		
		} else {
				die("Greška u čitanju podataka");		
		}
		
		if(count($autori) == 0) 
			return false;
		else 
			return true;
	}
	
	function provjeriDaLiVecPostojiBez($userName, $idAutora)
	{
		global $db_conn;
		
		$sql = "SELECT * 
				FROM korisnici
				WHERE userName = '$userName' AND idAutora != $idAutora";
		
		$autori = array();
		
		if ($result = $db_conn->query($sql)) 
		{
			while($red = $result->fetch_row()) 
			$autori[]=$red;
		
		} else {
				die("Greška u čitanju podataka");		
		}
		
		if(count($autori) == 0) 
			return false;
		else 
			return true;
	}
	
	function spremiAutora($userName, $Ime, $Prezime, $Password)
	{
		$pass = sha1($Password);
		
		date_default_timezone_set("Europe/Sarajevo");
		$datum = date("Y-m-d G:i:s");
		
		global $db_conn;
		
		$sql = "INSERT INTO korisnici (userName, imeAutora, prezimeAutora, password, datumRegistracije, administrator) 
								VALUES ('$userName', '$Ime', '$Prezime', '$pass', '$datum', 0)";
		
		if (!$db_conn->query($sql)) 
		{
			die("Greska!");
		}
	}
	
	function dajSveKomentare()
	{
		global $db_conn;
		
		$sql = "SELECT k.idKomentara, n.naslovNovosti, a.imeAutora, a.prezimeAutora, k.textKomentara, k.vrijemePostavljanja
				FROM korisnici a, novosti n, komentari k
				WHERE n.idNovosti = k.idNovosti AND a.idAutora = k.idAutora";
		
		$komentari = array();
		
		if ($result = $db_conn->query($sql)) 
		{
			while($red = $result->fetch_row()) 
			$komentari[]=$red;
		
		} else {
				die("Greška u čitanju podataka");		
		}
		
		$sql = "SELECT k.idKomentara, n.naslovNovosti, k.idKomentara, k.idKomentara, k.textKomentara, k.vrijemePostavljanja
				FROM novosti n, komentari k
				WHERE n.idNovosti = k.idNovosti AND k.idAutora IS NULL";
		
		if ($result = $db_conn->query($sql)) 
		{
			while($red = $result->fetch_row()) 
			{
				$red[2] = null;
				$red[3] = null;
				$komentari[]=$red;
			}
		
		} else {
				die("Greška u čitanju podataka");		
		}
		return $komentari;
	}
	
	function obrisiKomentar($idKomentara)
	{
		global $db_conn;
		
		$sql = "DELETE FROM komentari WHERE roditeljKomentar = $idKomentara";
		
		if (!$db_conn->query($sql)) 
		{
			die("Greška u brisanju komentara novosti!");
		} 
		
		$sql = "DELETE FROM komentari WHERE idKomentara = $idKomentara";
		
		if (!$db_conn->query($sql)) 
		{
			die("Greška u brisanju komentara novosti!");
		} 
	}
?>