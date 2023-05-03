function Oblicz_sume_doplaty(){
	//alert('licze Oblicz_sume_doplaty');
	var suma = 0;	
	var wartosc_wygiecie_wzmocnienia_okiennegoInput = document.getElementById('wartosc_wygiecie_wzmocnienia_okiennego');
	var wartosc_wygiecie_wzmocnienia_okiennego = wartosc_wygiecie_wzmocnienia_okiennegoInput.value;
	var wartosc_wygiecie_innego_elementuInput = document.getElementById('wartosc_wygiecie_innego_elementu');
	var wartosc_wygiecie_innego_elementu = wartosc_wygiecie_innego_elementuInput.value;
	var wartosc_wyfrezowanie_odwodnieniaInput = document.getElementById('wartosc_wyfrezowanie_odwodnienia');
	var wartosc_wyfrezowanie_odwodnienia = wartosc_wyfrezowanie_odwodnieniaInput.value;
	var wartosc_wstawienie_slupkaInput = document.getElementById('wartosc_wstawienie_slupka');
	var wartosc_wstawienie_slupka = wartosc_wstawienie_slupkaInput.value;
	var wartosc_dociecie_listwy_przyszybowejInput = document.getElementById('wartosc_dociecie_listwy_przyszybowej');
	var wartosc_dociecie_listwy_przyszybowej = wartosc_dociecie_listwy_przyszybowejInput.value;
	var wartosc_okucieInput = document.getElementById('wartosc_okucie');
	var wartosc_okucie = wartosc_okucieInput.value;
	var wartosc_zaszklenieInput = document.getElementById('wartosc_zaszklenie');
	var wartosc_zaszklenie = wartosc_zaszklenieInput.value;
	var wartosc_wykonanie_innej_uslugiInput = document.getElementById('wartosc_wykonanie_innej_uslugi');
	var wartosc_wykonanie_innej_uslugi = wartosc_wykonanie_innej_uslugiInput.value;
	var material_doplatyInput = document.getElementById('material_doplaty');
	var material_doplaty = material_doplatyInput.value;

	suma = Number(material_doplaty) + Number(wartosc_wygiecie_wzmocnienia_okiennego) + Number(wartosc_wygiecie_innego_elementu) + Number(wartosc_wyfrezowanie_odwodnienia) + Number(wartosc_wstawienie_slupka) + Number(wartosc_dociecie_listwy_przyszybowej) + Number(wartosc_okucie) + Number(wartosc_zaszklenie) + Number(wartosc_wykonanie_innej_uslugi);
	suma = suma.toFixed(2);
	document.getElementById('suma_doplaty').value=suma;
}


function Oblicz_material_doplaty(){
	//alert('material doplaty');
	var material_doplaty = 0;
	var slupek_wartoscInput = document.getElementById('slupek_wartosc');
	var slupek_wartosc = slupek_wartoscInput.value;
	var wzmocnienie_slupka_wartoscInput = document.getElementById('wzmocnienie_slupka_wartosc');
	var wzmocnienie_slupka_wartosc = wzmocnienie_slupka_wartoscInput.value;
	var okucia_wartoscInput = document.getElementById('okucia_wartosc');
	var okucia_wartosc = okucia_wartoscInput.value;
	var szyba_wartoscInput = document.getElementById('szyba_wartosc');
	var szyba_wartosc = szyba_wartoscInput.value;
	var inny_element_wartoscInput = document.getElementById('inny_element_wartosc');
	var inny_element_wartosc = inny_element_wartoscInput.value;

	material_doplaty = Number(wzmocnienie_slupka_wartosc) + Number(okucia_wartosc) + Number(szyba_wartosc) + Number(inny_element_wartosc) + Number(slupek_wartosc);
	material_doplaty = material_doplaty.toFixed(2);
	document.getElementById('material_doplaty').value=material_doplaty;
	Oblicz_sume_doplaty();
}

function Oblicz_sume_wycena_podstawowa(){
	//alert('licze sume wycena podstawowa');
	var suma = 0;	
	var wartosc_wygiecie_ramy_z_pvcInput = document.getElementById('wartosc_wygiecie_ramy_z_pvc');
	var wartosc_wygiecie_ramy_z_pvc = wartosc_wygiecie_ramy_z_pvcInput.value;
	var wartosc_wygiecie_skrzydla_pvcInput = document.getElementById('wartosc_wygiecie_skrzydla_pvc');
	var wartosc_wygiecie_skrzydla_pvc = wartosc_wygiecie_skrzydla_pvcInput.value;
	var wartosc_wygiecie_listwy_pvcInput = document.getElementById('wartosc_wygiecie_listwy_pvc');
	var wartosc_wygiecie_listwy_pvc = wartosc_wygiecie_listwy_pvcInput.value;
	
	var wartosc_wygiecie_innego_pvcInput = document.getElementById('wartosc_wygiecie_innego_pvc');
	var wartosc_wygiecie_innego_pvc = wartosc_wygiecie_innego_pvcInput.value;
	var wartosc_zgrzanieInput = document.getElementById('wartosc_zgrzanie');
	var wartosc_zgrzanie = wartosc_zgrzanieInput.value;
	var material_sumaInput = document.getElementById('material_suma');
	var material_suma = material_sumaInput.value;
	
	suma = Number(wartosc_wygiecie_ramy_z_pvc) + Number(wartosc_wygiecie_skrzydla_pvc) + Number(wartosc_wygiecie_listwy_pvc) + Number(wartosc_wygiecie_innego_pvc) + Number(wartosc_zgrzanie) + Number(material_suma);
	suma = suma.toFixed(2);
	document.getElementById('suma_wycena_podstawowa').value=suma;
}



// ########################################################################################################################################################################################################################
// #######################################################   MATERIAL   ###################################################################################################################################################
// ########################################################################################################################################################################################################################

function Oblicz_material_suma(){
	var rama_wartoscInput = document.getElementById('rama_wartosc');
	var rama_wartosc = rama_wartoscInput.value;
	var skrzydlo_wartoscInput = document.getElementById('skrzydlo_wartosc');
	var skrzydlo_wartosc = skrzydlo_wartoscInput.value;
	var listwa_wartoscInput = document.getElementById('listwa_wartosc');
	var listwa_wartosc = listwa_wartoscInput.value;
	var wzmocnienie_ramy_wartoscInput = document.getElementById('wzmocnienie_ramy_wartosc');
	var wzmocnienie_ramy_wartosc = wzmocnienie_ramy_wartoscInput.value;
	var wzmocnienie_skrzydla_wartoscInput = document.getElementById('wzmocnienie_skrzydla_wartosc');
	var wzmocnienie_skrzydla_wartosc = wzmocnienie_skrzydla_wartoscInput.value;
	
	var material_suma = Number(rama_wartosc) + Number(skrzydlo_wartosc) + Number(listwa_wartosc) + Number(wzmocnienie_ramy_wartosc) + Number(wzmocnienie_skrzydla_wartosc);
	material_suma = material_suma.toFixed(2);
	document.getElementById('material_suma').value=material_suma;
	//Oblicz_sume_wycena_podstawowa();
}


function Oblicz_wartosc_ramy_wycena_wstepna(){
	var cenaInput = document.getElementById('rama_cena');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('rama_metry');
	var ilosc = iloscInput.value;
	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;
	
	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;			

	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;			

	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('rama_wartosc').value=wartosc;
	Oblicz_material_suma();
}

function Oblicz_wartosc_skrzydla_wycena_wstepna(){
	var cenaInput = document.getElementById('skrzydlo_cena');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('skrzydlo_metry');
	var ilosc = iloscInput.value;
	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;
	
	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;			

	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;			

	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('skrzydlo_wartosc').value=wartosc;
	Oblicz_material_suma();
}

function Oblicz_wartosc_listwa_wycena_wstepna(){
	var cenaInput = document.getElementById('listwa_cena');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('listwa_metry');
	var ilosc = iloscInput.value;
	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;
	
	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;			

	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;			

	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('listwa_wartosc').value=wartosc;
	Oblicz_material_suma();
}

function Oblicz_wartosc_slupek_wycena_wstepna(){
	//alert('Oblicz_wartosc_slupek_wycena_wstepna');
	var cenaInput = document.getElementById('slupek_cena');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('slupek_metry');
	var ilosc = iloscInput.value;
	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;
	
	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;			

	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;			

	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('slupek_wartosc').value=wartosc;
	Oblicz_material_doplaty();
}

function Oblicz_wartosc_wzmocnienie_ramy_wycena_wstepna(){
	var cenaInput = document.getElementById('wzmocnienie_ramy_cena');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('wzmocnienie_ramy_metry');
	var ilosc = iloscInput.value;
	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;
	
	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;			

	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;			

	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('wzmocnienie_ramy_wartosc').value=wartosc;
	Oblicz_material_suma();
}

function Oblicz_wartosc_wzmocnienie_skrzydla_wycena_wstepna(){
	var cenaInput = document.getElementById('wzmocnienie_skrzydla_cena');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('wzmocnienie_skrzydla_metry');
	var ilosc = iloscInput.value;
		
	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;
	
	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;			

	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;			

	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('wzmocnienie_skrzydla_wartosc').value=wartosc;
	Oblicz_material_suma();
}

function Oblicz_wartosc_wzmocnienie_slupka_wycena_wstepna(){
	//alert('oko');
	var cenaInput = document.getElementById('wzmocnienie_slupka_cena');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('wzmocnienie_slupka_metry');
	var ilosc = iloscInput.value;
	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;

	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;			
	
	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;			

	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('wzmocnienie_slupka_wartosc').value=wartosc;
	Oblicz_material_doplaty();
}


function Oblicz_wartosc_wzmocnienie_luku_wycena_wstepna(){
	//alert('oko');
	var cenaInput = document.getElementById('wzmocnienie_luku_cena');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('wzmocnienie_luku_metry');
	var ilosc = iloscInput.value;
	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;

	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;			
	
	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;			

	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('wzmocnienie_luku_wartosc').value=wartosc;
	Oblicz_material_doplaty();
}

function Oblicz_wartosc_okucia_wycena_wstepna(){
	var cenaInput = document.getElementById('okucia_cena');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('okucia_ilosc');
	var ilosc = iloscInput.value;
		
	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;

	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;
	
	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;			

	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('okucia_wartosc').value=wartosc;
	Oblicz_material_doplaty();
}

function Oblicz_wartosc_szyba_wycena_wstepna(){
	var cenaInput = document.getElementById('szyba_cena');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('szyba_ilosc');
	var ilosc = iloscInput.value;
		
	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;

	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;
	
	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;			

	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('szyba_wartosc').value=wartosc;
	Oblicz_material_doplaty();
}

function Oblicz_wartosc_inny_element_wycena_wstepna(){
	var cenaInput = document.getElementById('inny_element_cena');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('inny_element_ilosc');
	var ilosc = iloscInput.value;
		
	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;

	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;
	
	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;			

	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('inny_element_wartosc').value=wartosc;
	Oblicz_material_doplaty();
}




// ########################################################################################################################################################################################################################
// #######################################   wycena podstawowa     ########################################################################################################################################################
// ########################################################################################################################################################################################################################
function Oblicz_wartosc_wygiecie_ramy_pvc_wycena_wstepna(){
	//alert('oko');
	var cenaInput = document.getElementById('cena_wygiecie_ramy_z_pvc');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('ilosc_wygiecie_ramy_z_pvc');
	var ilosc = iloscInput.value;
		
	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;
	
	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;		
	
	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;

	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('wartosc_wygiecie_ramy_z_pvc').value=wartosc;
	Oblicz_sume_wycena_podstawowa();
}

function Oblicz_wartosc_wygiecie_skrzydla_pvc_wycena_wstepna(){
	var cenaInput = document.getElementById('cena_wygiecie_skrzydla_z_pvc');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('ilosc_wygiecie_skrzydla_pvc');
	var ilosc = iloscInput.value;
	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;
	
	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;
	
	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;
		
	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('wartosc_wygiecie_skrzydla_pvc').value=wartosc;
	Oblicz_sume_wycena_podstawowa();
}

function Oblicz_wartosc_wygiecie_listwy_pvc_wycena_wstepna(){
	var cenaInput = document.getElementById('cena_wygiecie_listwy_z_pvc');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('ilosc_wygiecie_listwy_pvc');
	var ilosc = iloscInput.value;
		
	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;
	
	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;			
	
	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;

	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('wartosc_wygiecie_listwy_pvc').value=wartosc;
	Oblicz_sume_wycena_podstawowa();
}

function Oblicz_wartosc_wygiecie_innego_pvc_wycena_wstepna(){
	//alert('oko');
	var cenaInput = document.getElementById('cena_wygiecie_innego_pvc');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('ilosc_wygiecie_innego_pvc');
	var ilosc = iloscInput.value;
		
	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;
	
	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;			
	
	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;

	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('wartosc_wygiecie_innego_pvc').value=wartosc;
	Oblicz_sume_wycena_podstawowa();
}

function Oblicz_wartosc_zgrzanie_wycena_wstepna(){
	var cenaInput = document.getElementById('cena_zgrzanie');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('ilosc_zgrzanie');
	var ilosc = iloscInput.value;
	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;

	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;			
	
	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;

	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('wartosc_zgrzanie').value=wartosc;
	Oblicz_sume_wycena_podstawowa();
}



// ########################################################################################################################################################################################################################
// ############################################## dopaty #################################################################################################################################################################
// ########################################################################################################################################################################################################################




function Oblicz_wykonanie_innej_uslugi_wycena_wstepna(){
	var cenaInput = document.getElementById('cena_wykonanie_innej_uslugi');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('ilosc_wykonanie_innej_uslugi');
	var ilosc = iloscInput.value;
	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;
	
	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;			

	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;			

	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('wartosc_wykonanie_innej_uslugi').value=wartosc;
	Oblicz_sume_doplaty();	
}


function Oblicz_zaszklenie_wycena_wstepna(){
	var cenaInput = document.getElementById('cena_zaszklenie');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('ilosc_zaszklenie');
	var ilosc = iloscInput.value;
	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;
	
	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;			

	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;			

	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('wartosc_zaszklenie').value=wartosc;
	Oblicz_sume_doplaty();	
}


function Oblicz_okucie_wycena_wstepna(){
	var cenaInput = document.getElementById('cena_okucie');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('ilosc_okucie');
	var ilosc = iloscInput.value;
	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;
	
	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;			

	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;			

	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('wartosc_okucie').value=wartosc;
	Oblicz_sume_doplaty();	
}


function Oblicz_dociecie_listwy_przyszybowej_wycena_wstepna(){
	var cenaInput = document.getElementById('cena_dociecie_listwy_przyszybowej');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('ilosc_dociecie_listwy_przyszybowej');
	var ilosc = iloscInput.value;
	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;
	
	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;			

	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;			

	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('wartosc_dociecie_listwy_przyszybowej').value=wartosc;
	Oblicz_sume_doplaty();	
}

function Oblicz_wstawienie_slupka_wycena_wstepna(){
	var cenaInput = document.getElementById('cena_wstawienie_slupka');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('ilosc_wstawienie_slupka');
	var ilosc = iloscInput.value;
	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;
	
	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;			

	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;			

	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('wartosc_wstawienie_slupka').value=wartosc;
	Oblicz_sume_doplaty();	
}


function Oblicz_wygiecie_wzmocnienia_okiennego_wycena_wstepna(){
	var cenaInput = document.getElementById('cena_wygiecie_wzmocnienia_okiennego');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('ilosc_wygiecie_wzmocnienia_okiennego');
	var ilosc = iloscInput.value;
	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;
		
	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;			

	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;			

	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('wartosc_wygiecie_wzmocnienia_okiennego').value=wartosc;
	Oblicz_sume_doplaty();	
}

function Oblicz_wygiecie_innego_elementu_wycena_wstepna(){
	var cenaInput = document.getElementById('cena_wygiecie_innego_elementu');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('ilosc_wygiecie_innego_elementu');
	var ilosc = iloscInput.value;
	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;
	
	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;			

	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;			

	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('wartosc_wygiecie_innego_elementu').value=wartosc;
	Oblicz_sume_doplaty();	
}


function Oblicz_wyfrezowanie_odwodnienia_wycena_wstepna(){
	var cenaInput = document.getElementById('cena_wyfrezowanie_odwodnienia');
	var cena = cenaInput.value;
	var iloscInput = document.getElementById('ilosc_wyfrezowanie_odwodnienia');
	var ilosc = iloscInput.value;
	var ilosc_sztukInput = document.getElementById('ilosc_sztuk');
	var ilosc_sztuk = ilosc_sztukInput.value;
	
	var cena = cenaInput.value;
	cena = String(cena);
	cena = cena.replace(",", ".")
	cenaInput.value=cena;			

	var ilosc = iloscInput.value;
	ilosc = String(ilosc);
	ilosc = ilosc.replace(",", ".")
	iloscInput.value=ilosc;			

	var wartosc = cena*ilosc*ilosc_sztuk;
	wartosc = wartosc.toFixed(2);
	document.getElementById('wartosc_wyfrezowanie_odwodnienia').value=wartosc;
	Oblicz_sume_doplaty();	
}
