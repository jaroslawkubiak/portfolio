<?php
include("php/wyceny_deklaracja_pustych_tablic.php");


if($etap == 2)
	{
	$szerokosc_pola_input_ilosc = '40px';
	$szerokosc_pola_input_cena = '50px';
	$szerokosc_pola_input_wartosc = '50px';
	$szer_inne_wartosc = '100px';
	
	//obliczanie szerokosci tabeli dla wycen
	$ilosc_kolumn_ilosc = 49; 
	$ilosc_kolumn_cena = 30;
	$ilosc_kolumn_wartosc = 44;
	$ilosc_kolumn_rozne = 5; //nazwa produktu, wart netto i brutto, cena za szt, uwagi

	$szerokosc_kolumny_ilosc = 50;
	$szerokosc_kolumny_cena = 60;
	$szerokosc_kolumny_wartosc = 70;
	$szerokosc_kolumny_rozne = 120;
	$szerokosc_kolumny_nazwa_produktu = 250;

	$szerokosc_tabeli_glownej = $ilosc_kolumn_ilosc*$szerokosc_kolumny_ilosc + $ilosc_kolumn_cena*$szerokosc_kolumny_cena + $ilosc_kolumn_wartosc*$szerokosc_kolumny_wartosc + $ilosc_kolumn_rozne*$szerokosc_kolumny_rozne + $szerokosc_kolumny_nazwa_produktu*2;

	$pytanie11 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$klient.";");
	while($wynik11= mysqli_fetch_assoc($pytanie11))
		$klient_nazwa=$wynik11['nazwa'];

			
	echo '<table border="0" valign="top" align="left" width="100%"><tr class="text_duzy">';
	if($wycena_wstepna_nr == '') 
		{
		$napis_wycena = 'Wycena';
		$przekierowanie_do = 'zamowienie_wycena';
		}
	else
		{
		$napis_wycena = 'Wycena wstępna';
		$nr_zamowienia = $wycena_wstepna_nr;
		$przekierowanie_do = 'zamowienie_wycena_wstepna';
		}
	for ($k=1; $k<=5; $k++) echo '<td width="20%" align="center">'.$napis_wycena.' : <font color="blue">'.$nr_zamowienia.'</font> dla klienta <font color="blue">'.$klient_nazwa.'</font></td>';
	echo '</tr></table>';	
	
	include("php/dlugosc_luku_wyceny.php");
	echo '<br>';
	
	echo '<FORM action="index.php?page='.$przekierowanie_do.'" method="post">';
	echo '<INPUT type="hidden" name="etap" value="3">';
	echo '<input type="hidden" id="id_ilosc_pozycji" name="ilosc_pozycji" value="'.$ilosc_pozycji.'">';
	echo '<input type="hidden" name="klient" value="'.$klient.'">'; // klient ID
	echo '<input type="hidden" name="klient_nazwa" value="'.$klient_nazwa.'">';
	echo '<input type="hidden" name="zamowienie_id" value="'.$zamowienie_id.'">';
	echo '<input type="hidden" name="nr_zamowienia" value="'.$nr_zamowienia.'">';
	echo '<input type="hidden" id="sprawdz" value="tak">';
	echo '<input type="hidden" id="id_pozycja_transport" name="pozycja_transport" value="nie">';
	echo '<input type="hidden" id="status" name="status" value="">';

	//dane do wyceny wstepnej
	echo '<input type="hidden" name="wycena_wstepna_nr" value="'.$wycena_wstepna_nr.'">';
	echo '<input type="hidden" name="data_waznosci" value="'.$data_waznosci.'">';
	echo '<input type="hidden" name="email" value="'.$email.'">';
	echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
	echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';



	echo '<br><table valign="top" align="left" width="'.$szerokosc_tabeli_glownej.'px" border="1" cellspacing="1" cellpadding="1" class="text" BORDERCOLOR="black" frame="box" RULES="all">';

	include("php/wycena_edycja_nazwy_kolumn.php");


	// pobieram cennik dla klienta
	$pytanie = mysqli_query($conn, "SELECT * FROM klienci WHERE id=".$klient.";");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$cena[1] = number_format($wynik['wygiecie_ramy_z_pvc'], 2,'.','');
		$cena[2] = number_format($wynik['wygiecie_skrzydla_z_pvc'], 2,'.','');
		$cena[3] = number_format($wynik['wygiecie_listwy_z_pvc'], 2,'.','');
		$cena[4] = number_format($wynik['wygiecie_innego_elementu_z_pvc'], 2,'.','');
		
		$cena[5] = number_format($wynik['wygiecie_ramy_z_alu'], 2,'.','');
		$cena[6] = number_format($wynik['wygiecie_skrzydla_z_alu'], 2,'.','');
		$cena[7] = number_format($wynik['wygiecie_listwy_z_alu'], 2,'.','');
		$cena[8] = number_format($wynik['wygiecie_innego_elementu_z_alu'], 2,'.','');
	
		$cena[9] = number_format($wynik['wygiecie_wzmocnienia_okiennego'], 2,'.','');
		$cena[10] = number_format($wynik['wygiecie_innego_elementu_ze_stali'], 2,'.','');
		$cena[11] = number_format($wynik['zgrzanie'], 2,'.','');
		$cena[12] = number_format($wynik['wyfrezowanie_odwodnienia'], 2,'.','');
		
		$cena[13] = number_format($wynik['wstawienie_slupka'], 2,'.','');
		$cena[14] = number_format($wynik['dociecie_listwy_przyszybowej'], 2,'.','');
		$cena[29] = number_format($wynik['wstawienie_slupka_ruchomego'], 2,'.','');
		$cena[30] = number_format($wynik['dociecie_kompletu_listew_przyszybowych'], 2,'.','');
		
		$cena[15] = number_format($wynik['okucie'], 2,'.','');
		$cena[16] = number_format($wynik['zaszklenie'], 2,'.','');
		
		$cena[17] = number_format($wynik['wykonanie_innej_usługi'], 2,'.','');
		$cena[18] = number_format($wynik['oscieznica'], 2,'.','');
		$cena[19] = number_format($wynik['skrzydlo'], 2,'.','');
		$cena[20] = number_format($wynik['listwa'], 2,'.','');

		$cena[21] = number_format($wynik['slupek'], 2,'.','');
		$cena[22] = number_format($wynik['wzmocnienie_do_ramy'], 2,'.','');
		$cena[23] = number_format($wynik['wzmocnienie_do_skrzydla'], 2,'.','');
		$cena[24] = number_format($wynik['wzmocnienie_do_slupka'], 2,'.','');
		
		$cena[25] = number_format($wynik['wzmocnienie_do_luku'], 2,'.','');
		$cena[26] = number_format($wynik['okucia'], 2,'.','');
		$cena[27] = number_format($wynik['szyby'], 2,'.','');
		$cena[28] = number_format($wynik['inny_element'], 2,'.','');
		}

		
	// pobieram stawki VAT
	$TAB_VAT_DL = 0;
	$pytanie = mysqli_query($conn, "SELECT * FROM vat ORDER BY id ASC");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$TAB_VAT_DL++;
		$TAB_VAT[$TAB_VAT_DL]=$wynik['wartosc'];
		}

$wysykosc_wiersza = '35px';
//pole potrzebne do wylyczania wygiecia ramy z pvc - przy korekcie nie ma ptaszków
echo '<input type="hidden" id="czy_to_korekta" value="nie">';

for ($x=1;$x<=$ilosc_pozycji; $x++)
	{
	if($x%2)
		{	
		$wiersz = $kolor_bialy;
		$styl = "pole_input_biale_ramka"; 
		$styl2 = "pole_input_biale_bez_ramki";
		$styl_select = "pole_select_biale_z_ramka"; 
		$styl_uwagi = "pole_input_biale_ramka_uwagi"; 
		}
	else 
		{
		$wiersz = $kolor_szary;
		$styl = "pole_input_szare_ramka";
		$styl2 = "pole_input_szare_bez_ramki";
		$styl_select = "pole_select_szare_z_ramka"; 
		$styl_uwagi = "pole_input_szare_ramka_uwagi"; 
		}
		
	echo '<tr bgcolor="'.$wiersz.'" align="center" height="'.$wysykosc_wiersza.'"><td bgcolor="'.$kolor_tabeli.'">'.$x.'/'.$ilosc_pozycji.'</td>';
	// ##################################################################################################################################################################
	// ##################################################################################################################################################################
	// #######################################################################  łuki z pvc          ###################################################################
	// #######################################################################  wygiecie_ramy_z_pvc ###################################################################
	//   #################   kolumna E ilosc sz  
	$id_wygiecie_ramy_z_pvc_ilosc_szt = 'id_wygiecie_ramy_z_pvc_ilosc_szt_'.$x;
	$nazwa_wygiecie_ramy_z_pvc_ilosc_szt = 'nazwa_wygiecie_ramy_z_pvc_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_ramy_z_pvc_ilosc_szt.'" name="'.$nazwa_wygiecie_ramy_z_pvc_ilosc_szt.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_sztuki_wygiecie_wzmocnienia_okiennego('.$x.', '.$ilosc_pozycji.');"></td>';
	//   #################   kolumna F ilosc metr  
	$id_wygiecie_ramy_z_pvc_ilosc_m = 'id_wygiecie_ramy_z_pvc_ilosc_m_'.$x;
	$nazwa_wygiecie_ramy_z_pvc_ilosc_m = 'nazwa_wygiecie_ramy_z_pvc_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_ramy_z_pvc_ilosc_m.'" name="'.$nazwa_wygiecie_ramy_z_pvc_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_ramy_z_pvc('.$x.', '.$ilosc_pozycji.');"></td>';
	//   #################   kolumna G cena, ID z cennika = 1    ####################################
	$id_cena_ramy = 'id_cena_ramy_'.$x;	
	$nazwa_wygiecie_ramy_z_pvc_cena = 'nazwa_wygiecie_ramy_z_pvc_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[1].'" id="'.$id_cena_ramy.'" name="'.$nazwa_wygiecie_ramy_z_pvc_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_ramy_z_pvc('.$x.', '.$ilosc_pozycji.');"></td>';
	//   #################   kolumna H  wartosc   ####################################
	$id_wygiecie_ramy_z_pvc_wartosc = 'id_wygiecie_ramy_z_pvc_wartosc_'.$x;		
	$nazwa_wygiecie_ramy_z_pvc_wartosc = 'nazwa_wygiecie_ramy_z_pvc_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_ramy_z_pvc_wartosc.'" name="'.$nazwa_wygiecie_ramy_z_pvc_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
	
	//   #######################################################################  wygiecie_skrzydla_z_pvc ###################################################################

	//   #################   kolumna z ptaszkiem do zaznaczania
	$id_wygiecie_skrzydla_ptaszek = 'id_wygiecie_skrzydla_ptaszek_'.$x;
	$nazwa_wygiecie_skrzydla_ptaszek = 'nazwa_wygiecie_skrzydla_ptaszek['.$x.']';
	echo '<td align="center"><input type="checkbox" TABINDEX="'.$x.'" id="'.$id_wygiecie_skrzydla_ptaszek.'" name="'.$nazwa_wygiecie_skrzydla_ptaszek.'" class="'.$styl.'"  onclick="Zaznaczenie_checkboxa_wygiecie_skrzydla('.$x.', '.$ilosc_pozycji.');"></td>';
	
	//   #################   kolumna I ilosc sz  
	$id_wygiecie_skrzydla_z_pvc_ilosc_szt = 'id_wygiecie_skrzydla_z_pvc_ilosc_szt_'.$x;
	$nazwa_wygiecie_skrzydla_z_pvc_ilosc_szt = 'nazwa_wygiecie_skrzydla_z_pvc_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_skrzydla_z_pvc_ilosc_szt.'" name="'.$nazwa_wygiecie_skrzydla_z_pvc_ilosc_szt.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_sztuki_wygiecie_wzmocnienia_okiennego('.$x.', '.$ilosc_pozycji.');"></td>';
	//   #################   kolumna J ilosc metr  
	$id_wygiecie_skrzydla_z_pvc_ilosc_m = 'id_wygiecie_skrzydla_z_pvc_ilosc_m_'.$x;
	$nazwa_wygiecie_skrzydla_z_pvc_ilosc_m = 'nazwa_wygiecie_skrzydla_z_pvc_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_skrzydla_z_pvc_ilosc_m.'" name="'.$nazwa_wygiecie_skrzydla_z_pvc_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_skrzydla_z_pvc('.$x.');"></td>';
	//   #################   kolumna K cena, ID z cennika = 2    ####################################
	$id_cena_skrzydla = 'id_cena_skrzydla_'.$x;	
	$nazwa_wygiecie_skrzydla_z_pvc_cena = 'nazwa_wygiecie_skrzydla_z_pvc_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[2].'" id="'.$id_cena_skrzydla.'" name="'.$nazwa_wygiecie_skrzydla_z_pvc_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_skrzydla_z_pvc('.$x.');"></td>';
	//   #################   kolumna L  wartosc   ####################################
	$id_wygiecie_skrzydla_z_pvc_wartosc = 'id_wygiecie_skrzydla_z_pvc_wartosc_'.$x;		
	$nazwa_wygiecie_skrzydla_z_pvc_wartosc = 'nazwa_wygiecie_skrzydla_z_pvc_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_skrzydla_z_pvc_wartosc.'" name="'.$nazwa_wygiecie_skrzydla_z_pvc_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
	//   #######################################################################  wygiecie_listwy_z_pvc ###################################################################
	

	//   #################   kolumna z ptaszkiem do zaznaczania
	$id_wygiecie_listwy_ptaszek = 'id_wygiecie_listwy_ptaszek_'.$x;
	$nazwa_wygiecie_listwy_ptaszek = 'nazwa_wygiecie_listwy_ptaszek['.$x.']';
	echo '<td align="center"><input type="checkbox" TABINDEX="'.$x.'" id="'.$id_wygiecie_listwy_ptaszek.'" name="'.$nazwa_wygiecie_listwy_ptaszek.'" class="'.$styl.'"  onclick="Zaznaczenie_checkboxa_wygiecie_listwy('.$x.', '.$ilosc_pozycji.');"></td>';
	//   #################   kolumna M ilosc sz  
	$id_wygiecie_listwy_z_pvc_ilosc_szt = 'id_wygiecie_listwy_z_pvc_ilosc_szt_'.$x;
	$nazwa_wygiecie_listwy_z_pvc_ilosc_szt = 'nazwa_wygiecie_listwy_z_pvc_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_listwy_z_pvc_ilosc_szt.'" name="'.$nazwa_wygiecie_listwy_z_pvc_ilosc_szt.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'"></td>';
	//   #################   kolumna N ilosc metr  
	$id_wygiecie_listwy_z_pvc_ilosc_m = 'id_wygiecie_listwy_z_pvc_ilosc_m_'.$x;
	$nazwa_wygiecie_listwy_z_pvc_ilosc_m = 'nazwa_wygiecie_listwy_z_pvc_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_listwy_z_pvc_ilosc_m.'" name="'.$nazwa_wygiecie_listwy_z_pvc_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_listwy_z_pvc();"></td>';
	//   #################   kolumna O cena, ID z cennika = 3    ####################################
	$id_cena_listwy = 'id_cena_listwy_'.$x;	
	$nazwa_wygiecie_listwy_z_pvc_cena = 'nazwa_wygiecie_listwy_z_pvc_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[3].'" id="'.$id_cena_listwy.'" name="'.$nazwa_wygiecie_listwy_z_pvc_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_listwy_z_pvc();"></td>';
	//   #################   kolumna P  wartosc   ####################################
	$id_wygiecie_listwy_z_pvc_wartosc = 'id_wygiecie_listwy_z_pvc_wartosc_'.$x;		
	$nazwa_wygiecie_listwy_z_pvc_wartosc = 'nazwa_wygiecie_listwy_z_pvc_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_listwy_z_pvc_wartosc.'" name="'.$nazwa_wygiecie_listwy_z_pvc_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
		
	//   #######################################################################  wygiecie_innego elementu_z_pvc ###################################################################
	//   #################   kolumna Q ilosc sz  
	$nazwa_wygiecie_innego_elementu_z_pvc_ilosc_szt = 'nazwa_wygiecie_innego_elementu_z_pvc_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_wygiecie_innego_elementu_z_pvc_ilosc_szt.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'"></td>';
	//   #################   kolumna R ilosc metr  
	$id_wygiecie_innego_elementu_z_pvc_ilosc_m = 'id_wygiecie_innego_elementu_z_pvc_ilosc_m_'.$x;
	$nazwa_wygiecie_innego_elementu_z_pvc_ilosc_m = 'nazwa_wygiecie_innego_elementu_z_pvc_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_innego_elementu_z_pvc_ilosc_m.'" name="'.$nazwa_wygiecie_innego_elementu_z_pvc_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_innego_elementu_z_pvc();"></td>';
	//   #################   kolumna S cena, ID z cennika = 4    ####################################
	$id_cena_innego_elementu = 'id_cena_innego_elementu_'.$x;	
	$nazwa_wygiecie_innego_elementu_z_pvc_cena = 'nazwa_wygiecie_innego_elementu_z_pvc_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[4].'" id="'.$id_cena_innego_elementu.'" name="'.$nazwa_wygiecie_innego_elementu_z_pvc_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_innego_elementu_z_pvc();"></td>';
	//   #################   kolumna T  wartosc   ####################################
	$id_wygiecie_innego_elementu_z_pvc_wartosc = 'id_wygiecie_innego_elementu_z_pvc_wartosc_'.$x;		
	$nazwa_wygiecie_innego_elementu_z_pvc_wartosc = 'nazwa_wygiecie_innego_elementu_z_pvc_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_innego_elementu_z_pvc_wartosc.'" name="'.$nazwa_wygiecie_innego_elementu_z_pvc_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// ##################################################################################################################################################################
	// #######################################################################  łuki z aluminium               ###################################################################
	// #######################################################################  wygiecie_ramy_z_alu            ###################################################################
	// ##################################################################################################################################################################
	
	//   #################   kolumna u ilosc sz  
	$nazwa_wygiecie_ramy_z_alu_ilosc_szt = 'nazwa_wygiecie_ramy_z_alu_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_wygiecie_ramy_z_alu_ilosc_szt.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'"></td>';
	//   #################   kolumna v ilosc metr  
	$id_wygiecie_ramy_z_alu_ilosc_m = 'id_wygiecie_ramy_z_alu_ilosc_m_'.$x;
	$nazwa_wygiecie_ramy_z_alu_ilosc_m = 'nazwa_wygiecie_ramy_z_alu_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_ramy_z_alu_ilosc_m.'" name="'.$nazwa_wygiecie_ramy_z_alu_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_ramy_z_alu();"></td>';
	//   #################   kolumna w cena, ID z cennika = 5    ####################################
	$id_cena_ramy_alu = 'id_cena_ramy_alu_'.$x;	
	$nazwa_wygiecie_ramy_z_alu_cena = 'nazwa_wygiecie_ramy_z_alu_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[5].'" id="'.$id_cena_ramy_alu.'" name="'.$nazwa_wygiecie_ramy_z_alu_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_ramy_z_alu();"></td>';
	//   #################   kolumna x  wartosc   ####################################
	$id_wygiecie_ramy_z_alu_wartosc = 'id_wygiecie_ramy_z_alu_wartosc_'.$x;		
	$nazwa_wygiecie_ramy_z_alu_wartosc = 'nazwa_wygiecie_ramy_z_alu_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_ramy_z_alu_wartosc.'" name="'.$nazwa_wygiecie_ramy_z_alu_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
	
	
	//   #######################################################################  wygiecie_skrzydla_z_alu ###################################################################
	//   #################   kolumna y ilosc sz  
	$nazwa_wygiecie_skrzydla_z_alu_ilosc_szt = 'nazwa_wygiecie_skrzydla_z_alu_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_wygiecie_skrzydla_z_alu_ilosc_szt.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'"></td>';
	//   #################   kolumna z ilosc metr  
	$id_wygiecie_skrzydla_z_alu_ilosc_m = 'id_wygiecie_skrzydla_z_alu_ilosc_m_'.$x;
	$nazwa_wygiecie_skrzydla_z_alu_ilosc_m = 'nazwa_wygiecie_skrzydla_z_alu_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_skrzydla_z_alu_ilosc_m.'" name="'.$nazwa_wygiecie_skrzydla_z_alu_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_skrzydla_z_alu();"></td>';
	//   #################   kolumna aa cena, ID z cennika = 6    ####################################
	$id_cena_skrzydla_alu = 'id_cena_skrzydla_alu_'.$x;	
	$nazwa_wygiecie_skrzydla_z_alu_cena = 'nazwa_wygiecie_skrzydla_z_alu_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[6].'" id="'.$id_cena_skrzydla_alu.'" name="'.$nazwa_wygiecie_skrzydla_z_alu_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_skrzydla_z_alu();"></td>';
	//   #################   kolumna ab  wartosc   ####################################
	$id_wygiecie_skrzydla_z_alu_wartosc = 'id_wygiecie_skrzydla_z_alu_wartosc_'.$x;		
	$nazwa_wygiecie_skrzydla_z_alu_wartosc = 'nazwa_wygiecie_skrzydla_z_alu_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_skrzydla_z_alu_wartosc.'" name="'.$nazwa_wygiecie_skrzydla_z_alu_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
	
		
	//   #######################################################################  wygiecie_listwy_z_alu ###################################################################
	//   #################   kolumna ac ilosc sz  
	$nazwa_wygiecie_listwy_z_alu_ilosc_szt = 'nazwa_wygiecie_listwy_z_alu_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_wygiecie_listwy_z_alu_ilosc_szt.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'"></td>';
	//   #################   kolumna ad ilosc metr  
	$id_wygiecie_listwy_z_alu_ilosc_m = 'id_wygiecie_listwy_z_alu_ilosc_m_'.$x;
	$nazwa_wygiecie_listwy_z_alu_ilosc_m = 'nazwa_wygiecie_listwy_z_alu_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_listwy_z_alu_ilosc_m.'" name="'.$nazwa_wygiecie_listwy_z_alu_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_listwy_z_alu();"></td>';
	//   #################   kolumna ae cena, ID z cennika = 7    ####################################
	$id_cena_listwy_alu = 'id_cena_listwy_alu_'.$x;	
	$nazwa_wygiecie_listwy_z_alu_cena = 'nazwa_wygiecie_listwy_z_alu_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[7].'" id="'.$id_cena_listwy_alu.'" name="'.$nazwa_wygiecie_listwy_z_alu_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_listwy_z_alu();"></td>';
	//   #################   kolumna af  wartosc   ####################################
	$id_wygiecie_listwy_z_alu_wartosc = 'id_wygiecie_listwy_z_alu_wartosc_'.$x;		
	$nazwa_wygiecie_listwy_z_alu_wartosc = 'nazwa_wygiecie_listwy_z_alu_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_listwy_z_alu_wartosc.'" name="'.$nazwa_wygiecie_listwy_z_alu_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
		
		
	//   #######################################################################  wygiecie_innego elementu_z_alu ###################################################################
	//   #################   kolumna ag ilosc sz  
	$nazwa_wygiecie_innego_elementu_z_alu_ilosc_szt = 'nazwa_wygiecie_innego_elementu_z_alu_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_wygiecie_innego_elementu_z_alu_ilosc_szt.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'"></td>';
	//   #################   kolumna ah ilosc metr  
	$id_wygiecie_innego_elementu_z_alu_ilosc_m = 'id_wygiecie_innego_elementu_z_alu_ilosc_m_'.$x;
	$nazwa_wygiecie_innego_elementu_z_alu_ilosc_m = 'nazwa_wygiecie_innego_elementu_z_alu_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_innego_elementu_z_alu_ilosc_m.'" name="'.$nazwa_wygiecie_innego_elementu_z_alu_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_innego_elementu_z_alu();"></td>';
	//   #################   kolumna ai cena, ID z cennika = 8    ####################################
	$id_cena_innego_elementu_alu = 'id_cena_innego_elementu_alu_'.$x;	
	$nazwa_wygiecie_innego_elementu_z_alu_cena = 'nazwa_wygiecie_innego_elementu_z_alu_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[8].'" id="'.$id_cena_innego_elementu_alu.'" name="'.$nazwa_wygiecie_innego_elementu_z_alu_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_innego_elementu_z_alu();"></td>';
	//   #################   kolumna aj  wartosc   ####################################
	$id_wygiecie_innego_elementu_z_alu_wartosc = 'id_wygiecie_innego_elementu_z_alu_wartosc_'.$x;		
	$nazwa_wygiecie_innego_elementu_z_alu_wartosc = 'nazwa_wygiecie_innego_elementu_z_alu_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_innego_elementu_z_alu_wartosc.'" name="'.$nazwa_wygiecie_innego_elementu_z_alu_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';


	// ##################################################################################################################################################################
	// #######################################################################  łuki ze stali                      ###################################################################
	// #######################################################################  Wygicie wzmocnienia okiennego     ###################################################################
	// ##################################################################################################################################################################
	



	//pobieram info o checkboxie z bazy klientow
	$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ostatnio_uzyty_checkbox_wygiecie_wzmocnienia FROM klienci WHERE id = ".$klient.";"));
	$checkbox_wzmocnienie_okienne = $sql['ostatnio_uzyty_checkbox_wygiecie_wzmocnienia'];


	//   #################   kolumna z ptaszkiem do zaznaczania
	$id_wygiecie_wzmocnienia_okiennego_ptaszek = 'id_wygiecie_wzmocnienia_okiennego_ptaszek_'.$x;
	$nazwa_wygiecie_wzmocnienia_okiennego_ptaszek = 'nazwa_wygiecie_wzmocnienia_okiennego_ptaszek['.$x.']';


	if($checkbox_wzmocnienie_okienne == 'on') 
	{
		//jak zaznaczony to obliczamy jeszcze raz wartosci dla wzmocnienia i luku
		$atrybut_wzmocnienie_okienne = 'checked="checked"'; 
		// $wygiecie_wzmocnienia_okiennego_ilosc_szt[$x] = $wygiecie_ramy_pvc_ilosc_szt[$x] + $wygiecie_skrzydla_pvc_ilosc_szt[$x];
		// $wygiecie_wzmocnienia_okiennego_ilosc_m[$x] = $wygiecie_ramy_pvc_ilosc_m[$x] + $wygiecie_skrzydla_pvc_ilosc_m[$x];
		// $wzmocnienie_luku_ilosc[$x] = $wygiecie_wzmocnienia_okiennego_ilosc_m[$x];
		// $wzmocnienie_luku_wartosc[$x] = $wzmocnienie_luku_ilosc[$x] * $wzmocnienie_luku_cena[$x];
		// $wygiecie_wzmocnienia_okiennego_wartosc[$x] = $wygiecie_wzmocnienia_okiennego_ilosc_m[$x] * $wygiecie_wzmocnienia_okiennego_cena[$x];

	}
	else $atrybut_wzmocnienie_okienne = '';
	echo '<td align="center"><input type="checkbox" TABINDEX="'.$x.'" id="'.$id_wygiecie_wzmocnienia_okiennego_ptaszek.'" name="'.$nazwa_wygiecie_wzmocnienia_okiennego_ptaszek.'" '.$atrybut_wzmocnienie_okienne.' class="'.$styl.'"  onclick="Zaznaczenie_checkboxa_wzmocnienie_okienne('.$x.', '.$ilosc_pozycji.');"></td>';

	//   #################   kolumna ak ilosc sz  
	$id_wygiecie_wzmocnienia_okiennego_ilosc_szt = 'id_wygiecie_wzmocnienia_okiennego_ilosc_szt_'.$x;
	$nazwa_wygiecie_wzmocnienia_okiennego_ilosc_szt = 'nazwa_wygiecie_wzmocnienia_okiennego_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_wzmocnienia_okiennego_ilosc_szt.'" name="'.$nazwa_wygiecie_wzmocnienia_okiennego_ilosc_szt.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'"></td>';
	//   #################   kolumna al ilosc metr  
	$id_wygiecie_wzmocnienia_okiennego_ilosc_m = 'id_wygiecie_wzmocnienia_okiennego_ilosc_m_'.$x;
	$nazwa_wygiecie_wzmocnienia_okiennego_ilosc_m = 'nazwa_wygiecie_wzmocnienia_okiennego_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_wzmocnienia_okiennego_ilosc_m.'" name="'.$nazwa_wygiecie_wzmocnienia_okiennego_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_wzmocnienia_okiennego();"></td>';
	//   #################   kolumna am cena, ID z cennika = 9    ####################################
	$id_cena_wzmocnienia_okiennego = 'id_cena_wzmocnienia_okiennego_'.$x;	
	$nazwa_wygiecie_wzmocnienia_okiennego_cena = 'nazwa_wygiecie_wzmocnienia_okiennego_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[9].'" id="'.$id_cena_wzmocnienia_okiennego.'" name="'.$nazwa_wygiecie_wzmocnienia_okiennego_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_wzmocnienia_okiennego();"></td>';
	//   #################   kolumna an  wartosc   ####################################
	$id_wygiecie_wzmocnienia_okiennego_wartosc = 'id_wygiecie_wzmocnienia_okiennego_wartosc_'.$x;		
	$nazwa_wygiecie_wzmocnienia_okiennego_wartosc = 'nazwa_wygiecie_wzmocnienia_okiennego_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_wzmocnienia_okiennego_wartosc.'" name="'.$nazwa_wygiecie_wzmocnienia_okiennego_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';


	// #######################################################################  wygiecie_innego_elementu_ze_stali    ###################################################################
	//   #################   kolumna ao ilosc sz  
	$nazwa_wygiecie_innego_elementu_ze_stali_ilosc_szt = 'nazwa_wygiecie_innego_elementu_ze_stali_ilosc_szt['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_wygiecie_innego_elementu_ze_stali_ilosc_szt.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'"></td>';
	//   #################   kolumna ap ilosc metr  
	$id_wygiecie_innego_elementu_ze_stali_ilosc_m = 'id_wygiecie_innego_elementu_ze_stali_ilosc_m_'.$x;
	$nazwa_wygiecie_innego_elementu_ze_stali_ilosc_m = 'nazwa_wygiecie_innego_elementu_ze_stali_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wygiecie_innego_elementu_ze_stali_ilosc_m.'" name="'.$nazwa_wygiecie_innego_elementu_ze_stali_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_innego_elementu_ze_stali();"></td>';
	//   #################   kolumna aq cena, ID z cennika = 10    ####################################
	$id_cena_wygiecie_innego_elementu_ze_stali = 'id_cena_wygiecie_innego_elementu_ze_stali_'.$x;	
	$nazwa_wygiecie_innego_elementu_ze_stali_cena = 'nazwa_wygiecie_innego_elementu_ze_stali_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[10].'" id="'.$id_cena_wygiecie_innego_elementu_ze_stali.'" name="'.$nazwa_wygiecie_innego_elementu_ze_stali_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wygiecie_innego_elementu_ze_stali();"></td>';
	//   #################   kolumna ar  wartosc   ####################################
	$id_wygiecie_innego_elementu_ze_stali_wartosc = 'id_wygiecie_innego_elementu_ze_stali_wartosc_'.$x;		
	$nazwa_wygiecie_innego_elementu_ze_stali_wartosc = 'nazwa_wygiecie_innego_elementu_ze_stali_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wygiecie_innego_elementu_ze_stali_wartosc.'" name="'.$nazwa_wygiecie_innego_elementu_ze_stali_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

		
	// ##################################################################################################################################################################
	// #######################################################################  Konstrukcje okienne z pvc          ###################################################################
	// ##################################################################################################################################################################
	
	// #######################################################################  Zgrzanie	###################################################################
	//   #################   kolumna as ilosc  
	$id_zgrzanie_ilosc_m = 'id_zgrzanie_ilosc_m_'.$x;
	$nazwa_zgrzanie_ilosc_m = 'nazwa_zgrzanie_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_zgrzanie_ilosc_m.'" name="'.$nazwa_zgrzanie_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_zgrzanie();"></td>';
	//   #################   kolumna at cena, ID z cennika = 11    ####################################
	$id_cena_zgrzanie = 'id_cena_zgrzanie_'.$x;	
	$nazwa_zgrzanie_cena = 'nazwa_zgrzanie_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[11].'" id="'.$id_cena_zgrzanie.'" name="'.$nazwa_zgrzanie_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_zgrzanie();"></td>';
	//   #################   kolumna au  wartosc   ####################################
	$id_zgrzanie_wartosc = 'id_zgrzanie_wartosc_'.$x;		
	$nazwa_zgrzanie_wartosc = 'nazwa_zgrzanie_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_zgrzanie_wartosc.'" name="'.$nazwa_zgrzanie_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';


	//   #######################################################################  Wyfrezowanie odwodnienia  ###################################################################
	//   #################   kolumna av ilosc 
	$id_wyfrezowanie_odwodnienia_ilosc_m = 'id_wyfrezowanie_odwodnienia_ilosc_m_'.$x;
	$nazwa_wyfrezowanie_odwodnienia_ilosc_m = 'nazwa_wyfrezowanie_odwodnienia_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wyfrezowanie_odwodnienia_ilosc_m.'" name="'.$nazwa_wyfrezowanie_odwodnienia_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wyfrezowanie_odwodnienia();"></td>';
	//   #################   kolumna aw cena, ID z cennika = 12    ####################################
	$id_cena_wyfrezowanie_odwodnienia = 'id_cena_wyfrezowanie_odwodnienia_'.$x;	
	$nazwa_wyfrezowanie_odwodnienia_cena = 'nazwa_wyfrezowanie_odwodnienia_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[12].'" id="'.$id_cena_wyfrezowanie_odwodnienia.'" name="'.$nazwa_wyfrezowanie_odwodnienia_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wyfrezowanie_odwodnienia();"></td>';
	//   #################   kolumna ax  wartosc   ####################################
	$id_wyfrezowanie_odwodnienia_wartosc = 'id_wyfrezowanie_odwodnienia_wartosc_'.$x;		
	$nazwa_wyfrezowanie_odwodnienia_wartosc = 'nazwa_wyfrezowanie_odwodnienia_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wyfrezowanie_odwodnienia_wartosc.'" name="'.$nazwa_wyfrezowanie_odwodnienia_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	// #######################################################################  Wstawienie słupka	stałego ###################################################################
	//   #################   kolumna ay ilosc  
	$id_wstawienie_slupka_ilosc_m = 'id_wstawienie_slupka_ilosc_m_'.$x;
	$nazwa_wstawienie_slupka_ilosc_m = 'nazwa_wstawienie_slupka_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wstawienie_slupka_ilosc_m.'" name="'.$nazwa_wstawienie_slupka_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wstawienie_slupka();"></td>';
	//   #################   kolumna az cena, ID z cennika = 13    ####################################
	$id_cena_wstawienie_slupka = 'id_cena_wstawienie_slupka_'.$x;	
	$nazwa_wstawienie_slupka_cena = 'nazwa_wstawienie_slupka_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[13].'" id="'.$id_cena_wstawienie_slupka.'" name="'.$nazwa_wstawienie_slupka_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wstawienie_slupka();"></td>';
	//   #################   kolumna ba  wartosc   ####################################
	$id_wstawienie_slupka_wartosc = 'id_wstawienie_slupka_wartosc_'.$x;		
	$nazwa_wstawienie_slupka_wartosc = 'nazwa_wstawienie_slupka_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wstawienie_slupka_wartosc.'" name="'.$nazwa_wstawienie_slupka_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';


	// #######################################################################  Wstawienie supka ruchomego	###################################################################
	//   #################   kolumna ay ilość  
	$id_wstawienie_slupka_ruchomego_ilosc_m = 'id_wstawienie_slupka_ruchomego_ilosc_m_'.$x;
	$nazwa_wstawienie_slupka_ruchomego_ilosc_m = 'nazwa_wstawienie_slupka_ruchomego_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wstawienie_slupka_ruchomego_ilosc_m.'" name="'.$nazwa_wstawienie_slupka_ruchomego_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'"  onkeyup="Oblicz_wstawienie_slupka_ruchomego();"></td>';
	//   #################   kolumna az cena   ####################################
	$id_cena_wstawienie_slupka_ruchomego = 'id_cena_wstawienie_slupka_ruchomego_'.$x;	
	$nazwa_wstawienie_slupka_ruchomego_cena = 'nazwa_wstawienie_slupka_ruchomego_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_cena_wstawienie_slupka_ruchomego.'"  value="'.$cena[29].'" name="'.$nazwa_wstawienie_slupka_ruchomego_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'"  onkeyup="Oblicz_wstawienie_slupka_ruchomego();"></td>';
	//   #################   kolumna ba  wartosc   ####################################
	$id_wstawienie_slupka_ruchomego_wartosc = 'id_wstawienie_slupka_ruchomego_wartosc_'.$x;		
	$nazwa_wstawienie_slupka_ruchomego_wartosc = 'nazwa_wstawienie_slupka_ruchomego_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wstawienie_slupka_ruchomego_wartosc.'" name="'.$nazwa_wstawienie_slupka_ruchomego_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';


	// #######################################################################  Docicie listwy przyszybowej  ###################################################################
	//   #################   kolumna bb ilosc  
	$id_dociecie_listwy_przyszybowej_ilosc_m = 'id_dociecie_listwy_przyszybowej_ilosc_m_'.$x;
	$nazwa_dociecie_listwy_przyszybowej_ilosc_m = 'nazwa_dociecie_listwy_przyszybowej_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_dociecie_listwy_przyszybowej_ilosc_m.'" name="'.$nazwa_dociecie_listwy_przyszybowej_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_dociecie_listwy_przyszybowej();"></td>';
	//   #################   kolumna bc cena, ID z cennika = 14    ####################################
	$id_cena_dociecie_listwy_przyszybowej = 'id_cena_dociecie_listwy_przyszybowej_'.$x;	
	$nazwa_dociecie_listwy_przyszybowej_cena = 'nazwa_dociecie_listwy_przyszybowej_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[14].'" id="'.$id_cena_dociecie_listwy_przyszybowej.'" name="'.$nazwa_dociecie_listwy_przyszybowej_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_dociecie_listwy_przyszybowej();"></td>';
	//   #################   kolumna bd  wartosc   ####################################
	$id_dociecie_listwy_przyszybowej_wartosc = 'id_dociecie_listwy_przyszybowej_wartosc_'.$x;		
	$nazwa_dociecie_listwy_przyszybowej_wartosc = 'nazwa_dociecie_listwy_przyszybowej_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_dociecie_listwy_przyszybowej_wartosc.'" name="'.$nazwa_dociecie_listwy_przyszybowej_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';


	// #######################################################################  Docięcie  kompletu listew przyszybowych	###################################################################
	//   #################   kolumna bb ilość  
	$id_dociecie_kompletu_listew_przyszybowych_ilosc_m = 'id_dociecie_kompletu_listew_przyszybowych_ilosc_m_'.$x;
	$nazwa_dociecie_kompletu_listew_przyszybowych_ilosc_m = 'nazwa_dociecie_kompletu_listew_przyszybowych_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_dociecie_kompletu_listew_przyszybowych_ilosc_m.'" name="'.$nazwa_dociecie_kompletu_listew_przyszybowych_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_dociecie_kompletu_listew_przyszybowych();"></td>';
	//   #################   kolumna bc cena   ####################################
	$id_cena_dociecie_kompletu_listew_przyszybowych = 'id_cena_dociecie_kompletu_listew_przyszybowych_'.$x;	
	$nazwa_dociecie_kompletu_listew_przyszybowych_cena = 'nazwa_dociecie_kompletu_listew_przyszybowych_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[30].'" id="'.$id_cena_dociecie_kompletu_listew_przyszybowych.'" name="'.$nazwa_dociecie_kompletu_listew_przyszybowych_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_dociecie_kompletu_listew_przyszybowych();"></td>';
	//   #################   kolumna bd  wartosc   ####################################
	$id_dociecie_kompletu_listew_przyszybowych_wartosc = 'id_dociecie_kompletu_listew_przyszybowych_wartosc_'.$x;		
	$nazwa_dociecie_kompletu_listew_przyszybowych_wartosc = 'nazwa_dociecie_kompletu_listew_przyszybowych_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_dociecie_kompletu_listew_przyszybowych_wartosc.'" name="'.$nazwa_dociecie_kompletu_listew_przyszybowych_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';


	// #######################################################################  okucie	  ###################################################################
	//   #################   kolumna be ilosc  
	$id_okucie_ilosc_m = 'id_okucie_ilosc_m_'.$x;
	$nazwa_okucie_ilosc_m = 'nazwa_okucie_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_okucie_ilosc_m.'" name="'.$nazwa_okucie_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_okucie();"></td>';
	//   #################   kolumna bf cena, ID z cennika = 15    ####################################
	$id_cena_okucie = 'id_cena_okucie_'.$x;	
	$nazwa_okucie_cena = 'nazwa_okucie_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[15].'" id="'.$id_cena_okucie.'" name="'.$nazwa_okucie_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_okucie();"></td>';
	//   #################   kolumna bg  wartosc   ####################################
	$id_okucie_wartosc = 'id_okucie_wartosc_'.$x;		
	$nazwa_okucie_wartosc = 'nazwa_okucie_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_okucie_wartosc.'" name="'.$nazwa_okucie_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';


	// #######################################################################  zaszklenie	  ###################################################################
	//   #################   kolumna bh ilosc  
	$id_zaszklenie_ilosc_m = 'id_zaszklenie_ilosc_m_'.$x;
	$nazwa_zaszklenie_ilosc_m = 'nazwa_zaszklenie_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_zaszklenie_ilosc_m.'" name="'.$nazwa_zaszklenie_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_zaszklenie();"></td>';
	//   #################   kolumna bi cena, ID z cennika = 16   ####################################
	$id_cena_zaszklenie = 'id_cena_zaszklenie_'.$x;	
	$nazwa_zaszklenie_cena = 'nazwa_zaszklenie_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[16].'" id="'.$id_cena_zaszklenie.'" name="'.$nazwa_zaszklenie_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_zaszklenie();"></td>';
	//   #################   kolumna bj  wartosc   ####################################
	$id_zaszklenie_wartosc = 'id_zaszklenie_wartosc_'.$x;		
	$nazwa_zaszklenie_wartosc = 'nazwa_zaszklenie_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_zaszklenie_wartosc.'" name="'.$nazwa_zaszklenie_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';


	// #######################################################################  wykonanie_innej_uslugi	  ###################################################################
	//   #################   kolumna bk ilosc  
	$id_wykonanie_innej_uslugi_ilosc_m = 'id_wykonanie_innej_uslugi_ilosc_m_'.$x;
	$nazwa_wykonanie_innej_uslugi_ilosc_m = 'nazwa_wykonanie_innej_uslugi_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wykonanie_innej_uslugi_ilosc_m.'" name="'.$nazwa_wykonanie_innej_uslugi_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wykonanie_innej_uslugi();"></td>';
	//   #################   kolumna bl cena, ID z cennika = 17    ####################################
	$id_cena_wykonanie_innej_uslugi = 'id_cena_wykonanie_innej_uslugi_'.$x;	
	$nazwa_wykonanie_innej_uslugi_cena = 'nazwa_wykonanie_innej_uslugi_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[17].'" id="'.$id_cena_wykonanie_innej_uslugi.'" name="'.$nazwa_wykonanie_innej_uslugi_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wykonanie_innej_uslugi();"></td>';
	//   #################   kolumna bm  wartosc   ####################################
	$id_wykonanie_innej_uslugi_wartosc = 'id_wykonanie_innej_uslugi_wartosc_'.$x;		
	$nazwa_wykonanie_innej_uslugi_wartosc = 'nazwa_wykonanie_innej_uslugi_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wykonanie_innej_uslugi_wartosc.'" name="'.$nazwa_wykonanie_innej_uslugi_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';
		
		
	// ##################################################################################################################################################################
	// #######################################################################  Materia          ###################################################################
	// ##################################################################################################################################################################

	// #######################################################################  oscieznica	  ###################################################################
	//   #################   kolumna bn ilosc  
	$id_oscieznica_ilosc_m = 'id_oscieznica_ilosc_m_'.$x;
	$nazwa_oscieznica_ilosc_m = 'nazwa_oscieznica_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_oscieznica_ilosc_m.'" name="'.$nazwa_oscieznica_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_oscieznica();"></td>';
	//   #################   kolumna bo cena, ID z cennika = 18    ####################################
	$id_cena_oscieznica = 'id_cena_oscieznica_'.$x;	
	$nazwa_oscieznica_cena = 'nazwa_oscieznica_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[18].'" id="'.$id_cena_oscieznica.'" name="'.$nazwa_oscieznica_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_oscieznica();"></td>';
	//   #################   kolumna bp  wartosc   ####################################
	$id_oscieznica_wartosc = 'id_oscieznica_wartosc_'.$x;		
	$nazwa_oscieznica_wartosc = 'nazwa_oscieznica_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_oscieznica_wartosc.'" name="'.$nazwa_oscieznica_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	
	// #######################################################################  skrzydlo ###################################################################
	//   #################   kolumna bq ilosc  
	$id_skrzydlo_ilosc_m = 'id_skrzydlo_ilosc_m_'.$x;
	$nazwa_skrzydlo_ilosc_m = 'nazwa_skrzydlo_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_skrzydlo_ilosc_m.'" name="'.$nazwa_skrzydlo_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_skrzydlo();"></td>';
	//   #################   kolumna br cena, ID z cennika = 19    ####################################
	$id_cena_skrzydlo = 'id_cena_skrzydlo_'.$x;	
	$nazwa_skrzydlo_cena = 'nazwa_skrzydlo_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[19].'" id="'.$id_cena_skrzydlo.'" name="'.$nazwa_skrzydlo_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_skrzydlo();"></td>';
	//   #################   kolumna bs  wartosc   ####################################
	$id_skrzydlo_wartosc = 'id_skrzydlo_wartosc_'.$x;		
	$nazwa_skrzydlo_wartosc = 'nazwa_skrzydlo_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_skrzydlo_wartosc.'" name="'.$nazwa_skrzydlo_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	
	// #######################################################################  listwa	  ###################################################################
	//   #################   kolumna bt ilosc  
	$id_listwa_ilosc_m = 'id_listwa_ilosc_m_'.$x;
	$nazwa_listwa_ilosc_m = 'nazwa_listwa_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_listwa_ilosc_m.'" name="'.$nazwa_listwa_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_listwa();"></td>';
	//   #################   kolumna bu cena, ID z cennika = 20    ####################################
	$id_cena_listwa = 'id_cena_listwa_'.$x;	
	$nazwa_listwa_cena = 'nazwa_listwa_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[20].'" id="'.$id_cena_listwa.'" name="'.$nazwa_listwa_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_listwa();"></td>';
	//   #################   kolumna bv  wartosc   ####################################
	$id_listwa_wartosc = 'id_listwa_wartosc_'.$x;		
	$nazwa_listwa_wartosc = 'nazwa_listwa_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_listwa_wartosc.'" name="'.$nazwa_listwa_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	
	// #######################################################################  slupek	 ###################################################################
	//   #################   kolumna bw ilosc  
	$id_slupek_ilosc_m = 'id_slupek_ilosc_m_'.$x;
	$nazwa_slupek_ilosc_m = 'nazwa_slupek_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_slupek_ilosc_m.'" name="'.$nazwa_slupek_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_slupek();"></td>';
	//   #################   kolumna bx cena, ID z cennika = 21    ####################################
	$id_cena_slupek = 'id_cena_slupek_'.$x;	
	$nazwa_slupek_cena = 'nazwa_slupek_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[21].'" id="'.$id_cena_slupek.'" name="'.$nazwa_slupek_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_slupek();"></td>';
	//   #################   kolumna by  wartosc   ####################################
	$id_slupek_wartosc = 'id_slupek_wartosc_'.$x;		
	$nazwa_slupek_wartosc = 'nazwa_slupek_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_slupek_wartosc.'" name="'.$nazwa_slupek_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	
	// #######################################################################  wzmocnienie_do_ramy	   ###################################################################
	//   #################   kolumna bz ilosc  
	$id_wzmocnienie_do_ramy_ilosc_m = 'id_wzmocnienie_do_ramy_ilosc_m_'.$x;
	$nazwa_wzmocnienie_do_ramy_ilosc_m = 'nazwa_wzmocnienie_do_ramy_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wzmocnienie_do_ramy_ilosc_m.'" name="'.$nazwa_wzmocnienie_do_ramy_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wzmocnienie_do_ramy();"></td>';
	//   #################   kolumna ca cena, ID z cennika = 22    ####################################
	$id_cena_wzmocnienie_do_ramy = 'id_cena_wzmocnienie_do_ramy_'.$x;	
	$nazwa_wzmocnienie_do_ramy_cena = 'nazwa_wzmocnienie_do_ramy_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[22].'" id="'.$id_cena_wzmocnienie_do_ramy.'" name="'.$nazwa_wzmocnienie_do_ramy_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wzmocnienie_do_ramy();"></td>';
	//   #################   kolumna cb  wartosc   ####################################
	$id_wzmocnienie_do_ramy_wartosc = 'id_wzmocnienie_do_ramy_wartosc_'.$x;		
	$nazwa_wzmocnienie_do_ramy_wartosc = 'nazwa_wzmocnienie_do_ramy_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wzmocnienie_do_ramy_wartosc.'" name="'.$nazwa_wzmocnienie_do_ramy_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	
	// #######################################################################  wzmocnienie_do_skrzydla	 ###################################################################
	//   #################   kolumna cc ilosc  
	$id_wzmocnienie_do_skrzydla_ilosc_m = 'id_wzmocnienie_do_skrzydla_ilosc_m_'.$x;
	$nazwa_wzmocnienie_do_skrzydla_ilosc_m = 'nazwa_wzmocnienie_do_skrzydla_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wzmocnienie_do_skrzydla_ilosc_m.'" name="'.$nazwa_wzmocnienie_do_skrzydla_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wzmocnienie_do_skrzydla();"></td>';
	//   #################   kolumna cd cena, ID z cennika = 23    ####################################
	$id_cena_wzmocnienie_do_skrzydla = 'id_cena_wzmocnienie_do_skrzydla_'.$x;	
	$nazwa_wzmocnienie_do_skrzydla_cena = 'nazwa_wzmocnienie_do_skrzydla_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[23].'" id="'.$id_cena_wzmocnienie_do_skrzydla.'" name="'.$nazwa_wzmocnienie_do_skrzydla_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wzmocnienie_do_skrzydla();"></td>';
	//   #################   kolumna ce  wartosc   ####################################
	$id_wzmocnienie_do_skrzydla_wartosc = 'id_wzmocnienie_do_skrzydla_wartosc_'.$x;		
	$nazwa_wzmocnienie_do_skrzydla_wartosc = 'nazwa_wzmocnienie_do_skrzydla_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wzmocnienie_do_skrzydla_wartosc.'" name="'.$nazwa_wzmocnienie_do_skrzydla_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	
	// #######################################################################  wzmocnienie_do_slupka	###################################################################
	//   #################   kolumna cf ilosc  
	$id_wzmocnienie_do_slupka_ilosc_m = 'id_wzmocnienie_do_slupka_ilosc_m_'.$x;
	$nazwa_wzmocnienie_do_slupka_ilosc_m = 'nazwa_wzmocnienie_do_slupka_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wzmocnienie_do_slupka_ilosc_m.'" name="'.$nazwa_wzmocnienie_do_slupka_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wzmocnienie_do_slupka();"></td>';
	//   #################   kolumna cg cena, ID z cennika = 24    ####################################
	$id_cena_wzmocnienie_do_slupka = 'id_cena_wzmocnienie_do_slupka_'.$x;	
	$nazwa_wzmocnienie_do_slupka_cena = 'nazwa_wzmocnienie_do_slupka_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[24].'" id="'.$id_cena_wzmocnienie_do_slupka.'" name="'.$nazwa_wzmocnienie_do_slupka_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wzmocnienie_do_slupka();"></td>';
	//   #################   kolumna ch  wartosc   ####################################
	$id_wzmocnienie_do_slupka_wartosc = 'id_wzmocnienie_do_slupka_wartosc_'.$x;		
	$nazwa_wzmocnienie_do_slupka_wartosc = 'nazwa_wzmocnienie_do_slupka_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wzmocnienie_do_slupka_wartosc.'" name="'.$nazwa_wzmocnienie_do_slupka_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	
	// #######################################################################  wzmocnienie_do_luku	 ###################################################################
	//   #################   kolumna ci ilosc  
	$id_wzmocnienie_do_luku_ilosc_m = 'id_wzmocnienie_do_luku_ilosc_m_'.$x;
	$nazwa_wzmocnienie_do_luku_ilosc_m = 'nazwa_wzmocnienie_do_luku_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_wzmocnienie_do_luku_ilosc_m.'" name="'.$nazwa_wzmocnienie_do_luku_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wzmocnienie_do_luku();"></td>';
	//   #################   kolumna cj cena, ID z cennika = 25    ####################################
	$id_cena_wzmocnienie_do_luku = 'id_cena_wzmocnienie_do_luku_'.$x;	
	$nazwa_wzmocnienie_do_luku_cena = 'nazwa_wzmocnienie_do_luku_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[25].'" id="'.$id_cena_wzmocnienie_do_luku.'" name="'.$nazwa_wzmocnienie_do_luku_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_wzmocnienie_do_luku();"></td>';
	//   #################   kolumna ck  wartosc   ####################################
	$id_wzmocnienie_do_luku_wartosc = 'id_wzmocnienie_do_luku_wartosc_'.$x;		
	$nazwa_wzmocnienie_do_luku_wartosc = 'nazwa_wzmocnienie_do_luku_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_wzmocnienie_do_luku_wartosc.'" name="'.$nazwa_wzmocnienie_do_luku_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	
	// #######################################################################  okucia	                       ###################################################################
	//   #################   kolumna cl ilosc  
	$id_okucia_ilosc_m = 'id_okucia_ilosc_m_'.$x;
	$nazwa_okucia_ilosc_m = 'nazwa_okucia_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_okucia_ilosc_m.'" name="'.$nazwa_okucia_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_okucia();"></td>';
	//   #################   kolumna cm cena, ID z cennika = 26    ####################################
	$id_cena_okucia = 'id_cena_okucia_'.$x;	
	$nazwa_okucia_cena = 'nazwa_okucia_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[26].'" id="'.$id_cena_okucia.'" name="'.$nazwa_okucia_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_okucia();"></td>';
	//   #################   kolumna cn  wartosc   ####################################
	$id_okucia_wartosc = 'id_okucia_wartosc_'.$x;		
	$nazwa_okucia_wartosc = 'nazwa_okucia_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_okucia_wartosc.'" name="'.$nazwa_okucia_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	
	// #######################################################################  szyby	                       ###################################################################
	//   #################   kolumna co ilosc  
	$id_szyby_ilosc_m = 'id_szyby_ilosc_m_'.$x;
	$nazwa_szyby_ilosc_m = 'nazwa_szyby_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_szyby_ilosc_m.'" name="'.$nazwa_szyby_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_szyby();"></td>';
	//   #################   kolumna cp cena, ID z cennika = 27    ####################################
	$id_cena_szyby = 'id_cena_szyby_'.$x;	
	$nazwa_szyby_cena = 'nazwa_szyby_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[27].'" id="'.$id_cena_szyby.'" name="'.$nazwa_szyby_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_szyby();"></td>';
	//   #################   kolumna cq  wartosc   ####################################
	$id_szyby_wartosc = 'id_szyby_wartosc_'.$x;		
	$nazwa_szyby_wartosc = 'nazwa_szyby_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_szyby_wartosc.'" name="'.$nazwa_szyby_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';

	
	// #######################################################################  inny_element	                       ###################################################################
	//   #################   kolumna cr ilosc  
	$id_inny_element_ilosc_m = 'id_inny_element_ilosc_m_'.$x;
	$nazwa_inny_element_ilosc_m = 'nazwa_inny_element_ilosc_m['.$x.']';
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" id="'.$id_inny_element_ilosc_m.'" name="'.$nazwa_inny_element_ilosc_m.'" style="width: '.$szerokosc_pola_input_ilosc.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_inny_element();"></td>';
	//   #################   kolumna cs cena, ID z cennika = 28    ####################################
	$id_cena_inny_element = 'id_cena_inny_element_'.$x;	
	$nazwa_inny_element_cena = 'nazwa_inny_element_cena['.$x.']';		
	echo '<td align="right"><input type="text" TABINDEX="'.$x.'" value="'.$cena[28].'" id="'.$id_cena_inny_element.'" name="'.$nazwa_inny_element_cena.'" style="width: '.$szerokosc_pola_input_cena.'" autocomplete="off" class="'.$styl.'" onkeyup="Oblicz_inny_element();"></td>';
	//   #################   kolumna ct  wartosc   ####################################
	$id_inny_element_wartosc = 'id_inny_element_wartosc_'.$x;		
	$nazwa_inny_element_wartosc = 'nazwa_inny_element_wartosc['.$x.']';
	echo '<td align="right" bgcolor="yellow"><input type="text" id="'.$id_inny_element_wartosc.'" name="'.$nazwa_inny_element_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" readonly="readonly" autocomplete="off" class="pole_input_zolte_bez_ramki">'.$waluta.'</td>';


	// ##################################################################################################################################################################
	// ##################################################################################################################################################################
	// ##################################################################################################################################################################
	// #######################################################################  Pozostałe wartosci          #############################################################
	// ##################################################################################################################################################################
	// ##################################################################################################################################################################
	// ##################################################################################################################################################################
	
	//   #################   kolumna cu  okna   ####################################
	$id_okna_wartosc = 'id_okna_wartosc_'.$x;	
	$nazwa_okna_wartosc = 'nazwa_okna_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" id="'.$id_okna_wartosc.'" name="'.$nazwa_okna_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_okna();">'.$waluta.'</td>';
	
	//   #################   kolumna cv  Drzwi wewntrzne   ####################################
	$id_drzwi_wewnetrzne_wartosc = 'id_drzwi_wewnetrzne_wartosc_'.$x;	
	$nazwa_drzwi_wewnetrzne_wartosc = 'nazwa_drzwi_wewnetrzne_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" id="'.$id_drzwi_wewnetrzne_wartosc.'" name="'.$nazwa_drzwi_wewnetrzne_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_drzwi_wewnetrzne();">'.$waluta.'</td>';
	
	//   #################   kolumna cw  Drzwi zewntrzne   ####################################
	$id_drzwi_zewnetrzne_wartosc = 'id_drzwi_zewnetrzne_wartosc_'.$x;	
	$nazwa_drzwi_zewnetrzne_wartosc = 'nazwa_drzwi_zewnetrzne_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" id="'.$id_drzwi_zewnetrzne_wartosc.'" name="'.$nazwa_drzwi_zewnetrzne_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_drzwi_zewnetrzne();">'.$waluta.'</td>';
	
	//   #################   kolumna cy  Bramy   ####################################
	$id_bramy_wartosc = 'id_bramy_wartosc_'.$x;	
	$nazwa_bramy_wartosc = 'nazwa_bramy_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" id="'.$id_bramy_wartosc.'" name="'.$nazwa_bramy_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_bramy();">'.$waluta.'</td>';
	
	//   #################   kolumna cy  Parapety   ####################################
	$id_parapety_wartosc = 'id_parapety_wartosc_'.$x;	
	$nazwa_parapety_wartosc = 'nazwa_parapety_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" id="'.$id_parapety_wartosc.'" name="'.$nazwa_parapety_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_parapety();">'.$waluta.'</td>';
	
	//   #################   kolumna cz  Rolety zewntrzne   ####################################
	$id_rolety_zewnetrzne_wartosc = 'id_rolety_zewnetrzne_wartosc_'.$x;	
	$nazwa_rolety_zewnetrzne_wartosc = 'nazwa_rolety_zewnetrzne_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" id="'.$id_rolety_zewnetrzne_wartosc.'" name="'.$nazwa_rolety_zewnetrzne_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_rolety_zewnetrzne();">'.$waluta.'</td>';
	
	//   #################   kolumna da  Rolety wewntrzne   ####################################
	$id_rolety_wewnetrzne_wartosc = 'id_rolety_wewnetrzne_wartosc_'.$x;	
	$nazwa_rolety_wewnetrzne_wartosc = 'nazwa_rolety_wewnetrzne_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" id="'.$id_rolety_wewnetrzne_wartosc.'" name="'.$nazwa_rolety_wewnetrzne_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_rolety_wewnetrzne();">'.$waluta.'</td>';

	//   #################   kolumna db  Moskitiery   ####################################
	$id_moskitiery_wartosc = 'id_moskitiery_wartosc_'.$x;	
	$nazwa_moskitiery_wartosc = 'nazwa_moskitiery_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" id="'.$id_moskitiery_wartosc.'" name="'.$nazwa_moskitiery_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_moskitiery();">'.$waluta.'</td>';

	//   #################   kolumna dc  Monta   ####################################
	$id_montaz_wartosc = 'id_montaz_wartosc_'.$x;	
	$nazwa_montaz_wartosc = 'nazwa_montaz_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" id="'.$id_montaz_wartosc.'" name="'.$nazwa_montaz_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_montaz();">'.$waluta.'</td>';
	
	//   #################   kolumna dd  Odpady z pvc   ####################################
	$id_odpady_z_pvc_wartosc = 'id_odpady_z_pvc_wartosc_'.$x;	
	$nazwa_odpady_z_pvc_wartosc = 'nazwa_odpady_z_pvc_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" id="'.$id_odpady_z_pvc_wartosc.'" name="'.$nazwa_odpady_z_pvc_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_odpady_z_pvc();">'.$waluta.'</td>';
	
	//   #################   kolumna de  Odpady ze stali i alu   ####################################
	$id_odpady_ze_stali_wartosc = 'id_odpady_ze_stali_wartosc_'.$x;	
	$nazwa_odpady_ze_stali_wartosc = 'nazwa_odpady_ze_stali_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" id="'.$id_odpady_ze_stali_wartosc.'" name="'.$nazwa_odpady_ze_stali_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_odpady_ze_stali();">'.$waluta.'</td>';
	
	//   #################   kolumna de  transport   ####################################
	$id_transport_wartosc = 'id_transport_wartosc_'.$x;	
	$nazwa_transport_wartosc = 'nazwa_transport_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" id="'.$id_transport_wartosc.'" name="'.$nazwa_transport_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_transport();">'.$waluta.'</td>';
	
	//   #################   kolumna dg  inne   ####################################
	$id_inne_wartosc = 'id_inne_wartosc_'.$x;	
	$nazwa_inne_wartosc = 'nazwa_inne_wartosc['.$x.']';		
	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" id="'.$id_inne_wartosc.'" name="'.$nazwa_inne_wartosc.'" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="Zamien_przecinek_inne();">'.$waluta.'</td>';
		
	//   #################   kolumna stopien trudnosci  ####################################
	$id_stopien_trudnosci = 'id_stopien_trudnosci'.$x;	
	$nazwa_stopien_trudnosci = 'nazwa_stopien_trudnosci['.$x.']';		
	echo '<td align="center"><select name="'.$nazwa_stopien_trudnosci.'" id="'.$id_stopien_trudnosci.'" class="'.$styl_select.'" onchange="CzyMoznaZapisac();" style="width: 50px">';
	for ($k=1; $k<=$DLUGOSC_TABELA_STOPIEN_TRUDNOSCI; $k++) 
	if(1 == $TABELA_STOPIEN_TRUDNOSCI[$k]) echo '<option selected="selected" value="'.$TABELA_STOPIEN_TRUDNOSCI[$k].'">'.$TABELA_STOPIEN_TRUDNOSCI[$k].'</option>';
	else echo '<option value="'.$TABELA_STOPIEN_TRUDNOSCI[$k].'">'.$TABELA_STOPIEN_TRUDNOSCI[$k].'</option>';
	echo '</select></td>';


	// ##################################################################################################################################################################
	// ##################################################################################################################################################################
	// ##################################################################################################################################################################
	// ##################################################################################################################################################################
	// ##################################################################################################################################################################
	// ##################################################################################################################################################################
	
	// #################   kolumna DH   nazwa produktu  ################################################
	$ilosc_produktow = 0;
	$pytanie2 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='produkty' ORDER BY opis ASC");
	while($wynik2= mysqli_fetch_assoc($pytanie2))
		{
		$ilosc_produktow++;
		$produkt_id[$ilosc_produktow] = $wynik2['id'];
		$produkt_opis[$ilosc_produktow] = $wynik2['opis'];
		}
	$nazwa_produktu = 'nazwa_produktu['.$x.']';
	$id_nazwa_produktu = 'id_nazwa_produktu_'.$x;
	echo '<td align="center"><select name="'.$nazwa_produktu.'" id="'.$id_nazwa_produktu.'" class="'.$styl_select.'" onchange="CzyMoznaZapisac();" style="width: 200px">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_produktow; $k++) 
	if($produkt == $produkt_opis[$k]) echo '<option selected="selected" value="'.$produkt_opis[$k].'">'.$produkt_opis[$k].'</option>';
	else echo '<option value="'.$produkt_opis[$k].'">'.$produkt_opis[$k].'</option>';
	echo '</select></td>';
	
	//   #################   kolumna DI    Cena netto za sztuke  ####################################
	$id_cena_netto_za_sztuke = 'id_cena_netto_za_sztuke_'.$x;	
	$nazwa_cena_netto_za_sztuke = 'nazwa_cena_netto_za_sztuke['.$x.']';
	echo '<td align="right" bgcolor="#ccffcc"><input type="text" value="0" id="'.$id_cena_netto_za_sztuke.'" name="'.$nazwa_cena_netto_za_sztuke.'" size="6" readonly="readonly" autocomplete="off" class="pole_input_zielone_ramka">'.$waluta.'</td>';

	//   #################   kolumna DJ    ilosc sztuk  ####################################
	$id_ilosc_sztuk = 'id_ilosc_sztuk_'.$x;
	$nazwa_ilosc_sztuk = 'nazwa_ilosc_sztuk['.$x.']';	
	echo '<td align="center"><input type="text" TABINDEX="'.$x.'" id="'.$id_ilosc_sztuk.'" name="'.$nazwa_ilosc_sztuk.'" onkeyup="ObliczNettoZaSztuke();" size="3" autocomplete="off" class="'.$styl.'"></td>';
	
	//   #################   kolumna DK    wartosc netto  ####################################
	$id_wartosc_netto = 'id_wartosc_netto_'.$x;		
	$nazwa_wartosc_netto = 'nazwa_wartosc_netto['.$x.']';	
	echo '<td align="center" bgcolor="#ffcc99"><input type="text" id="'.$id_wartosc_netto.'" name="'.$nazwa_wartosc_netto.'" size="6" readonly="readonly" autocomplete="off" class="pole_input_pomaranczowe_ramka">'.$waluta.'</td>';
	
	//   #################   kolumna DL    VAT  ####################################
	$id_vat = 'id_vat_'.$x;		
	$nazwa_vat = 'nazwa_vat['.$x.']';	
	echo '<td bgcolor="#ffcc99"><select name="'.$nazwa_vat.'" id="'.$id_vat.'" class="pole_select_pomaranczowe_z_ramka" style="width: 50px" onchange="ObliczWartoscBrutto();">';
	for ($k=1; $k<=$TAB_VAT_DL; $k++) if($k<$TAB_VAT_DL) echo '<option value="'.$TAB_VAT[$k].'">'.$TAB_VAT[$k].'</option>'; else echo '<option selected="selected" value="'.$TAB_VAT[$k].'">'.$TAB_VAT[$k].'</option>';
	echo '</select></td>';
	
	//   #################   kolumna DM    wartosc brutto  ####################################
	$id_wartosc_brutto = 'id_wartosc_brutto_'.$x;		
	$nazwa_wartosc_brutto = 'nazwa_wartosc_brutto['.$x.']';	
	echo '<td align="center" bgcolor="#ff99cc"><input type="text" id="'.$id_wartosc_brutto.'" name="'.$nazwa_wartosc_brutto.'" size="6" readonly="readonly" autocomplete="off" class="pole_input_rozowe_ramka">'.$waluta.'</td>';
	
	//   #################   kolumna DN    nr faktury  ####################################
	$id_nr_faktury = 'id_nr_faktury_'.$x;		
	$nazwa_nr_faktury = 'nazwa_nr_faktury['.$x.']';	
	if($x == 1) echo '<td><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_nr_faktury.'" id="'.$id_nr_faktury.'" size="10" maxlenght="50" onchange="Skopiuj_nr_faktury();" autocomplete="off" class="'.$styl.'"></td>';
	else echo '<td><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_nr_faktury.'" id="'.$id_nr_faktury.'" size="10" maxlenght="50" onkeyup="Skasuj_date_faktury('.$x.');" autocomplete="off" class="'.$styl.'"></td>';
	
	//   #################   kolumna DO    data faktury  ####################################
	$id_data_faktury = 'id_data_faktury_'.$x;		
	$nazwa_data_faktury = 'nazwa_data_faktury['.$x.']';	
	if($x == 1) echo '<td><input type="text" name="'.$nazwa_data_faktury.'" id="'.$id_data_faktury.'" size="10" onchange="Skopiuj_date_faktury();" autocomplete="off" class="'.$styl.'"></td>';
	else echo '<td><input type="text" name="'.$nazwa_data_faktury.'" id="'.$id_data_faktury.'" size="10" autocomplete="off" class="'.$styl.'"></td>';
	
	?>
	<script type="text/javascript">
		Calendar.setup({
			inputField     :    "<?php echo $id_data_faktury; ?>",     // id of the input field
			ifFormat       :    "%d-%m-%Y",      // format of the input field
			button         :    "f_date_c",  // trigger for the calendar (button ID)
			singleClick    :    true
		});
	</script>
	<?php

	//   #################   kolumna DP    uwagi  ####################################
	$nazwa_uwagi = 'nazwa_uwagi['.$x.']';	
	echo '<td><textarea name="'.$nazwa_uwagi.'" TABINDEX="'.$x.'" cols="20" rows="1" class="'.$styl_uwagi.'"></textarea></td></tr>';
	} /// do for ($x=1;$x<=$ilosc_pozycji; $x++)

	//   #########################################################################################################################
	//   #########################################################################################################################
	//    wyswietlanie pozycji transportowej
	//   #########################################################################################################################
	//   #########################################################################################################################
	// if($pozycja_transport == 'tak')
	// 	{
	// 	$x = $ilosc_pozycji + 1;
	// 	if($x%2)
	// 		{	
	// 		$wiersz = $kolor_bialy;
	// 		$styl = "pole_input_biale_ramka"; 
	// 		$styl2 = "pole_input_biale_bez_ramki";
	// 		$styl_select = "pole_select_biale_z_ramka"; 
	// 		}
	// 	else 
	// 		{
	// 		$wiersz = $kolor_szary;
	// 		$styl = "pole_input_szare_ramka";
	// 		$styl2 = "pole_input_szare_bez_ramki";
	// 		$styl_select = "pole_select_szare_z_ramka"; 
	// 		}
		
	// 	echo '<tr bgcolor="'.$wiersz.'" align="center" height="'.$wysykosc_wiersza.'"><td bgcolor="'.$kolor_tabeli.'">'.$x.'/'.$x.'</td>';
	// 	echo '<td align="left" colspan="115" class="text"></td>';

	// 	//   #################   kolumna de  transport   ####################################
	// 	echo '<td align="center" bgcolor="yellow"><input type="text" TABINDEX="'.$x.'" id="id_pozycja_transport_wartosc" name="nazwa_pozycja_transport_wartosc" style="width: '.$szerokosc_pola_input_wartosc.'" autocomplete="off" class="pole_input_zolte_ramka" onkeyup="ObliczWartoscNettoPozycjaTransport();">'.$waluta.'</td>';
		
	// 	echo '<td align="left" colspan="4" class="text"></td>';
	// 	//   #################   kolumna DK    wartosc netto  ####################################
	// 	echo '<td align="center" bgcolor="#ffcc99"><input type="text" id="id_wartosc_netto_pozycja_transport" name="nazwa_wartosc_netto_pozycja_transport" size="6" readonly="readonly" autocomplete="off" class="pole_input_pomaranczowe_ramka">'.$waluta.'</td>';
		
	// 	//   #################   kolumna DL    VAT  ####################################
	// 	echo '<td bgcolor="#ffcc99"><select name="nazwa_vat_pozycja_transport" id="id_vat_pozycja_transport" class="pole_select_pomaranczowe_z_ramka" style="width: 50px" onchange="ObliczWartoscNettoPozycjaTransport();">';
	// 	for ($k=1; $k<=$TAB_VAT_DL; $k++) if($k<$TAB_VAT_DL) echo '<option value="'.$TAB_VAT[$k].'">'.$TAB_VAT[$k].'</option>'; else echo '<option selected="selected" value="'.$TAB_VAT[$k].'">'.$TAB_VAT[$k].'</option>';
	// 	echo '</select></td>';
		
	// 	//   #################   kolumna DM    wartosc brutto  ####################################
	// 	echo '<td align="center" bgcolor="#ff99cc"><input type="text" id="id_wartosc_brutto_pozycja_transport" name="nazwa_wartosc_brutto_pozycja_transport" size="6" readonly="readonly" autocomplete="off" class="pole_input_rozowe_ramka">'.$waluta.'</td>';
		
	// 	//   #################   kolumna DN    nr faktury  ####################################
	// 	$id_nr_faktury = 'id_nr_faktury_'.$x;		
	// 	$nazwa_nr_faktury = 'nazwa_nr_faktury['.$x.']';	
		
	// 	echo '<td><input type="text" TABINDEX="'.$x.'" name="'.$nazwa_nr_faktury.'" id="'.$id_nr_faktury.'" size="10" maxlenght="50" onkeyup="Skasuj_date_faktury('.$x.');" autocomplete="off" class="'.$styl.'"></td>';
		
	// 	//   #################   kolumna DO    data faktury  ####################################
	// 	$id_data_faktury = 'id_data_faktury_'.$x;		
	// 	$nazwa_data_faktury = 'nazwa_data_faktury['.$x.']';	
	// 	echo '<td><input type="text" name="'.$nazwa_data_faktury.'" id="'.$id_data_faktury.'" size="10" autocomplete="off" class="'.$styl.'"></td>';
	
		?>
		<script type="text/javascript">
			Calendar.setup({
				inputField     :    "<?php echo $id_data_faktury; ?>",     // id of the input field
				ifFormat       :    "%d-%m-%Y",      // format of the input field
				button         :    "f_date_c",  // trigger for the calendar (button ID)
				singleClick    :    true
			});
		</script>
		<?php

				
		// echo '<td align="left" class="text"></td>';
		// echo '</tr>';
		// }
	// else 
	echo '<input type="hidden" id="id_wartosc_netto_pozycja_transport" name="nazwa_wartosc_netto_pozycja_transport">';	// to musi by bo nie dziaa sumowanie netto i brutto

	echo '<tr><td style="background-color:#ffffff; border-bottom-color:#ffffff; border-top-color:#ffffff; border-left-style:hidden; border-right-style:hidden;"></td>'; //pozycja
	$nowa_ilosc_pozycji = $ilosc_pozycji + 1;
	
	$link = 'index.php?page=wycena_dodaj&klient='.$klient.'&ilosc_pozycji='.$nowa_ilosc_pozycji.'&zamowienie_id='.$zamowienie_id.'&nr_zamowienia='.$nr_zamowienia.'&wycena_wstepna_nr='.$wycena_wstepna_nr.'&email='.$email.'&jak='.$jak.'&wg_czego='.$wg_czego.'&data_waznosci='.$data_waznosci.'&etap=2';
	
	
	echo '<td align="center" colspan="13" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-style:hidden; border-right-style:hidden;">';
		echo '<a href="'.$link.'">Dodaj kolejną pozycję</a>';
	echo '</td>';
	echo '<td align="center" colspan="10" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-style:hidden; border-right-style:hidden;"></td>';
	
	echo '<td align="center" colspan="33" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-style:hidden; border-right-style:hidden;"><input type="submit" TABINDEX="'.$x.'" disabled id="zapisz1" name="submit" value="Zapisz"></td>';
	echo '<td align="center" colspan="32" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-style:hidden; border-right-style:hidden;"><input type="submit" TABINDEX="'.$x.'" disabled id="zapisz2" name="submit" value="Zapisz"></td>';
	echo '<td align="center" colspan="32" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-color:#ffffff;"><input type="submit" TABINDEX="'.$x.'"  disabled id="zapisz3" name="submit" value="Zapisz"></td>';
	echo '<td align="center" bgcolor="#ffcc99" style="border-bottom-color:#000000; border-top-color:#000000; border-left-color:#000000; border-right-color:#000000;"><input type="text" id="id_suma_netto" name="nazwa_suma_netto" size="6" readonly="readonly" autocomplete="off" class="pole_input_pomaranczowe_ramka">'.$waluta.'</td>';
	echo '<td align="center" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-color:#ffffff;"></td>';
	
	echo '<td align="center" bgcolor="#ff99cc" style="border-bottom-color:#000000; border-top-color:#000000; border-left-color:#000000; border-right-color:#000000;"><input type="text" id="id_suma_brutto" name="nazwa_suma_brutto" size="6" readonly="readonly" autocomplete="off" class="pole_input_rozowe_ramka">'.$waluta.'</td>';
	echo '<td align="center" colspan="2" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-color:#ffffff; border-right-style:hidden;"><input type="submit" TABINDEX="'.$x.'" disabled id="zapisz4" name="submit" value="Zapisz"></td>';
	echo '<td align="center" style="border-bottom-style:hidden; border-top-color:#ffffff; border-left-color:#ffffff; border-right-style:hidden;"><input type="checkbox" name="zmienic_cennik_klienta">Zmienić cennik klienta?</td>';
	
	echo '</tr>';
	echo '</form>';
echo '</table>'; // koniec tabeli glownej
} // do if etap == 2


?>