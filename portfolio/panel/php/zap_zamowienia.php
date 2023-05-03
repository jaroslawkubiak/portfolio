<?php
$warunek = "";
if($SORT_KLIENT_NAZWA != "") 
	{
	if($warunek == "") $warunek .= 'WHERE klient_nazwa = "'.$SORT_KLIENT_NAZWA.'"';
	else $warunek .= ' AND klient_nazwa = "'.$SORT_KLIENT_NAZWA.'"';
	}          
		  
if(($SORT_STATUS != "") && ($SORT_STATUS != "PUSTE"))
	{
	if($warunek == "") $warunek .= 'WHERE status = "'.$SORT_STATUS.'"';
	else $warunek .= ' AND status = "'.$SORT_STATUS.'"';
	}        
	elseif(($SORT_STATUS != "") && ($SORT_STATUS == "PUSTE"))
		{
		if($warunek == "") $warunek .= 'WHERE status = ""';
		else $warunek .= ' AND status = ""';
		}

if($SORT_DATA_PRZYJECIA != "") 
	{
	if($warunek == "") $warunek .= 'WHERE data_przyjecia = "'.$SORT_DATA_PRZYJECIA.'"';
	else $warunek .= ' AND data_przyjecia = "'.$SORT_DATA_PRZYJECIA.'"';
	}        

if(($SORT_DATA_DOSTAWY != "") && ($SORT_DATA_DOSTAWY != "PUSTE"))
	{
	if($warunek == "") $warunek .= 'WHERE data_dostawy = "'.$SORT_DATA_DOSTAWY.'"';
	else $warunek .= ' AND data_dostawy = "'.$SORT_DATA_DOSTAWY.'"';
	}        
	elseif(($SORT_DATA_DOSTAWY != "") && ($SORT_DATA_DOSTAWY == "PUSTE"))
		{
		if($warunek == "") $warunek .= 'WHERE data_dostawy = ""';
		else $warunek .= ' AND data_dostawy = ""';
		}

if(($SORT_TERMIN_REALIZACJI != "") && ($SORT_TERMIN_REALIZACJI != "PUSTE"))
	{
	if($warunek == "") $warunek .= 'WHERE termin_realizacji = "'.$SORT_TERMIN_REALIZACJI.'"';
	else $warunek .= ' AND termin_realizacji = "'.$SORT_TERMIN_REALIZACJI.'"';
	}        
	elseif(($SORT_TERMIN_REALIZACJI != "") && ($SORT_TERMIN_REALIZACJI == "PUSTE"))
		{
		if($warunek == "") $warunek .= 'WHERE termin_realizacji = ""';
		else $warunek .= ' AND termin_realizacji = ""';
		}

if(($SORT_ZAMOWIONY_PRODUKT != "") && ($SORT_ZAMOWIONY_PRODUKT != "PUSTE"))
	{
	if($warunek == "") $warunek .= 'WHERE zamowiony_produkt = "'.$SORT_ZAMOWIONY_PRODUKT.'"';
	else $warunek .= ' AND zamowiony_produkt = "'.$SORT_ZAMOWIONY_PRODUKT.'"';
	}        
	elseif(($SORT_ZAMOWIONY_PRODUKT != "") && ($SORT_ZAMOWIONY_PRODUKT == "PUSTE"))
		{
		if($warunek == "") $warunek .= 'WHERE zamowiony_produkt = ""';
		else $warunek .= ' AND zamowiony_produkt = ""';
		}
		
if($SORT_NR_ZAMOWIENIA_KLIENTA != "") 
	{
	if($warunek == "") $warunek .= 'WHERE nr_zamowienia_klienta = "'.$SORT_NR_ZAMOWIENIA_KLIENTA.'"';
	else $warunek .= ' AND nr_zamowienia_klienta = "'.$SORT_NR_ZAMOWIENIA_KLIENTA.'"';
	}   
	     
if($SORT_STREFA != "") 
	{
	if($warunek == "") $warunek .= 'WHERE strefa = "'.$SORT_STREFA.'"';
	else $warunek .= ' AND strefa = "'.$SORT_STREFA.'"';
	}        

if($SORT_NR_ZAMOWIENIA != "") 
	{
	if($warunek == "") $warunek .= 'WHERE nr_zamowienia = "'.$SORT_NR_ZAMOWIENIA.'"';
	else $warunek .= ' AND nr_zamowienia = "'.$SORT_NR_ZAMOWIENIA.'"';
	}        
	
if(($SORT_KOLOR_PROFILI != "") && ($SORT_KOLOR_PROFILI != "PUSTE"))
	{
	if($warunek == "") $warunek .= 'WHERE kolor_profili = "'.$SORT_KOLOR_PROFILI.'"';
	else $warunek .= ' AND kolor_profili = "'.$SORT_KOLOR_PROFILI.'"';
	}        
	elseif(($SORT_KOLOR_PROFILI != "") && ($SORT_KOLOR_PROFILI == "PUSTE"))
		{
		if($warunek == "") $warunek .= 'WHERE kolor_profili = ""';
		else $warunek .= ' AND kolor_profili = ""';
		}

if(($SORT_RODZAJ_OKUC != "") && ($SORT_RODZAJ_OKUC != "PUSTE"))
	{
	if($warunek == "") $warunek .= 'WHERE rodzaj_okuc = "'.$SORT_RODZAJ_OKUC.'"';
	else $warunek .= ' AND rodzaj_okuc = "'.$SORT_RODZAJ_OKUC.'"';
	}        
	elseif(($SORT_RODZAJ_OKUC != "") && ($SORT_RODZAJ_OKUC == "PUSTE"))
		{
		if($warunek == "") $warunek .= 'WHERE rodzaj_okuc = ""';
		else $warunek .= ' AND rodzaj_okuc = ""';
		}

if(($SORT_RODZAJ_SZYB != "") && ($SORT_RODZAJ_SZYB != "PUSTE"))
	{
	if($warunek == "") $warunek .= 'WHERE rodzaj_szyb = "'.$SORT_RODZAJ_SZYB.'"';
	else $warunek .= ' AND rodzaj_szyb = "'.$SORT_RODZAJ_SZYB.'"';
	}        
	elseif(($SORT_RODZAJ_SZYB != "") && ($SORT_RODZAJ_SZYB == "PUSTE"))
		{
		if($warunek == "") $warunek .= 'WHERE rodzaj_szyb = ""';
		else $warunek .= ' AND rodzaj_szyb = ""';
		}

if(($SORT_PROFIL != "") && ($SORT_PROFIL != "PUSTE"))
	{
	if($warunek == "") $warunek .= 'WHERE system_profili = "'.$SORT_PROFIL.'"';
	else $warunek .= ' AND system_profili = "'.$SORT_PROFIL.'"';
	}    
	elseif(($SORT_PROFIL != "") && ($SORT_PROFIL == "PUSTE"))
		{
		if($warunek == "") $warunek .= 'WHERE system_profili = ""';
		else $warunek .= ' AND system_profili = ""';
		}

if($SORT_NR_ZLECENIA_TRANSPORTOWEGO != "")
	{
	if($SORT_NR_ZLECENIA_TRANSPORTOWEGO == "PUSTE") if($warunek == "") $warunek .= 'WHERE nr_zlecenia_transportowego = ""'; else $warunek .= ' AND nr_zlecenia_transportowego = ""';
	else if($warunek == "") $warunek .= 'WHERE nr_zlecenia_transportowego = "'.$SORT_NR_ZLECENIA_TRANSPORTOWEGO.'"'; else $warunek .= ' AND nr_zlecenia_transportowego = "'.$SORT_NR_ZLECENIA_TRANSPORTOWEGO.'"';
	}

if(($SORT_KOLOR_USZCZELEK != "") && ($SORT_KOLOR_USZCZELEK != "PUSTE"))
	{
	if($warunek == "") $warunek .= 'WHERE kolor_uszczelek = "'.$SORT_KOLOR_USZCZELEK.'"';
	else $warunek .= ' AND kolor_uszczelek = "'.$SORT_KOLOR_USZCZELEK.'"';
	}        
	elseif(($SORT_KOLOR_USZCZELEK != "") && ($SORT_KOLOR_USZCZELEK == "PUSTE"))
		{
		if($warunek == "") $warunek .= 'WHERE kolor_uszczelek = ""';
		else $warunek .= ' AND kolor_uszczelek = ""';
		}

if(($SORT_MAGAZYN != "") && ($SORT_MAGAZYN != "PUSTE"))
	{
	if($warunek == "") $warunek .= 'WHERE magazyn = "'.$SORT_MAGAZYN.'"';
	else $warunek .= ' AND magazyn = "'.$SORT_MAGAZYN.'"';
	}        
	elseif(($SORT_MAGAZYN != "") && ($SORT_MAGAZYN == "PUSTE"))
		{
		if($warunek == "") $warunek .= 'WHERE magazyn = ""';
		else $warunek .= ' AND magazyn = ""';
		}

if(($SORT_STAN != "") && ($SORT_STAN != "PUSTE"))
	{
	if($warunek == "") $warunek .= 'WHERE stan = "'.$SORT_STAN.'"';
	else $warunek .= ' AND stan = "'.$SORT_STAN.'"';
	}        
	elseif(($SORT_STAN != "") && ($SORT_STAN == "PUSTE"))
		{
		if($warunek == "") $warunek .= 'WHERE stan = ""';
		else $warunek .= ' AND stan = ""';
		}

if(($data_poczatkowa != "") && ($data_koncowa != ""))
{
	$data_poczatkowa_pieces = explode("-", $data_poczatkowa);		
	$data_poczatkowa_time = mktime(0,0,0,$data_poczatkowa_pieces[1], $data_poczatkowa_pieces[0], $data_poczatkowa_pieces[2]);
	$data_koncowa_pieces = explode("-", $data_koncowa);		
	$data_koncowa_time = mktime(23,59,59,$data_koncowa_pieces[1], $data_koncowa_pieces[0], $data_koncowa_pieces[2]);
	
	if($warunek == "") $warunek .= 'WHERE data_przyjecia_time >= "'.$data_poczatkowa_time.'" AND data_przyjecia_time <= "'.$data_koncowa_time.'"';
	else $warunek .= ' AND data_przyjecia_time >= "'.$data_poczatkowa_time.'" AND data_przyjecia_time <= "'.$data_koncowa_time.'" ';
}
	


$SORTOWANIE_DIV = '&pokaz='.$pokaz.'&szukaj='.$szukaj.'&data_poczatkowa='.$data_poczatkowa.'&data_koncowa='.$data_koncowa.'&SORT_STAN='.$SORT_STAN.'&SORT_NR_ZLECENIA_TRANSPORTOWEGO='.$SORT_NR_ZLECENIA_TRANSPORTOWEGO.'&SORT_STREFA='.$SORT_STREFA.'&SORT_PROFIL='.$SORT_PROFIL.'&SORT_RODZAJ_SZYB='.$SORT_RODZAJ_SZYB.'&SORT_RODZAJ_OKUC='.$SORT_RODZAJ_OKUC.'&SORT_MAGAZYN='.$SORT_MAGAZYN.'&SORT_KOLOR_PROFILI='.$SORT_KOLOR_PROFILI.'&SORT_NR_ZAMOWIENIA='.$SORT_NR_ZAMOWIENIA.'&SORT_NR_ZAMOWIENIA_KLIENTA='.$SORT_NR_ZAMOWIENIA_KLIENTA.'&SORT_ZAMOWIONY_PRODUKT='.$SORT_ZAMOWIONY_PRODUKT.'&SORT_TERMIN_REALIZACJI='.$SORT_TERMIN_REALIZACJI.'&SORT_KOLOR_USZCZELEK='.$SORT_KOLOR_USZCZELEK.'&SORT_DATA_PRZYJECIA='.$SORT_DATA_PRZYJECIA.'&SORT_DATA_DOSTAWY='.$SORT_DATA_DOSTAWY.'&SORT_STATUS='.$SORT_STATUS.'&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA.'';

$i=0;
$ilosc_nr_zamowienia_klienta=0;
$SUMA_SZTUKI = 0;
$SUMA_LUKI_PVC = 0;
$SUMA_LUKI_STAL = 0;
$SUMA_LUKI_ALU = 0;
$SUMA_ZGRZEWY = 0;
$SUMA_ODWODNIENIA = 0;
$SUMA_SLUPKI = 0;
$SUMA_OKUWANIE = 0;
$SUMA_SZKLENIE = 0;
$SUMA_DOCIECIE_LISTWY = 0;
$SUMA_SLUPKI_RUCHOME = 0;
$SUMA_KOMPLET_LISTEW = 0;
$SUMA_WARTOSC_NETTO = 0;
$SUMA_WARTOSC_BRUTTO = 0;

$zamowienie_id = [];
$klient_nazwa = [];
$data_przyjecia_zamowienia = [];
$nr_zamowienia = [];
$nr_zamowienia_klienta = [];
$NR_ZAMOWIENIA_KLIENTA = [];
$zamowiony_produkt = [];
$system_profili = [];
$rodzaj_okuc = [];
$rodzaj_szyb = [];
$kolor_profili = [];
$kolor_uszczelek = [];
$magazyn = [];
$kurs_euro = [];
$stan = [];
$sztuki = [];
$luki_pvc = [];
$luki_stal = [];
$luki_alu = [];
$zgrzewy = [];
$slupki = [];
$dociecie_listwy = [];
$slupki_ruchome = [];
$komplet_listew = [];
$szklenie = [];
$numer_wz = [];
$okuwanie = [];
$odwodnienia = [];
$wartosc_netto = [];
$wartosc_brutto = [];
$data_wysylki_potwierdzenia = [];
$link_potwierdzenie = [];
$data_wysylki_potwierdzenia_dostawy = [];
$lista_materialow_data = [];
$lista_materialow_link = [];
$link_dostawa = [];
$termin_realizacji = [];
$strefa = [];
$data_dostawy = [];
$nr_zlecenia_transportowego = [];
$status = [];
$uwagi = [];
$uwaga_1 = [];
$uwaga_2 = [];

if($wg_czego == '') $wg_czego = 'id';
if($jak == '') $jak = 'DESC';


$temp_wart_wyceny_netto = [];
$temp_wart_wyceny_brutto = [];

if($warunek == '') $warunek = "WHERE status <> 'Dostarczone' AND status <> 'Odebrane' AND status <> 'Anulowane' ";

$pytanie = mysqli_query($conn, "SELECT * FROM zamowienia ".$warunek." ORDER BY ".$wg_czego." ".$jak.";");
while($wynik= mysqli_fetch_assoc($pytanie))
{
$temp_status=$wynik['status']; 
if((($temp_status != "Dostarczone") || ($SORT_STATUS == "Dostarczone")) && (($temp_status != "Odebrane") || ($SORT_STATUS == "Odebrane")) && (($temp_status != "Anulowane") || ($SORT_STATUS == "Anulowane")))
	{
	$i++;
	$zamowienie_id[$i]=$wynik['id'];
	$klient_nazwa[$i]=$wynik['klient_nazwa'];
	$data_przyjecia_zamowienia[$i] = $wynik['data_przyjecia'];

	// konwertujemy date przyjecia na time
	// $data_przyjecia_pieces = explode("-", $data_przyjecia_zamowienia[$i]);		
	// $data_przyjecia_time = mktime(10,0,0,$data_przyjecia_pieces[1], $data_przyjecia_pieces[0], $data_przyjecia_pieces[2]);
	// $result = mysqli_query($conn, "UPDATE zamowienia SET data_przyjecia_time = '".$data_przyjecia_time."' WHERE id = ".$zamowienie_id[$i].";");

	$nr_zamowienia[$i]=$wynik['nr_zamowienia'];
	$nr_zamowienia_klienta[$i]=$wynik['nr_zamowienia_klienta'];
	
	if(($nr_zamowienia_klienta[$i] != '') && ($nr_zamowienia_klienta[$i] != '---'))
		{
		$ilosc_nr_zamowienia_klienta++;
		$NR_ZAMOWIENIA_KLIENTA[$ilosc_nr_zamowienia_klienta] = $nr_zamowienia_klienta[$i];
		}
		
	$zamowiony_produkt[$i]=$wynik['zamowiony_produkt'];
	$system_profili[$i]=$wynik['system_profili'];
	$rodzaj_okuc[$i]=$wynik['rodzaj_okuc'];
	$rodzaj_szyb[$i]=$wynik['rodzaj_szyb'];
	$kolor_profili[$i]=$wynik['kolor_profili'];
	$kolor_uszczelek[$i]=$wynik['kolor_uszczelek'];
	$magazyn[$i]=$wynik['magazyn'];
	$kurs_euro[$i]=$wynik['kurs_euro'];
	$stan[$i]=$wynik['stan'];
	

	$sztuki[$i]=$wynik['sztuki'];
		$SUMA_SZTUKI += $sztuki[$i];
	$luki_pvc[$i]=$wynik['luki_pvc'];
		$SUMA_LUKI_PVC += $luki_pvc[$i];
	$luki_stal[$i]=$wynik['luki_stal'];
		$SUMA_LUKI_STAL += $luki_stal[$i];
	$luki_alu[$i]=$wynik['luki_alu'];
		$SUMA_LUKI_ALU += $luki_alu[$i];
	$zgrzewy[$i]=$wynik['zgrzewy'];
		$SUMA_ZGRZEWY += $zgrzewy[$i];
	$odwodnienia[$i]=$wynik['odwodnienia'];
		$SUMA_ODWODNIENIA += $odwodnienia[$i];
	$slupki[$i]=$wynik['slupki'];
		$SUMA_SLUPKI += $slupki[$i];
	$okuwanie[$i]=$wynik['okuwanie'];
		$SUMA_OKUWANIE += $okuwanie[$i];
	$szklenie[$i]=$wynik['szklenie'];
		$SUMA_SZKLENIE += $szklenie[$i];
	$dociecie_listwy[$i]=$wynik['dociecie_listwy'];
		$SUMA_DOCIECIE_LISTWY += $dociecie_listwy[$i];
	$slupki_ruchome[$i]=$wynik['slupek_ruchomy'];
		$SUMA_SLUPKI_RUCHOME += $slupki_ruchome[$i];
	$komplet_listew[$i]=$wynik['komplet_listew'];
		$SUMA_KOMPLET_LISTEW += $komplet_listew[$i];
	
	if($user_id != 1) 
		{
		//szukamy ilosci wykonanych luki pvc i zgrzewy
		$luki_pvc_relizacja[$i] = 0;
		$zgrzewy_relizacja[$i] = 0;
		$pytanie347 = mysqli_query($conn, "SELECT ilosc, rodzaj_produktu FROM realizacja_produkcji WHERE (rodzaj_produktu = 1 OR rodzaj_produktu = 4) AND zamowienie_id = ".$zamowienie_id[$i].";");
		while($wynik347= mysqli_fetch_assoc($pytanie347))
			{
			if($wynik347['rodzaj_produktu'] == 1) $luki_pvc_relizacja[$i] += $wynik347['ilosc'];
			if($wynik347['rodzaj_produktu'] == 4) $zgrzewy_relizacja[$i] += $wynik347['ilosc'];
			}
			
		$luki_pvc_do_realizacji[$i] = $luki_pvc[$i] - $luki_pvc_relizacja[$i];
		$zgrzewy_do_realizacji[$i] = $zgrzewy[$i] - $zgrzewy_relizacja[$i];
		}


	$wartosc_netto[$i]=$wynik['wartosc_netto'];
		$SUMA_WARTOSC_NETTO += $wartosc_netto[$i];
	$wartosc_brutto[$i]=$wynik['wartosc_brutto'];
		$SUMA_WARTOSC_BRUTTO += $wartosc_brutto[$i];


	//czasami wartości netto i brutto nie zgadzają się między zamówieniem w wyceną. Tutaj je sprawdzamy i zapisujemy poprawne wartości z wyceny do zamówienia.
	$temp_wart_wyceny_netto[$zamowienie_id[$i]] = 0;
	$temp_wart_wyceny_brutto[$zamowienie_id[$i]] = 0;
	$pytanie347 = mysqli_query($conn, "SELECT wartosc_netto, wartosc_brutto FROM wyceny WHERE zamowienie_id = ".$zamowienie_id[$i].";");
	while($wynik347= mysqli_fetch_assoc($pytanie347))
		{
		$temp_wart_wyceny_netto[$zamowienie_id[$i]] += $wynik347['wartosc_netto'];
		$temp_wart_wyceny_brutto[$zamowienie_id[$i]] += $wynik347['wartosc_brutto'];
		}
	$temp_wart_wyceny_netto[$zamowienie_id[$i]] = change($temp_wart_wyceny_netto[$zamowienie_id[$i]]);
	$wartosc_netto[$i] = change($wartosc_netto[$i]);
	$temp_wart_wyceny_brutto[$zamowienie_id[$i]] = change($temp_wart_wyceny_brutto[$zamowienie_id[$i]]);
	$wartosc_brutto[$i] = change($wartosc_brutto[$i]);
	
	if($temp_wart_wyceny_netto[$zamowienie_id[$i]] != $wartosc_netto[$i]) $result = mysqli_query($conn, "UPDATE zamowienia SET wartosc_netto = ".$temp_wart_wyceny_netto[$zamowienie_id[$i]]." WHERE id = ".$zamowienie_id[$i]."");
	if($temp_wart_wyceny_brutto[$zamowienie_id[$i]] != $wartosc_brutto[$i]) $result = mysqli_query($conn, "UPDATE zamowienia SET wartosc_brutto = ".$temp_wart_wyceny_brutto[$zamowienie_id[$i]]." WHERE id = ".$zamowienie_id[$i]."");
	// KONIEC


	$data_wysylki_potwierdzenia[$i]=$wynik['data_wysylki_potwierdzenia'];
	$link_potwierdzenie[$i]=$wynik['link_potwierdzenie'];
	$data_wysylki_potwierdzenia_dostawy[$i]=$wynik['data_wysylki_potwierdzenia_dostawy'];
	$lista_materialow_data[$i]=$wynik['lista_materialow_data'];
	$lista_materialow_link[$i]=$wynik['lista_materialow_link'];
	$link_dostawa[$i]=$wynik['link_dostawa'];
	$termin_realizacji[$i]=$wynik['termin_realizacji'];
	$strefa[$i]=$wynik['strefa'];
	$data_dostawy[$i]=$wynik['data_dostawy'];
	$nr_zlecenia_transportowego[$i]=$wynik['nr_zlecenia_transportowego'];
	$numer_wz[$i]=$wynik['numer_wz'];
	$status[$i]=$wynik['status'];
	
	$uwagi[$i]=$wynik['uwagi'];
	$uwaga_1[$i]=$wynik['uwaga_1'];
	$uwaga_2[$i]=$wynik['uwaga_2'];
	
	if(($uwagi[$i] != '') && ($uwaga_1[$i] != '') && ($uwaga_2[$i] == '')) $uwagi[$i] = $uwagi[$i].',<br>'.$uwaga_1[$i];
	if(($uwagi[$i] != '') && ($uwaga_1[$i] == '') && ($uwaga_2[$i] != '')) $uwagi[$i] = $uwagi[$i].',<br>'.$uwaga_2[$i];
	if(($uwagi[$i] != '') && ($uwaga_1[$i] != '') && ($uwaga_2[$i] != '')) $uwagi[$i] = $uwagi[$i].',<br>'.$uwaga_1[$i].',<br>'.$uwaga_2[$i];
	
	if(($uwagi[$i] == '') && ($uwaga_1[$i] != '') && ($uwaga_2[$i] == '')) $uwagi[$i] = $uwaga_1[$i];
	if(($uwagi[$i] == '') && ($uwaga_1[$i] == '') && ($uwaga_2[$i] != '')) $uwagi[$i] = $uwaga_2[$i];
	if(($uwagi[$i] == '') && ($uwaga_1[$i] != '') && ($uwaga_2[$i] != '')) $uwagi[$i] = $uwaga_1[$i].',<br>'.$uwaga_2[$i];
	
	}
}
?>