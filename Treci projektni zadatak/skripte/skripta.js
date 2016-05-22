// ========================== Postavljanje vremena objave =======================================

function azurirajVrijemeObjave()
{
	var datumiObjave = document.getElementsByClassName("datumObjave");
	var razlikeDatumiObjave = document.getElementsByClassName("porukaODatumuObjave");	
	var brojElemenata = datumiObjave.length;
	var datumObjave;
	var trenutniDateTime = new Date();
	var minute;
	var sati;
	for(var i=0; i<brojElemenata; i++)
	{
		datumObjave = new Date(datumiObjave[i].innerHTML.toString());
		var razlika = Math.round((trenutniDateTime - datumObjave)/1000); //Razlika u sekundama
		
		if(razlika < 60)
			razlikeDatumiObjave[i].innerHTML = "Novost objavljena prije par sekundi";
		else if(razlika < 3600)
		{
			minute = Math.round(razlika/60);
			if(minute > 10 && minute <= 20)
				razlikeDatumiObjave[i].innerHTML = "Novost objavljena prije " + minute.toString() + " minuta";	
			else if (minute%10 == 1)
				razlikeDatumiObjave[i].innerHTML = "Novost objavljena prije " + minute.toString() + " minutu";
			else if(minute%10 >= 5 || minute%10 == 0)
				razlikeDatumiObjave[i].innerHTML = "Novost objavljena prije " + minute.toString() + " minuta";
			else
				razlikeDatumiObjave[i].innerHTML = "Novost objavljena prije " + minute.toString() + " minute";
		
		}
		else if(razlika < 86400)
		{
			sati = Math.round(razlika/3600);
			if(sati>10 && sati <= 20)
				razlikeDatumiObjave[i].innerHTML = "Novost objavljena prije " + sati.toString() + " sati";
			else if (sati%10 == 1)
				razlikeDatumiObjave[i].innerHTML = "Novost objavljena prije " + sati.toString() + " sat";
			else if(sati%10 >= 5 || sati%10 == 0)
				razlikeDatumiObjave[i].innerHTML = "Novost objavljena prije " + sati.toString() + " sati";
			else
				razlikeDatumiObjave[i].innerHTML = "Novost objavljena prije " + sati.toString() + " sata";
	
		}
		else if(razlika < 604800)
		{
			dani = Math.round(razlika/86400);
			if (dani%10 == 1 && dani != 11)
				razlikeDatumiObjave[i].innerHTML = "Novost objavljena prije " + dani.toString() + " dan";
			else
				razlikeDatumiObjave[i].innerHTML = "Novost objavljena prije " + dani.toString() + " dana";
		
		}
		else if(razlika < 2592000)
		{
			sedmice = Math.round(razlika/604800);
			if (sedmice%10 == 1)
				razlikeDatumiObjave[i].innerHTML = "Novost objavljena prije " + sedmice.toString() + " sedmicu";
			else if(sedmice%10 >= 5 || sedmice%10 == 0)
				razlikeDatumiObjave[i].innerHTML = "Novost objavljena prije " + sedmice.toString() + " sedmica";
			else
				razlikeDatumiObjave[i].innerHTML = "Novost objavljena prije " + sedmice.toString() + " sedmice";
		
		}
		else 
		{
			razlikeDatumiObjave[i].innerHTML = "Novost objavljena na datum: " +" "+ (datumObjave.getDay() == 0 ? "Ned," : datumObjave.getDay() == 1 ? "Pon," : datumObjave.getDay() == 2 ? "Uto," : datumObjave.getDay() == 3 ? "Sri," : datumObjave.getDay() == 4 ? "Čet," : datumObjave.getDay() == 5 ? "Pet," : "Sub,") +" "+(datumObjave.toDateString()).substring(3);
		}
		
	}

}

// ========================== Filtriranje objava ================================================

var ime, prezime, email, poruka;

function filtriraj(value){
	
	var objaveLijevaSekcija = document.getElementsByClassName("postLijevaSekcija");
	var objaveDesnaSekcija = document.getElementsByClassName("postDesnaSekcija");
	
	var brojElemenataL = objaveLijevaSekcija.length;
	var brojElemenataR = objaveDesnaSekcija.length;
	var datumObjave;
	var trenutniDateTime = new Date();

	switch(value.toString())
	{
		case "danas": {
							for(var i=0; i<brojElemenataL; i++)
							{
								datumObjave = new Date(objaveLijevaSekcija[i].getElementsByClassName("datumObjave")[0].innerHTML.toString());
								var razlika = Math.round((trenutniDateTime - datumObjave)/1000); //Razlika u sekundama
								
								if(razlika > 86400)
									objaveLijevaSekcija[i].style.display = "none";
								else
									objaveLijevaSekcija[i].style.display = "block";
							
							}
							for(var i=0; i<brojElemenataR; i++)
							{
								datumObjave = new Date(objaveDesnaSekcija[i].getElementsByClassName("datumObjave")[0].innerHTML.toString());
								var razlika = Math.round((trenutniDateTime - datumObjave)/1000); //Razlika u sekundama
								
								if(razlika > 86400)
									objaveDesnaSekcija[i].style.display = "none";
								else
									objaveDesnaSekcija[i].style.display = "block";
							
							}
							break;
									
		}
		
		case "ovasedmica": {
								var brojDana = trenutniDateTime.getDay();
								var datumPonedjeljka = trenutniDateTime;
								datumPonedjeljka.setDate(trenutniDateTime.getDate() - brojDana + (brojDana == 0 ? -6:1));
								datumPonedjeljka.setHours(0,0,0,0);
			
								
								for(var i=0; i<brojElemenataL; i++)
								{
									datumObjave = new Date(objaveLijevaSekcija[i].getElementsByClassName("datumObjave")[0].innerHTML.toString());
								
									if(datumObjave > datumPonedjeljka)
										objaveLijevaSekcija[i].style.display = "block";
									else
										objaveLijevaSekcija[i].style.display = "none";
								
								}
								
								for(var i=0; i<brojElemenataR; i++)
								{
									datumObjave = new Date(objaveDesnaSekcija[i].getElementsByClassName("datumObjave")[0].innerHTML.toString());
									
									if(datumObjave > datumPonedjeljka)
										objaveDesnaSekcija[i].style.display = "block";
									else
										objaveDesnaSekcija[i].style.display = "none";
								
								}
							break;
		}
		
		case "ovajmjesec": {
								var prviDanMjeseca = trenutniDateTime;
								prviDanMjeseca.setDate(1);
								prviDanMjeseca.setHours(0,0,0,0);
							
								for(var i=0; i<brojElemenataL; i++)
								{
									datumObjave = new Date(objaveLijevaSekcija[i].getElementsByClassName("datumObjave")[0].innerHTML.toString());
								
									if(datumObjave > prviDanMjeseca)
										objaveLijevaSekcija[i].style.display = "block";
									else
										objaveLijevaSekcija[i].style.display = "none";
								
								}
								for(var i=0; i<brojElemenataR; i++)
								{
									datumObjave = new Date(objaveDesnaSekcija[i].getElementsByClassName("datumObjave")[0].innerHTML.toString());
		
									if(datumObjave > prviDanMjeseca)
										objaveDesnaSekcija[i].style.display = "block";
									else
										objaveDesnaSekcija[i].style.display = "none";
								
								}
							break;
			
		}
		
		case "sve": {
						for(var i=0; i<brojElemenataL; i++)
						{									
							objaveLijevaSekcija[i].style.display = "block";								
						}	
						for(var i=0; i<brojElemenataR; i++)
						{
							objaveDesnaSekcija[i].style.display = "block";							
						}
					break;
		}
	}
	
}

// ========================== Validacija forme za kontakt ==================================================

function validacijaImena(value)
{
	if(value.length < 3)
	{
		document.getElementById("ime").style.backgroundColor = "red";
		return false;
	}
	else{
		document.getElementById("ime").style.backgroundColor = "white";
		return true;
	}
}

function validacijaPrezimena(value)
{
	if(value.length < 3)
	{
		document.getElementById("prezime").style.backgroundColor = "red";
		return false;
	}
	else{
		document.getElementById("prezime").style.backgroundColor = "white";
		return true;
	

	}
}

function validacijaEmaila(value)
{
	var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	
	if(value.match(regex))
	{
		document.getElementById("email").style.backgroundColor = "white";
		
		if(document.getElementById("ponovniMail").value != "" && document.getElementById("ponovniMail").value != value)
		{
			document.getElementById("ponovniMail").style.backgroundColor = "red";
		}
		else
		{
			document.getElementById("ponovniMail").style.backgroundColor = "white";
			
		}
		
		return true;
	}
	else{
		
		document.getElementById("email").style.backgroundColor = "red";
		
		return false;
	}
	
}

function validacijaPonovljenogMaila(value)
{
	if(validacijaEmaila(document.getElementById("email").value))
	{
		if(value == document.getElementById("email").value)
		{
			document.getElementById("ponovniMail").style.backgroundColor = "white";
			return true;
		}
		else
		{
			document.getElementById("ponovniMail").style.backgroundColor = "red";
			return false;
		}
	}
}

function validacijaPoruke(value)
{
	if(value == "")
	{
		document.getElementById("poruka").style.backgroundColor = "red";
		return false;
	}
	else{
		document.getElementById("poruka").style.backgroundColor = "white";
		return true;

	}
}

function validirajNakonSubmita()
{
	if(!validacijaImena(document.getElementById("ime").value))
	{
		alert("Ime mora sadržavati više od 3 znaka.");
		return;
	}
	else if(!validacijaPrezimena(document.getElementById("prezime").value))
	{
		alert("Prezime mora sadržavati više od 3 znaka.");
		return;
	}
	else if(!validacijaEmaila(document.getElementById("email").value))
	{
		alert("Email mora biti u formatu korisnicko_ime@domena.");
		return;
	}
	else if(validacijaEmaila(document.getElementById("email").value) && !validacijaPonovljenogMaila(document.getElementById("ponovniMail").value))
	{
		
		  alert("Email mora biti ponovljen.");
		  return;
	}
	else if(!validacijaPoruke(document.getElementById("poruka").value))
	{
		alert("Nije moguće poslati praznu poruku.");
		return;
	}
}

// ============================= Validacija forme za unos novosti =======================================

var validneEkstenzije = [".jpg", ".jpeg", ".bmp", ".gif", ".png"]; 

function validirajNaslovPosta(naslov)
{
	if(naslov.length < 3)
		return false;
	else return true;
}

function validirajUploadSlike(nazivFajla)
{
	if (nazivFajla.length > 0) {
                var validnaEx = false;
                for (var j = 0; j < validneEkstenzije.length; j++) 
				{
                    var trenutnaEx = validneEkstenzije[j];
                    if (nazivFajla.substr(nazivFajla.length - trenutnaEx.length, trenutnaEx.length).toLowerCase() == trenutnaEx.toLowerCase()) {
                        validnaEx = true;
                        break;
                    }
                }             
                if (!validnaEx) {
                    return false;
                }
				
				return true;
            }
}

function validirajOpisSlike(opis)
{
	if(opis.length < 3)
		return false;
	else return true;
}

function validirajSadrzajPosta(sadrzaj)
{
	if(sadrzaj.length < 10)
		return false;
	else return true;
}

function dajPodatkeZaKodDrzave(kodDrzave, callback, telPozivni, poruka)
{
	
	var xmlhttp = new XMLHttpRequest();
        
		xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				return callback(xmlhttp.responseText, telPozivni, poruka);
            }
        };
        xmlhttp.open("GET", "https://restcountries.eu/rest/v1/alpha?codes=" + kodDrzave, true);
        xmlhttp.send();
	
}
function uporediPozivniTelIPozivniZaKodDrzave(telPozivni, kodDrzavePozivni, poruka)
{
	if(telPozivni.substring(1) != kodDrzavePozivni || telPozivni.substring(0,1) != '+') 
	{
		poruka.innerHTML = "Kod drzave i telefon se ne slažu! Telefon mora biti u formatu +pozivni_broj brojTelefona!";
		return false;
	}
	else{
		poruka.innerHTML = "";
		return true;
	}
}
function ajaxUpitZavrsen(podaci, telPozivni, poruka)
{
	var formatirani = JSON.parse(podaci);
	
	if(formatirani[0])
		return uporediPozivniTelIPozivniZaKodDrzave(telPozivni, formatirani[0]["callingCodes"], poruka)
	else
		return uporediPozivniTelIPozivniZaKodDrzave(telPozivni, "", poruka)
	
}

function validirajTelefonLijevo(kodDrzave)
{
	var broj = document.getElementById("telBrojLijevo").value;
	tel = broj.split("/")[0];
	var poruka = document.getElementById("porukaLijevo");
	
	if(tel != "")
	return dajPodatkeZaKodDrzave(kodDrzave, ajaxUpitZavrsen, tel, poruka);
}

function validirajKodDrzaveLijevo(tel)
{
	var kodDrzave = document.getElementById("kodDrzaveLijevo").value;
	var poruka = document.getElementById("porukaLijevo");
	tel = tel.split("/")[0];
	if(kodDrzave != "")
	dajPodatkeZaKodDrzave(kodDrzave, ajaxUpitZavrsen, tel, poruka);

}

function validirajTelefonDesno(kodDrzave)
{
	var broj = document.getElementById("telBrojDesno").value;
	var poruka = document.getElementById("porukaDesno");
	
	if(tel != "")
	dajPodatkeZaKodDrzave(kodDrzave, ajaxUpitZavrsen, tel, poruka);
}

function validirajKodDrzaveDesno(tel)
{
	var kodDrzave = document.getElementById("kodDrzaveDesno").value;
	var poruka = document.getElementById("porukaDesno");
	if(kodDrzave != "")
	dajPodatkeZaKodDrzave(kodDrzave, ajaxUpitZavrsen, tel, poruka);

}

function validirajFormuZaNovostDesno()
{
	
	if(!validirajNaslovPosta(document.getElementById("naslovDesno").value))
	{
		document.getElementById("porukaDesno").innerHTML = "Naslov mora biti bar 3 znaka!";
		return false;
	}
	else if(!validirajUploadSlike(document.getElementById("slikaDesno").value))
	{
		document.getElementById("porukaDesno").innerHTML = "Fajl nije izabran ili nema validnu ekstenziju! Validne ekstenzije su: " + validneEkstenzije.join(", ");
		return false;
	}
	else if(!validirajOpisSlike(document.getElementById("opisSlikeDesno").value))
	{
		document.getElementById("porukaDesno").innerHTML = "Opis slike mora biti bar 3 znaka!";
		return false;
	}
	else if(document.getElementById("kodDrzaveDesno").value == "")
	{
		document.getElementById("porukaDesno").innerHTML = "Dvoslovni kod države ne može biti prazan!";
		return false;
	}
	else if(document.getElementById("telBrojDesno").value == "")
	{
		document.getElementById("porukaDesno").innerHTML = "Telefonski broj autora ne može biti prazano polje!";
		return false;
	}
	else if(document.getElementById("porukaDesno").innerHTML == "Kod drzave i telefon se ne slažu! Telefon mora biti u formatu pozivni_broj/brojTelefona!")
	{
		return false;
	}
	else if(document.getElementById("BrojDesno").value.length == 0)
	{
		document.getElementById("porukaDesno").innerHTML = "Telefonski broj ne može biti prazno polje!";
		return false;
	}
	else if(!validirajSadrzajPosta(document.getElementById("sadrzajPostaDesno").value))
	{
		document.getElementById("porukaDesno").innerHTML = "Sadrzaj novosti mora biti bar 10 znakova!";
		return false;
	}
	
	return true;
}

function validirajFormuZaNovostLijevo()
{

	if(!validirajNaslovPosta(document.getElementById("naslovLijevo").value))
	{
		document.getElementById("porukaLijevo").innerHTML = "Naslov mora biti bar 3 znaka!";
		return false;
	}
	else if(!validirajUploadSlike(document.getElementById("slikaLijevo").value))
	{
		document.getElementById("porukaLijevo").innerHTML = "Fajl nije izabran ili nema validnu ekstenziju! Validne ekstenzije su: " + validneEkstenzije.join(", ");
		return false;
	}
	else if(!validirajOpisSlike(document.getElementById("opisSlikeLijevo").value))
	{
		document.getElementById("porukaLijevo").innerHTML = "Opis slike mora biti bar 3 znaka!";
		return false;
	}
	else if(document.getElementById("kodDrzaveLijevo").value == "")
	{
		document.getElementById("porukaLijevo").innerHTML = "Dvoslovni kod države ne može biti prazan!";
		return false;
	}
	else if(document.getElementById("telBrojLijevo").value == "")
	{
		document.getElementById("porukaLijevo").innerHTML = "Telefonski broj autora ne može biti prazano polje!";
		return false;
	}
	else if(document.getElementById("porukaLijevo").innerHTML == "Kod drzave i telefon se ne slažu! Telefon mora biti u formatu pozivni_broj/brojTelefona!")
	{
		return false;
	}
	else if(document.getElementById("BrojLijevo").value.length == 0)
	{
		document.getElementById("porukaLijevo").innerHTML = "Telefonski broj ne može prazno polje!";
		return false;
	}
	else if(!validirajSadrzajPosta(document.getElementById("sadrzajPostaLijevo").value))
	{
		document.getElementById("porukaLijevo").innerHTML = "Sadrzaj novosti mora biti bar 10 znakova!";
		return false;
	}
	
	return true;
}

//=========================================================== Sortiranje objava =================================

function posaljiPodatak(value)
{
	window.location.assign("http://localhost/index.php?sortiranje=" + value.toString());
}