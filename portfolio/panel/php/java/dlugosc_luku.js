function ObliczDlugoscLuku()
{
	//alert('licze');
	var szerokoscInput = document.getElementById('szerokosc');
	var wysokoscInput = document.getElementById('wysokosc');
	
	var szerokosc = szerokoscInput.value;
		szerokosc = String(szerokosc);
		szerokosc = szerokosc.replace(",", ".")
		szerokoscInput.value=szerokosc;
	var wysokosc = wysokoscInput.value;
		wysokosc = String(wysokosc);
		wysokosc = wysokosc.replace(",", ".")
		wysokoscInput.value=wysokosc;
	
	//alert('szerokosc='+szerokosc);
	var dlugosc, sin_alfa, promien;
	
	if((szerokosc != 0) && (wysokosc != 0))
		{
		promien = (((0.25*szerokosc*szerokosc)+(wysokosc*wysokosc))/(2*wysokosc));
		sin_alfa = (szerokosc*0.5)/promien;
		//waga = waga.toFixed(2);
		sin_alfa = sin_alfa.toFixed(3);
		kat = Sinus(sin_alfa);
		dlugosc = (3.14*promien*2*kat)/180+25;
		
		//alert('kat='+kat+'wynik_sinus='+wynik_sinus);
		//alert('promien='+promien+'sin_alfa='+sin_alfa);
		dlugosc = dlugosc.toFixed(1);
		promien = promien.toFixed(1);
		document.forms['dlugosc_luku2'].dlugosc_luku.value = dlugosc;
		document.forms['dlugosc_luku2'].promien.value = promien;
		//document.forms['dlugosc_luku2'].sinus.value = sin_alfa;
		//document.forms['dlugosc_luku2'].kat.value = kat;
		
		var wysokosc2 = wysokosc*2;
		if(wysokosc2 > szerokosc) B6 = 'Łuk wg szablonu';
		else if(wysokosc2 < szerokosc) B6 = 'Łuk wycinkowy';
		else B6 = 'Łuk pókolisty';
		document.forms['dlugosc_luku2'].luk.value = B6;
		document.forms['dlugosc_luku2'].rodzaj_luku.value = B6;
	}
}
	
	
