<?php
//zamowienia pokazujemy domyslnie do 12 miesiecy wstecz
$dwanascie_miesiecy = 365*24*60*60;

if(($data_poczatkowa == '') && ($data_koncowa == ''))
	{
    $data_poczatkowa = $time - $dwanascie_miesiecy;
	$data_poczatkowa = date('d-m-Y', $data_poczatkowa);
	$data_koncowa = date('d-m-Y', $time);
	}

include("php/zap_zamowienia.php");
include("php/zamowienia_sortowanie.php");

//pobieram dane do sortowania
$ilosc_produktow = 0;
$pytanie2 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='produkty' ORDER BY opis ASC");
while($wynik2= mysqli_fetch_assoc($pytanie2))
	{
	$ilosc_produktow++;
	$produkt_opis[$ilosc_produktow] = $wynik2['opis'];
	}
	
$ilosc_profili = 0;
$pytanie23 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='profil' ORDER BY opis ASC");
while($wynik23= mysqli_fetch_assoc($pytanie23))
	{
	$ilosc_profili++;
	$profil_opis[$ilosc_profili] = $wynik23['opis'];
	}			
			
$ilosc_rodzaj_okuc = 0;
$pytanie24 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='rodzaj_okuc' ORDER BY opis ASC");
while($wynik24= mysqli_fetch_assoc($pytanie24))
	{
	$ilosc_rodzaj_okuc++;
	$rodzaj_okuc_opis[$ilosc_rodzaj_okuc] = $wynik24['opis'];
	}		
	
$ilosc_rodzaj_szyb = 0;
$pytanie24 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='rodzaj_szyb' ORDER BY opis ASC");
while($wynik24= mysqli_fetch_assoc($pytanie24))
	{
	$ilosc_rodzaj_szyb++;
	$rodzaj_szyb_opis[$ilosc_rodzaj_szyb] = $wynik24['opis'];
	}		
		
$ilosc_kolor_profili = 0;
$pytanie24 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='kolor_profili' ORDER BY opis ASC");
while($wynik24= mysqli_fetch_assoc($pytanie24))
	{
	$ilosc_kolor_profili++;
	$kolor_profili_opis[$ilosc_kolor_profili] = $wynik24['opis'];
	}		
	
$ilosc_kolor_uszczelek = 0;
$pytanie24 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='kolor_uszczelek' ORDER BY opis ASC");
while($wynik24= mysqli_fetch_assoc($pytanie24))
	{
	$ilosc_kolor_uszczelek++;
	$kolor_uszczelek_opis[$ilosc_kolor_uszczelek] = $wynik24['opis'];
	}		
	
$ilosc_magazyn = 0;
$pytanie24 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='magazyn' ORDER BY opis ASC");
while($wynik24= mysqli_fetch_assoc($pytanie24))
	{
	$ilosc_magazyn++;
	$magazyn_opis[$ilosc_magazyn] = $wynik24['opis'];
	}		
	
$ilosc_stan = 0;
$pytanie24 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='stan' ORDER BY opis ASC");
while($wynik24= mysqli_fetch_assoc($pytanie24))
	{
	$ilosc_stan++;
	$stan_opis[$ilosc_stan] = $wynik24['opis'];
	}		
			
$ilosc_status = 0;
$pytanie24 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='status' ORDER BY opis ASC");
while($wynik24= mysqli_fetch_assoc($pytanie24))
	{
	$ilosc_status++;
	$status_opis[$ilosc_status] = $wynik24['opis'];
	}		

$ilosc_klientow = 0;
$pytanie24 = mysqli_query($conn, "SELECT * FROM klienci ORDER BY nazwa ASC");
while($wynik24= mysqli_fetch_assoc($pytanie24))
	{
	$ilosc_klientow++;
	$KLIENT_NAZWA[$ilosc_klientow] = $wynik24['nazwa'];
	}

//poprawne zapytanie do pobrania dat w kolejności !!!!!!!!!!!!
$ilosc_data_przyjecia = -1;
$result = mysqli_query($conn, "SELECT DISTINCT data_przyjecia FROM zamowienia WHERE status <> 'Dostarczone' AND status <> 'Odebrane' AND status <> 'Anulowane' ORDER BY data_time DESC;");
while ($a_row = mysqli_fetch_assoc($result) )
	{
	$ilosc_data_przyjecia++;
	$DATA_PRZYJECIA[$ilosc_data_przyjecia] = $a_row['data_przyjecia'];
	}

$ilosc_data_dostawy = 0;
$result = mysqli_query($conn, "SELECT DISTINCT data_dostawy FROM zamowienia WHERE data_dostawy IS NOT NULL ORDER BY data_time DESC;");
while ($a_rowa = mysqli_fetch_assoc ($result) )
	{
	if($a_rowa['data_dostawy'] != '')
		{
		$ilosc_data_dostawy++;
		$DATA_DOSTAWY[$ilosc_data_dostawy] = $a_rowa['data_dostawy'];
		}
	}

$ilosc_nr_zlecenia_transportowego = 0;
$result = mysqli_query($conn, "SELECT DISTINCT nr_zlecenia_transportowego FROM zamowienia WHERE nr_zlecenia_transportowego IS NOT NULL AND status <> 'Dostarczone' AND status <> 'Anulowane' AND status <> 'Odebrane' ORDER BY nr_zlecenia_transportowego ASC;");
while ($a_rowa = mysqli_fetch_assoc ($result) )
	{
	if($a_rowa['nr_zlecenia_transportowego'] != '')
		{
		$ilosc_nr_zlecenia_transportowego++;
		$NR_ZLECENIA_TRANSPORTOWEGO[$ilosc_nr_zlecenia_transportowego] = $a_rowa['nr_zlecenia_transportowego'];
		}
	}

if($dubel == 'tak') echo '<div align="center" class="text_duzy_czerwony">UWAGA! Wykryto próbę zdublowania zamówienia! Dodawanie zamówienia zostało przerwane.</div>';
	
	
echo '<div class="text" align="center"><a href="php/drukuj/drukuj_zamowienia.php?'.$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'" target="_blank">Drukuj zamówienia</a></div>';
echo '</td></tr><tr><td>';
	//sortowanie zlecen
	echo '<FORM name="szukaj">';
	echo '<input type="hidden" name="page" value="zamowienia">';
	echo '<input type="hidden" name="jak" value="'.$jak.'">';
	echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';                                
	echo '<input type="hidden" name="pokaz" value="1">'; 

	echo '<input type="hidden" name="szukaj" value="'.$szukaj.'">';                                
	echo '<input type="hidden" name="data_poczatkowa" value="'.$data_poczatkowa.'">';                                
	echo '<input type="hidden" name="data_koncowa" value="'.$data_koncowa.'">';                                
$wybierz_kolor = 0;
//echo 'i='.$i;
//echo '<table align="left" width="150px" class="tabela"><tr><td></td></tr></table><br><br>';

//dlugosc tabeli jest w pliku zamowienia_sortowanie
echo '<table class="tabela"  width="'.$dlugosc_tabeli.'px" align="left">';
echo '<tr valign="bottom" align="center" bgcolor="'.$kolor_tabeli.'" class="text" >';
if(($pokaz == 1) || ($szukaj == 1)) echo '<td '.$rowspan.' width="40px" valign="middle">'.$kol_lp.'<br>'.$i.'<br><a href="index.php?page=zamowienia&jak=DESC&wg_czego=id">'.$image_close.'</a></td>';
else echo '<td '.$rowspan.' width="40px" valign="middle">'.$kol_lp.'<br>'.$i.'</td>';

echo '<td '.$rowspan.' width="150px">'.$kol_klient.'<div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=klient_nazwa">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=klient_nazwa">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_KLIENT_NAZWA" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_klientow; $k++) 
		if ($KLIENT_NAZWA[$k] == $SORT_KLIENT_NAZWA) echo '<option value="'.$KLIENT_NAZWA[$k].'" selected="selected">'.$KLIENT_NAZWA[$k].'</option>';
		else echo '<option value="'.$KLIENT_NAZWA[$k].'">'.$KLIENT_NAZWA[$k].'</option>';
	echo '</select>';
echo '</td>';

echo '<td '.$rowspan.' width="90px">'.$kol_data_przyjecia_zamowienia.'<div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=data_przyjecia">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=data_przyjecia">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_DATA_PRZYJECIA" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	echo '<option></option>';
	for ($k=0; $k<=$ilosc_data_przyjecia; $k++) 
		if ($DATA_PRZYJECIA[$k] == $SORT_DATA_PRZYJECIA) echo '<option value="'.$DATA_PRZYJECIA[$k].'" selected="selected">'.$DATA_PRZYJECIA[$k].'</option>';
		else echo '<option value="'.$DATA_PRZYJECIA[$k].'">'.$DATA_PRZYJECIA[$k].'</option>';
	echo '</select>';
echo '</td>';

echo '<td '.$rowspan.' width="100px">'.$kol_nr_zamowienia_arcus.'<div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=nr_zamowienia">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=nr_zamowienia">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_NR_ZAMOWIENIA" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	echo '<option></option>';
	for ($k=1; $k<=$i; $k++) 
		if ($nr_zamowienia[$k] == $SORT_NR_ZAMOWIENIA) echo '<option value="'.$nr_zamowienia[$k].'" selected="selected">'.$nr_zamowienia[$k].'</option>';
		else echo '<option value="'.$nr_zamowienia[$k].'">'.$nr_zamowienia[$k].'</option>';
	echo '</select>';
echo '</td>';

echo '<td '.$rowspan.' width="120px">'.$kol_nr_zamowienia_klienta.'<div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=nr_zamowienia_klienta">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=nr_zamowienia_klienta">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_NR_ZAMOWIENIA_KLIENTA" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	echo '<option></option>';
	if($SORT_NR_ZAMOWIENIA_KLIENTA == "---") echo '<option selected="selected">---</option>'; else echo '<option>---</option>';
	for ($k=1; $k<=$ilosc_nr_zamowienia_klienta; $k++) 
		if ($NR_ZAMOWIENIA_KLIENTA[$k] == $SORT_NR_ZAMOWIENIA_KLIENTA) echo '<option value="'.$NR_ZAMOWIENIA_KLIENTA[$k].'" selected="selected">'.$NR_ZAMOWIENIA_KLIENTA[$k].'</option>';
		else echo '<option value="'.$NR_ZAMOWIENIA_KLIENTA[$k].'">'.$NR_ZAMOWIENIA_KLIENTA[$k].'</option>';
	echo '</select>';
echo '</td>';

echo '<td '.$rowspan.' width="80px" valign="middle">'.$kol_data_wysylki_potwierdzenia.'</td>';
echo '<td '.$rowspan.' width="80px" valign="middle">'.$kol_data_wysylki_potwierdzenia_dostawy.'</td>';
echo '<td '.$rowspan.' width="60px" valign="middle">'.$kol_data_wyslania_listy_materialow.'</td>';

echo '<td '.$rowspan.' width="90px">'.$kol_zamowiony_produkt.'<div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=zamowiony_produkt">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=zamowiony_produkt">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_ZAMOWIONY_PRODUKT" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	echo '<option></option>';
	if($SORT_ZAMOWIONY_PRODUKT == "PUSTE") echo '<option selected="selected">PUSTE</option>'; else echo '<option>PUSTE</option>';
	for ($k=1; $k<=$ilosc_produktow; $k++) 
		if ($produkt_opis[$k] == $SORT_ZAMOWIONY_PRODUKT) echo '<option value="'.$produkt_opis[$k].'" selected="selected">'.$produkt_opis[$k].'</option>';
		else echo '<option value="'.$produkt_opis[$k].'">'.$produkt_opis[$k].'</option>';
	echo '</select>';
echo '</td>';
 
if($user_id != 1) echo '<td colspan="7">'.$kol_material.'</td>';
if($user_id != 1) echo '<td colspan="12">'.$kol_ilosc.'</td>';


//######################### WARTOSC NETTO I BRUTTO #################################################
echo '<td '.$rowspan.' width="85px">'.$kol_wartosc_zamowienia_netto2.'<div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=wartosc_netto">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=wartosc_netto">'.$image_arrow_up.'</a></div></td>';
echo '<td '.$rowspan.' width="85px">'.$kol_wartosc_zamowienia_brutto2.'<div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=wartosc_brutto">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=wartosc_brutto">'.$image_arrow_up.'</a></div></td>';

//######################### STREFA #################################################
echo '<td '.$rowspan.' width="80px">Strefa<div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=strefa">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=strefa">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_STREFA" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
		echo '<option></option>';
		if($SORT_STREFA == 1) echo '<option value="1" selected="selected">1</option>'; else echo '<option value="1">1</option>';			
		if($SORT_STREFA == 2) echo '<option value="2" selected="selected">2</option>'; else echo '<option value="2">2</option>';			
		if($SORT_STREFA == 3) echo '<option value="3" selected="selected">3</option>'; else echo '<option value="3">3</option>';			
		if($SORT_STREFA == 4) echo '<option value="4" selected="selected">4</option>'; else echo '<option value="4">4</option>';			
		if($SORT_STREFA == 'Inna') echo '<option value="Inna" selected="selected">Inna</option>'; else echo '<option value="Inna">Inna</option>';			
	echo '</select>';
echo '</td>';

//######################### TERMIN REALIZACJI ZAMOWIENIA #################################################
echo '<td '.$rowspan.' width="80px">'.$kol_termin_realizacji_zamowienia2.'<div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=termin_realizacji">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=termin_realizacji">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_TERMIN_REALIZACJI" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	echo '<option></option>';
	if($SORT_TERMIN_REALIZACJI == "PUSTE") echo '<option selected="selected">PUSTE</option>'; else echo '<option>PUSTE</option>';
	for ($k=1; $k<=$TAB_DATA_DOSTAWY_DL; $k++) 
		{
		if($TAB_DATA_DOSTAWY[$k] == $SORT_TERMIN_REALIZACJI) echo '<option value="'.$TAB_DATA_DOSTAWY[$k].'" selected="selected">'.$TAB_DATA_DOSTAWY[$k].'</option>';
		else echo '<option value="'.$TAB_DATA_DOSTAWY[$k].'">'.$TAB_DATA_DOSTAWY[$k].'</option>';			
		}
	echo '</select>';
echo '</td>';

//######################### DATA DOSTAWY #################################################
echo '<td '.$rowspan.' width="90px">'.$kol_data_dostawy2.'<div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=data_dostawy">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=data_dostawy">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_DATA_DOSTAWY" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	echo '<option></option>';
	if($SORT_DATA_DOSTAWY == "PUSTE") echo '<option selected="selected">PUSTE</option>'; else echo '<option>PUSTE</option>';
	for ($k=1; $k<=$ilosc_data_dostawy; $k++) 
		if ($DATA_DOSTAWY[$k] == $SORT_DATA_DOSTAWY) echo '<option value="'.$DATA_DOSTAWY[$k].'" selected="selected">'.$DATA_DOSTAWY[$k].'</option>';
		else echo '<option value="'.$DATA_DOSTAWY[$k].'">'.$DATA_DOSTAWY[$k].'</option>';
	echo '</select>';
echo '</td>';

//######################### NR ZLECENIA TRANSPORTOWEGO #################################################
echo '<td '.$rowspan.' width="90px">'.$kol_nr_zlecenia_transportowego2.'<div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=nr_zlecenia_transportowego">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=nr_zlecenia_transportowego">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_NR_ZLECENIA_TRANSPORTOWEGO" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	echo '<option></option>';
	if($SORT_NR_ZLECENIA_TRANSPORTOWEGO == "PUSTE") echo '<option selected="selected">PUSTE</option>'; else echo '<option>PUSTE</option>';
	for ($k=1; $k<=$ilosc_nr_zlecenia_transportowego; $k++) 
		if ($NR_ZLECENIA_TRANSPORTOWEGO[$k] == $SORT_NR_ZLECENIA_TRANSPORTOWEGO) echo '<option value="'.$NR_ZLECENIA_TRANSPORTOWEGO[$k].'" selected="selected">'.$NR_ZLECENIA_TRANSPORTOWEGO[$k].'</option>';
		else echo '<option value="'.$NR_ZLECENIA_TRANSPORTOWEGO[$k].'">'.$NR_ZLECENIA_TRANSPORTOWEGO[$k].'</option>';
	echo '</select>';
echo '</td>';

//######################### NR FAKTURY #################################################
echo '<td '.$rowspan.' width="70px" valign="middle">Nr faktury</td>';


//######################### STATUS #################################################
echo '<td '.$rowspan.' width="90px">'.$kol_status_zamowienia2.'<div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=status">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=status">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_STATUS" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	echo '<option></option>';
	if($SORT_STATUS == "PUSTE") echo '<option selected="selected">PUSTE</option>'; else echo '<option>PUSTE</option>';
	for ($k=1; $k<=$ilosc_status; $k++) 
		if ($status_opis[$k] == $SORT_STATUS) echo '<option value="'.$status_opis[$k].'" selected="selected">'.$status_opis[$k].'</option>';
		else echo '<option value="'.$status_opis[$k].'">'.$status_opis[$k].'</option>';
	echo '</select>';
echo '</td>';

echo '<td '.$rowspan.' width="90px" valign="middle">'.$kol_uwagi.'</td></tr>';


if($user_id != 1)
	{
	//#############################     kolumny do materialu    ##############################################################
	$szerokosc_kolumny2 = '70px';
	echo '<tr align="center" valign="bottom" bgcolor="'.$kolor_tabeli.'" class="text"><td width="'.$szerokosc_kolumny2.'">'.$kol_system_prolifi.'<div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=system_profili">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=system_profili">'.$image_arrow_up.'</a></div>';
		echo '<select name="SORT_PROFIL" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
		echo '<option></option>';
		if($SORT_PROFIL == "PUSTE") echo '<option selected="selected">PUSTE</option>'; else echo '<option>PUSTE</option>';
		for ($k=1; $k<=$ilosc_profili; $k++) 
			if ($profil_opis[$k] == $SORT_PROFIL) echo '<option value="'.$profil_opis[$k].'" selected="selected">'.$profil_opis[$k].'</option>';
			else echo '<option value="'.$profil_opis[$k].'">'.$profil_opis[$k].'</option>';
		echo '</select>';
	echo '</td>';

	echo '<td width="'.$szerokosc_kolumny2.'">'.$kol_rodzaj_okuc.'<div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=rodzaj_okuc">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=rodzaj_okuc">'.$image_arrow_up.'</a></div>';
		echo '<select name="SORT_RODZAJ_OKUC" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
		echo '<option></option>';
		if($SORT_RODZAJ_OKUC == "PUSTE") echo '<option selected="selected">PUSTE</option>'; else echo '<option>PUSTE</option>';
		for ($k=1; $k<=$ilosc_rodzaj_okuc; $k++) 
			if ($rodzaj_okuc_opis[$k] == $SORT_RODZAJ_OKUC) echo '<option value="'.$rodzaj_okuc_opis[$k].'" selected="selected">'.$rodzaj_okuc_opis[$k].'</option>';
			else echo '<option value="'.$rodzaj_okuc_opis[$k].'">'.$rodzaj_okuc_opis[$k].'</option>';
		echo '</select>';
	echo '</td>';

	echo '<td width="'.$szerokosc_kolumny2.'">'.$kol_rodzaj_szyb.'<div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=rodzaj_szyb">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=rodzaj_szyb">'.$image_arrow_up.'</a></div>';
		echo '<select name="SORT_RODZAJ_SZYB" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
		echo '<option></option>';
		if($SORT_RODZAJ_SZYB == "PUSTE") echo '<option selected="selected">PUSTE</option>'; else echo '<option>PUSTE</option>';
		for ($k=1; $k<=$ilosc_rodzaj_szyb; $k++) 
			if ($rodzaj_szyb_opis[$k] == $SORT_RODZAJ_SZYB) echo '<option value="'.$rodzaj_szyb_opis[$k].'" selected="selected">'.$rodzaj_szyb_opis[$k].'</option>';
			else echo '<option value="'.$rodzaj_szyb_opis[$k].'">'.$rodzaj_szyb_opis[$k].'</option>';
		echo '</select>';
	echo '</td>';

	echo '<td width="'.$szerokosc_kolumny2.'">'.$kol_kolor_profili.'<div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=kolor_profili">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=kolor_profili">'.$image_arrow_up.'</a></div>';
		echo '<select name="SORT_KOLOR_PROFILI" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
		echo '<option></option>';
		if($SORT_KOLOR_PROFILI == "PUSTE") echo '<option selected="selected">PUSTE</option>'; else echo '<option>PUSTE</option>';
		for ($k=1; $k<=$ilosc_kolor_profili; $k++) 
			if ($kolor_profili_opis[$k] == $SORT_KOLOR_PROFILI) echo '<option value="'.$kolor_profili_opis[$k].'" selected="selected">'.$kolor_profili_opis[$k].'</option>';
			else echo '<option value="'.$kolor_profili_opis[$k].'">'.$kolor_profili_opis[$k].'</option>';
		echo '</select>';
	echo '</td>';

	echo '<td width="'.$szerokosc_kolumny2.'">'.$kol_kolor_uszczelek.'<div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=kolor_uszczelek">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=kolor_uszczelek">'.$image_arrow_up.'</a></div>';
		echo '<select name="SORT_KOLOR_USZCZELEK" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
		echo '<option></option>';
		if($SORT_KOLOR_USZCZELEK == "PUSTE") echo '<option selected="selected">PUSTE</option>'; else echo '<option>PUSTE</option>';
		for ($k=1; $k<=$ilosc_kolor_uszczelek; $k++) 
			if ($kolor_uszczelek_opis[$k] == $SORT_KOLOR_USZCZELEK) echo '<option value="'.$kolor_uszczelek_opis[$k].'" selected="selected">'.$kolor_uszczelek_opis[$k].'</option>';
			else echo '<option value="'.$kolor_uszczelek_opis[$k].'">'.$kolor_uszczelek_opis[$k].'</option>';
		echo '</select>';
	echo '</td>';

	echo '<td width="'.$szerokosc_kolumny2.'">'.$kol_magazyn.'<div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=magazyn">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=magazyn">'.$image_arrow_up.'</a></div>';
		echo '<select name="SORT_MAGAZYN" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
		echo '<option></option>';
		if($SORT_MAGAZYN == "PUSTE") echo '<option selected="selected">PUSTE</option>'; else echo '<option>PUSTE</option>';
		for ($k=1; $k<=$ilosc_magazyn; $k++) 
			if ($magazyn_opis[$k] == $SORT_MAGAZYN) echo '<option value="'.$magazyn_opis[$k].'" selected="selected">'.$magazyn_opis[$k].'</option>';
			else echo '<option value="'.$magazyn_opis[$k].'">'.$magazyn_opis[$k].'</option>';
		echo '</select>';
	echo '</td>';

	echo '<td width="'.$szerokosc_kolumny2.'">'.$kol_stan.'<div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=stan">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=stan">'.$image_arrow_up.'</a></div>';
		echo '<select name="SORT_STAN" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
		echo '<option></option>';
		if($SORT_STAN == "PUSTE") echo '<option selected="selected">PUSTE</option>'; else echo '<option>PUSTE</option>';
		for ($k=1; $k<=$ilosc_stan; $k++) 
			if ($stan_opis[$k] == $SORT_STAN) echo '<option value="'.$stan_opis[$k].'" selected="selected">'.$stan_opis[$k].'</option>';
			else echo '<option value="'.$stan_opis[$k].'">'.$stan_opis[$k].'</option>';
		echo '</select>';
	echo '</td>';

	//kolumny do ilosc
	$szerokosc_kolumny1 = '60px';
	echo '<td width="'.$szerokosc_kolumny1.'">'.$kol_sztuki.'<br><br><div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=sztuki">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=sztuki">'.$image_arrow_up.'</a></div></td>';
	echo '<td width="'.$szerokosc_kolumny1.'">'.$kol_luki_pvc.'<br><br><div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=luki_pvc">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=luki_pvc">'.$image_arrow_up.'</a></div></td>';
	echo '<td width="'.$szerokosc_kolumny1.'">'.$kol_luki_stal.'<br><br><div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=luki_stal">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=luki_stal">'.$image_arrow_up.'</a></div></td>';
	echo '<td width="'.$szerokosc_kolumny1.'">'.$kol_luki_alu.'<br><br><div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=luki_alu">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=luki_alu">'.$image_arrow_up.'</a></div></td>';
	echo '<td width="'.$szerokosc_kolumny1.'">'.$kol_zgrzewy.'<br><br><div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=zgrzewy">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=zgrzewy">'.$image_arrow_up.'</a></div></td>';
	echo '<td width="'.$szerokosc_kolumny1.'">'.$kol_odwodnienia.'<br><br><div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=odwodnienia">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=odwodnienia">'.$image_arrow_up.'</a></div></td>';
	echo '<td width="'.$szerokosc_kolumny1.'">'.$kol_slupki.'<br><br><div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=slupki">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=slupki">'.$image_arrow_up.'</a></div></td>';
	echo '<td width="'.$szerokosc_kolumny1.'">'.$kol_slupki_ruchome.'<br><br><div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=slupek_ruchomy">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=slupek_ruchomy">'.$image_arrow_up.'</a></div></td>';
	echo '<td width="'.$szerokosc_kolumny1.'">'.$kol_okuwanie.'<br><br><div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=okuwanie">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=okuwanie">'.$image_arrow_up.'</a></div></td>';
	echo '<td width="'.$szerokosc_kolumny1.'">'.$kol_szklenie.'<br><br><div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=szklenie">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=szklenie">'.$image_arrow_up.'</a></div></td>';
	echo '<td width="'.$szerokosc_kolumny1.'">'.$kol_dociecie_listwy.'<br><br><div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=dociecie_listwy">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=dociecie_listwy">'.$image_arrow_up.'</a></div></td>';
	echo '<td width="'.$szerokosc_kolumny1.'">'.$kol_dociecie_kompletu_listew.'<br><br><div align="right"><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=komplet_listew">'.$image_arrow_down.'</a><a href="index.php?page=zamowienia'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=komplet_listew">'.$image_arrow_up.'</a></div></td></tr>';
	}
echo '</form>';

for ($x=1; $x<=$i; $x++)
	{
	echo '<tr class="text_zmienny" align="center" bgcolor="'.$kolor_bialy.'"><td class="text" bgcolor="'.$kolor_tabeli.'">'.$x.'</td>'; 
	
	echo '<td><a href="index.php?page=zamowienie_edycja&zamowienie_id='.$zamowienie_id[$x].''.$SORTOWANIE_DIV.'&jak='.$jak.'&wg_czego='.$wg_czego.'"><font color="black">'.$klient_nazwa[$x].'</font></a></td>';
	echo '<td>'.$data_przyjecia_zamowienia[$x].'</td>';
	echo '<td><a href="index.php?page=wycena_edycja'.$SORTOWANIE_DIV.'&zamowienie_id='.$zamowienie_id[$x].'&jak='.$jak.'&wg_czego='.$wg_czego.'">'.$nr_zamowienia[$x].'</a></td>';
	
	echo '<td>'.$nr_zamowienia_klienta[$x].'</td>';
			
	echo '<td><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/pdf_potwierdzenia_zamowien/'.$link_potwierdzenie[$x].'" target="_blank"><font color="black">'.$data_wysylki_potwierdzenia[$x].'</font></a></td>';

	//data_wysylki_potwierdzenia_dostawy
	echo '<td><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/pdf_dostawy/'.$link_dostawa[$x].'" target="_blank"><font color="black">'.$data_wysylki_potwierdzenia_dostawy[$x];
	if($numer_wz[$x] != '') echo '<br>'.$numer_wz[$x];
	echo '</font></a></td>';
	
	if($lista_materialow_data[$x] != '') $lista_materialow_data[$x] = date("d-m-Y", $lista_materialow_data[$x]);
	echo '<td><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/pdf_lista_materialow/'.$lista_materialow_link[$x].'" target="_blank"><font color="black">'.$lista_materialow_data[$x].'</font></a></td>';


	echo '<td>'.$zamowiony_produkt[$x].'</td>';
	if($user_id != 1) 
		{
		echo '<td>'.$system_profili[$x].'</td>';
		echo '<td>'.$rodzaj_okuc[$x].'</td>';
		echo '<td>'.$rodzaj_szyb[$x].'</td>';
		
		echo '<td>'.$kolor_profili[$x].'</td>';
		echo '<td>'.$kolor_uszczelek[$x].'</td>';
		echo '<td>'.$magazyn[$x].'</td>';
		echo '<td>'.$stan[$x].'</td>';

		if($sztuki[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$sztuki[$x].'</td>';
		if($luki_pvc[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$luki_pvc[$x].' ('.$luki_pvc_do_realizacji[$x].')</td>';
		if($luki_stal[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$luki_stal[$x].'</td>';
		if($luki_alu[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$luki_alu[$x].'</td>';
		
		if($zgrzewy[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$zgrzewy[$x].' ('.$zgrzewy_do_realizacji[$x].')</td>';
		if($odwodnienia[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$odwodnienia[$x].'</td>';
		if($slupki[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$slupki[$x].'</td>';
		if($slupki_ruchome[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$slupki_ruchome[$x].'</td>';
		if($okuwanie[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$okuwanie[$x].'</td>';
		if($szklenie[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$szklenie[$x].'</td>';
		if($dociecie_listwy[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$dociecie_listwy[$x].'</td>';
		if($komplet_listew[$x] == 0) echo '<td>-</td>'; else echo '<td>'.$komplet_listew[$x].'</td>';
		}
	
	
	if($zalogowany_user == 1)
		if(($wartosc_netto[$x] == '0.00') || ($wartosc_brutto[$x] == '0.00') || ($wartosc_netto[$x] == Null) || ($wartosc_brutto[$x] == Null)) 
		{
			$wartosc_netto[$x] = pobierz_wartosc_netto($zamowienie_id[$x], $conn);
			$wartosc_brutto[$x] = pobierz_wartosc_brutto($zamowienie_id[$x], $conn);
			mysqli_query($conn, "UPDATE zamowienia SET wartosc_netto = ".$wartosc_netto[$x]." WHERE id = ".$zamowienie_id[$x]."");
			mysqli_query($conn, "UPDATE zamowienia SET wartosc_brutto = ".$wartosc_brutto[$x]." WHERE id = ".$zamowienie_id[$x]."");
		}
		
	$wartosc_netto[$x] = number_format($wartosc_netto[$x], 2,'.',' ');
	$wartosc_brutto[$x] = number_format($wartosc_brutto[$x], 2,'.',' ');
	
	echo '<td>'.$wartosc_netto[$x].$waluta.'</td>';
	echo '<td>'.$wartosc_brutto[$x].$waluta.'</td>';
	echo '<td>'.$strefa[$x].'</td>';
	echo '<td>'.$termin_realizacji[$x].'</td>';
	echo '<td>'.$data_dostawy[$x].'</td>';
	echo '<td>'.$nr_zlecenia_transportowego[$x].'</td>';

	// nr faktury
	echo '<td>';
	$ile_roznych_faktur = 0;
	$pytanie = mysqli_query($conn, "SELECT DISTINCT nr_faktury FROM wyceny WHERE zamowienie_id = ".$zamowienie_id[$x]." AND nr_faktury <> '' AND korekta_fv = 'NIE' ");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$ile_roznych_faktur++;
		echo $rozne_faktury[$ile_roznych_faktur]=$wynik['nr_faktury'];
		echo '<br>';
		}
	if($ile_roznych_faktur == 0) echo '<font color="red">BRAK</font>';
	echo '</td>';

	echo '<td>'.$status[$x].'</td>';
	echo '<td>'.$uwagi[$x].'</td></tr>';
	}
	
// dol tabeli
echo '<tr valign="bottom" align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
if($user_id == 1)
	{
	echo '<td></td>'; // lp
	echo '<td></td>'; // klient nazwa
	echo '<td></td>'; // Data przyjecia zamowienia
	echo '<td></td>'; // nr zamowienia arcus
	echo '<td></td>'; // nr zamowienia klienta
	echo '<td></td>'; // data wysylki
	echo '<td></td>'; // data wysylki
	echo '<td></td>'; // data wysylki listy materialow
	echo '<td></td>'; // zam produkt
	echo '<td>'.kwota($SUMA_WARTOSC_NETTO).$waluta.'</td>';
	echo '<td>'.kwota($SUMA_WARTOSC_BRUTTO).$waluta.'</td>';
	echo '<td></td>'; //strefa
	echo '<td></td>'; //termin realizacji
	echo '<td></td>'; // data dostawy
	echo '<td></td>'; // nr zlec transp
	echo '<td></td>'; // nr faktur
	echo '<td></td>'; //status
	echo '<td></td>'; //uwagi
	}
else
	{
	echo '<td></td>'; // lp
	echo '<td></td>'; // klient nazwa
	echo '<td></td>'; // Data przyjecia zamowienia
	echo '<td></td>'; // nr zamowienia arcus
	echo '<td></td>'; // nr zamowienia klienta
	echo '<td></td>'; // data wysylki
	echo '<td></td>'; // data wysylki
	echo '<td></td>'; // data wysłania listy materiałów
	echo '<td></td>'; // zam produkt
	echo '<td></td>'; // system profili
	echo '<td></td>'; // rodzaj okuc
	echo '<td></td>'; // rodzaj szyb
	echo '<td></td>'; // kolor profili
	echo '<td></td>'; // kolor uszczelek
	echo '<td></td>'; // magazyn
	echo '<td></td>'; // stan
	echo '<td>'.$SUMA_SZTUKI.'</td>';
	echo '<td>'.$SUMA_LUKI_PVC.'</td>';
	echo '<td>'.$SUMA_LUKI_STAL.'</td>';
	echo '<td>'.$SUMA_LUKI_ALU.'</td>';
	echo '<td>'.$SUMA_ZGRZEWY.'</td>';
	echo '<td>'.$SUMA_ODWODNIENIA.'</td>';
	echo '<td>'.$SUMA_SLUPKI.'</td>';
	echo '<td>'.$SUMA_SLUPKI_RUCHOME.'</td>';
	echo '<td>'.$SUMA_OKUWANIE.'</td>';
	echo '<td>'.$SUMA_SZKLENIE.'</td>';
	echo '<td>'.$SUMA_DOCIECIE_LISTWY.'</td>';
	echo '<td>'.$SUMA_KOMPLET_LISTEW.'</td>';

	echo '<td>'.kwota($SUMA_WARTOSC_NETTO).$waluta.'</td>';
	echo '<td>'.kwota($SUMA_WARTOSC_BRUTTO).$waluta.'</td>';
	echo '<td></td>'; //strefa
	echo '<td></td>'; //termin realizacji
	echo '<td></td>'; // data dostawy
	echo '<td></td>'; // nr zlec transp
	echo '<td></td>'; //nr faktury
	echo '<td></td>'; //status
	echo '<td></td>'; //uwagi
	}
echo '</tr></table>';

echo '</td></tr></table>'; // początek tabeli jest w pliku zamowienia_sortowanie
?>