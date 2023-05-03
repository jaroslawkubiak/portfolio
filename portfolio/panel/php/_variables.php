<?php
// echo  date('d-m-Y h:i:s', 1667812525);

/*
//warningi serwera:
Warning: A non-numeric value encountered in 
rozwiązanie - dodac (float)przed zmienna, np: (float)$nazwa_ilosc_sztuk[$i]

Notice: Uninitialized string offset:
rozwiązanie: na razie brak, drze ryja o to, bo deklaruje tablice a potem zamieniam ją na string żeby zapisać string, a odwołując się do $temp[$i] szuka $i znaku w tym stringu

Warning: mysqli_fetch_assoc() expects parameter 1 to be mysqli_result, bool given
rozwiązanie: zmienna która trafia do SQL jest pusta lub zapytanie jest błędne, npp nieprawidłowa nazwa kolumny

Notice: Undefined index:
rozwiązanie : if(isset($ZMIENNA)) bo zmienna jest pusta

Notice: Trying to access array offset on value of type null 
rozwiązanie - brak danych z sql - zwraca puste.

Notice: Undefined offset: 1 
rozwiązanie:
zadeklarowac zmienne i wyzerować
for($k = 1; $k<=12; $k++)
	{
		$WARTOSC_CALKOWITA[$k] = 0;
		$WARTOSC_CALKOWITA_BRUTTO[$k] = 0;
	}



	$SQL = [];
	//tresc zapytan
	$SQL[1] = "UPDATE wyceny SET termin_realizacji = '".$termin_realizacji."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id.";";
	$SQL[2] = "UPDATE wyceny SET sposob_dostawy_wycena_wstepna = '".$sposob_dostawy."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id.";";
	$SQL[3] = "UPDATE wyceny SET wycena_wstepna_wartosc_netto = ".$SUMA." WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id.";";
	$SQL[4] = "UPDATE wyceny SET wycena_wstepna_email = '".$email."' WHERE wycena_wstepna_nr = '".$wycena_wstepna_nr."' AND klient_id = ".$klient_id.";";
	$SQL[5] = "UPDATE klienci SET ostatnio_uzyty_wycena = '".$email."' WHERE id = ".$klient_id.";";

	//wykonanie zapytan
	for($s=1; $s<=5; $s++) mysqli_query($conn, $SQL[$s]);

$cenka = change($cenka);

required=""






######################### zapytanie SELECT ######################
$sql = "SELECT * FROM logowania_uzytkownikow2 WHERE godzina_wylogowania = 0;";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0) 
	while ($wynik = mysqli_fetch_assoc($result)) 
		{
		$idi=$wynik['id'];
		$godzina_logowania=$wynik['godzina_logowania'];
		}

######################### zapytanie SELECT  TYLKO O JEDEN WIERSZ ######################
$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT godzina_wylogowania, godzina_logowania FROM logowania_klientow WHERE klient_id = ".$klient_id[$x]." ORDER BY id DESC LIMIT 1;"));
$godzina_wylogowania = $sql['godzina_wylogowania'];

$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT opis FROM rozne WHERE typ = 'wysokosc_okna_cennika';"));
$wysokosc_okna_cennika = $sql['opis'];



######################### zapytanie INSERT  i UPDATE   ######################
$sql = "INSERT INTO logowania_uzytkownikow2 (`session_id`, `user_id`, `godzina_logowania`) VALUES ('$sess_id', '$user_id', '$godzina_logowania');";
$result = mysqli_query($conn, $sql);

$result = mysqli_query($conn, "UPDATE klienci SET kraj = '".$kraj."' WHERE id = ".$id.";");



######################### Sprawdzenie poprawności wykonania zapytania JEST DO TEGO FUNKCJA ######################
//do funkcji musi trafic samo zapytanie np: SELECT * FROM fv_naglowek WHERE id = ".$fv_id.";
show_mysqli_query($conn, $sql);

######################### wyciaga id ostatniego zapytania ######################
$artykul_id = mysqli_insert_id($conn);



################################# zamienia dowolne podane znaki
zamien_dowolne_znaki($string, $szukaj, $zamien_na)
$nabywca_nip = zamien_dowolne_znaki($nabywca_nip, '-', '');



############################   wyswietle info o bledzie przy wysylce emaili z pdfami
show_mail_send_error_info($mail->ErrorInfo);
	to umieszczać w treści
	$error_info = $mail->ErrorInfo;
	show_mail_send_error_info($error_info);


############################## konwertujemy  wartosc na float
$wygiecie_ramy_pvc_ilosc_szt = floatval($wygiecie_ramy_pvc_ilosc_szt);	

#################################   używać zamiast eregi
$test = 'ZT/51/09/2020';
if (preg_match("/ZT/", $test))  echo "A match was found.";
else echo "A match was not found.";



TAKI UKAD DZIAŁA ALE TYLKO ONLINE!!!!!!!!!!!!!!!!!!!!!!!!

mysql_query("SET AUTOCOMMIT=0");
mysql_query("START TRANSACTION");
$pytanie121 = mysql_query("UPDATE uzytkownicy SET telefon = '".$time."' WHERE id = 3");
$pytanie122 = mysql_query("UPDATE uzytkownicey SET telefon = '".$time."' WHERE id = 2");
if($pytanie121 && $pytanie122) 
	{
	echo 'robie commit';
	mysql_query("COMMIT"); 
	}
else 
	{
	echo 'robie rolback';
	mysql_query("ROLLBACK");
	}



&& 		AND
||  	OR

user_id =  $_SESSION["USER_ID"]

BORDERCOLOR="black" frame="box" RULES="all"

echo '<meta http-equiv="refresh" content="0; URL=index.php?page=fv_fakturowanie&jak='.$jak.'&drukuj_fv='.$drukuj_fv.'>';
*/		




$nbsp = '&nbsp;&nbsp;&nbsp;';


//############################################ Różne komunikaty na stronach ###########################################
$kom_dane_do_faktury = 'Dane do faktury';
$kom_informacje_ogolne = 'Informacje ogólne';
$kom_oferta_zostala_wyslana_poprawnie = 'Oferta została wysłana poprawnie.';
$kom_wpis_zostal_usuniety = 'Wpis został usunięty.';
$kom_wpis_zostal_dodany = 'Wpis został dodany.';
$kom_kontakt_zostal_zaplanowany = 'Kontakt został zaplanowany.';
$kom_adres_dostawy = 'Adres dostawy';


$wyraz_sprzedaz = 'sprzedaż';
$wyraz_Sprzedaz = 'Sprzedaż';
$wyraz_wartosc = 'wartość';
$wyraz_Wartosc = 'Wartość';
$wyraz_srednia = 'średnia';
$wyraz_Srednia = 'Średnia';
$wyraz_miesiac = 'miesiąc';
$wyraz_Miesiac = 'Miesiąc';
$wyraz_dzien = 'dzień';
$wyraz_Dzien = 'Dzień';
$wyraz_ilosc = 'ilość';
$wyraz_Ilosc = 'Ilość';
$wyraz_Klientow = 'Klientów';
$wyraz_klientow = 'klientów';
$wyraz_imie = 'imię';
$wyraz_Imie = 'Imię';
$wyraz_poczatkowa = 'początkowa';
$wyraz_Poczatkowa = 'Początkowa';
$wyraz_koncowa = 'końcowa';
$wyraz_Koncowa = 'Końcowa';
$wyraz_zamowienie = 'zamówienie';
$wyraz_Zamowienie = 'Zamówienie';
$wyraz_ZAMOWIENIE = 'ZAMÓWIENIE';
$wyraz_szerokosc = 'szerokość';
$wyraz_Szerokosc = 'Szerokość';
$wyraz_wysokosc = 'wysokość';
$wyraz_Wysokosc = 'Wysokość';
$wyraz_Dlugosc_luku = 'Długość łuku';
$wyraz_Promien = 'Promień';
$wyraz_Luki = 'Łuki';
$wyraz_Wygiecie = 'Wygięcie';
$wyraz_zamowienia = 'zamówienia';
$wyraz_Zamowienia = 'Zamówienia';



$kom_faktura_zostala_wyslana_na_adres = 'Faktura została wysłana na adres';
$kom_wpisane_hasla_sa_rozne = 'Wpisane przez Ciebie nowe hasła są różne.';
$kom_wpisane_haslo_jest_inne_niz_w_bazie = 'Wpisane przez Ciebie hasło jest inne niż to w bazie.';
$kom_haslo_zostalo_zmienione = 'Hasło zostało zmienione.';
$kom_login_zostal_zmieniony = 'Login został zmieniony.';
$kom_dane_do_logowania = 'Dane do logowania';
$kol_termin_platnosci = 'Termin płatności';
$kom_warunki_platnosci = 'Warunki płatności';
$kom_dane_do_faktury = 'Dane do faktury';
$kom_dane_do_faktury_zostaly_zmienione = 'Dane do faktury zostały zmienione.';
$kom_informacje_ogolne_zmienione = 'Informacje ogólne zostały zmienione.';
$kom_dane_warunki_platnosci = 'Warunki płatności';
$kom_dane_do_logowania = 'Dane do logowania';
$kom_adres_dostawcy = 'Adres dostawy';
$kom_zaznacz_aby_usunac_klienta_z_bazy = 'Zaznacz, aby usunąć klienta z bazy ';
$kom_klient_aktywny = 'Klient aktywny ';
$kom_zmien_dane = 'Zmień dane';
$kom_warunki_platnosci_zostaly_zmienione = 'Warunki płatności zostały zmienione.';


$adres_ip = $_SERVER['REMOTE_ADDR'];
$znaczek_tylda = '~';

$lokalny_adres_email = 'braniewska7@gmail.com';
$zalogowany_user = isset($_SESSION["USER_ID"]) ? $_SESSION["USER_ID"] : '';
$linia_rozdzielajaca = '----------------------------------------';
$logo_do_potwierdzen = 'http://arcus-luki.nazwa.pl/panel_dane/arcus-logo-big.jpg';


$time = time();
$aktualny_dzien = date('j', $time);    //j  Day of the month without leading zeros
$AKTUALNY_DZIEN = date('d', $time);    //d  Day of the month, 2 digits with leading zeros  	01 to 31
$aktualny_miesiac = date('n', $time);  //n 	Numeric representation of a month, without leading zeros
$AKTUALNY_MIESIAC = date('m', $time);  //m  Numeric representation of a month, with leading zeros  	01 through 12
$aktualny_rok = date('y', $time); 
$AKTUALNY_ROK = date('Y', $time);      //Y  A full numeric representation of a year, 4 digits  	Examples: 1999 or 2003
$AKTUALNA_GODZINA = date('H', $time);  //H  Godzina, w formacie 24-godzinnym, z zerami wiodacymi 	00 through 23
$AKTUALNA_MINUTA = date('i', $time);   //i 	Minuty z zerami wiodacymi 	00 do 59
$AKTUALNA_SEKUNDA = date('s', $time);  //s 	Sekundy, z zerami wiodacymi 	00 az do 59

$dzis = date('d-m-Y', $time);
/*

	$data_poczatkowa_time = mktime(0,0,0,$pieces[1], $pieces[0], $pieces[2]);
	int mktime ( int $godzina , int $minuta , int $sekunda , int $miesiac , int $dzies , int $rok [, int $letni/zimowy ] )

*/
$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[1] = 'Wyfrezować rowek typu U';
$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[2] = 'Wyfrezować rowek typu V';
$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[3] = 'Ściąć na płasko';
$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[4] = 'Wypolerować';
$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[5] = 'Nie czyścić';
$TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW[6] = 'Wg zamówienia';
$DLUGOSC_TABELA_SPOSOB_CZYSZCZENIA_ZGRZEWOW = 6;

$TABELA_SPOSOB_FREZOWANIA_ODWODNIEN[1] = '5x25';
$TABELA_SPOSOB_FREZOWANIA_ODWODNIEN[2] = '5x28';
$TABELA_SPOSOB_FREZOWANIA_ODWODNIEN[3] = 'Inna';
$TABELA_SPOSOB_FREZOWANIA_ODWODNIEN[4] = 'Nie frezować';
$TABELA_SPOSOB_FREZOWANIA_ODWODNIEN[5] = 'Wg zamówienia';
$DLUGOSC_TABELA_SPOSOB_FREZOWANIA_ODWODNIEN = 5;

$TABELA_STOPIEN_TRUDNOSCI[1] = 0.25;
$TABELA_STOPIEN_TRUDNOSCI[2] = 0.5;
$TABELA_STOPIEN_TRUDNOSCI[3] = 1;
$TABELA_STOPIEN_TRUDNOSCI[4] = 2;
$TABELA_STOPIEN_TRUDNOSCI[5] = 3;
$DLUGOSC_TABELA_STOPIEN_TRUDNOSCI = 5;


//########## #TABELE ####################################################################################################################################
$tabela_klientow = "klienci";
$tabela_logowan_klientow = "logowania_klientow";

$tabulator = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$vat = 1.23;
$waluta = ' zł';
###################### nazwy kolumn w tabelach ##############
$kol_lp = 'LP';
$kol_jednostka = 'Jednostka';
$kol_imie = 'Imię';
$kol_imie_nazwisko = 'Imię i nazwisko';
$kol_nazwisko = 'Nazwisko';
$kol_stanowisko = 'Stanowisko';
$kol_status_firmy = 'Status firmy';
$kol_login = 'Login';
$kol_zamawiany_towar = 'Zamawiany towar';
$kol_klient = 'Klient';
$kol_haslo = 'Hasło';
$kol_strefa = 'Strefa';
$kol_login_haslo = 'Login/Hasło';
$kol_kod_pocztowy = 'Kod pocztowy';
$kol_telefon = 'Telefon';
$kol_fax = 'Fax';
$kol_nip = 'NIP';
$kol_nazwa = 'Nazwa';
$kol_pelna_nazwa = 'Pełna nazwa';
$kol_podpis = 'Podpis';
$kol_zamowic_profile = 'Zamówić profile';
$kol_wartosc_profili = 'Wartość profili';

$kol_wydane_profile = 'Wydane profile';
$kol_wygiete_profile_pvc = 'Wygięte profile z pvc';
$kol_wyfrezowane_odwodnienia = 'Wyfrezowane odwodnienia';
$kol_zgrzane_profile = 'Zgrzane profile';
$kol_wstawione_slupki = 'Wstawione słupki';
$kol_dociete_listwy = 'Docięcie listwy przyszybowej tylko łukowej';
$kol_dociecie_kompletu_listew_przyszybowych = 'Docięcie kompletu listew przyszybowych';
$kol_okute_elementy = 'Okute elementy';
$kol_zaszklone_elementy = 'Zaszklone elementy';
$kol_spakowane_wyroby = 'Spakowane wyroby';




$kol_szablony_przy_wyrobach = 'Szablony przy wyrobach';
$kol_szablony_luzem = 'Szablony luzem';
$kol_profile = 'Profile';
$kol_uszczelki = 'Uszczelki';
$kol_email = 'Email';
$kol_email_wycena = 'Email do wycen';
$kol_email_potwierdzenie = 'Email do potwierdzeń';
$kol_ulica = 'Ulica';
$kol_miasto = 'Miasto';
$kol_adres = 'Adres';
$kol_adres_dostawy = 'Adres dostawy';
$kol_data_dodania = "Data dodania";
$kol_data_zamowienia = "Data zamówienia";
$kol_data_wyslania = "Data wysłania";
$kol_data_ostatniego_zamowienia = "Data ostatniego zamówienia";
$kol_data_wyslania_listy_materialow = 'Data<br><br>wysłania<br><br>listy<br><br>materiałów';
$kol_data_ostatniego_logowania = "Data ostatniego logowania";
$kol_stanowisko = "Stanowisko";
$kol_status_logowania = "Status logowania";
$kol_element = 'Element';
$kol_edycja = 'Edycja';
$kol_usun = 'Usuń';
$kol_artykul = 'Artykuł';
$kol_kolor = 'Kolor';
$kol_uszczelka = 'Uszczelka';
$kol_symbol_profilu = 'Symbol profilu';
$kol_symbol = 'Symbol';
$kol_symbol_koloru = 'Symbol koloru';
$kol_ilosc_na_magazynie = 'Ilość na magazynie';
$kol_cena_netto_zakupu_eu = 'Cena netto<br><br>zakupu eu';
$kol_cena_netto_zakupu_zl = 'Cena netto<br><br>zakupu zł';

$kol_cena_zakupu_netto = 'Cena zakupu netto';
$kol_cena_sprzedazy_netto = 'Cena sprzedaży netto';
$kol_wartosc_netto_pln = 'Wartość netto PLN';

$kol_cena_netto_zakupu_eu2 = 'Cena netto zakupu eu';
$kol_cena_netto_zakupu_zl2 = 'Cena netto zakupu zł';
$kol_cena_netto_sprzedazy_eu = 'Cena netto<br><br>sprzedaży eu';
$kol_cena_netto_sprzedazy_zl = 'Cena netto<br><br>sprzedaży zł';
$kol_wartosc_netto_zl = 'Wartość netto zł';
$kol_typ = 'Typ';
$kol_produkt = 'Produkt';
$kol_system_prolifi = 'System profili';
$kol_system = 'System';
$kol_rodzaj_okuc = 'Rodzaj okuć';
$kol_rodzaj_szyb = 'Rodzaj szyb';
$kol_kolor_profili = 'Kolor profili';
$kol_kolor_uszczelek = 'Kolor uszczelek';
$kol_magazyn = 'Magazyn';
$kol_stan = 'Stan';
$kol_sztuki = 'Sztuki';
$kol_luki_pvc = 'Łuki z pvc';
$kol_luki_stal= 'Łuki ze stali';
$kol_luki_alu = 'Łuki z alu';
$kol_luki_aluminium = 'Łuki z aluminium';
$kol_zgrzewy = 'Zgrzewy';
$kol_odwodnienia = 'Odwodnienia';
$kol_otwory_pod_klamke = 'Otwory pod klamkę';
$kol_otwory_odpowietrzajace = 'Otwory odpowietrzające';
$kol_osoba_do_kontaktu = 'Osoba do kontaktu';
$kol_slupki = 'Słupki stałe';
$kol_slupki_ruchome = 'Słupki ruchome';
$kol_okuwanie = 'Okuwanie';
$kol_szklenie = 'Szklenie';
$kol_sposob_platnosci = 'Sposób płatności';
$kol_dociecie_listwy = 'Docięcie listwy tylko łukowej';
$kol_dociecie_kompletu_listew = 'Docięcie kompletu listew';
$kol_nr_wyceny = 'Nr wyceny';
$kol_wartosc_netto = 'Wartość netto zamówienia';
$kol_wartosc_brutto = 'Wartość brutto zamówienia';
$kol_termin_realizacji = 'Termin realizacji zamówienia';
$kol_data_dostawy = 'Data dostawy';
$kol_nr_zlecenia_transportowego = 'Nr zlecenia transportowego';
$kol_nr_faktury = 'Nr faktury';
$kol_status_zamowienia = 'Status zamówienia';
$kol_status = 'Status';
$kol_uwagi = 'Uwagi';
$kol_uwagi_pdf = 'Uwagi do potwierdzenia (PDF)';
$kol_uwagi_email = 'Uwagi do treści email';
$kol_odbior = 'Odbiór';
$kol_zwrot = 'Zwrot';
$kol_status_platnosci = 'Status<br><br>płatności';
$kol_pozycje_wyceny = 'Pozycje wyceny';
$kol_pozycje_zamowienia = 'Pozycje zamówienia';
$kol_status_zamowien = 'Status zamówień';
$kol_suma_pobran_brutto = 'Suma pobrań brutto';
$kol_Drzwi_wewnetrzne = 'Drzwi wewnętrzne';
$kol_Drzwi_zewnetrzne = 'Drzwi zewnętrzne';
$kol_Rolety_wewnetrzne = 'Rolety wewnętrzne';
$kol_Rolety_zewnetrzne = 'Rolety zewnętrzne';
$kol_Montaz = 'Montaż';


$kol_wycena = 'Wycena';
$kol_nr_zamowienia = 'Nr zamówienia';
$kol_nr_reklamacji = 'Nr reklamacji';
$kol_potwierdzenie_dostawy = 'Potwierdzenie dostawy';
$kol_kurs_euro = 'Kurs EURO';
$kol_sposob_dostawy = 'Sposób dostawy';
$kol_kierowca = 'Kierowca';
$kol_data_zaladunku = "Data załadunku";
$kol_data_wyjazdu = "Data wyjazdu";
$kol_suma_zamowien_brutto = "Suma zamówień brutto";
$kol_liczba_paczek = 'Liczba paczek wyrobów';
$kol_data_wykonania = "Data wykonania";
$kol_pozycja = "Pozycja";
$kol_rodzaj_produktu = "Rodzaj produktu";
$kol_pracownik = "Pracownicy";
$kol_data_wysylki_potwierdzenia = "Data<br><br>wysyłki<br><br>potwierdzenia<br><br>zamówienia";
$kol_data_wysylki_potwierdzenia_dostawy = "Data<br><br>wysyłki<br><br>potwierdzenia<br><br>dostawy";
$kol_data_przyjecia_zamowienia = "Data<br><br>przyjęcia<br><br>zamówienia";
$kol_data_przyjecia_zamowienia2 = "Data przyjęcia zamówienia";
$kol_nr_zamowienia_arcus = "Nr<br><br>zamówienia<br><br>ARCUS";
$kol_nr_zamowienia_arcus2 = "Nr zamówienia ARCUS";
$kol_nr_zamowienia_arcus_klienta = "Nr zamówienia<br><br>ARCUS | klienta";
$kol_nr_zamowienia_arcus_klienta2 = "Nr zam ARCUS | Nr zam klienta | Nr faktury";
$kol_nr_zamowienia_klienta = "Nr<br><br>zamówienia<br><br>klienta";
$kol_nr_zamowienia_klienta2 = "Nr zamówienia klienta";
$kol_material = "Materiał";
$kol_zamowiony_produkt = "Zamówiony<br><br>produkt";
$kol_ilosc = "Ilość";
$kol_wyslij_tabele = "Wyślij tabelę";
$kol_ilosc_szt = "Ilość szt";
$kol_ilosc_m = "Ilość m";
$kol_cena = "Cena";
$kol_wartosc = "Wartość";
$kol_wartosc_zamowienia= "Wartość zamówienia";
$kol_wartosc_zamowienia_netto2 = "Wartość<br><br>netto<br><br>zamówienia";
$kol_wartosc_zamowienia_brutto2 = "Wartość<br><br>brutto<br><br>zamówienia";
$kol_termin_realizacji_zamowienia2 = "Termin<br><br>realizacji<br><br>zamówienia";
$kol_data_dostawy2 = "Data<br><br>dostawy";
$kol_nr_zlecenia_transportowego2 = "Nr<br><br>zlecenia<br><br>transportowego";
$kol_nr_zlecenia_transportowego3 = "Nr zlecenia<br><br>transportowego";
$kol_status_zamowienia2 = "Status<br><br>zamówienia";
$kol_data_ostatniej_oferty = "Data ostatniej oferty";
				
//########## FV ##########
$kol_nr_fv = "Nr faktury";	
$napis_wyslij_fv_przez_email = 'Wyślij fakturę przez e-mail';
$napis_wyslij_fv_do_ksiegowosci = 'Wyślij fakturę do księgowości';
$napis_wyslij_korekte_przez_email = 'Wyślij korektę przez e-mail';
$napis_wyslij_proforme_przez_email = 'Wyślij proformę przez e-mail';
$napis_wyslij_przypomnienie_zaplaty = 'Wyślij przypomnienie zapłaty';						
$napis_drukuj_fakture = 'Drukuj';						
$napis_drukuj_zestawienie_faktur = 'Drukuj zestawienie faktur';			
$kolor_typ_dok['Faktura'] ="#ffffff";			
$kolor_typ_dok['Duplikat'] ="#00fbf8";			
$kolor_typ_dok['Proforma'] ="#1bc860";			
$kolor_typ_dok['Korekta'] ="#f29011";			

//########## rozne zmienne ##########
$kolor_tabeli = "#e24139";
$kolor_tabeli_edycja = "#FE1D1D";
$kolor_szary = "#d4d8d3";
$kolor_ciemno_szary = "#a8a8a6";
$kolor_jasno_szary = "#e6e6e6";

$kolor_bialy = "#FFFFFF";
$kolor_nie_edytowalne = "#EEEEEE";
$kolor_pz = '#F30606';
$kolor_wz = '#17D517';
$kolor_pw = '#8B4513';
$kolor_rw = '#4B0082';
$kolor_bo = '#26D7D5';
$br = '<br><br><br><br>';

$aktualny_tydzien = date('W', $time);


if($aktualny_tydzien <=8)
	{
	$poczatek_tydzien = 53 + ($aktualny_tydzien - 8);
	$aktualny_rok--;
	}
else $poczatek_tydzien = $aktualny_tydzien - 8;


$TAB_DATA_DOSTAWY_DL = 53;
for($t = 1; $t <=$TAB_DATA_DOSTAWY_DL; $t++)
	{
	if(($poczatek_tydzien >= 1) && ($poczatek_tydzien <=9)) 
		{
		$TAB_DATA_DOSTAWY[$t] = 'T0'.$poczatek_tydzien.'/'.$aktualny_rok;
		$TAB_DATA_DOSTAWY2[$t] = '0'.$poczatek_tydzien.'/';
		}
	else 
		{
		$TAB_DATA_DOSTAWY[$t] = 'T'.$poczatek_tydzien.'/'.$aktualny_rok;
		$TAB_DATA_DOSTAWY2[$t] = $poczatek_tydzien.'/';
		}
	
	if($poczatek_tydzien < 53) $poczatek_tydzien++;
	else 
		{
		$poczatek_tydzien = 1;
		$aktualny_rok++;
		}
	}
	
$TABELA_LISTA_PRODUKTOW[0] = 'Profile';
$TABELA_LISTA_PRODUKTOW[1] = 'Łuki z pvc';
$TABELA_LISTA_PRODUKTOW[2] = 'Łuki ze stali';
$TABELA_LISTA_PRODUKTOW[3] = 'Łuki z alu';
$TABELA_LISTA_PRODUKTOW[4] = 'Zgrzewy';
$TABELA_LISTA_PRODUKTOW[5] = 'Słupki';
$TABELA_LISTA_PRODUKTOW[6] = 'Odwodnienia';
$TABELA_LISTA_PRODUKTOW[7] = 'Docięcie listwy przyszybowej tylko łukowej';
$TABELA_LISTA_PRODUKTOW[8] = 'Okuwanie';
$TABELA_LISTA_PRODUKTOW[9] = 'Szklenie';
$TABELA_LISTA_PRODUKTOW[10] = 'Wyroby';
$TABELA_LISTA_PRODUKTOW[11] = 'Docięcie kompletu listew przyszybowych';
$dl_lista_produktow = 11;

$wojewodztwa = ['dolnośląskie', 'kujawsko-pomorskie', 'lubelskie', 'lubuskie', 'łódzkie', 'małopolskie', 'mazowieckie', 'opolskie', 'podkarpackie', 'podlaskie', 'pomorskie', 'śląskie', 'świętokrzyskie', 'warmińsko-mazurskie', 'wielkopolskie', 'zachodniopomorskie'];


$TABELA_STATUS_ZAMOWIEN_DO_DOSTAWCOW[1] = 'Niewysłane';
$TABELA_STATUS_ZAMOWIEN_DO_DOSTAWCOW[2] = 'Wysłane';
$TABELA_STATUS_ZAMOWIEN_DO_DOSTAWCOW[3] = 'Zrealizowane';
$DL_TABELA_STATUS_ZAMOWIEN_DO_DOSTAWCOW = 3;

$TABELA_LISTA_JEDNOSTEK[1] = 'szt.';
$TABELA_LISTA_JEDNOSTEK[2] = 'kg';
$DL_TABELA_LISTA_JEDNOSTEK = 2;


$TABELA_MIESIECY[1] = 'Styczeń';
$TABELA_MIESIECY[2] = 'Luty';
$TABELA_MIESIECY[3] = 'Marzec';
$TABELA_MIESIECY[4] = 'Kwiecień';
$TABELA_MIESIECY[5] = 'Maj';
$TABELA_MIESIECY[6] = 'Czerwiec';
$TABELA_MIESIECY[7] = 'Lipiec';
$TABELA_MIESIECY[8] = 'Sierpień';
$TABELA_MIESIECY[9] = 'Wrzesień';
$TABELA_MIESIECY[10] = 'Październik';
$TABELA_MIESIECY[11] = 'Listopad';
$TABELA_MIESIECY[12] = 'Grudzień';

$TABELA_STREFY[1] = '';
$TABELA_STREFY[2] = '1';
$TABELA_STREFY[3] = '2';
$TABELA_STREFY[4] = '3';
$TABELA_STREFY[5] = '4';
$TABELA_STREFY[6] = 'Inna';
$DL_TABELA_STREFY = 6;

// tworzymy liste rozwijana do sortowania zakladki wycena dane
$ROK_STARTOWY_WYCENA_DANE = 2016;
$licz = 0;
while ($ROK_STARTOWY_WYCENA_DANE <= $AKTUALNY_ROK) 
	{
	$licz++;
	$TABELA_LISTA_LAT_WYCENA_DANE[$licz] = $ROK_STARTOWY_WYCENA_DANE;
	$ROK_STARTOWY_WYCENA_DANE++;
	}
$DLUGOSC_TABELA_LISTA_LAT_WYCENA_DANE = $licz;

//5184000 dwa miechy 60 dni
$czas_miedzy_zamowieniami_2 = 5184000;


$powrot_do_ustawienia_dodaj_zamowienie = '<br><br><center><a href="index.php?page=ustawienia_dz_lista&zamowienie_id='.$zamowienie_id.'&skad='.$skad.'">Powrót - Ustawienia</a><center>';
$powrot_do_ustawienia_suwaki_lista = '<br><br><center><a href="index.php?page=ustawienia_suwaki_lista">Powrót - Ustawienia</a><center>';

$powrot_do_wycen_wstepnych = '<br><br><center><a href="index.php?page=wyceny_wstepne&wg_czego='.$wg_czego.'&jak='.$jak.'">Powrót - Rejestr wycen</a><center>';
$powrot_do_sposob_czyszczenia_zgrzewow = '<br><br><center><a href="index.php?page=sposob_czyszczenia_zgrzewow&wg_czego='.$wg_czego.'&jak='.$jak.'">Powrót - Sposób czyszczenia zgrzewów</a><center>';
$powrot_do_sposob_frezowania_odwodnien = '<br><br><center><a href="index.php?page=sposob_frezowania_odwodnien&wg_czego='.$wg_czego.'&jak='.$jak.'">Powrót - Sposób frezowania odwodnień</a><center>';

$powrot_do_wycen_wstepnej = '<br><br><center><a href="index.php?page=wycena_wstepna_edycja&wycena_wstepna_nr='.$wycena_wstepna_nr.'&wg_czego='.$wg_czego.'&jak='.$jak.'">Powrót - Edycja wyceny wstępnej</a><center>';
$powrot_do_rysunkow = '<br><br><center><a href="index.php?page=wycena_wstepna_rysunki&wg_czego='.$wg_czego.'&jak='.$jak.'">Powrót - Rysunki</a><center>';

$powrot_do_dostawcow = '<br><br><center><a href="index.php?page=dostawcy&jak=DESC&wg_czego=id">Powrót - Dostawcy</a><center>';
$powrot_do_klienci = '<br><br><center><a href="index.php?page=klienci&jak='.$jak.'&wg_czego='.$wg_czego.'">Powrót - Klienci</a><center>';
$powrot_do_klienci_wstecz = '<br><br><center><a href="index.php?page=klienci&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj_klienta='.$szukaj_klienta.'&szukaj=1">Wstecz - Klienci</a><center>';
$powrot_do_uzytkownicy = '<br><br><center><a href="index.php?page=uzytkownicy&jak=DESC&wg_czego=id">Powrót - Użytkownicy</a><center>';
$powrot_do_minimalne_promienie = '<br><br><center><a href="index.php?page=minimalne_promienie&jak='.$jak.'&wg_czego='.$wg_czego.'&SORT_SYMBOL_PROFILU='.$SORT_SYMBOL_PROFILU.'&SORT_SYSTEM='.$SORT_SYSTEM.'">Powrót - Minimalne promienie</a><center>';
$powrot_do_zachodzenia = '<br><br><center><a href="index.php?page=zachodzenia&jak='.$jak.'&wg_czego='.$wg_czego.'">Powrót - Zachodzenia</a><center>';
$powrot_do_zamowienia = '<br><br><center><a href="index.php?page=zamowienia&jak='.$jak.'&wg_czego='.$wg_czego.'">Powrót do rejestru zamówień</a><center>';
$powrot_do_zamowienia_wstecz = '<br><br><center><a href="index.php?page=zamowienia&jak='.$jak.'&wg_czego='.$wg_czego.'&pokaz='.$pokaz.'&SORT_STAN='.$SORT_STAN.'&SORT_NR_ZLECENIA_TRANSPORTOWEGO='.$SORT_NR_ZLECENIA_TRANSPORTOWEGO.'&SORT_PROFIL='.$SORT_PROFIL.'&SORT_RODZAJ_SZYB='.$SORT_RODZAJ_SZYB.'&SORT_RODZAJ_OKUC='.$SORT_RODZAJ_OKUC.'&SORT_MAGAZYN='.$SORT_MAGAZYN.'&SORT_KOLOR_PROFILI='.$SORT_KOLOR_PROFILI.'&SORT_NR_ZAMOWIENIA='.$SORT_NR_ZAMOWIENIA.'&SORT_NR_ZAMOWIENIA_KLIENTA='.$SORT_NR_ZAMOWIENIA_KLIENTA.'&SORT_ZAMOWIONY_PRODUKT='.$SORT_ZAMOWIONY_PRODUKT.'&SORT_TERMIN_REALIZACJI='.$SORT_TERMIN_REALIZACJI.'&SORT_KOLOR_USZCZELEK='.$SORT_KOLOR_USZCZELEK.'&SORT_DATA_PRZYJECIA='.$SORT_DATA_PRZYJECIA.'&SORT_DATA_DOSTAWY='.$SORT_DATA_DOSTAWY.'&SORT_STATUS='.$SORT_STATUS.'&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA.'">Wstecz - Zamówienia</a><center>';
$powrot_do_konkretnego_zamowienia = '<br><br><center><a href="index.php?page=zamowienie_edycja&zamowienie_id='.$zamowienie_id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&pokaz='.$pokaz.'&SORT_STAN='.$SORT_STAN.'&SORT_NR_ZLECENIA_TRANSPORTOWEGO='.$SORT_NR_ZLECENIA_TRANSPORTOWEGO.'&SORT_PROFIL='.$SORT_PROFIL.'&SORT_RODZAJ_SZYB='.$SORT_RODZAJ_SZYB.'&SORT_RODZAJ_OKUC='.$SORT_RODZAJ_OKUC.'&SORT_MAGAZYN='.$SORT_MAGAZYN.'&SORT_KOLOR_PROFILI='.$SORT_KOLOR_PROFILI.'&SORT_NR_ZAMOWIENIA='.$SORT_NR_ZAMOWIENIA.'&SORT_NR_ZAMOWIENIA_KLIENTA='.$SORT_NR_ZAMOWIENIA_KLIENTA.'&SORT_ZAMOWIONY_PRODUKT='.$SORT_ZAMOWIONY_PRODUKT.'&SORT_TERMIN_REALIZACJI='.$SORT_TERMIN_REALIZACJI.'&SORT_KOLOR_USZCZELEK='.$SORT_KOLOR_USZCZELEK.'&SORT_DATA_PRZYJECIA='.$SORT_DATA_PRZYJECIA.'&SORT_DATA_DOSTAWY='.$SORT_DATA_DOSTAWY.'&SORT_STATUS='.$SORT_STATUS.'&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA.'">Powrót do zamówienia</a><center>';

$powrot_do_wyceny = '<br><br><center><a href="index.php?page=wycena_edycja&zamowienie_id='.$zamowienie_id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&pokaz='.$pokaz.'&SORT_STAN='.$SORT_STAN.'&SORT_NR_ZLECENIA_TRANSPORTOWEGO='.$SORT_NR_ZLECENIA_TRANSPORTOWEGO.'&SORT_PROFIL='.$SORT_PROFIL.'&SORT_RODZAJ_SZYB='.$SORT_RODZAJ_SZYB.'&SORT_RODZAJ_OKUC='.$SORT_RODZAJ_OKUC.'&SORT_MAGAZYN='.$SORT_MAGAZYN.'&SORT_KOLOR_PROFILI='.$SORT_KOLOR_PROFILI.'&SORT_NR_ZAMOWIENIA='.$SORT_NR_ZAMOWIENIA.'&SORT_NR_ZAMOWIENIA_KLIENTA='.$SORT_NR_ZAMOWIENIA_KLIENTA.'&SORT_ZAMOWIONY_PRODUKT='.$SORT_ZAMOWIONY_PRODUKT.'&SORT_TERMIN_REALIZACJI='.$SORT_TERMIN_REALIZACJI.'&SORT_KOLOR_USZCZELEK='.$SORT_KOLOR_USZCZELEK.'&SORT_DATA_PRZYJECIA='.$SORT_DATA_PRZYJECIA.'&SORT_DATA_DOSTAWY='.$SORT_DATA_DOSTAWY.'&SORT_STATUS='.$SORT_STATUS.'&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA.'">Powrót do wyceny</a><center>';

$powrot_do_fakturowania = '<br><br><center><a href="index.php?page=fv_fakturowanie&rodzaj_dokumentu='.$rodzaj_dokumentu.'&jak='.$jak.'&wg_czego='.$wg_czego.'&termin_wystawienia=on&szukany_miesiac='.$AKTUALNY_MIESIAC.'">Powrót do fakturowania</a><center>';


$powrot_do_wysortowanych_zamowien = '<br><br><center><a href="index.php?page=zamowienia&jak='.$jak.'&wg_czego='.$wg_czego.'&pokaz='.$pokaz.'&SORT_STAN='.$SORT_STAN.'&SORT_STREFA='.$SORT_STREFA.'&SORT_NR_ZLECENIA_TRANSPORTOWEGO='.$SORT_NR_ZLECENIA_TRANSPORTOWEGO.'&SORT_PROFIL='.$SORT_PROFIL.'&SORT_RODZAJ_SZYB='.$SORT_RODZAJ_SZYB.'&SORT_RODZAJ_OKUC='.$SORT_RODZAJ_OKUC.'&SORT_MAGAZYN='.$SORT_MAGAZYN.'&SORT_KOLOR_PROFILI='.$SORT_KOLOR_PROFILI.'&SORT_NR_ZAMOWIENIA='.$SORT_NR_ZAMOWIENIA.'&SORT_NR_ZAMOWIENIA_KLIENTA='.$SORT_NR_ZAMOWIENIA_KLIENTA.'&SORT_ZAMOWIONY_PRODUKT='.$SORT_ZAMOWIONY_PRODUKT.'&SORT_TERMIN_REALIZACJI='.$SORT_TERMIN_REALIZACJI.'&SORT_KOLOR_USZCZELEK='.$SORT_KOLOR_USZCZELEK.'&SORT_DATA_PRZYJECIA='.$SORT_DATA_PRZYJECIA.'&SORT_DATA_DOSTAWY='.$SORT_DATA_DOSTAWY.'&SORT_STATUS='.$SORT_STATUS.'&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA.'">Powrót do wysortowanych zamówień</a><center>';

$powrot_do_rejestru_zamowien_do_dostawcow = '<br><br><center><a href="index.php?page=zamowienia_do_dostawcow&jak='.$jak.'&wg_czego='.$wg_czego.'&pokaz='.$pokaz.'&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA.'&SORT_NUMERY_ZAMOWIEN='.$SORT_NUMERY_ZAMOWIEN.'&SORT_DATA_ZAMOWIENIA='.$SORT_DATA_ZAMOWIENIA.'&SORT_DATA_WYSLANIA='.$SORT_DATA_WYSLANIA.'&SORT_STATUS='.$SORT_STATUS.'">Powrót do rejestru zamówień</a><center>';
$powrot_do_rejestru_zamowien_do_dostawcow_z_dodawania = '<br><br><center><a href="index.php?page=zamowienia_do_dostawcow&jak=DESc&wg_czego=data_zamowienia_time">Powrót do rejestru zamówień</a><center>';

$powrot_do_rejestru_zamowien = '<br><br><center><a href="index.php?page=zamowienia&jak='.$jak.'&wg_czego='.$wg_czego.'">Powrót do rejestru zamówień</a><center>';
$powrot_do_magazynu = '<br><br><center><a href="index.php?page=magazyn&jak='.$jak.'&wg_czego='.$wg_czego.'&pokaz='.$pokaz.'&SORT_SYSTEM='.$SORT_SYSTEM.'&SORT_ELEMENT='.$SORT_ELEMENT.'&SORT_KOLOR='.$SORT_KOLOR.'&SORT_SYMBOL_KOLORU='.$SORT_SYMBOL_KOLORU.'&SORT_SYMBOL_PROFILU='.$SORT_SYMBOL_PROFILU.'&SORT_KOLOR_USZCZELEK='.$SORT_KOLOR_USZCZELEK.'&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA.'">Powrót do magazynu</a><center>';
$powrot_do_magazynu2 = '<br><br><center><a href="index.php?page=magazyn&jak='.$jak.'&wg_czego='.$wg_czego.'">Powrót do magazynu</a><center>';
$powrot_do_artykulu_dodaj = '<br><br><center><a href="index.php?page=magazyn_szukaj&artykul_id='.$artykul_id.'&szukaj_symbol_profilu='.$szukaj_symbol_profilu.'&jak='.$jak.'&wg_czego='.$wg_czego.'&pokaz='.$pokaz.'&SORT_SYSTEM='.$SORT_SYSTEM.'&SORT_ELEMENT='.$SORT_ELEMENT.'&SORT_KOLOR='.$SORT_KOLOR.'&SORT_SYMBOL_KOLORU='.$SORT_SYMBOL_KOLORU.'&SORT_SYMBOL_PROFILU='.$SORT_SYMBOL_PROFILU.'&SORT_KOLOR_USZCZELEK='.$SORT_KOLOR_USZCZELEK.'&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA.'">Powrót do artykułu</a><center>';
$powrot_do_artykulu_edycja = '<br><br><center><a href="index.php?page=magazyn_szukaj&artykul_id='.$artykul_id.'&szukaj_symbol_profilu='.$szukaj_symbol_profilu.'&jak='.$jak.'&wg_czego='.$wg_czego.'&pokaz='.$pokaz.'&SORT_SYSTEM='.$SORT_SYSTEM.'&SORT_ELEMENT='.$SORT_ELEMENT.'&SORT_KOLOR='.$SORT_KOLOR.'&SORT_SYMBOL_KOLORU='.$SORT_SYMBOL_KOLORU.'&SORT_SYMBOL_PROFILU='.$SORT_SYMBOL_PROFILU.'&SORT_KOLOR_USZCZELEK='.$SORT_KOLOR_USZCZELEK.'&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA.'">Powrót do artykułu</a><center>';


$powrot_do_nowego_zamowienia = '<br><br><center><a href="index.php?page=zamowienie_dodaj&jak='.$jak.'&wg_czego='.$wg_czego.'&klient='.$nowy_klient_id.'">Powrót do nowego zamówienia</a><center>';

$powrot_do_zlecenia_transportowe = '<br><br><center><a href="index.php?page=zlecenia_transportowe&jak='.$jak.'&wg_czego='.$wg_czego.'">Powrót - Lista zleceń transportowych</a><center>';
$powrot_do_konkretnego_zlecenia_transportowego = '<br><br><center><a href="index.php?page=zlecenie_transportowe_pokaz&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'">Powrót do zlecenia transportowego</a><center>';
$powrot_do_konkretnego_zlecenia_transportowego_edycja = '<br><br><center><a href="index.php?page=zlecenie_transportowe_pokaz&id='.$id_zlec_transp.'&jak='.$jak.'&wg_czego='.$wg_czego.'">Powrót do zlecenia transportowego</a><center>';
$powrot_do_realizacja_produkcji = '<br><br><center><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&klienci_do_planu_produkcji='.$klienci_do_planu_produkcji.'&jak='.$jak.'&wg_czego='.$wg_czego.'">Powrót</a></center>';
$powrot_do_realizacja_produkcji_historia_wpisow = '<br><br><center><a href="index.php?page=realizacja_produkcji_historia_wpisow&jak=DESC&wg_czego=id&data_poczatkowa='.$data_poczatkowa.'&data_koncowa='.$data_koncowa.'&sprawdzany_pracownik='.$sprawdzany_pracownik.'&sprawdzane_zamowienie='.$sprawdzane_zamowienie.'">Powrót</a></center>';
$powrot_do_wystawiania_faktury = '<br><br><center><a href="index.php?page=fv_wystaw&zamowienie_id='.$zamowienie_id.'&wg_czego='.$wg_czego.'&jak='.$jak.'">Powrót do wystawiania faktury</a></center>';
$powrot_do_wystawiania_zamowienie_do_dostawcow = '<br><br><center><a href="index.php?page=zamowienia_do_dostawcow_edycja&zamowienie_id='.$zamowienie_id.'">Powrót do wystawiania zamówienia</a></center>';

$powrot_do_wystawiania_zamowienia_dodaj = '<br><br><center><a href="index.php?page=zamowienie_edycja&zamowienie_id='.$zamowienie_id.'&jak=DESC&wg_czego=id">Powrót do dodawania zamówienia</a></center>';
$powrot_do_wystawiania_zamowienia_wycena = '<br><br><center><a href="index.php?page=zamowienie_wycena&zamowienie_id='.$zamowienie_id.'&jak=DESC&wg_czego=id">Powrót do wystawiania zamówienia</a></center>';
$powrot_do_wystawiania_zamowienia_edycja = '<br><br><center><a href="index.php?page=zamowienie_edycja&zamowienie_id='.$zamowienie_id.'&jak=DESC&wg_czego=id">Powrót do edycji zamówienia</a></center>';

$powrot_do_edycji_wyceny_wstepnej = '<br><br><center><a href="index.php?page=wycena_wstepna_edycja&wycena_wstepna_id='.$wycena_wstepna_id.'">Powrót do edycji wyceny</a><center>';
$powrot_do_rejestru_wycen_wstepnych = '<br><br><center><a href="index.php?page=wyceny_wstepne&jak=DESC&wg_czego=id">Powrót do rejestru wycen</a><center>';



$guzik_realizacja_produkcji = '<br><br><center><a href="index.php?page=realizacja_produkcji"><input type="button" value="REALIZACJA PRODUKCJI" class="button_produkcja_mniejszy"></a></center><br><br>';
$guzik_powrot_do_realizacja_produkcji = '<br><br><center><a href="index.php?page=realizajca_produkcji"><input type="button" value="Powrót" class="button_produkcja_mniejszy"></a></center>';

#################################### OBRAZKI ##############
$pole_obowiazkowe = '<img src="images/pole_obowiazkowe.png" alt="Pole obowiązkowe" title="Pole obowiązkowe">';
$image_arrow_up = '<img src="images/arrow_up1.png" border="0" title="Rosnąco" alt="Rosnąco">';
$image_arrow_down = '<img src="images/arrow_down1.png" border="0" title="Malejąco" alt="Malejąco">';
$image_close = '<img src="images/close.png" border="0" title="Wyłącz filtr" alt="Wyłącz filtr">';
$image_delete = '<img src="images/close.png" border="0" title="Usuń" alt="Usuń" width="16px">';
$image_delete2 = '<img src="images/delete.png" border="0" title="Usuń" alt="Usuń" width="30px">';
$image_edit = '<img src="images/edit.png" border="0" title="Edycja" alt="Edycja">';
$image_printer = '<img src="images/printer.png" border="0" title="Drukuj" alt="Drukuj">';
$image_send_email = '<img src="images/send_email.png" border="0" title="Wyślij" alt="Wyślij">';
$image_green_dot = '<img src="images/green_dot.png" border="0" title="Zalogowany" alt="Zalogowany">';
$image_red_dot = '<img src="images/red_dot.png" border="0" title="Wylogowany" alt="Wylogowany">';
$image_green_dot_mini = '<img src="images/green_dot_mini.png" border="0">';
$image_red_dot_mini = '<img src="images/red_dot_mini.png" border="0">';


////menu produkcja  
$image_menu_wyloguj = '<img src="images/produkcja_menu/wyloguj.png" border="0" width="150px">';
$image_menu_premia_akordowa = '<img src="images/produkcja_menu/premia_akordowa.png" border="0" width="150px">';
$image_menu_zamowienia_do_wykonania = '<img src="images/produkcja_menu/zamowienia_do_wykonania.png" border="0" width="150px">';
$image_menu_zamowienia_wykonane = '<img src="images/produkcja_menu/zamowienia_wykonane.png" border="0" width="150px">';
$image_menu_historia = '<img src="images/produkcja_menu/historia_wpisow.png" border="0" width="150px">';
$image_menu_wzmocnienia = '<img src="images/produkcja_menu/wzmocnienia.png" border="0" width="150px">';
$image_menu_wydajnosc_produkcji = '<img src="images/produkcja_menu/wydajnosc_produkcji.png" border="0" width="150px">';
$image_menu_magazyn = '<img src="images/produkcja_menu/magazyn.png" border="0" width="150px">';
$image_menu_sposob_czyszczenia_zgrzewow = '<img src="images/produkcja_menu/sposob_czyszczenia_zgrzewow.png" border="0" width="150px">';
$image_menu_karty_produkcyjne = '<img src="images/produkcja_menu/karty_produkcyjne.png" border="0" width="150px">';
$image_menu_dlugosc_luku = '<img src="images/produkcja_menu/dlugosc_luku.png" border="0" width="150px">';
$image_menu_przekatna = '<img src="images/produkcja_menu/przekatna.png" border="0" width="150px">';
$image_menu_zlecenia_zaladunkowe = '<img src="images/produkcja_menu/zlecenia_zaladunkowe.png" border="0" width="150px">';




$image_zaplacona = '<img src="images/zaplacona.png" border="0" title="Zapłacona" alt="Zapłacona">';
$image_niezaplacona = '<img src="images/niezaplacona.png" border="0" title="NIEZAPŁACONA" alt="NIEZAPŁACONA">';
$image_nadplata = '<img src="images/nadplata.png" border="0" title="NADPŁATA" alt="NADPŁATA">';
$image_czesciowo = '<img src="images/czesciowo.png" border="0" title="człciowo" alt="człciowo">';
$image_send_mail = '<img src="images/send_mail.png" border="0" title="Wyślij" alt="Wyślij">';
$image_send_mail_gray = '<img src="images/send_mail_gray.png" border="0" title="Wyślij" alt="Wyślij">';
$image_printer_mini = '<img src="images/printer_mini.png" border="0" title="Drukuj" alt="Drukuj">';
$image_printer_mini_gray = '<img src="images/printer_mini_gray.png" border="0" title="Drukuj" alt="Drukuj">';
$image_lista = '<img src="images/lista.png" border="0" title="Lista" alt="Lista">';
$image_logo_mini = '<img src="images/arcus_logo_mini.png" border="0">';
$image_pdf_mini = '<img src="../images/pdf_mini.png" border="0" title="PDF" alt="PDF">';
$image_pdf_mini2 = '<img src="images/pdf_mini.png" border="0" title="PDF" alt="PDF">';
$image_pdf_usun = '<img src="images/pdf_usun.png" border="0" title="PDF" alt="PDF">';
$image_pdf_mini2_gray = '<img src="images/pdf_mini_gray.png" border="0" title="PDF" alt="PDF">';
$image_pdf_mini_edit = '<img src="images/pdf_mini_edit.png" border="0" title="PDF" alt="PDF">';
$image_pdf_icon = '<img src="../images/pdf_icon.png" border="0" title="Pokaż" alt="Pokaż">';
$image_pdf_icon2 = '<img src="images/pdf_icon.png" border="0" title="Pokaż" alt="Pokaż">';
$image_pdf_icon_gray = '<img src="images/pdf_icon_gray.png" border="0" title="Pokaż" alt="Pokaż">';
$image_search = '<img src="images/search.png" border="0">';
$image_search_black = "<img src='images/search_black.png' border='0'>";
$image_wystaw_fv = '<img src="images/wystaw_fv.png" border="0" title="Wystaw fakturę" alt="Wystaw fakturę">';
$image_wystaw_korekte_fv = '<img src="images/wystaw_korekte_fv.png" border="0" title="Wystaw korektę faktury" alt="Wystaw korektę faktury">';
$image_plusik = '<img src="images/plusik.png" border="0" title="Dodaj" alt="Dodaj" height="20px">';
$image_strona_w_budowie = '<img src="images/strona_w_budowie.png" border="0" title="" alt="">';
$image_email = '<img src="images/email.png" border="0" title="Wyślij" alt="Wyślij">';

$image_trash = '<img src="images/trash.png" border="0" title="Usuń" alt="Usuń" height="50px">';
$image_trash_mini = '<img src="images/trash.png" border="0" title="Usuń" alt="Usuń" height="25px">';
$image_rysunek = '<img src="images/rysunek.jpg" border="0" title="Wybierz rysunek" alt="Wybierz rysunek" width="270px">';
$image_archiwum = '<img src="images/archive.ico" border="0" title="Archiwum" alt="Archiwum" height="50px">';

$image_plik_jpg = '<img src="images/plik_jpg.png" border="0" title="" alt="">';
$image_plik_pdf = '<img src="images/plik_pdf.png" border="0" title="" alt="">';
$image_plik_doc = '<img src="images/plik_doc.png" border="0" title="" alt="">';
$image_plik_xls = '<img src="images/plik_xls.png" border="0" title="" alt="">';
$image_plik_nieznany = '<img src="images/plik_nieznany.png" border="0" title="" alt="">';

$image_plik_jpg_mini = '<img src="images/plik_jpg.png" border="0" title="" alt="" height="20px">';
$image_plik_pdf_mini = '<img src="images/plik_pdf.png" border="0" title="" alt="" height="20px">';
$image_plik_doc_mini = '<img src="images/plik_doc.png" border="0" title="" alt="" height="20px">';
$image_plik_xls_mini = '<img src="images/plik_xls.png" border="0" title="" alt="" height="20px">';
$image_plik_nieznany_mini = '<img src="images/plik_nieznany.png" border="0" title="" alt="" height="20px">';
$image_logout = '<img src="images/logout.png" border="0" title="Wyloguj" alt="Wyloguj" height="32px">';


#################################### KONIEC OBRAZKI ##################################
$aktualny_dzien = date('j', $time);    //j  Day of the month without leading zeros
$AKTUALNY_DZIEN = date('d', $time);    //d  Day of the month, 2 digits with leading zeros  	01 to 31
$aktualny_miesiac = date('n', $time);  //n 	Numeric representation of a month, without leading zeros
$AKTUALNY_MIESIAC = date('m', $time);  //m  Numeric representation of a month, with leading zeros  	01 through 12
$aktualny_rok = date('y', $time); 
$AKTUALNY_ROK = date('Y', $time);      //Y  A full numeric representation of a year, 4 digits  	Examples: 1999 or 2003
$AKTUALNA_GODZINA = date('H', $time);  //H  Godzina, w formacie 24-godzinnym, z zerami wiodacymi 	00 through 23
$AKTUALNA_MINUTA = date('i', $time);   //i 	Minuty z zerami wiodacymi 	00 do 59
$AKTUALNA_SEKUNDA = date('s', $time);  //s 	Sekundy, z zerami wiodacymi 	00 aa do 59









?>