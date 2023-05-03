<?php
/*
Opis plików z panelu:

Pliki z których wysyłany jest email przez PHPMailer:
- potwierdzenie.php 							SERWER OK + local + załącznik + email z error_info OK
- fv_wyslij_fakture_do_ksiegowosci.php 			SERWER OK + local + załącznik + email z error_info OK
- fv_wyslij_przypomnienie_zaplaty.php			SERWER OK + local + załącznik + email z error_info OK
- fv_wyslij_fakture_przez_email.php 			SERWER OK + local + załącznik + email z error_info OK
- lista_materialow_pdf.php						SERWER OK + local + załącznik + email z error_info OK
- potwierdzenie_dostawy_z_zamowienia_pdf.php	SERWER OK + local + załącznik + email z error_info OK
- potwierdzenie_dostawy_pdf.php					local + załącznik + email z error_info OK
- klienci_edycja_oferta_indywidualna.php		SERWER OK + local + załącznik + email z error_info OK
- minimalne_promienie_tabela_pdf.php			SERWER OK + local + załącznik + email z error_info OK	
- zamowienie_do_dostawcow_pdf.php				local + załącznik + email z error_info OK
- wycena_wstepna_pdf.php						SERWER OK + local + załącznik + email z error_info OK
- generuj_raport.php							SERWER OK + local + załącznik + email z error_info OK

Pliki w których tworzony jest plik PDF:
- potwierdzenie.php
- generuj_duplikat.php
- generuj_fakture.php
- generuj_fakture_euro.php
- generuj_fakture_korekte.php
- generuj_fakture_proforme.php
- generuj_fakture_proforme_euro.php
- lista_materialow_pdf.php
- potwierdzenie_dostawy_z_zamowienia.php
- potwierdzenie_dostawy_pdf.php
- minimalne_promienie_tabela_pdf.php
- zamowienie_do_dostawcow_pdf.php
- wycena_wstepna_pdf.php
*/


if($user_stanowisko == 'administrator') 
	{
	$ilosc_menu = 9;
	if($user_id == 1) $ilosc_menu++;
	}

if($user_stanowisko == 'handel') $ilosc_menu = 8;
if($user_stanowisko == 'księgowość') $ilosc_menu = 3;

//lokalnie mam inny styl menu
// if($adres_ip == '127.0.0.1') $szer_jednego_menu = 141;
// else $szer_jednego_menu = 141;

$szer_jednego_menu = 141;
$szerokosc_tabeli_menu = $szer_jednego_menu * $ilosc_menu;
echo '<table border="0" width="'.$szerokosc_tabeli_menu.'" align="left" cellpadding="0" cellspacing="0"><tr><td>';

if($user_stanowisko == 'administrator')
	{
	echo '<ol id="menu">';
		// zakupy
		echo '<li><a href="#">Zakupy</a>';
			echo '<ul>';
				echo '<li class="prawo"><a href="index.php?page=magazyn&jak=ASC&wg_czego=system">Magazyn</a>';
					echo '<ol>';
					echo '<li><a href="index.php?page=magazyn_dodaj_pozycje&jak='.$jak.'&wg_czego='.$wg_czego.'">Dodaj</a></li>';
					//echo '<li><a href="index.php?page=artykul_dodaj&jak='.$jak.'&wg_czego='.$wg_czego.'">Dodaj artykuł</a></li>';
					echo '</ol>';
				echo '</li>';

				echo '<li><a href="index.php?page=zamowienia_do_dostawcow&jak=DESC&wg_czego=data_zamowienia_time">Rejestr zamówień</a></li>';

				echo '<li class="prawo"><a href="index.php?page=dostawcy&jak=DESC&wg_czego=id">Dostawcy</a>';
					echo '<ol>';
						echo '<li><a href="index.php?page=dostawcy_dodaj">Dodaj</a></li>';
					echo '</ol>';
				echo '</li>';
			echo '</ul>';
		echo '</li>';

		// Marketing  
		echo '<li><a href="#">Marketing</a>';
			echo '<ul>';
				echo '<li><a href="index.php?page=oferty_wychodzace&jak=DESC&wg_czego=id">Oferty wychodzące</a></li>';
				echo '<li><a href="index.php?page=lista_straconych_klientow&jak=DESC&wg_czego=id">Lista straconych klientów</a></li>';
				echo '<li><a href="index.php?page=lista_planowanych_kontaktow&jak=DESC&wg_czego=id">Lista planowanych kontaktów</a></li>';
			echo '</ul>';
		echo '</li>';

		// Sprzedaż  
		echo '<li><a href="#">Sprzedaż</a>';
			echo '<ul>';
				echo '<li class="prawo"><a href="index.php?page=klienci&jak=DESC&wg_czego=id">Klienci</a>';
				echo '<ol>';
				echo '<li><a href="index.php?page=klienci_dodaj&jak=DESC&wg_czego=id&pod_page=klienci_dodaj_dane_do_faktury">Dodaj</a></li>';
				echo '<li><a href="index.php?page=klienci_baza_email">Baza e-mail</a></li>';
				echo '</ol>';
				echo '</li>';

				echo '<li class="prawo"><a href="index.php?page=zamowienia&jak=DESC&wg_czego=id">Zamówienia od klientów</a>';
				echo '<ol>';
				echo '<li><a href="index.php?page=zamowienie_dodaj&jak=DESC&wg_czego=id">Dodaj zamówienie</a></li>';
				echo '</ol>';
				echo '</li>';

				echo '<li><a href="index.php?page=fv_fakturowanie&rodzaj_dokumentu=Faktura&jak=DESC&wg_czego=data_wystawienia_time&termin_wystawienia=on&szukany_miesiac='.$AKTUALNY_MIESIAC.'">Fakturowanie</a></li>';

				echo '<li><a href="index.php?page=jpk_fa&etap=1">Generuj JPK_FA</a></li>';
				if($user_id == 1) echo '<li><a href="index.php?page=jpk_vat&etap=1">Generuj JPK VAT</a></li>';
			echo '</ul>';
		echo '</li>';

		// produkcja
		echo '<li><a href="#">Produkcja</a>';
			echo '<ul>';
				echo '<li><a href="#">Magazyn</a></li>';
				echo '<li><a href="#">Przygotowanie produkcji</a></li>';
				echo '<li class="prawo"><a href="index.php?page=realizacja_produkcji">Realizacja produkcji</a>';
					echo '<ol>';
						echo '<li><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&jak=DESC&wg_czego=id">Zamówienia do wykonania</a></li>';
						echo '<li><a href="index.php?page=realizacja_produkcji_zamowienia_wykonane&jak=DESC&wg_czego=id">Zamówienia wykonane</a></li>';
						echo '<li><a href="index.php?page=realizacja_produkcji_historia_wpisow&jak=DESC&wg_czego=id">Historia wpisów</a></li>';
					echo '</ol>';
				echo '</li>';
			echo '</ul>';
		echo '</li>';

		// logistyka i transport
		echo '<li><a href="#">Logistyka i Transport</a>';
			echo '<ul>';
				echo '<li><a href="#">Planowanie produkcji</a></li>';
				echo '<li class="prawo"><a href="index.php?page=zlecenia_transportowe&jak=DESC&wg_czego=id">Zlecenia transportowe</a>';
					echo '<ol><li><a href="index.php?page=zlecenie_transportowe_dodaj&etap=1&jak=DESC&wg_czego=id">Dodaj zlecenie</a></li></ol>';
			echo '</li>';
			echo '</ul>';
		echo '</li>';

		// analizy 
		echo '<li><a href="#">Analizy</a>';		  
			echo '<ul>';
				echo '<li><a href="index.php?page=analiza_wycena_dane">Wycena dane</a></li>';
				echo '<li><a href="index.php?page=analiza_sprzedaz_klienci">Sprzedaż wg klientów</a></li>';
				echo '<li><a href="index.php?page=analiza_sprzedaz_systemy">Sprzedaż wg systemów</a></li>';
				echo '<li><a href="index.php?page=analiza_wartosc_produkcji">Wartość produkcji</a></li>';
				echo '<li><a href="index.php?page=analiza_ilosc_klientow">Ilość klientów</a></li>';
				echo '<li><a href="index.php?page=analiza_wydajnosc_produkcji">Wydajność produkcji</a></li>';
				echo '<li><a href="index.php?page=analiza_sprzedaz_produkty&SPRAWDZANY_ROK='.$AKTUALNY_ROK.'">Sprzedaż wg produktów</a></li>';
				echo '<li><a href="index.php?page=analiza_wartosc_zamowien">Wartość zamówień brutto</a></li>';
				echo '<li><a href="index.php?page=produkcja_premia_akordowa">Premia akordowa</a></li>';
			echo '</ul>';
		echo '</li>';

		// wyceny
		echo '<li><a href="#">Wyceny</a>';		  
			echo '<ul>';
				echo '<li class="prawo"><a href="index.php?page=wyceny_wstepne&jak=DESC&wg_czego=id">Wyceny</a>';
					echo '<ol><li><a href="index.php?page=wycena_wstepna_dodaj&jak=DESC&wg_czego=id">Nowa wycena</a></li></ol>';
				echo '</li>';
				echo '<li><a href="index.php?page=wycena_wstepna_rysunki&jak=ASC&wg_czego=kolejnosc">Rysunki</a></li>';
				echo '<li><a href="index.php?page=dlugosc_luku">Długość łuku</a></li>';
				echo '<li><a href="index.php?page=przekatna">Przekątna</a></li>';
			echo '</ul>';
		echo '</li>';

		// technologia
		echo '<li><a href="#">Technologia</a>';
			echo '<ul>';
				echo '<li><a href="index.php?page=wzmocnienia">Wzmocnienia</a></li>';
				echo '<li class="prawo"><a href="index.php?page=minimalne_promienie&jak=DESC&wg_czego=id">Minimalne promienie</a>';
					echo '<ol><li><a href="index.php?page=minimalne_promienie_dodaj&SORT_SYSTEM='.$SORT_SYSTEM.'&SORT_SYMBOL_PROFILU='.$SORT_SYMBOL_PROFILU.'&jak='.$jak.'&wg_czego='.$wg_czego.'">Dodaj</a></li></ol>';
				echo '</li>';

				echo '<li class="prawo"><a href="index.php?page=sposob_czyszczenia_zgrzewow&jak=ASC&wg_czego=klient_nazwa">Sposób czyszczenia zgrzewów</a>';
					echo '<ol><li><a href="index.php?page=sposob_czyszczenia_zgrzewow_dodaj&jak='.$jak.'&wg_czego='.$wg_czego.'">Dodaj</a></li></ol>';
				echo '</li>';

				echo '<li class="prawo"><a href="index.php?page=zachodzenia&jak=DESC&wg_czego=id">Zachodzenia</a>';
					echo '<ol><li><a href="index.php?page=zachodzenia_dodaj&jak=DESC&wg_czego=id">Dodaj</a></li></ol>';
				echo '</li>';
			echo '</ul>';
		echo '</li>';

		echo '</ol>';

	echo '</td><td>';

	//################# ustawienia
	echo '<ol id="menu2">';
		echo '<li><a href="#">Ustawienia</a>';
			echo '<ul>';
				echo '<li class="lewo"><a href="index.php?page=uzytkownicy">Użytkownicy</a>';
					echo '<ol><li><a href="index.php?page=uzytkownicy_dodaj">Dodaj</a></li></ol>';
				echo '</li>';

		echo '<li class="lewo"><a href="#">Ustawienia</a>';
			echo '<ol>';
				echo '<li><a href="index.php?page=ustawienia_druku">Druku</a></li>';
				echo '<li><a href="index.php?page=ustawienia_numeracji">Numeracja</a></li>';
				echo '<li><a href="index.php?page=ustawienia_cennik">Cennik domyślny</a></li>';
				echo '<li><a href="index.php?page=ustawienia_cennik_osobisty">Cennik osobisty</a></li>';
				echo '<li><a href="index.php?page=ustawienia_vat">Vat</a></li>';
				echo '<li><a href="index.php?page=fv_ustawienia">Faktury</a></li>';
				echo '<li><a href="index.php?page=ustawienia_jpk">JPK VAT</a></li>';
				echo '<li><a href="index.php?page=ustawienia_magazyn">Magazyn</a></li>';
				echo '<li><a href="index.php?page=ustawienia_suwaki_lista">Suwaki</a></li>';
				echo '<li><a href="index.php?page=ustawienia_dz_lista">Dodaj zamówienie</a></li>';
				echo '<li><a href="index.php?page=ustawienia_uwagi">Uwagi</a></li>';
				echo '<li><a href="index.php?page=ustawienia_wyceny_wstepne">Wycena wstępna</a></li>';
				echo '<li><a href="index.php?page=ustawienia_oferta_indywidualna">Oferta indywidualna</a></li>';
				echo '<li><a href="index.php?page=ustawienia_zlecenia_transportowe">Zlecenia transportowe</a></li>';
				echo '<li><a href="index.php?page=ustawienia_dzial_stanowisko">Dział / Stanowisko</a></li>';
			echo '</ol>';
		echo '</li>';
		
		echo '<li><a href="index.php?page=wyloguj">Wyloguj!</a></li>';
		echo '</ul>';
		echo '</li>';
	echo '</ol>';
	}

// ############################ HANDEL ##############
if($user_stanowisko == 'handel')
	{
	echo '<ol id="menu">';
	   echo ' <li><a href="#">Zakupy</a>';
			echo '<ul>';
				echo '<li class="prawo"><a href="index.php?page=magazyn&jak=ASC&wg_czego=system">Magazyn</a>';
					echo '<ol>';
					echo '<li><a href="index.php?page=magazyn_dodaj_pozycje&jak='.$jak.'&wg_czego='.$wg_czego.'">Dodaj</a></li>';
					echo '</ol>';
				echo '</li>';
					
				echo '<li class="prawo"><a href="index.php?page=zamowienia_do_dostawcow&jak=DESC&wg_czego=data_zamowienia_time">Rejestr zamówień</a>';
					echo '<ol>';
					echo '<li><a href="index.php?page=zamowienia_do_dostawcow_dodaj&etap=1&jak=ASC&wg_czego=system">Dodaj zamówienie do dostawców</a></li>';
					echo '</ol>';
				echo '</li>';
			echo '</ul>';
		echo '</li>';
		
	   echo ' <li><a href="#">Marketing</a>';
			echo '<ul>';
				echo '<li><a href="#">Oferty wychodzące</a></li>';
			echo '</ul>';
		echo '</li>';
		
	   echo ' <li><a href="#">Sprzedaż</a>';
			echo '<ul>';
				echo '<li class="prawo"><a href="index.php?page=klienci&jak=DESC&wg_czego=id">Klienci</a>';
					echo '<ol>';
					echo '<li><a href="index.php?page=klienci_dodaj&jak=DESC&wg_czego=id">Dodaj</a></li>';
					echo '</ol>';
				echo '</li>';
									
				echo '<li class="prawo"><a href="index.php?page=zamowienia&jak=DESC&wg_czego=id">Zamówienia od klientow</a>';
					echo '<ol>';
					echo '<li><a href="index.php?page=zamowienie_dodaj&jak=DESC&wg_czego=id">Dodaj zamówienie</a></li>';
					echo '</ol>';
				echo '</li>';
				$termin_wystawienia = 'on';
				echo '<li><a href="index.php?page=fv_fakturowanie&rodzaj_dokumentu=Faktura&jak=DESC&wg_czego=id&termin_wystawienia=on&szukany_miesiac='.$AKTUALNY_MIESIAC.'">Fakturowanie</a></li>';
				echo '</li>';
			echo '</ul>';
		echo '</li>';
	
		echo '<li><a href="#">Produkcja</a>';
			echo '<ul>';
				echo '<li><a href="#">Magazyn</a></li>';
				echo '<li><a href="#">Przygotowanie produkcji</a></li>';
				echo '<li class="prawo"><a href="index.php?page=realizacja_produkcji">Realizacja produkcji</a>';
					echo '<ol>';
					echo '<li><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&jak=DESC&wg_czego=id">Zamówienia do wykonania</a></li>';
					echo '<li><a href="index.php?page=realizacja_produkcji_zamowienia_wykonane&jak=DESC&wg_czego=id">Zamówienia wykonane</a></li>';
					echo '<li><a href="index.php?page=realizacja_produkcji_historia_wpisow&jak=DESC&wg_czego=id">Historia wpisów</a></li>';
					echo '</ol>';
				echo '</li>';
			echo '</ul>';
		echo '</li>';
		
	   echo ' <li><a href="#">Logistyka i Transport</a>';
			echo '<ul>';
				echo '<li><a href="#">Planowanie produkcji</a></li>';
				echo '<li class="prawo"><a href="index.php?page=zlecenia_transportowe&jak=DESC&wg_czego=id">Zlecenia transportowe</a>';
					echo '<ol>';
					echo '<li><a href="index.php?page=zlecenie_transportowe_dodaj&etap=1&jak=DESC&wg_czego=id">Dodaj zlecenie</a></li>';
					echo '</ol>';
				echo '</li>';
			echo '</ul>';
		echo '</li>';
		
		echo '<li><a href="#">Wyceny</a>';		  
			echo '<ul>';
			echo '<li class="prawo"><a href="index.php?page=wyceny_wstepne&jak=DESC&wg_czego=id">Wyceny</a>';
				echo '<ol>';
				echo '<li><a href="index.php?page=wycena_wstepna_dodaj&jak=DESC&wg_czego=id">Nowa wycena</a></li>';
				echo '</ol>';
			echo '</li>';
			echo '<li><a href="index.php?page=dlugosc_luku">Długość łuku</a></li>';
			echo '</ul>';
		echo '</li>';
		
		echo '<li><a href="#">Technologia</a>';
			echo '<ul>';
				echo '<li><a href="index.php?page=wzmocnienia">Wzmocnienia</a></li>';
			echo '</ul>';
		echo '</li>';
			echo '<li><a href="index.php?page=wyloguj">Wyloguj!</a>';
		echo '</li>';
	  echo '</ol>';
	}




if(($user_stanowisko != 'księgowość') && ($user_stanowisko != 'handel') && ($user_stanowisko != 'administrator'))
	{
		echo '<a href="index.php?page=wyloguj">'.$image_logout.'</a>';
	}


echo '</td></tr></table>';


?>