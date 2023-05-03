<?php
$napis_guzika_dodaj_liste = 'Dodaj listę materiałów';
$napis_guzika_edytuj_liste = 'Edytuj listę materiałów';
$napis_guzika_dodaj_karte_produkcyjna = 'Dodaj kartę produkcyjną';

if($zapisz == $napis_guzika_dodaj_karte_produkcyjna)
	{
	$nr_zamowienia = edytuj_zamowienie($conn, $nr_zamowienia, $zamowienie_id, $klient, $nr_zamowienia_klienta, $produkt, $profil, $rodzaj_okuc, $rodzaj_szyb, $kolor_profili, $kolor_uszczelek, $magazyn, $stan, $wartosc_netto, $wartosc_brutto, $termin_realizacji, $data_dostawy, $nr_zlecenia_transportowego, $status, $uwagi, $pierwsza_data_przyjecia, $kurs_euro, $rodzaj, $adres_serwera_do_faktur, $uwaga_1, $uwaga_2, $miasto_dostawy, $strefa, $uwagi_do_email, $odbior_materialu, $kod_pocztowy_dostawy, $ulica_dostawy, $zablokowac);
	echo '<head><META HTTP-EQUIV="REFRESH" CONTENT="0; URL=index.php?page=karta_produkcyjna_dodaj&klient='.$klient.'&zamowienie_id='.$zamowienie_id.'&nr_zamowienia='.$nr_zamowienia.'&jak='.$jak.'&wg_czego='.$wg_czego.'"></head>';
	}

if($zapisz == $napis_guzika_dodaj_liste)
	{
	$nr_zamowienia = edytuj_zamowienie($conn, $nr_zamowienia, $zamowienie_id, $klient, $nr_zamowienia_klienta, $produkt, $profil, $rodzaj_okuc, $rodzaj_szyb, $kolor_profili, $kolor_uszczelek, $magazyn, $stan, $wartosc_netto, $wartosc_brutto, $termin_realizacji, $data_dostawy, $nr_zlecenia_transportowego, $status, $uwagi, $pierwsza_data_przyjecia, $kurs_euro, $rodzaj, $adres_serwera_do_faktur, $uwaga_1, $uwaga_2, $miasto_dostawy, $strefa, $uwagi_do_email, $odbior_materialu, $kod_pocztowy_dostawy, $ulica_dostawy, $zablokowac);
	echo '<head><META HTTP-EQUIV="REFRESH" CONTENT="0; URL=index.php?page=lista_materialow_dodaj&klient='.$klient.'&zamowienie_id='.$zamowienie_id.'&nr_zamowienia='.$nr_zamowienia.'&jak='.$jak.'&wg_czego='.$wg_czego.'"></head>';
	}
	
if($zapisz == $napis_guzika_edytuj_liste)
	{
	$nr_zamowienia = edytuj_zamowienie($conn, $nr_zamowienia, $zamowienie_id, $klient, $nr_zamowienia_klienta, $produkt, $profil, $rodzaj_okuc, $rodzaj_szyb, $kolor_profili, $kolor_uszczelek, $magazyn, $stan, $wartosc_netto, $wartosc_brutto, $termin_realizacji, $data_dostawy, $nr_zlecenia_transportowego, $status, $uwagi, $pierwsza_data_przyjecia, $kurs_euro, $rodzaj, $adres_serwera_do_faktur, $uwaga_1, $uwaga_2, $miasto_dostawy, $strefa, $uwagi_do_email, $odbior_materialu, $kod_pocztowy_dostawy, $ulica_dostawy, $zablokowac);
	echo '<head><META HTTP-EQUIV="REFRESH" CONTENT="0; URL=index.php?page=lista_materialow_edycja&klient='.$klient.'&zamowienie_id='.$zamowienie_id.'&nr_zamowienia='.$nr_zamowienia.'&jak='.$jak.'&wg_czego='.$wg_czego.'"></head>';
	}


// ##############################    jezeli klient ma tylko jeden adres dostawy to domyslnie wybieramy miasto
$pytanie = mysqli_query($conn, "SELECT klient_id FROM zamowienia WHERE id=$zamowienie_id;");
while($wynik= mysqli_fetch_assoc($pytanie))
	$klient = $wynik['klient_id'];

$pytanie188 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$klient.";");
while($wynik188= mysqli_fetch_assoc($pytanie188))
	{
	$klient_dostawy_miasto=$wynik188['dostawy_miasto'];
	$klient_pomocniczy_ulica=$wynik188['dostawy_pomocniczy_ulica'];
	$klient_pomocniczy_miasto=$wynik188['dostawy_pomocniczy_miasto'];
	$klient_pomocniczy_kod_pocztowy=$wynik188['dostawy_pomocniczy_kod_pocztowy'];
	}

if(($klient_pomocniczy_ulica == '') && ($klient_pomocniczy_kod_pocztowy == '') && ($klient_pomocniczy_miasto == ''))
	$pytanie116 = mysqli_query($conn, "UPDATE zamowienia SET miasto_dostawy = '".$klient_dostawy_miasto."' WHERE id = ".$zamowienie_id.";");
// #################################################################################################################################



// ###############################################################  zmieniamy adres dostawy po submit radio
if($adres_dostawy != '')
	{
	$pytanie188 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$klient.";");
	while($wynik188= mysqli_fetch_assoc($pytanie188))
		{
		$klient_dostawy_miasto=$wynik188['dostawy_miasto'];
		$klient_pomocniczy_miasto=$wynik188['dostawy_pomocniczy_miasto'];

		$klient_dostawy_ulica=$wynik188['dostawy_ulica'];
		$klient_dostawy_kod_pocztowy=$wynik188['dostawy_kod_pocztowy'];

		$klient_pomocniczy_ulica=$wynik188['dostawy_pomocniczy_ulica'];
		$klient_pomocniczy_kod_pocztowy=$wynik188['dostawy_pomocniczy_kod_pocztowy'];
		}

	if($adres_dostawy == 'glowny') 
	{
		$miasto_dostawy = $klient_dostawy_miasto;
		$kod_pocztowy_dostawy = $klient_dostawy_kod_pocztowy;
		$ulica_dostawy = $klient_dostawy_ulica;
	}
	if($adres_dostawy == 'pomocniczy') 
	{

		$miasto_dostawy = $klient_pomocniczy_miasto;
		$kod_pocztowy_dostawy = $klient_pomocniczy_kod_pocztowy;
		$ulica_dostawy = $klient_pomocniczy_ulica;
	}
	$SQL = [];
	$SQL[1] = "UPDATE zamowienia SET miasto_dostawy = '".$miasto_dostawy."' WHERE id = ".$zamowienie_id.";";
	$SQL[2] = "UPDATE zamowienia SET kod_pocztowy_dostawy = '".$kod_pocztowy_dostawy."' WHERE id = ".$zamowienie_id.";";
	$SQL[3] = "UPDATE zamowienia SET ulica_dostawy = '".$ulica_dostawy."' WHERE id = ".$zamowienie_id.";";
	//wykonanie zapytan
	for($s=1; $s<=3; $s++) mysqli_query($conn, $SQL[$s]);
	
	}
// #################################################################################################################################


if($usunac == 1)
	{
	//echo 'zam id='.$zamowienie_id;
	//spr czy nie jest zablokowane
	$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT zablokowac FROM zamowienia WHERE id = ".$zamowienie_id.";"));
	$zablokowac = $sql['zablokowac'];

	if($zablokowac != 'on')
	{
		//można usuwac
		mysqli_query($conn, "DELETE FROM zamowienia WHERE id = ".$zamowienie_id." LIMIT 1;");
		mysqli_query($conn, "DELETE FROM zlecenia_transportowe_tresc WHERE zamowienie_id = ".$zamowienie_id." LIMIT 1;");
		mysqli_query($conn, "DELETE FROM wyceny WHERE zamowienie_id = ".$zamowienie_id.";");
		echo '<div align="center" class="text_duzy_niebieski"><br>Zamówienie zostało usunięte z bazy</div>';
	}
	else echo '<div align="center" class="text_duzy_czerwony"><br>Zamówienie jest zablkowane. Nie można usunąć.</div>';

	echo $powrot_do_wysortowanych_zamowien;
	echo $powrot_do_rejestru_zamowien;
	}

elseif($zapisz == '+')
	{
	$nr_zamowienia = edytuj_zamowienie($conn, $nr_zamowienia, $zamowienie_id, $klient, $nr_zamowienia_klienta, $produkt, $profil, $rodzaj_okuc, $rodzaj_szyb, $kolor_profili, $kolor_uszczelek, $magazyn, $stan, $wartosc_netto, $wartosc_brutto, $termin_realizacji, $data_dostawy, $nr_zlecenia_transportowego, $status, $uwagi, $pierwsza_data_przyjecia, $kurs_euro, $rodzaj, $adres_serwera_do_faktur, $uwaga_1, $uwaga_2, $miasto_dostawy, $strefa, $uwagi_do_email, $odbior_materialu, $kod_pocztowy_dostawy, $ulica_dostawy, $zablokowac);
	echo '<head><META HTTP-EQUIV="REFRESH" CONTENT="0; URL=index.php?page=ustawienia_dz_lista&zamowienie_id='.$zamowienie_id.'&skad='.$skad.'"> </head>';
	}

elseif($zapisz == 'Zapisz')
	{
	// echo '##################  zapisuje  ######################<br>';
	// sprawdzamy czy poprzedni status to dostarczone
	$pytanie33 = mysqli_query($conn, "SELECT status FROM zamowienia WHERE id = ".$zamowienie_id.";");
	while($wynik33= mysqli_fetch_assoc($pytanie33))
		$stary_status=$wynik33['status'];


	$nr_zamowienia = edytuj_zamowienie($conn, $nr_zamowienia, $zamowienie_id, $klient, $nr_zamowienia_klienta, $produkt, $profil, $rodzaj_okuc, $rodzaj_szyb, $kolor_profili, $kolor_uszczelek, $magazyn, $stan, $wartosc_netto, $wartosc_brutto, $termin_realizacji, $data_dostawy, $nr_zlecenia_transportowego, $status, $uwagi, $pierwsza_data_przyjecia, $kurs_euro, $rodzaj, $adres_serwera_do_faktur, $uwaga_1, $uwaga_2, $miasto_dostawy, $strefa, $uwagi_do_email, $odbior_materialu, $kod_pocztowy_dostawy, $ulica_dostawy, $zablokowac);
	
	echo '<div class="text_duzy_niebieski" align="center">Zamówienie zostało zmienione.</div>';
	  
	// #########################################################################################     dodajemy zamowienie do zlecen transportowych  ######################################################################################
	//pobieram sposob_platnosci z bazy klienta
	$pytanie14 = mysqli_query($conn, "SELECT sposob_platnosci FROM klienci WHERE id = ".$klient.";");
	while($wynik14= mysqli_fetch_assoc($pytanie14))
		$klient_sposob_platnosci=$wynik14['sposob_platnosci'];

	if($nr_zlecenia_transportowego != '')
		{
		// echo 'nr_zlecenia_transportowego ='.$nr_zlecenia_transportowego.'<br>';
		// echo 'poprzedni_nr_zlecenia_transportowego ='.$poprzedni_nr_zlecenia_transportowego.'<br>';
		// echo 'klient ='.$klient.'<br>';

		//sprawdzamy czy zamowienie już nie widnieje w tym zleceniu transportowym do którego jest dodawane, aby skopiować dane dot zwrotów i odbiorów
		$pytanie123 = mysqli_query($conn, "SELECT * from zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego = '".$nr_zlecenia_transportowego."' AND klient_id = ".$klient." LIMIT 1;");
		while($wynik123 = mysqli_fetch_assoc($pytanie123))
		{
			// echo 'to zamówienie już jest w tym zleceniu transpt<br>';
			$odbior_material = $wynik123['odbior_material'];
			$odbior_szablon = $wynik123['odbior_szablon'];
			// $zwrot_material = $wynik123['zwrot_material'];
			// $zwrot_szablon = $wynik123['zwrot_szablon'];
			// $zwrot_uszczelki = $wynik123['zwrot_uszczelki'];
			$uwagi = $wynik123['uwagi'];
			$kolejnosc = $wynik123['kolejnosc'];
			$liczba_paczek_wyrobow = $wynik123['liczba_paczek_wyrobow'];
			$liczba_paczek_zwrot = $wynik123['liczba_paczek_zwrot'];
			$data_dostawy = $wynik123['data_dostawy'];
			$suma_pobran_brutto = $wynik123['suma_pobran_brutto'];
			$suma_pobran_brutto_edycja = $wynik123['suma_pobran_brutto_edycja'];
		}



		//####################   zmiana numerow zlec transp. bylo inne a teraz jest nowe
		if(($poprzedni_nr_zlecenia_transportowego != $nr_zlecenia_transportowego) && ($poprzedni_nr_zlecenia_transportowego != ''))
			{
			//usuwamy zamówienie ze zlec transp
			mysqli_query($conn, "DELETE FROM zlecenia_transportowe_tresc WHERE klient_id = ".$klient." AND zamowienie_id = ".$zamowienie_id.";");
			
			$ilosc_pozycji = 0;
			//$SUMA_POBRAN_BRUTTO = 0;
			$pytanie291 = mysqli_query($conn, "SELECT ilosc_pozycji, wartosc_brutto FROM wyceny WHERE zamowienie_id = ".$zamowienie_id.";");
			while($wynik291= mysqli_fetch_assoc($pytanie291))
				{
				$ilosc_pozycji++;
				$wartosc_brutto_wycena[$ilosc_pozycji] = $wynik291['wartosc_brutto'];
				//$SUMA_POBRAN_BRUTTO += $wartosc_brutto_wycena[$ilosc_pozycji];
				}

			for ($k=1; $k<=$ilosc_pozycji; $k++) 
				{
				if($liczba_paczek_zwrot == '') $liczba_paczek_zwrot = 0;
				if($liczba_paczek_wyrobow == '') $liczba_paczek_wyrobow = 0;
				if($kolejnosc == '') $kolejnosc = 0;
				$wartosc_brutto_wycena[$k] = change($wartosc_brutto_wycena[$k]);
				$suma_pobran_brutto = change($suma_pobran_brutto);
						
				$query1 = "INSERT INTO zlecenia_transportowe_tresc (`nr_zlecenia_transportowego`, `klient_id`, `zamowienie_id`, `kwota_brutto`, `pozycja_wyceny`, `user_id`, `sposob_platnosci`, `time`, `odbior_material`, `odbior_szablon`, `uwagi`, `kolejnosc`, `liczba_paczek_wyrobow`, `liczba_paczek_zwrot`, `data_dostawy`, `suma_pobran_brutto`, `suma_pobran_brutto_edycja` ) values ('$nr_zlecenia_transportowego', '$klient', '$zamowienie_id', '$wartosc_brutto_wycena[$k]', '$k', '$user_id', '$klient_sposob_platnosci', '$time', '$odbior_material', '$odbior_szablon', '$uwagi', '$kolejnosc', '$liczba_paczek_wyrobow', '$liczba_paczek_zwrot', '$data_dostawy', '$suma_pobran_brutto', '$suma_pobran_brutto_edycja');";
				mysqli_query($conn, $query1);
				}
				
			}
		elseif(($poprzedni_nr_zlecenia_transportowego != $nr_zlecenia_transportowego) && ($poprzedni_nr_zlecenia_transportowego == ''))
			{
			$ilosc_pozycji = 0;
			//$SUMA_POBRAN_BRUTTO = 0;
			$pytanie291 = mysqli_query($conn, "SELECT ilosc_pozycji, wartosc_brutto FROM wyceny WHERE zamowienie_id = ".$zamowienie_id.";");
			while($wynik291= mysqli_fetch_assoc($pytanie291))
				{
				$ilosc_pozycji++;
				$wartosc_brutto_wycena[$ilosc_pozycji] = $wynik291['wartosc_brutto'];
				//$SUMA_POBRAN_BRUTTO += $wartosc_brutto_wycena[$ilosc_pozycji];				
				}

			for ($k=1; $k<=$ilosc_pozycji; $k++) 
				{
				if($liczba_paczek_zwrot == '') $liczba_paczek_zwrot = 0;
				if($liczba_paczek_wyrobow == '') $liczba_paczek_wyrobow = 0;
				if($kolejnosc == '') $kolejnosc = 0;
				$wartosc_brutto_wycena[$k] = change($wartosc_brutto_wycena[$k]);
				$suma_pobran_brutto = change($suma_pobran_brutto);

				//szukamy czy w zamowieniu jest zaznaczony odbior materialu
				$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT odbior_materialu FROM zamowienia WHERE id = ".$zamowienie_id.";"));
				if($sql['odbior_materialu'] != '') $odbior_material = $sql['odbior_materialu'];

				$query2 = "INSERT INTO zlecenia_transportowe_tresc (`nr_zlecenia_transportowego`, `klient_id`, `zamowienie_id`, `kwota_brutto`, `pozycja_wyceny`, `user_id`, `sposob_platnosci`, `time`, `odbior_material`, `odbior_szablon`, `uwagi`, `kolejnosc`, `liczba_paczek_wyrobow`, `liczba_paczek_zwrot`, `data_dostawy`, `suma_pobran_brutto`, `suma_pobran_brutto_edycja` ) values ('$nr_zlecenia_transportowego', '$klient', '$zamowienie_id', '$wartosc_brutto_wycena[$k]', '$k', '$user_id', '$klient_sposob_platnosci', '$time', '$odbior_material', '$odbior_szablon', '$uwagi', '$kolejnosc', '$liczba_paczek_wyrobow', '$liczba_paczek_zwrot', '$data_dostawy', '$suma_pobran_brutto', '$suma_pobran_brutto_edycja');";
				mysqli_query($conn, $query2);
				}
			}

		}
	//usuwam nr zlec transp. zostaje puste
	elseif($poprzedni_nr_zlecenia_transportowego != '') 
		{
		// echo 'usuwam numer<br>';
		mysqli_query($conn, "DELETE FROM zlecenia_transportowe_tresc WHERE klient_id = ".$klient." AND zamowienie_id = ".$zamowienie_id.";");
		}


	//wysyka potwierdzenia
	$wyslij = 0;

	if(($bez_potwierdzenia == '') && ($stary_status != 'Dostarczone') && ($stary_status != 'Anulowane')) //wyslij potwierdzenie
		{
		$pytanie13 = mysqli_query($conn, "UPDATE klienci SET ostatnio_uzyty_potwierdzenie_zamowienia = '".$klient_potwierdzenie."' WHERE id = ".$klient.";");
		
		include('php/potwierdzenie.php'); //jezeli puste wyslij potwierdzenie, jezeli 1 nie wysylaj
		
		$pytanie103 = mysqli_query($conn, "UPDATE zamowienia SET status = '".$status."' WHERE id = ".$zamowienie_id.";");
		echo '<div class="text_duzy_niebieski" align="center">Status zamówienia został zmieniony na : '.$status.'.</div>';
		}
		
	if($id_zlec_transp != '') echo $powrot_do_konkretnego_zlecenia_transportowego_edycja;
	else
		{
		echo $powrot_do_wysortowanych_zamowien;
		echo $powrot_do_rejestru_zamowien;
		}
}


if((!$submit) && ($zapisz != 'Zapisz'))
{

if($zatwierdz == 'tak')
	{
	//echo 'zatwierdz='.$zatwierdz.'<br>';
	// po zmienia czegokolwiek strona sie odwieza, wiec zapisujemy nowe wartocsi do bazy
	$query = "UPDATE zamowienia SET zamowiony_produkt = '".$produkt."', system_profili = '".$profil."', rodzaj_okuc = '".$rodzaj_okuc."', rodzaj_szyb = '".$rodzaj_szyb."', kolor_profili = '".$kolor_profili."', kolor_uszczelek = '".$kolor_uszczelek."', nr_zamowienia_klienta = '".$nr_zamowienia_klienta."', magazyn = '".$magazyn."', stan = '".$stan."', termin_realizacji = '".$termin_realizacji."', data_dostawy = '".$data_dostawy."', nr_zlecenia_transportowego = '".$nr_zlecenia_transportowego."', status = '".$status."', uwagi = '".$uwagi."', uwaga_1 = '".$uwaga_1."', uwaga_2 = '".$uwaga_2."' WHERE id = ".$zamowienie_id.";";
	mysqli_query($conn, $query);

	if($kurs_euro != '')
		{
			$kurs_euro = change($kurs_euro);
			$query = "UPDATE zamowienia SET kurs_euro = '".$kurs_euro."' WHERE id = ".$zamowienie_id.";";
			mysqli_query($conn, $query);
		}
	}

$pytanie = mysqli_query($conn, "SELECT * FROM zamowienia WHERE id = $zamowienie_id;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$klient = $wynik['klient_id'];
	$klient_nazwa = $wynik['klient_nazwa'];
	$miasto_dostawy = $wynik['miasto_dostawy'];
	$typ_zamowienia = $wynik['typ'];
	$data_przyjecia=$wynik['data_przyjecia'];
	$nr_zamowienia=$wynik['nr_zamowienia'];
	$nr_zamowienia_klienta=$wynik['nr_zamowienia_klienta'];
	$produkt=$wynik['zamowiony_produkt'];
	$profil=$wynik['system_profili'];
	$rodzaj_okuc=$wynik['rodzaj_okuc'];
	$rodzaj_szyb=$wynik['rodzaj_szyb'];
	$kolor_profili=$wynik['kolor_profili'];
	$kolor_uszczelek=$wynik['kolor_uszczelek'];
	$magazyn=$wynik['magazyn'];
	$stan=$wynik['stan'];
	$kurs_euro=$wynik['kurs_euro'];
	$termin_realizacji=$wynik['termin_realizacji'];
	$strefa=$wynik['strefa'];
	$data_dostawy=$wynik['data_dostawy'];
	$nr_zlecenia_transportowego=$wynik['nr_zlecenia_transportowego'];
	$status=$wynik['status'];
	$uwagi=$wynik['uwagi'];
	$uwaga_1=$wynik['uwaga_1'];
	$uwaga_2=$wynik['uwaga_2'];
	$uwagi_do_email=$wynik['uwagi_do_email'];
	$odbior_materialu=$wynik['odbior_materialu'];
	$lista_materialow_nr=$wynik['lista_materialow_nr'];
	$lista_materialow_opis=$wynik['lista_materialow_opis'];
	$lista_materialow_status=$wynik['lista_materialow_status'];
	$lista_materialow_email=$wynik['lista_materialow_email'];
	$lista_materialow_data=$wynik['lista_materialow_data'];
	$lista_materialow_link=$wynik['lista_materialow_link'];
	$zablokowac=$wynik['zablokowac'];

	}

	//pobieramy wartosc zamowienia z wyceny
	$wartosc_netto = pobierz_wartosc_netto($zamowienie_id, $conn);
	$wartosc_brutto = pobierz_wartosc_brutto($zamowienie_id, $conn);


$parametr_zamowienie_zamkniete = '';
$zamowienie_zamkniete = 0;
if(($status != 'Dostarczone') && ($status != 'Odebrane') && ($status != 'Anulowane')) echo '<div class="text_duzy" align="center">Edycja zamówienia</div>';
else 
	{
	echo '<div class="text_duzy" align="center">Edycja zamówienia niemożliwa - Zamówienie dostarczone.</div>';
	$parametr_zamowienie_zamkniete = ' disabled="disabled"';
	$zamowienie_zamkniete = 1;
	}
//echo '<div class="text" align="center"><a href="php/drukuj/drukuj_zamowienie.php?zamowienie_id='.$zamowienie_id.'&user_id='.$_SESSION["USER_ID"].'" target="_blank">Drukuj zamówienie</a></div>';
//echo '<div class="text_duzy" align="center">Edycja zamówienia</div>';

echo '<table width="1200px" align="center" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';
echo '<FORM action="index.php?page=zamowienie_edycja" method="post">';
echo '<INPUT type="hidden" name="zamowienie_edycja" value="zamowienie_edycja">';
echo '<INPUT type="hidden" name="klient" value="'.$klient.'">';
echo '<INPUT type="hidden" name="nr_zamowienia" value="'.$nr_zamowienia.'">';
echo '<INPUT type="hidden" name="zamowienie_id" value="'.$zamowienie_id.'">';
echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
echo '<INPUT type="hidden" name="wartosc_brutto" value="'.$wartosc_brutto.'">';
echo '<INPUT type="hidden" name="zatwierdz" value="tak">';
echo '<INPUT type="hidden" name="miasto_dostawy" value="'.$miasto_dostawy.'">';
echo '<INPUT type="hidden" name="SORT_STAN" value="'.$SORT_STAN.'">';
echo '<INPUT type="hidden" name="SORT_NR_ZLECENIA_TRANSPORTOWEGO" value="'.$SORT_NR_ZLECENIA_TRANSPORTOWEGO.'">';
echo '<INPUT type="hidden" name="SORT_PROFIL" value="'.$SORT_PROFIL.'">';
echo '<INPUT type="hidden" name="SORT_RODZAJ_SZYB" value="'.$SORT_RODZAJ_SZYB.'">';
echo '<INPUT type="hidden" name="SORT_RODZAJ_OKUC" value="'.$SORT_RODZAJ_OKUC.'">';
echo '<INPUT type="hidden" name="pokaz" value="'.$pokaz.'">';
echo '<INPUT type="hidden" name="SORT_MAGAZYN" value="'.$SORT_MAGAZYN.'">';
echo '<INPUT type="hidden" name="SORT_KOLOR_PROFILI" value="'.$SORT_KOLOR_PROFILI.'">';
echo '<INPUT type="hidden" name="SORT_NR_ZAMOWIENIA" value="'.$SORT_NR_ZAMOWIENIA.'">';
echo '<INPUT type="hidden" name="SORT_NR_ZAMOWIENIA_KLIENTA" value="'.$SORT_NR_ZAMOWIENIA_KLIENTA.'">';
echo '<INPUT type="hidden" name="SORT_ZAMOWIONY_PRODUKT" value="'.$SORT_ZAMOWIONY_PRODUKT.'">';
echo '<INPUT type="hidden" name="SORT_TERMIN_REALIZACJI" value="'.$SORT_TERMIN_REALIZACJI.'">';
echo '<INPUT type="hidden" name="SORT_STREFA" value="'.$SORT_STREFA.'">';
echo '<INPUT type="hidden" name="SORT_KOLOR_USZCZELEK" value="'.$SORT_KOLOR_USZCZELEK.'">';
echo '<INPUT type="hidden" name="SORT_DATA_PRZYJECIA" value="'.$SORT_DATA_PRZYJECIA.'">';
echo '<INPUT type="hidden" name="SORT_DATA_DOSTAWY" value="'.$SORT_DATA_DOSTAWY.'">';
echo '<INPUT type="hidden" name="SORT_STATUS" value="'.$SORT_STATUS.'">';
echo '<INPUT type="hidden" name="SORT_KLIENT_NAZWA" value="'.$SORT_KLIENT_NAZWA.'">';

echo '<INPUT type="hidden" name="skad" value="zamowienie_edycja">';
echo '<INPUT type="hidden" name="id_zlec_transp" value="'.$id_zlec_transp.'">';
echo '<INPUT type="hidden" name="pierwsza_data_przyjecia" value="'.$data_przyjecia.'">';


$szerokosc_kolumna1 = '33%';
$szerokosc_kolumna2 = '33%';
$szerokosc_kolumna3 = '33%';
$szerokosc_pola_input = 'size="52"';

	echo '<table width="100%" align="center" border="0" cellpadding="3" cellpadding="3">';
	if($zamowienie_zamkniete == 0) $styl = 'pole_input_edycja';
	else $styl = 'pole_input';
	
	echo '<tr align="center" class="text"><td align="right" width="'.$szerokosc_kolumna1.'">'.$kol_klient.' : </td><td align="left" width="'.$szerokosc_kolumna2.'">'.$klient_nazwa.' ('.$miasto_dostawy.')</td><td width="'.$szerokosc_kolumna3.'"></td></tr>';
	
	// ##############################    adresy dostawy
	$pytanie188 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$klient.";");
	while($wynik188= mysqli_fetch_assoc($pytanie188))
		{
		$klient_dostawy_ulica=$wynik188['dostawy_ulica'];
		$klient_dostawy_miasto=$wynik188['dostawy_miasto'];
		$klient_dostawy_kod_pocztowy=$wynik188['dostawy_kod_pocztowy'];
		$klient_pomocniczy_ulica=$wynik188['dostawy_pomocniczy_ulica'];
		$klient_pomocniczy_miasto=$wynik188['dostawy_pomocniczy_miasto'];
		$klient_pomocniczy_kod_pocztowy=$wynik188['dostawy_pomocniczy_kod_pocztowy'];
		}

	if(($klient_pomocniczy_ulica != '') && ($klient_pomocniczy_kod_pocztowy != '') && ($klient_pomocniczy_miasto != ''))
		{
		echo '<tr align="center" class="text"><td colspan="3">';
			echo '<table border="0" cellpadding="4" cellspacing="4" align="center" width="50%" class="text"><tr><td align="center" colspan="2" class="text_duzy">Wybierz adres dostawy</td></tr>';
			if(($adres_dostawy == 'glowny') || ($miasto_dostawy == $klient_dostawy_miasto))
				{
				$checked_adres_dostawy_glowny = 'checked'; 
				$miasto_dostawy = $klient_dostawy_miasto;
				}
			else $checked_adres_dostawy_glowny = '';
			
			if(($adres_dostawy == 'pomocniczy') || ($miasto_dostawy == $klient_pomocniczy_miasto))
				{
				$checked_adres_dostawy_pomocniczy = 'checked'; 
				$miasto_dostawy = $klient_pomocniczy_miasto;
				}
			else $checked_adres_dostawy_pomocniczy = '';
			if(($adres_dostawy == '') && ($miasto_dostawy == '')) $checked_adres_dostawy_glowny = 'checked';	


			echo '<tr align="center"><td width="50%">Adres główny&nbsp;<input type="radio" name="adres_dostawy" value="glowny" '.$checked_adres_dostawy_glowny.' onchange="submit();" '.$parametr_zamowienie_zamkniete.'></td><td width="50%">Adres pomocniczy&nbsp;<input type="radio" name="adres_dostawy" value="pomocniczy" '.$checked_adres_dostawy_pomocniczy.' onchange="submit();" '.$parametr_zamowienie_zamkniete.'></td></tr>';
			echo '<tr align="center"><td>';
				echo $klient_dostawy_ulica.'<br>';
				echo $klient_dostawy_kod_pocztowy.' '.$klient_dostawy_miasto;
			echo '</td><td width="50%">';
				echo $klient_pomocniczy_ulica.'<br>';
				echo $klient_pomocniczy_kod_pocztowy.' '.$klient_pomocniczy_miasto;
			echo '</td></tr>';
			echo '</table>';
		echo '</td></tr>';
		}
	else $miasto_dostawy = $klient_dostawy_miasto;
	// ############################## KONIEC  adresy dostawy

	
	
	echo '<tr align="center" class="text"><td align="right">'.$kol_nr_zamowienia.' : </td><td align="left">'.$nr_zamowienia.'</td><td></td></tr>';

	echo '<tr align="center"><td align="right" class="text">'.$kol_nr_zamowienia_klienta2.' : </td><td align="left"><input autocomplete="off" type="text" '.$szerokosc_pola_input.' '.$parametr_zamowienie_zamkniete.' maxlength="20" class="'.$styl.'" name="nr_zamowienia_klienta" value="'.$nr_zamowienia_klienta.'"></td><td></td></tr>';

	//##################################################################################################################################  produkt   ##################################################################################################################################
	$ilosc_produktow = 0;
	$pytanie2 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='produkty' ORDER BY opis ASC;");
	while($wynik2= mysqli_fetch_assoc($pytanie2))
		{
		$ilosc_produktow++;
		$produkt_id[$ilosc_produktow] = $wynik2['id'];
		$produkt_opis[$ilosc_produktow] = $wynik2['opis'];
		}
	echo '<tr align="center" class="text"><td align="right">'.$kol_produkt.' : </td><td align="left">';
	echo '<select name="produkt" class="'.$styl.'" style="width: 100%"  '.$parametr_zamowienie_zamkniete.'>';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_produktow; $k++) 
	if($produkt == $produkt_opis[$k]) echo '<option selected="selected" value="'.$produkt_opis[$k].'">'.$produkt_opis[$k].'</option>';
	else echo '<option value="'.$produkt_opis[$k].'">'.$produkt_opis[$k].'</option>';
	echo '</select></td>';
	echo '<td align="left"><INPUT type="submit" '.$parametr_zamowienie_zamkniete.' name="zapisz" value="+">';
	echo '</td></tr>';

	//################################## system profile
	$ilosc_profili = 0;
	$pytanie3 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='profil' ORDER BY opis ASC;");
	while($wynik3= mysqli_fetch_assoc($pytanie3))
		{
		$ilosc_profili++;
		$profil_id[$ilosc_profili] = $wynik3['id'];
		$profil_opis[$ilosc_profili] = $wynik3['opis'];
		}
	echo '<tr align="center" class="text"><td align="right">'.$kol_system_prolifi.' : </td><td align="left">';
	echo '<select name="profil" class="'.$styl.'" style="width: 100%"  '.$parametr_zamowienie_zamkniete.'>';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_profili; $k++) 
	if($profil == $profil_opis[$k]) echo '<option selected="selected" value="'.$profil_opis[$k].'">'.$profil_opis[$k].'</option>';
	else echo '<option value="'.$profil_opis[$k].'">'.$profil_opis[$k].'</option>';
	echo '</select></td>';
	echo '<td align="left"><INPUT type="submit" '.$parametr_zamowienie_zamkniete.' name="zapisz" value="+">';
	echo '</td></tr>';

	// ##################################    kolor profili
	$ilosc_kolor_profili = 0;
	$pytanie6 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='kolor_profili' ORDER BY opis ASC;");
	while($wynik6= mysqli_fetch_assoc($pytanie6))
		{
		$ilosc_kolor_profili++;
		$kolor_profili_id[$ilosc_kolor_profili] = $wynik6['id'];
		$kolor_profili_opis[$ilosc_kolor_profili] = $wynik6['opis'];
		}
	echo '<tr align="center" class="text"><td align="right">'.$kol_kolor_profili.' : </td><td align="left">';
	echo '<select name="kolor_profili" class="'.$styl.'" style="width: 100%"  '.$parametr_zamowienie_zamkniete.'>';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_kolor_profili; $k++) 
	if($kolor_profili == $kolor_profili_opis[$k]) echo '<option selected="selected" value="'.$kolor_profili_opis[$k].'">'.$kolor_profili_opis[$k].'</option>';
	else echo '<option value="'.$kolor_profili_opis[$k].'">'.$kolor_profili_opis[$k].'</option>';
	echo '</select></td>';
	echo '<td align="left"><INPUT type="submit" '.$parametr_zamowienie_zamkniete.' name="zapisz" value="+">';
	echo '</td></tr>';

	// ##################################     magazyn
	$ilosc_magazyn = 0;
	$pytanie8 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='magazyn' ORDER BY opis ASC;");
	while($wynik8= mysqli_fetch_assoc($pytanie8))
		{
		$ilosc_magazyn++;
		$magazyn_id[$ilosc_magazyn] = $wynik8['id'];
		$magazyn_opis[$ilosc_magazyn] = $wynik8['opis'];
		}
	echo '<tr align="center" class="text"><td align="right">'.$kol_magazyn.' : </td><td align="left">';
	echo '<select name="magazyn" class="'.$styl.'" style="width: 100%"  '.$parametr_zamowienie_zamkniete.'>';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_magazyn; $k++) 
	if($magazyn == $magazyn_opis[$k]) echo '<option selected="selected" value="'.$magazyn_opis[$k].'">'.$magazyn_opis[$k].'</option>';
	else echo '<option value="'.$magazyn_opis[$k].'">'.$magazyn_opis[$k].'</option>';
	echo '</select></td>';
	echo '<td align="left"><INPUT type="submit" '.$parametr_zamowienie_zamkniete.' name="zapisz" value="+">';
	echo '</td></tr>';

	// ##################################   stan
	$ilosc_stan = 0;
	$pytanie9 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='stan' ORDER BY opis ASC;");
	while($wynik9= mysqli_fetch_assoc($pytanie9))
		{
		$ilosc_stan++;
		$stan_id[$ilosc_stan] = $wynik9['id'];
		$stan_opis[$ilosc_stan] = $wynik9['opis'];
		}
	echo '<tr align="center" class="text"><td align="right">'.$kol_stan.' : </td><td align="left">';
	echo '<select name="stan" class="'.$styl.'" style="width: 100%"  '.$parametr_zamowienie_zamkniete.'>';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_stan; $k++) 
	if($stan == $stan_opis[$k]) echo '<option selected="selected" value="'.$stan_opis[$k].'">'.$stan_opis[$k].'</option>';
	else echo '<option value="'.$stan_opis[$k].'">'.$stan_opis[$k].'</option>';
	echo '</select></td>';
	echo '<td align="left"><INPUT type="submit" '.$parametr_zamowienie_zamkniete.' name="zapisz" value="+">';
	echo '</td></tr>';
	
	//##################################    odbir materiau od klienta
	echo '<tr align="center" class="text"><td align="right">Odbiór materiału od klienta : </td><td align="left">';
		if($odbior_materialu == 'on') echo '<input type="checkbox" checked name="odbior_materialu" '.$parametr_zamowienie_zamkniete.'>';
		else echo '<input type="checkbox" name="odbior_materialu" '.$parametr_zamowienie_zamkniete.'>';
	echo '</td><td align="left"></td></tr>';

	//##################################    kolor uszczelek
	$ilosc_kolor_uszczelek = 0;
	$pytanie7 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='kolor_uszczelek' ORDER BY opis ASC;");
	while($wynik7= mysqli_fetch_assoc($pytanie7))
		{
		$ilosc_kolor_uszczelek++;
		$kolor_uszczelek_id[$ilosc_kolor_uszczelek] = $wynik7['id'];
		$kolor_uszczelek_opis[$ilosc_kolor_uszczelek] = $wynik7['opis'];
		}
	echo '<tr align="center" class="text"><td align="right">'.$kol_kolor_uszczelek.' : </td><td align="left">';
	echo '<select name="kolor_uszczelek" class="'.$styl.'" style="width: 100%"  '.$parametr_zamowienie_zamkniete.'>';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_kolor_uszczelek; $k++) 
	if($kolor_uszczelek == $kolor_uszczelek_opis[$k]) echo '<option selected="selected" value="'.$kolor_uszczelek_opis[$k].'">'.$kolor_uszczelek_opis[$k].'</option>';
	else echo '<option value="'.$kolor_uszczelek_opis[$k].'">'.$kolor_uszczelek_opis[$k].'</option>';
	echo '</select></td>';
	echo '<td align="left"><INPUT type="submit" '.$parametr_zamowienie_zamkniete.' name="zapisz" value="+">';
	echo '</td></tr>';

	// ##################################   rodzaj okuć
	$ilosc_rodzaj_okuc = 0;
	$pytanie4 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='rodzaj_okuc' ORDER BY opis ASC;");
	while($wynik4= mysqli_fetch_assoc($pytanie4))
		{
		$ilosc_rodzaj_okuc++;
		$rodzaj_okuc_id[$ilosc_rodzaj_okuc] = $wynik4['id'];
		$rodzaj_okuc_opis[$ilosc_rodzaj_okuc] = $wynik4['opis'];
		}
	echo '<tr align="center" class="text"><td align="right">'.$kol_rodzaj_okuc.' : </td><td align="left">';
	echo '<select name="rodzaj_okuc" class="'.$styl.'" style="width: 100%"  '.$parametr_zamowienie_zamkniete.'>';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_rodzaj_okuc; $k++) 
	if($rodzaj_okuc == $rodzaj_okuc_opis[$k]) echo '<option selected="selected" value="'.$rodzaj_okuc_opis[$k].'">'.$rodzaj_okuc_opis[$k].'</option>';
	else echo '<option value="'.$rodzaj_okuc_opis[$k].'">'.$rodzaj_okuc_opis[$k].'</option>';
	echo '</select></td>';
	echo '<td align="left"><INPUT type="submit" '.$parametr_zamowienie_zamkniete.' name="zapisz" value="+">';
	echo '</td></tr>';

	// ##################################    rodzaj szyb
	$ilosc_rodzaj_szyb = 0;
	$pytanie5 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='rodzaj_szyb' ORDER BY opis ASC;");
	while($wynik5= mysqli_fetch_assoc($pytanie5))
		{
		$ilosc_rodzaj_szyb++;
		$rodzaj_szyb_id[$ilosc_rodzaj_szyb] = $wynik5['id'];
		$rodzaj_szyb_opis[$ilosc_rodzaj_szyb] = $wynik5['opis'];
		}
	echo '<tr align="center" class="text"><td align="right">'.$kol_rodzaj_szyb.' : </td><td align="left">';
	echo '<select name="rodzaj_szyb" class="'.$styl.'" style="width: 100%"  '.$parametr_zamowienie_zamkniete.'>';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_rodzaj_szyb; $k++) 
	if($rodzaj_szyb == $rodzaj_szyb_opis[$k]) echo '<option selected="selected" value="'.$rodzaj_szyb_opis[$k].'">'.$rodzaj_szyb_opis[$k].'</option>';
	else echo '<option value="'.$rodzaj_szyb_opis[$k].'">'.$rodzaj_szyb_opis[$k].'</option>';
	echo '</select></td>';
	echo '<td align="left"><INPUT type="submit" '.$parametr_zamowienie_zamkniete.' name="zapisz" value="+">';
	echo '</td></tr>';

	//#########################################   KARTA PRODUKCYJNA  #####################################
	echo '<tr align="center" class="text"><td align="right">Karta produkcyjna : </td><td align="left">';
	echo '<INPUT type="submit" '.$parametr_zamowienie_zamkniete.' name="zapisz" value="'.$napis_guzika_dodaj_karte_produkcyjna.'">';
	//sprawdzamy czy pliki s dodane do zamówienia
	$ilosc_plikow = 0;
	$pytanie14 = mysqli_query($conn, "SELECT * FROM karta_produkcyjna_pliki WHERE zamowienie_id = ".$zamowienie_id.";");
	while($wynik14= mysqli_fetch_assoc($pytanie14))
		{
		$ilosc_plikow++;
		$nazwa_pliku[$ilosc_plikow]=$wynik14['nazwa_pliku'];
		}
	if($ilosc_plikow != 0)
		{
		$szerokosc_tabeli = 400;
		$sciezka = '../panel_dane/karta_produkcyjna_pliki';
		echo '<br><table width="'.$szerokosc_tabeli.'px" align="left" border="1" cellspacing="1" cellpadding="1" BORDERCOLOR="black" frame="box" RULES="all" bgcolor="'.$kolor_bialy.'">';
		$ilosc_kolumn = 3;
		$szerokosc_kolumny = 100/$ilosc_kolumn;
		$szerokosc_obrazkow = $szerokosc_tabeli/$ilosc_kolumn;
		$licz = 0;
		for($x=1; $x<=$ilosc_plikow; $x++) 
			{
			if($licz == 0) echo '<tr bgcolor="'.$kolor_bialy.'">';	
			if($licz < $ilosc_kolumn)
				{
				$licz++;
				echo '<td class="text_duzy" width="'.$szerokosc_kolumny.'%" valign="middle" align="center" bgcolor="'.$kolor_bialy.'">';
				echo '<center><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/karta_produkcyjna_pliki/'.$nazwa_pliku[$x].'" data-lightbox="roadtrip" data-title="'.$nazwa_pliku[$x].'">';
				echo '<img src="http://'.$adres_serwera_do_faktur.'/panel_dane/karta_produkcyjna_pliki/'.$nazwa_pliku[$x].'" width="'.$szerokosc_obrazkow.'px">';
				echo '</a></center>';
				echo '</td>';
				}
			if($licz == $ilosc_kolumn) 
				{
				echo '</tr>';	
				$licz=0;
				}
			}
		echo '</table>';
		} // do if ilosc plikow
	echo '</td></tr>';
	//##########################################################################################################################

	//#########################################   LISTA MATERIAŁÓW  #####################################
	echo '<tr align="center" class="text"><td align="right">Lista materiałów : </td><td align="left">';

		if($lista_materialow_nr == '') echo '<INPUT type="submit" '.$parametr_zamowienie_zamkniete.' name="zapisz" value="'.$napis_guzika_dodaj_liste.'">';
		else
			{
			echo '<INPUT type="submit" name="zapisz" '.$parametr_zamowienie_zamkniete.' value="'.$napis_guzika_edytuj_liste.'">';
			echo '<table border="0" width="100%" class="text">';
			echo '<tr><td width="25%" align="left">';
				echo $lista_materialow_status;
			echo '</td><td width="50%" align="center">';
				echo $lista_materialow_email;
			echo '</td><td width="25%" align="right">';
				if($lista_materialow_data != '') echo date('d-m-Y', $lista_materialow_data);
			echo '</td></tr></table>';
			
			echo '</td><td align="left" valign="middle">';
			echo '<a href="index.php?page=lista_materialow_wyslij&klient='.$klient.'&zamowienie_id='.$zamowienie_id.'&jak='.$jak.'&wg_czego='.$wg_czego.'">'.$image_email.'</a>';
			echo $nbsp;
			if($lista_materialow_link != '') echo '<a href="http://'.$adres_serwera_do_faktur.'/panel_dane/pdf_lista_materialow/'.$lista_materialow_link.'" target="_blank">'.$image_pdf_icon2.'</a>';
			}
	echo '</td></tr>';

	//#########################################   STREFA  #####################################
	echo '<tr align="center" class="text"><td align="right">Strefa : </td><td align="left">';
		echo '<select name="strefa" class="'.$styl.'" '.$parametr_zamowienie_zamkniete.'>';
		for($k=1; $k<=$DL_TABELA_STREFY; $k++)
			if($strefa == $TABELA_STREFY[$k]) echo '<option selected="selected" value="'.$TABELA_STREFY[$k].'">'.$TABELA_STREFY[$k].'</option>';
			else echo '<option value="'.$TABELA_STREFY[$k].'">'.$TABELA_STREFY[$k].'</option>';
		echo '</select>';
	echo '</td></tr>';

	// ######################################### termin realizacji zamówienia #########################################
	echo '<tr align="center"><td align="right" class="text">'.$kol_termin_realizacji.' : </td><td align="left">';         
		echo '<table cellspacing="0" cellpadding="0" border="0"><tr>
		<td><input type="text" '.$szerokosc_pola_input.' maxlength="20" '.$parametr_zamowienie_zamkniete.' class="'.$styl.'" autocomplete="off"  name="termin_realizacji" id="f_date_c" value="'.$termin_realizacji.'"/></td>
		<td></td></tr></table>';
		?>
		<script type="text/javascript">
			Calendar.setup({
				inputField     :    "f_date_c",     // id of the input field
				ifFormat       :    "T%W/%y",      // format of the input field
				button         :    "f_date_c",  // trigger for the calendar (button ID)
				singleClick    :    true
			});
		</script>
		</td><td></td></tr>	
		<?php
	
	if($zalogowany_user != 1) require("php/termin_realizacji_tabela.php");

	// ######################################### wycena #########################################
	$SORTOWANIE_DIV = '&pokaz='.$pokaz.'&SORT_STAN='.$SORT_STAN.'&SORT_NR_ZLECENIA_TRANSPORTOWEGO='.$SORT_NR_ZLECENIA_TRANSPORTOWEGO.'&SORT_PROFIL='.$SORT_PROFIL.'&SORT_RODZAJ_SZYB='.$SORT_RODZAJ_SZYB.'&SORT_RODZAJ_OKUC='.$SORT_RODZAJ_OKUC.'&SORT_MAGAZYN='.$SORT_MAGAZYN.'&SORT_KOLOR_PROFILI='.$SORT_KOLOR_PROFILI.'&SORT_NR_ZAMOWIENIA='.$SORT_NR_ZAMOWIENIA.'&SORT_NR_ZAMOWIENIA_KLIENTA='.$SORT_NR_ZAMOWIENIA_KLIENTA.'&SORT_ZAMOWIONY_PRODUKT='.$SORT_ZAMOWIONY_PRODUKT.'&SORT_TERMIN_REALIZACJI='.$SORT_TERMIN_REALIZACJI.'&SORT_KOLOR_USZCZELEK='.$SORT_KOLOR_USZCZELEK.'&SORT_DATA_PRZYJECIA='.$SORT_DATA_PRZYJECIA.'&SORT_DATA_DOSTAWY='.$SORT_DATA_DOSTAWY.'&SORT_STATUS='.$SORT_STATUS.'&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA.'';
	echo '<tr align="center"><td align="right" class="text">'.$kol_wycena.' : </td><td align="left" class="text"><a href="index.php?page=wycena_edycja&zamowienie_id='.$zamowienie_id.'&jak='.$jak.'&klient_wycena='.$klient.''.$SORTOWANIE_DIV.'&wg_czego='.$wg_czego.'">';
	if($zamowienie_zamkniete == 1) echo 'Pokaż pozycje wyceny</a></td><td></td></tr>';
	else echo 'Edytuj pozycje wyceny</a></td><td></td></tr>';
	
	$wartosc_netto = change($wartosc_netto);
	$wartosc_brutto = change($wartosc_brutto);
	echo '<input type="hidden" class="'.$styl.'" name="wartosc_netto" value="'.$wartosc_netto.'">';
	echo '<input type="hidden" class="'.$styl.'" name="wartosc_brutto" value="'.$wartosc_brutto.'">';
	$wartosc_netto = number_format($wartosc_netto, 2,'.',' ');
	$wartosc_brutto = number_format($wartosc_brutto, 2,'.',' ');
	echo '<tr align="center" class="text"><td align="right">'.$kol_wartosc_netto.' : </td><td align="left">'.$wartosc_netto.$waluta.'</td><td></td></tr>';
	echo '<tr align="center" class="text"><td align="right">'.$kol_wartosc_brutto.' : </td><td align="left">'.$wartosc_brutto.$waluta.'</td><td></td></tr>';

	
	$ile_roznych_faktur = 0;
	$pytanie = mysqli_query($conn, "SELECT DISTINCT nr_faktury FROM wyceny WHERE zamowienie_id = ".$zamowienie_id." AND nr_faktury <> '' AND korekta_fv = 'NIE';");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$ile_roznych_faktur++;
		$rozne_faktury[$ile_roznych_faktur]=$wynik['nr_faktury'];
		}
	
	echo '<tr align="center" class="text"><td align="right">'.$kol_nr_fv.' : </td><td align="left">';
	if($ile_roznych_faktur == 0) echo '---'; else for ($k=1; $k<=$ile_roznych_faktur; $k++) echo '<div class="text">'.$rozne_faktury[$k].'</div>';
	echo '</td><td></td></tr>';


	echo '<tr align="center"><td align="right" class="text">'.$kol_kurs_euro.' : </td><td align="left"><input autocomplete="off"  type="text" '.$szerokosc_pola_input.'  '.$parametr_zamowienie_zamkniete.' maxlength="5" class="'.$styl.'" name="kurs_euro" value="'.$kurs_euro.'"></td><td></td></tr>';
	echo '<tr align="center"><td align="right" class="text">'.$kol_data_dostawy.' : </td><td align="left">';         
	
	echo '<table cellspacing="0" cellpadding="0" border="0"><tr>
	<td><input type="text" '.$szerokosc_pola_input.'   maxlength="20" readonly="readonly" class="'.$styl.'" autocomplete="off" '.$parametr_zamowienie_zamkniete.' name="data_dostawy" id="f_date_d" value="'.$data_dostawy.'"/></td>';
	if($zamowienie_zamkniete == 0) echo '<td></td></tr></table>';
	else echo '<td></td></tr></table>';
	?>
	<script type="text/javascript">
		Calendar.setup({
			inputField     :    "f_date_d",     // id of the input field
			ifFormat       :    "%d-%m-%Y",      // format of the input field
			button         :    "f_date_d",  // trigger for the calendar (button ID)
			singleClick    :    true
		});
	</script>
	</td><td></td></tr>	
	<?php
	
	if($status == "Dostarczone") echo '<tr align="center" class="text"><td align="right">'.$kol_nr_zlecenia_transportowego.' : </td><td align="left" colspan="3">'.$nr_zlecenia_transportowego.'</td></tr>';
	else
		{
		// lista zlecen transportowych
		$ilosc_zlecen_transportowych = 0;
		$pytanie91 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_naglowek WHERE status <> 'Dostarczone' ORDER BY id DESC;");
		while($wynik91= mysqli_fetch_assoc($pytanie91))
			{
			$ilosc_zlecen_transportowych++;
			$nr_zlecenia_transportowego_baza[$ilosc_zlecen_transportowych] = $wynik91['nr_zlecenia_transportowego'];
			}
		echo '<INPUT type="hidden" name="poprzedni_nr_zlecenia_transportowego" value="'.$nr_zlecenia_transportowego.'">';

		echo '<tr align="center"><td align="right" class="text">'.$kol_nr_zlecenia_transportowego.' : </td><td align="left">';
		echo '<select name="nr_zlecenia_transportowego" class="'.$styl.'" style="width: 100%" '.$parametr_zamowienie_zamkniete.'>';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_zlecen_transportowych; $k++) 
		if($nr_zlecenia_transportowego == $nr_zlecenia_transportowego_baza[$k]) echo '<option selected="selected" value="'.$nr_zlecenia_transportowego_baza[$k].'">'.$nr_zlecenia_transportowego_baza[$k].'</option>';
		else echo '<option value="'.$nr_zlecenia_transportowego_baza[$k].'">'.$nr_zlecenia_transportowego_baza[$k].'</option>';
		echo '</select></td><td></td></tr>';
		}

	// status zamówienia
	$ilosc_status = 0;
	if($ile_roznych_faktur == 0) $warunek_status = " AND opis <> 'Dostarczone' AND opis <> 'Odebrane'";
	else $warunek_status = '';
	$pytanie91 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='status' ".$warunek_status." ORDER BY opis ASC;");
	while($wynik91= mysqli_fetch_assoc($pytanie91))
		{
		$ilosc_status++;
		$status_id[$ilosc_status] = $wynik91['id'];
		$status_opis[$ilosc_status] = $wynik91['opis'];
		}
	if($zamowienie_zamkniete == 1) 
		{
		if(($zalogowany_user == 1) || ($zalogowany_user == 2) || ($zalogowany_user == 3) || ($zalogowany_user == 4)) $disabled = "";
		else $disabled = " disabled"; 
		}
	else $disabled = "";
	//echo 'disabled='.$disabled.'<br>';
	echo '<tr align="center" class="text"><td align="right">'.$kol_status_zamowienia.' : </td><td align="left">';
		echo '<select name="status" class="'.$styl.'" style="width: 100%" >';
		echo '<option></option>';
		for ($k=1; $k<=$ilosc_status; $k++) 
		if($status == $status_opis[$k]) echo '<option selected="selected" value="'.$status_opis[$k].'">'.$status_opis[$k].'</option>';
		elseif(($status_opis[$k] == 'Anulowane')  && ($zablokowac != 'on')) echo '<option value="'.$status_opis[$k].'">'.$status_opis[$k].'</option>';
		elseif($status_opis[$k] != 'Anulowane') echo '<option value="'.$status_opis[$k].'">'.$status_opis[$k].'</option>';
		echo '</select></td>';
	echo '<td align="left"><INPUT type="submit" '.$parametr_zamowienie_zamkniete.' name="zapisz" value="+">';
	echo '</td></tr>';
	
	// uwagi 1 zamówienia
	$ilosc_uwaga_1 = 0;
	$pytanie91 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='uwagi' ORDER BY opis ASC;");
	while($wynik91= mysqli_fetch_assoc($pytanie91))
		{
		$ilosc_uwaga_1++;
		$uwaga_1_id[$ilosc_uwaga_1] = $wynik91['id'];
		$uwaga_1_opis[$ilosc_uwaga_1] = $wynik91['opis'];
		}
			
	echo '<tr align="center" class="text"><td align="right">'.$kol_uwagi.' : </td><td align="left">';
	echo '<select name="uwaga_1" class="'.$styl.'" style="width: 100%"  '.$parametr_zamowienie_zamkniete.'>';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_uwaga_1; $k++) 
	if($uwaga_1 == $uwaga_1_opis[$k]) echo '<option selected="selected" value="'.$uwaga_1_opis[$k].'">'.$uwaga_1_opis[$k].'</option>';
	else echo '<option value="'.$uwaga_1_opis[$k].'">'.$uwaga_1_opis[$k].'</option>';
	echo '</select></td>';
	echo '<td align="left"><INPUT type="submit" '.$parametr_zamowienie_zamkniete.' name="zapisz" value="+">';
	echo '</td></tr>';
	
	// uwagi 2 zamówienia
	$ilosc_uwaga_2 = 0;
	$pytanie91 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='uwagi' ORDER BY opis ASC;");
	while($wynik91= mysqli_fetch_assoc($pytanie91))
		{
		$ilosc_uwaga_2++;
		$uwaga_2_id[$ilosc_uwaga_2] = $wynik91['id'];
		$uwaga_2_opis[$ilosc_uwaga_2] = $wynik91['opis'];
		}
	echo '<tr align="center" class="text"><td align="right">'.$kol_uwagi.' : </td><td align="left">';
	echo '<select name="uwaga_2" class="'.$styl.'" style="width: 100%"  '.$parametr_zamowienie_zamkniete.'>';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_uwaga_2; $k++) 
	if($uwaga_2 == $uwaga_2_opis[$k]) echo '<option selected="selected" value="'.$uwaga_2_opis[$k].'">'.$uwaga_2_opis[$k].'</option>';
	else echo '<option value="'.$uwaga_2_opis[$k].'">'.$uwaga_2_opis[$k].'</option>';
	echo '</select></td>';
	echo '<td align="left"><INPUT type="submit" '.$parametr_zamowienie_zamkniete.' name="zapisz" value="+">';
	echo '</td></tr>';

	echo '<tr align="center"><td align="right" class="text">'.$kol_uwagi_pdf.' : </td><td align="left">';
	echo '<textarea name="uwagi" cols="49" rows="4" class="'.$styl.'"  '.$parametr_zamowienie_zamkniete.'>'.$uwagi.'</textarea></td><td></td></tr>';
	
	echo '<tr align="center"><td align="right" class="text">'.$kol_uwagi_email.' : </td><td align="left">';
	echo '<textarea name="uwagi_do_email" cols="49" rows="4" class="'.$styl.'"  '.$parametr_zamowienie_zamkniete.'>'.$uwagi_do_email.'</textarea></td><td></td></tr>';


// if($id_zlec_transp == '')
// 	{
	if($zamowienie_zamkniete == 0)
		{
		$mozna_usuwac_nie_ma_fv = 0;
		$pytanie1247 = mysqli_query($conn, "SELECT zamowienie_id FROM fv_naglowek WHERE zamowienie_id = ".$zamowienie_id.";");
		while($wynik1247= mysqli_fetch_assoc($pytanie1247))
			{
			$mozna_usuwac_nie_ma_fv = 1;
			}
		if($mozna_usuwac_nie_ma_fv == 0) echo '<tr class="Text"><td align="center" colspan="3" class="text_red">Zaznacz, aby usunąć zamówienie <input type="checkbox" name="usunac" value="1"><br></td></tr>';
		else echo '<tr class="Text"><td align="center" colspan="3" class="text_red">Nie można usunąć - wystawiono dokument (faktura lub proforma)<br></td></tr>';


		//blokada zamykania zamówienia - nigdy ma nie być zamknięte gdy jest to zaznaczone
		if($zablokowac == 'on') $zablokowac_checked = ' checked'; else $zablokowac_checked = '';
		echo '<tr class="Text"><td align="center" colspan="3" class="text_green"><br><font size="+1">Zaznacz, aby zablokować możliwość zamknięcia zamówienia </font><input type="checkbox" name="zablokowac" '.$zablokowac_checked.'><br><br></td></tr>';


		//########## guzik od wysylania potwierdzen  
		include("php/lista_emaili_potwierdzenie_zamowienia.php");

		echo '<tr><td colspan="3" align="center" class="text_duzy_niebieski">Wybierz, aby wysłać potwierdzenie</td></tr>';

		echo '<tr align="center" class="text"><td></td><td>';
			echo '<select name="klient_potwierdzenie" class="pole_input" style="width: 100%" >';
			for ($k=1; $k<=$ilosc_email; $k++) 
			if($klient_email_ostatni == $klient_email[$k]) echo '<option selected="selected" value="'.$klient_email[$k].'">'.$klient_email[$k].'</option>';
			elseif($klient_email[$k] == $linia_rozdzielajaca) echo '<option value="'.$klient_email[$k].'" disabled>'.$klient_email[$k].'</option>';
			else echo '<option value="'.$klient_email[$k].'">'.$klient_email[$k].'</option>';
			echo '</select>';
		echo '</td><td></td></tr>';
			
		echo '<tr class="text_duzy_niebieski"><td align="center" colspan="3">BEZ POTWIERDZENIA <input type="checkbox" name="bez_potwierdzenia" value="1" checked="checked"><br></td></tr>';		
		echo '<tr class="text"><td align="center" colspan="3">Korekta zamówienia? <input type="checkbox" name="korekta_zamowienia"><br></td></tr>';		
	
		echo '<tr><td colspan="3"align="center">';
		echo '<table border="0" align="center"><tr><td class="text_duzy_niebieski"align="center">Kliknij, aby wysłać potwierdzenie dostawy </td>';
		echo '<td align="center"><a href="javascript: potwierdzenie_dostawy_z_zamowienia_okienko(\''.$zamowienie_id.'\',\''.$klient.'\',\''.$_SESSION["USER_ID"].'\')">'.$image_send_email.'</a></td></tr>';
		echo '</table>';
			
		echo '<tr class="Text"><td align="center" colspan=3>';
		echo '<INPUT type="submit" name="zapisz" value="Zapisz"></td></tr>';
		} //  do if($zamowienie_zamkniete == 0)
	// }
// elseif($zamowienie_zamkniete == 0) echo '<tr class="Text"><td align="center" colspan=4><INPUT type="submit" name="zapisz" value="Zapisz">vdvdv</td></tr>';
echo '<tr class="Text"><td align="center" colspan=4>';
	

if((($zalogowany_user == 1) || ($zalogowany_user == 2) || ($zalogowany_user == 3) || ($zalogowany_user == 4)) && ($zamowienie_zamkniete == 1)) echo '<INPUT type="submit" name="zapisz" value="Zapisz"><br><br>';
	
	if($id_zlec_transp != '') echo $powrot_do_konkretnego_zlecenia_transportowego_edycja;
	else
		{
		echo $powrot_do_wysortowanych_zamowien;
		echo $powrot_do_rejestru_zamowien;
		}
		
	echo '</td></tr></table>';
	echo '</FORM>';

echo '</td></tr></table>';
}
?>