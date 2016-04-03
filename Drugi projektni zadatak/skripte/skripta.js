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

// ========================== Validacija forme ==================================================

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