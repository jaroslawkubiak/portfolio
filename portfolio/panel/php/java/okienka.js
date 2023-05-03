function info_zlecenie_transportowe(klient_id)
{ 
nowe=window.open('php/zlecenie_transportowe_info_okienko.php?klient_id='+ klient_id, 'Informacja - zlecenie transportowe', "width=800, height=1000, top=100, left=150, scrollbars=yes");
nowe.focus();
}

function potwierdzenie_dostawy_z_zamowienia_okienko(id, klient_id, user_id)
{ 
nowe=window.open('php/potwierdzenie_dostawy_z_zamowienia_okienko.php?id='+ id + '&klient_id='+ klient_id + '&user_id='+ user_id, 'Wyślij potwierdzenie dostawy', "width=600, height=650, top=100, left=340, scrollbars=yes");
nowe.focus();
}

function potwierdzenie_dostawy_okienko(id, klient_id, user_id)
{ 
nowe=window.open('php/potwierdzenie_dostawy_okienko.php?id='+ id + '&klient_id='+ klient_id + '&user_id='+ user_id, 'Wyślij potwierdzenie dostawy', "width=600, height=650, top=100, left=340, scrollbars=yes");
nowe.focus();
}


function sposoby_wyslij_tabele(klient_id)
{ 
nowe=window.open('php/sposoby_wyslij_tabele.php?klient_id='+ klient_id, 'Wyślij tabelę', "width=600, height=650, top=100, left=340, scrollbars=yes");
nowe.focus();
}

function fv_wyslij_fakture_przez_email(fv_id, user_id)
{ 
nowe=window.open('php/fv_wyslij_fakture_przez_email.php?fv_id='+ fv_id + '&user_id='+ user_id, 'Wyślij fakturę', "width=600, height=650, top=100, left=340, scrollbars=yes");
nowe.focus();
}

function fv_wyslij_fakture_do_ksiegowosci(fv_id, user_id)
{ 
nowe=window.open('php/fv_wyslij_fakture_do_ksiegowosci.php?fv_id='+ fv_id + '&user_id='+ user_id, 'Wyślij fakturę', "width=600, height=650, top=100, left=340, scrollbars=yes");
nowe.focus();
}
function fv_wyslij_fakture_do_biura(fv_id, user_id)
{ 
nowe=window.open('php/fv_wyslij_fakture_do_biura.php?fv_id='+ fv_id + '&user_id='+ user_id, 'Wyślij fakturę', "width=600, height=650, top=100, left=340, scrollbars=yes");
nowe.focus();
}

function fv_wyslij_przypomnienie_zaplaty(fv_id, user_id)
{ 
nowe=window.open('php/fv_wyslij_przypomnienie_zaplaty.php?fv_id='+ fv_id + '&user_id='+ user_id, 'Wyślij przypomnienie zapłaty', "width=900, height=750, top=50, left=100, scrollbars=yes");
nowe.focus();
}

function pokaz_historie_logowan_klientow()
{ 
nowe=window.open('php/pokaz_historie_logowan_klientow.php?', 'Historia logowań klientów', "width=600, height=650, top=0, left=340, scrollbars=yes");
nowe.focus();
}

function pokaz_historie_logowan_klienta(klient_id)
{ 
nowe=window.open('php/pokaz_historie_logowan_klienta.php?klient_id='+ klient_id, 'Historia logowań klienta', "width=600, height=650, top=0, left=340, scrollbars=yes");
nowe.focus();
}



function przepisz_adres_dostawy()
   {
   if(!document.klient.dostawy_ulica.value)document.klient.dostawy_ulica.value=document.klient.ulica.value;
   else document.klient.dostawy_ulica.value='';
   if(!document.klient.dostawy_miasto.value)document.klient.dostawy_miasto.value=document.klient.miasto.value;
   else document.klient.dostawy_miasto.value='';
   if(!document.klient.dostawy_kod_pocztowy.value)document.klient.dostawy_kod_pocztowy.value=document.klient.kod_pocztowy.value;
   else document.klient.dostawy_kod_pocztowy.value='';
   }

function przepisz_oferty_alu()
   {
   if(!document.klient.oferty_alu_osoba.value)document.klient.oferty_alu_osoba.value=document.klient.oferty_pvc_osoba.value;
   else document.klient.oferty_alu_osoba.value='';
   if(!document.klient.oferty_alu_email.value)document.klient.oferty_alu_email.value=document.klient.oferty_pvc_email.value;
   else document.klient.oferty_alu_email.value='';
   if(!document.klient.oferty_alu_telefon.value)document.klient.oferty_alu_telefon.value=document.klient.oferty_pvc_telefon.value;
   else document.klient.oferty_alu_telefon.value='';
 /** kopiowanie wybranych systemow 
   if(!document.klient.oferty_alu_system1.value)document.klient.oferty_alu_system1.value=document.klient.oferty_pvc_system1.value;
   else document.klient.oferty_alu_system1.value='';
   if(!document.klient.oferty_alu_system2.value)document.klient.oferty_alu_system2.value=document.klient.oferty_pvc_system2.value;
   else document.klient.oferty_alu_system2.value='';
   if(!document.klient.oferty_alu_system3.value)document.klient.oferty_alu_system3.value=document.klient.oferty_pvc_system3.value;
   else document.klient.oferty_alu_system3.value='';
   */
   }
   
function przepisz_wycena_pvc()
   {
   if(!document.klient.wycena_pvc_osoba.value)document.klient.wycena_pvc_osoba.value=document.klient.oferty_alu_osoba.value;
   else document.klient.wycena_pvc_osoba.value='';
   if(!document.klient.wycena_pvc_email.value)document.klient.wycena_pvc_email.value=document.klient.oferty_alu_email.value;
   else document.klient.wycena_pvc_email.value='';
   if(!document.klient.wycena_pvc_telefon.value)document.klient.wycena_pvc_telefon.value=document.klient.oferty_alu_telefon.value;
   else document.klient.wycena_pvc_telefon.value='';
   }
   
function przepisz_wycena_alu()
   {
   if(!document.klient.wycena_alu_osoba.value)document.klient.wycena_alu_osoba.value=document.klient.wycena_pvc_osoba.value;
   else document.klient.wycena_alu_osoba.value='';
   if(!document.klient.wycena_alu_email.value)document.klient.wycena_alu_email.value=document.klient.wycena_pvc_email.value;
   else document.klient.wycena_alu_email.value='';
   if(!document.klient.wycena_alu_telefon.value)document.klient.wycena_alu_telefon.value=document.klient.wycena_pvc_telefon.value;
   else document.klient.wycena_alu_telefon.value='';
   }


function przepisz_potwierdzenie_pvc()
   {
   if(!document.klient.potwierdzenie_pvc_osoba.value)document.klient.potwierdzenie_pvc_osoba.value=document.klient.wycena_alu_osoba.value;
   else document.klient.potwierdzenie_pvc_osoba.value='';
   if(!document.klient.potwierdzenie_pvc_email.value)document.klient.potwierdzenie_pvc_email.value=document.klient.wycena_alu_email.value;
   else document.klient.potwierdzenie_pvc_email.value='';
   if(!document.klient.potwierdzenie_pvc_telefon.value)document.klient.potwierdzenie_pvc_telefon.value=document.klient.wycena_alu_telefon.value;
   else document.klient.potwierdzenie_pvc_telefon.value='';
   }
   
function przepisz_potwierdzenie_alu()
   {
   if(!document.klient.potwierdzenie_alu_osoba.value)document.klient.potwierdzenie_alu_osoba.value=document.klient.potwierdzenie_pvc_osoba.value;
   else document.klient.potwierdzenie_alu_osoba.value='';
   if(!document.klient.potwierdzenie_alu_email.value)document.klient.potwierdzenie_alu_email.value=document.klient.potwierdzenie_pvc_email.value;
   else document.klient.potwierdzenie_alu_email.value='';
   if(!document.klient.potwierdzenie_alu_telefon.value)document.klient.potwierdzenie_alu_telefon.value=document.klient.potwierdzenie_pvc_telefon.value;
   else document.klient.potwierdzenie_alu_telefon.value='';
   }
   
function wplac_calosc(source) 
{
	var kwotaInput = document.getElementById('nazwa_do_zaplaty['+source+']');
	var kwota = kwotaInput.value;
	document.getElementById('wartosc_wplaty').value=kwota;
}



function zaznacz_pozycje(source) 
{
		
	var checkboxes = document.getElementsByTagName('input');	
    var glownyChecked = document.getElementById('id_'+source).checked;
	var ilosc_pozycjiInput = document.getElementById(source);
	var ilosc_pozycji = ilosc_pozycjiInput.value;

	for(var x=1; x<=ilosc_pozycji; x++)
		{
		checkboxes = document.getElementsByName('pozycja['+x+']');
		for(var i=0, n=checkboxes.length; i<n; i++) 
			{
			checkboxes[i].checked = glownyChecked;
			}
		}
	document.getElementById("myForm").submit();
}


function zmien_rodzaj_produktu(source) 
{
	//var checkboxes = document.getElementsByTagName('input');	
   // var glownyChecked = document.getElementById('id_'+source).checked;
	var ilosc_pozycjiInput = document.getElementById(source);
	var ilosc_pozycji = ilosc_pozycjiInput.value;

	for(var x=1; x<=ilosc_pozycji; x++)
		{
		checkboxes = document.getElementsByName('pozycja['+x+']');
		for(var i=0, n=checkboxes.length; i<n; i++) 
			{
			checkboxes[i].checked = false;
			}
		}
	document.getElementById("myForm").submit();
}


function toggle(source) 
{
	var suma_brutto = 0;
	var checkboxes = document.getElementsByTagName('input');	
    var glownyChecked = document.getElementById('id_'+source).checked;
	var ilosc_pozycjiInput = document.getElementById(source);
	var ilosc_pozycji = ilosc_pozycjiInput.value;


	for(var x=1; x<=ilosc_pozycji; x++)
		{
		checkboxes = document.getElementsByName('pozycja['+source+']['+x+']');
		for(var i=0, n=checkboxes.length; i<n; i++) 
			{
			checkboxes[i].checked = glownyChecked;
			}
			
		if(glownyChecked == true) 
			{
			var wartosc_bruttoInput = document.getElementById('id_pozycja['+source+']['+x+']');
			var wartosc_brutto = wartosc_bruttoInput.value;
			
			var pozycja_statusInput = document.getElementById('id_pozycja_status['+source+']['+x+']');
			var pozycja_status = pozycja_statusInput.value;
			//alert('pozycja_status='+pozycja_status);
			if(pozycja_status != 'Dostarczone') suma_brutto += Number(wartosc_brutto);
			}
		else suma_brutto = 0;
		}

		if(glownyChecked == true) 
			{
			var result = suma_brutto.toFixed(2);
			document.getElementById('input_id_suma_brutto['+source+']').value=result;
			}
		else 
			{
			document.getElementById('input_id_suma_brutto['+source+']').value=suma_brutto;
			}
		
}

function licz_sume_zamowien(id_zamowienia, pozycja) 
{
	//alert('id='+id_zamowienia+'pozycja='+pozycja)
	var suma_brutto = 0;
	//pobieram wartosc brutto danel pozycji
	var wartosc_bruttoInput = document.getElementById('id_pozycja['+id_zamowienia+']['+pozycja+']');
	var wartosc_brutto = wartosc_bruttoInput.value;
	
	//pobieram wartosc brutto sumy zamowien
	var suma_bruttoInput = document.getElementById('input_id_suma_brutto['+id_zamowienia+']');
	var suma_brutto = suma_bruttoInput.value;
	
    var stan_checkboxa = document.getElementById('id_pozycja_wycena['+id_zamowienia+']['+pozycja+']').checked;
	//alert('suma_brutto='+suma_brutto+'check='+stan_checkboxa);
	
	if(stan_checkboxa == false) var nowa_suma = Number(suma_brutto) - Number(wartosc_brutto);
	else var nowa_suma = Number(suma_brutto) + Number(wartosc_brutto);
	
	var result = nowa_suma.toFixed(2);
	
	document.getElementById('input_id_suma_brutto['+id_zamowienia+']').value=result;
}
