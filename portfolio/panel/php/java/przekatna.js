function ObliczPrzekatna()
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
	var przekatna;
	
	if((szerokosc != 0) && (wysokosc != 0))
		{

		przekatna = Math.sqrt(szerokosc*szerokosc + wysokosc*wysokosc);


		przekatna = przekatna.toFixed(2);
		document.forms['przekatna'].przekatna.value = przekatna;
		
	}
}
	
	
