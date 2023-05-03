<?php
echo '<FORM name="szukaj">';
echo '<input type="hidden" name="page" value="'.$page.'">';
	
	echo '<table valign="top" align="center" border="1" cellspacing="1" cellpadding="1" class="text" BORDERCOLOR="black" frame="box" RULES="all">';
	echo '<tr align="center" bgcolor="'.$kolor_tabeli.'"><td width="100%">Wybierz rok : ';
	echo '<select name="SPRAWDZANY_ROK" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	if($SPRAWDZANY_ROK == "") $SPRAWDZANY_ROK = $AKTUALNY_ROK;
	for($x= 1; $x<= $DLUGOSC_TABELA_LISTA_LAT_WYCENA_DANE; $x++) 
		{
		if ($TABELA_LISTA_LAT_WYCENA_DANE[$x] == $SPRAWDZANY_ROK) echo '<option value="'.$TABELA_LISTA_LAT_WYCENA_DANE[$x].'" selected="selected">'.$TABELA_LISTA_LAT_WYCENA_DANE[$x].'</option>';
		else echo '<option value="'.$TABELA_LISTA_LAT_WYCENA_DANE[$x].'">'.$TABELA_LISTA_LAT_WYCENA_DANE[$x].'</option>';
		}
	echo '</select>';
	echo '</td></tr></table><br>';


	$szer_rozne = '70px';
	$wysokosc_rozne = '30px';
	echo '<table valign="top" align="center" border="1" cellspacing="1" cellpadding="1" class="text" BORDERCOLOR="black" frame="box" RULES="all">';
	echo '<tr align="center" bgcolor="#dcdcdc" height="'.$wysokosc_rozne.'"><td width="20%">Dotyczy / Miesiąc</td>';
	for($k=1; $k<=12; $k++) 
		{
		echo '<td width="'.$szer_rozne.'">'.$k.'</td>';
		$WARTOSC_CALKOWITA[$k] = 0;
		$WARTOSC_PVC[$k] = 0;
		$ILOSC_SZT_PVC[$k] = 0;
		$ILOSC_M_PVC[$k] = 0;
		$CENA_LUKI_PVC[$k] = 0;

		$WARTOSC_ALU[$k] = 0;
		$ILOSC_SZT_ALU[$k] = 0;
		$ILOSC_M_ALU[$k] = 0;
		$CENA_LUKI_ALU[$k] = 0;

		$WARTOSC_STALI[$k] = 0;
		$ILOSC_SZT_STALI[$k] = 0;
		$ILOSC_M_STALI[$k] = 0;
		$CENA_LUKI_STALI[$k] = 0;

		$WARTOSC_ZGRZANIE[$k] = 0;
		$ILOSC_ZGRZANIE[$k] = 0;
		$CENA_ZGRZANIE[$k] = 0;

		$WARTOSC_WYFREZOWANIE_ODWODNIENIA[$k] = 0;
		$ILOSC_WYFREZOWANIE_ODWODNIENIA[$k] = 0;
		$CENA_WYFREZOWANIE_ODWODNIENIA[$k] = 0;
		
		}
	echo '<td width="10%">Średnia</td>';
	echo '<td width="10%">Suma</td>';
	echo '</tr>';
	
	for($k = 1; $k<=12; $k++)
		{
		$WARTOSC_CALKOWITA[$k] = 0;
		$WARTOSC_CALKOWITA_BRUTTO[$k] = 0;
		$ILOSC_WSTAWIENIE_SLUPKA[$k] = 0;
		$WARTOSC_LISTWA_PRZYSZYBOWA[$k] = 0;
		$ILOSC_LISTWA_PRZYSZYBOWA[$k] = 0;
		$ILOSC_WSTAWIENIE_SLUPKA[$k] = 0;
		$ILOSC_WSTAWIENIE_SLUPKA[$k] = 0;
		$ILOSC_WSTAWIENIE_SLUPKA[$k] = 0;
		$ILOSC_WSTAWIENIE_SLUPKA[$k] = 0;
		$WARTOSC_LISTWA_PRZYSZYBOWA[$k] = 0;
		$ILOSC_LISTWA_PRZYSZYBOWA[$k] = 0;
		$WARTOSC_okucie[$k] = 0;
		$ILOSC_okucie[$k] = 0;
		$WARTOSC_zaszklenie[$k] = 0;
		$ILOSC_zaszklenie[$k] = 0;
		$WARTOSC_MATERIAL[$k] = 0;
		$WARTOSC_okna[$k] = 0;
		$WARTOSC_drzwi_wewnetrzne[$k] = 0;
		$WARTOSC_drzwi_zewnetrzne[$k] = 0;
		$WARTOSC_bramy[$k] = 0;
		$WARTOSC_parapety[$k] = 0;
		$WARTOSC_rolety_zewnetrzne[$k] = 0;
		$WARTOSC_rolety_wewnetrzne[$k] = 0;
		$WARTOSC_moskitiery[$k] = 0;
		$WARTOSC_montaz[$k] = 0;
		$WARTOSC_odpady_pvc[$k] = 0;
		$WARTOSC_odpady_alu_stal[$k] = 0;
		$WARTOSC_WSTAWIENIE_SLUPKA[$k] = 0;
		$WARTOSC_transport[$k] = 0;
		}
	
	
	//pobieramy dane dotyczące faktur z numerem xxx
	$pytanie3 = mysqli_query($conn, "SELECT wartosc_netto, wartosc_brutto, data_faktury_miesiac FROM wyceny WHERE nr_faktury = 'xxx' AND data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik3 = mysqli_fetch_assoc($pytanie3))
		{
		$wartosc_netto=$wynik3['wartosc_netto'];
		$wartosc_brutto=$wynik3['wartosc_brutto'];
		$data_faktury_miesiac=$wynik3['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_CALKOWITA[1] += $wartosc_netto;
					$WARTOSC_CALKOWITA_BRUTTO[1] += $wartosc_brutto;
					break;
				case 2:
					$WARTOSC_CALKOWITA[2] += $wartosc_netto;
					$WARTOSC_CALKOWITA_BRUTTO[2] += $wartosc_brutto;
					break;
				case 3:
					$WARTOSC_CALKOWITA[3] += $wartosc_netto;
					$WARTOSC_CALKOWITA_BRUTTO[3] += $wartosc_brutto;
					break;
				case 4:
					$WARTOSC_CALKOWITA_BRUTTO[4] += $wartosc_brutto;
					$WARTOSC_CALKOWITA[4] += $wartosc_netto;
					break;
				case 5:
					$WARTOSC_CALKOWITA_BRUTTO[5] += $wartosc_brutto;
					$WARTOSC_CALKOWITA[5] += $wartosc_netto;
					break;
				case 6:
					$WARTOSC_CALKOWITA_BRUTTO[6] += $wartosc_brutto;
					$WARTOSC_CALKOWITA[6] += $wartosc_netto;
					break;
				case 7:
					$WARTOSC_CALKOWITA_BRUTTO[7] += $wartosc_brutto;
					$WARTOSC_CALKOWITA[7] += $wartosc_netto;
					break;
				case 8:
					$WARTOSC_CALKOWITA_BRUTTO[8] += $wartosc_brutto;
					$WARTOSC_CALKOWITA[8] += $wartosc_netto;
					break;
				case 9:
					$WARTOSC_CALKOWITA_BRUTTO[9] += $wartosc_brutto;
					$WARTOSC_CALKOWITA[9] += $wartosc_netto;
					break;
				case 10:
					$WARTOSC_CALKOWITA_BRUTTO[10] += $wartosc_brutto;
					$WARTOSC_CALKOWITA[10] += $wartosc_netto;
					break;
				case 11:
					$WARTOSC_CALKOWITA_BRUTTO[11] += $wartosc_brutto;
					$WARTOSC_CALKOWITA[11] += $wartosc_netto;
					break;
				case 12:
					$WARTOSC_CALKOWITA_BRUTTO[12] += $wartosc_brutto;
					$WARTOSC_CALKOWITA[12] += $wartosc_netto;
					break;
			}		
		}

//pobieramy wartości z bazy faktur
	$pytanie3 = mysqli_query($conn, "SELECT wartosc_netto_fv, wartosc_brutto_fv, data_wystawienia_miesiac, nr_fv_korygowanej FROM fv_naglowek WHERE data_wystawienia_rok = '".$SPRAWDZANY_ROK."' AND (typ_dok = 'Korekta' OR typ_dok = 'Faktura') ;");
	while($wynik3 = mysqli_fetch_assoc($pytanie3))
		{
		$wartosc_netto_fv=$wynik3['wartosc_netto_fv'];
		$wartosc_brutto_fv=$wynik3['wartosc_brutto_fv'];
		$data_faktury_miesiac=$wynik3['data_wystawienia_miesiac'];
		$nr_fv_korygowanej=$wynik3['nr_fv_korygowanej'];
			//sprawdzamy czy to korekta, jezeli tak, to szukamy wartosci faktury ktorą koryguje i obliczamy wartość korekty.
			if($nr_fv_korygowanej != '')
			{
				$pytanie2112 = mysqli_query($conn, "SELECT wartosc_brutto_fv, wartosc_netto_fv FROM fv_naglowek WHERE nr_dok = '".$nr_fv_korygowanej."' AND typ_dok = 'Faktura';");
				while($wynik2112= mysqli_fetch_assoc($pytanie2112))
					{
					$wartosc_netto_korygowanej_fv=$wynik2112['wartosc_netto_fv'];
					$wartosc_brutto_korygowanej_fv=$wynik2112['wartosc_brutto_fv'];
					$wartosc_netto_fv -= $wartosc_netto_korygowanej_fv;
					$wartosc_brutto_fv -= $wartosc_brutto_korygowanej_fv;
					}
			}

			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_CALKOWITA[1] += $wartosc_netto_fv;
					$WARTOSC_CALKOWITA_BRUTTO[1] += $wartosc_brutto_fv;
					break;
				case 2:
					$WARTOSC_CALKOWITA[2] += $wartosc_netto_fv;
					$WARTOSC_CALKOWITA_BRUTTO[2] += $wartosc_brutto_fv;
					break;
				case 3:
					$WARTOSC_CALKOWITA[3] += $wartosc_netto_fv;
					$WARTOSC_CALKOWITA_BRUTTO[3] += $wartosc_brutto_fv;
					break;
				case 4:
					$WARTOSC_CALKOWITA_BRUTTO[4] += $wartosc_brutto_fv;
					$WARTOSC_CALKOWITA[4] += $wartosc_netto_fv;
					break;
				case 5:
					$WARTOSC_CALKOWITA_BRUTTO[5] += $wartosc_brutto_fv;
					$WARTOSC_CALKOWITA[5] += $wartosc_netto_fv;
					break;
				case 6:
					$WARTOSC_CALKOWITA_BRUTTO[6] += $wartosc_brutto_fv;
					$WARTOSC_CALKOWITA[6] += $wartosc_netto_fv;
					break;
				case 7:
					$WARTOSC_CALKOWITA_BRUTTO[7] += $wartosc_brutto_fv;
					$WARTOSC_CALKOWITA[7] += $wartosc_netto_fv;
					break;
				case 8:
					$WARTOSC_CALKOWITA_BRUTTO[8] += $wartosc_brutto_fv;
					$WARTOSC_CALKOWITA[8] += $wartosc_netto_fv;
					break;
				case 9:
					$WARTOSC_CALKOWITA_BRUTTO[9] += $wartosc_brutto_fv;
					$WARTOSC_CALKOWITA[9] += $wartosc_netto_fv;
					break;
				case 10:
					$WARTOSC_CALKOWITA_BRUTTO[10] += $wartosc_brutto_fv;
					$WARTOSC_CALKOWITA[10] += $wartosc_netto_fv;
					break;
				case 11:
					$WARTOSC_CALKOWITA_BRUTTO[11] += $wartosc_brutto_fv;
					$WARTOSC_CALKOWITA[11] += $wartosc_netto_fv;
					break;
				case 12:
					$WARTOSC_CALKOWITA_BRUTTO[12] += $wartosc_brutto_fv;
					$WARTOSC_CALKOWITA[12] += $wartosc_netto_fv;
					break;
			}		
		}
		
	$WARTOSC_SUMA = 0;
	$WARTOSC_SUMA_BRUTTO = 0;
	// ###########################################################		 Wartość całkowita netto 					###################################################################################	
	$kolor_tla = $kolor_bialy;
	echo '<tr align="center" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_tla.'" width="350px" align="left">Wartość całkowita faktur netto</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_CALKOWITA_pokaz[$z] = number_format($WARTOSC_CALKOWITA[$z], 2,'.',' ');
		$WARTOSC_CALKOWITA[$z] = number_format($WARTOSC_CALKOWITA[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_tla.'">'.$WARTOSC_CALKOWITA_pokaz[$z].'</td>'; //B2 do M2
		if($WARTOSC_CALKOWITA[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA += $WARTOSC_CALKOWITA[$z];
		}
	if($na_ile_dzielic != 0) 
		{
			$WARTOSC_SREDNIA = $WARTOSC_SUMA/$na_ile_dzielic;
			$WARTOSC_SREDNIA = number_format($WARTOSC_SREDNIA, 2,'.',' ');
		}
	else $WARTOSC_SREDNIA = 0;
	$WARTOSC_SUMA = number_format($WARTOSC_SUMA, 2,'.',' ');
	echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SREDNIA.'</td>'; 		// N2
	echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SUMA.'</td></tr>'; 		// O2
	// ###########################################################		Wartość całkowita brutto					###################################################################################	
	echo '<tr align="center" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_szary.'" width="350px" align="left">Wartość całkowita faktur brutto</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_CALKOWITA_BRUTTO_pokaz[$z] = number_format($WARTOSC_CALKOWITA_BRUTTO[$z], 2,'.',' ');
		$WARTOSC_CALKOWITA_BRUTTO[$z] = number_format($WARTOSC_CALKOWITA_BRUTTO[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_szary.'">'.$WARTOSC_CALKOWITA_BRUTTO_pokaz[$z].'</td>'; //B2 do M2
		if($WARTOSC_CALKOWITA_BRUTTO[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA_BRUTTO += $WARTOSC_CALKOWITA_BRUTTO[$z];
		}
	
	if($na_ile_dzielic != 0) 
		{
		$WARTOSC_SREDNIA_BRUTTO = $WARTOSC_SUMA_BRUTTO/$na_ile_dzielic;
		$WARTOSC_SREDNIA_BRUTTO = number_format($WARTOSC_SREDNIA_BRUTTO, 2,'.',' ');
		}
	else $WARTOSC_SREDNIA_BRUTTO = 0;
	$WARTOSC_SUMA_BRUTTO = number_format($WARTOSC_SUMA_BRUTTO, 2,'.',' ');
	echo '<td bgcolor="'.$kolor_szary.'">'.$WARTOSC_SREDNIA_BRUTTO.'</td>'; 		// N2
	echo '<td bgcolor="'.$kolor_szary.'">'.$WARTOSC_SUMA_BRUTTO.'</td></tr>'; 		// O2
	


	// ##############################################################################################################################################################################	
	// ###########################################################		  PVC  					###################################################################################	
	// ##############################################################################################################################################################################	
	$pytanie31 = mysqli_query($conn, "SELECT wygiecie_ramy_pvc_wartosc, wygiecie_skrzydla_pvc_wartosc, wygiecie_listwy_pvc_wartosc, wygiecie_innego_pvc_wartosc, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$wygiecie_ramy_pvc_wartosc=$wynik31['wygiecie_ramy_pvc_wartosc'];
		$wygiecie_skrzydla_pvc_wartosc=$wynik31['wygiecie_skrzydla_pvc_wartosc'];
		$wygiecie_listwy_pvc_wartosc=$wynik31['wygiecie_listwy_pvc_wartosc'];
		$wygiecie_innego_pvc_wartosc=$wynik31['wygiecie_innego_pvc_wartosc'];
		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_PVC[1] = $WARTOSC_PVC[1] + $wygiecie_ramy_pvc_wartosc + $wygiecie_skrzydla_pvc_wartosc + $wygiecie_listwy_pvc_wartosc + $wygiecie_innego_pvc_wartosc;
					break;
				case 2:
					$WARTOSC_PVC[2] = $WARTOSC_PVC[2] + $wygiecie_ramy_pvc_wartosc + $wygiecie_skrzydla_pvc_wartosc + $wygiecie_listwy_pvc_wartosc + $wygiecie_innego_pvc_wartosc;
					break;
				case 3:
					$WARTOSC_PVC[3] = $WARTOSC_PVC[3] + $wygiecie_ramy_pvc_wartosc + $wygiecie_skrzydla_pvc_wartosc + $wygiecie_listwy_pvc_wartosc + $wygiecie_innego_pvc_wartosc;
					break;
				case 4:
					$WARTOSC_PVC[4] = $WARTOSC_PVC[4] + $wygiecie_ramy_pvc_wartosc + $wygiecie_skrzydla_pvc_wartosc + $wygiecie_listwy_pvc_wartosc + $wygiecie_innego_pvc_wartosc;
					break;
				case 5:
					$WARTOSC_PVC[5] = $WARTOSC_PVC[5] + $wygiecie_ramy_pvc_wartosc + $wygiecie_skrzydla_pvc_wartosc + $wygiecie_listwy_pvc_wartosc + $wygiecie_innego_pvc_wartosc;
					break;
				case 6:
					$WARTOSC_PVC[6] = $WARTOSC_PVC[6] + $wygiecie_ramy_pvc_wartosc + $wygiecie_skrzydla_pvc_wartosc + $wygiecie_listwy_pvc_wartosc + $wygiecie_innego_pvc_wartosc;
					break;
				case 7:
					$WARTOSC_PVC[7] = $WARTOSC_PVC[7] + $wygiecie_ramy_pvc_wartosc + $wygiecie_skrzydla_pvc_wartosc + $wygiecie_listwy_pvc_wartosc + $wygiecie_innego_pvc_wartosc;
					break;
				case 8:
					$WARTOSC_PVC[8] = $WARTOSC_PVC[8] + $wygiecie_ramy_pvc_wartosc + $wygiecie_skrzydla_pvc_wartosc + $wygiecie_listwy_pvc_wartosc + $wygiecie_innego_pvc_wartosc;
					break;
				case 9:
					$WARTOSC_PVC[9] = $WARTOSC_PVC[9] + $wygiecie_ramy_pvc_wartosc + $wygiecie_skrzydla_pvc_wartosc + $wygiecie_listwy_pvc_wartosc + $wygiecie_innego_pvc_wartosc;
					break;
				case 10:
					$WARTOSC_PVC[10] = $WARTOSC_PVC[10] + $wygiecie_ramy_pvc_wartosc + $wygiecie_skrzydla_pvc_wartosc + $wygiecie_listwy_pvc_wartosc + $wygiecie_innego_pvc_wartosc;
					break;
				case 11:
					$WARTOSC_PVC[11] = $WARTOSC_PVC[11] + $wygiecie_ramy_pvc_wartosc + $wygiecie_skrzydla_pvc_wartosc + $wygiecie_listwy_pvc_wartosc + $wygiecie_innego_pvc_wartosc;
					break;
				case 12:
					$WARTOSC_PVC[12] = $WARTOSC_PVC[12] + $wygiecie_ramy_pvc_wartosc + $wygiecie_skrzydla_pvc_wartosc + $wygiecie_listwy_pvc_wartosc + $wygiecie_innego_pvc_wartosc;
					break;
			}		
		}
		
	$WARTOSC_SUMA = 0;
	echo '<tr align="center" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_tla.'" rowspan="4" align="left">'.$kol_wartosc.' | '.$kol_ilosc.' | cena łuki z pvc</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_PVC[$z] = number_format($WARTOSC_PVC[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_tla.'">'.$WARTOSC_PVC[$z].'</td>';
		if($WARTOSC_PVC[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA += $WARTOSC_PVC[$z];
		}	
	if($na_ile_dzielic != 0) $WARTOSC_SREDNIA = $WARTOSC_SUMA/$na_ile_dzielic;
	else $WARTOSC_SREDNIA = 0;
	$WARTOSC_SUMA = number_format($WARTOSC_SUMA, 2,'.',' ');
	$WARTOSC_SREDNIA = number_format($WARTOSC_SREDNIA, 2,'.',' ');
	echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SREDNIA.'</td>';
	echo '<td rowspan="4" bgcolor="'.$kolor_tla.'">'.$WARTOSC_SUMA.'</td></tr>';

	// ##############################################################################################################################################################################	
	$pytanie31 = mysqli_query($conn, "SELECT wygiecie_ramy_pvc_ilosc_szt, wygiecie_skrzydla_pvc_ilosc_szt, wygiecie_innego_pvc_ilosc_szt, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$wygiecie_ramy_pvc_ilosc_szt=$wynik31['wygiecie_ramy_pvc_ilosc_szt'];
		$wygiecie_skrzydla_pvc_ilosc_szt=$wynik31['wygiecie_skrzydla_pvc_ilosc_szt'];
		$wygiecie_innego_pvc_ilosc_szt=$wynik31['wygiecie_innego_pvc_ilosc_szt'];
		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$ILOSC_SZT_PVC[1] = $ILOSC_SZT_PVC[1] + $wygiecie_ramy_pvc_ilosc_szt + $wygiecie_skrzydla_pvc_ilosc_szt + $wygiecie_innego_pvc_ilosc_szt;
					break;
				case 2:
					$ILOSC_SZT_PVC[2] = $ILOSC_SZT_PVC[2] + $wygiecie_ramy_pvc_ilosc_szt + $wygiecie_skrzydla_pvc_ilosc_szt + $wygiecie_innego_pvc_ilosc_szt;
					break;
				case 3:
					$ILOSC_SZT_PVC[3] = $ILOSC_SZT_PVC[3] + $wygiecie_ramy_pvc_ilosc_szt + $wygiecie_skrzydla_pvc_ilosc_szt + $wygiecie_innego_pvc_ilosc_szt;
					break;
				case 4:
					$ILOSC_SZT_PVC[4] = $ILOSC_SZT_PVC[4] + $wygiecie_ramy_pvc_ilosc_szt + $wygiecie_skrzydla_pvc_ilosc_szt + $wygiecie_innego_pvc_ilosc_szt;
					break;
				case 5:
					$ILOSC_SZT_PVC[5] = $ILOSC_SZT_PVC[5] + $wygiecie_ramy_pvc_ilosc_szt + $wygiecie_skrzydla_pvc_ilosc_szt + $wygiecie_innego_pvc_ilosc_szt;
					break;
				case 6:
					$ILOSC_SZT_PVC[6] = $ILOSC_SZT_PVC[6] + $wygiecie_ramy_pvc_ilosc_szt + $wygiecie_skrzydla_pvc_ilosc_szt + $wygiecie_innego_pvc_ilosc_szt;
					break;
				case 7:
					$ILOSC_SZT_PVC[7] = $ILOSC_SZT_PVC[7] + $wygiecie_ramy_pvc_ilosc_szt + $wygiecie_skrzydla_pvc_ilosc_szt + $wygiecie_innego_pvc_ilosc_szt;
					break;
				case 8:
					$ILOSC_SZT_PVC[8] = $ILOSC_SZT_PVC[8] + $wygiecie_ramy_pvc_ilosc_szt + $wygiecie_skrzydla_pvc_ilosc_szt + $wygiecie_innego_pvc_ilosc_szt;
					break;
				case 9:
					$ILOSC_SZT_PVC[9] = $ILOSC_SZT_PVC[9] + $wygiecie_ramy_pvc_ilosc_szt + $wygiecie_skrzydla_pvc_ilosc_szt + $wygiecie_innego_pvc_ilosc_szt;
					break;
				case 10:
					$ILOSC_SZT_PVC[10] = $ILOSC_SZT_PVC[10] + $wygiecie_ramy_pvc_ilosc_szt + $wygiecie_skrzydla_pvc_ilosc_szt + $wygiecie_innego_pvc_ilosc_szt;
					break;
				case 11:
					$ILOSC_SZT_PVC[11] = $ILOSC_SZT_PVC[11] + $wygiecie_ramy_pvc_ilosc_szt + $wygiecie_skrzydla_pvc_ilosc_szt + $wygiecie_innego_pvc_ilosc_szt;
					break;
				case 12:
					$ILOSC_SZT_PVC[12] = $ILOSC_SZT_PVC[12] + $wygiecie_ramy_pvc_ilosc_szt + $wygiecie_skrzydla_pvc_ilosc_szt + $wygiecie_innego_pvc_ilosc_szt;
					break;
			}		
		}
		
	$ILOSC_SZT_SUMA = 0;
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$ILOSC_SZT_PVC[$z] = number_format($ILOSC_SZT_PVC[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'">'.$ILOSC_SZT_PVC[$z].'</td>';
		if($ILOSC_SZT_PVC[$z] != 0) $na_ile_dzielic++;
		$ILOSC_SZT_SUMA += $ILOSC_SZT_PVC[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$ILOSC_SZT_SREDNIA = $ILOSC_SZT_SUMA/$na_ile_dzielic;
		$ILOSC_SZT_SREDNIA = number_format($ILOSC_SZT_SREDNIA, 2,'.',' ');
		$ILOSC_SZT_SUMA = number_format($ILOSC_SZT_SUMA, 2,'.',' ');
		echo '<td align="center" bgcolor="'.$kolor_tla.'">'.$ILOSC_SZT_SREDNIA.'</td></tr>';
	
	// ##############################################################################################################################################################################	
	$pytanie31 = mysqli_query($conn, "SELECT wygiecie_ramy_pvc_ilosc_m, wygiecie_skrzydla_pvc_ilosc_m, wygiecie_innego_pvc_ilosc_m, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$wygiecie_ramy_pvc_ilosc_m=$wynik31['wygiecie_ramy_pvc_ilosc_m'];
		$wygiecie_skrzydla_pvc_ilosc_m=$wynik31['wygiecie_skrzydla_pvc_ilosc_m'];
		$wygiecie_innego_pvc_ilosc_m=$wynik31['wygiecie_innego_pvc_ilosc_m'];
		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$ILOSC_M_PVC[1] = $ILOSC_M_PVC[1] + $wygiecie_ramy_pvc_ilosc_m + $wygiecie_skrzydla_pvc_ilosc_m + $wygiecie_innego_pvc_ilosc_m;
					break;
				case 2:
					$ILOSC_M_PVC[2] = $ILOSC_M_PVC[2] + $wygiecie_ramy_pvc_ilosc_m + $wygiecie_skrzydla_pvc_ilosc_m + $wygiecie_innego_pvc_ilosc_m;
					break;
				case 3:
					$ILOSC_M_PVC[3] = $ILOSC_M_PVC[3] + $wygiecie_ramy_pvc_ilosc_m + $wygiecie_skrzydla_pvc_ilosc_m + $wygiecie_innego_pvc_ilosc_m;
					break;
				case 4:
					$ILOSC_M_PVC[4] = $ILOSC_M_PVC[4] + $wygiecie_ramy_pvc_ilosc_m + $wygiecie_skrzydla_pvc_ilosc_m + $wygiecie_innego_pvc_ilosc_m;
					break;
				case 5:
					$ILOSC_M_PVC[5] = $ILOSC_M_PVC[5] + $wygiecie_ramy_pvc_ilosc_m + $wygiecie_skrzydla_pvc_ilosc_m + $wygiecie_innego_pvc_ilosc_m;
					break;
				case 6:
					$ILOSC_M_PVC[6] = $ILOSC_M_PVC[6] + $wygiecie_ramy_pvc_ilosc_m + $wygiecie_skrzydla_pvc_ilosc_m + $wygiecie_innego_pvc_ilosc_m;
					break;
				case 7:
					$ILOSC_M_PVC[7] = $ILOSC_M_PVC[7] + $wygiecie_ramy_pvc_ilosc_m + $wygiecie_skrzydla_pvc_ilosc_m + $wygiecie_innego_pvc_ilosc_m;
					break;
				case 8:
					$ILOSC_M_PVC[8] = $ILOSC_M_PVC[8] + $wygiecie_ramy_pvc_ilosc_m + $wygiecie_skrzydla_pvc_ilosc_m + $wygiecie_innego_pvc_ilosc_m;
					break;
				case 9:
					$ILOSC_M_PVC[9] = $ILOSC_M_PVC[9] + $wygiecie_ramy_pvc_ilosc_m + $wygiecie_skrzydla_pvc_ilosc_m + $wygiecie_innego_pvc_ilosc_m;
					break;
				case 10:
					$ILOSC_M_PVC[10] = $ILOSC_M_PVC[10] + $wygiecie_ramy_pvc_ilosc_m + $wygiecie_skrzydla_pvc_ilosc_m + $wygiecie_innego_pvc_ilosc_m;
					break;
				case 11:
					$ILOSC_M_PVC[11] = $ILOSC_M_PVC[11] + $wygiecie_ramy_pvc_ilosc_m + $wygiecie_skrzydla_pvc_ilosc_m + $wygiecie_innego_pvc_ilosc_m;
					break;
				case 12:
					$ILOSC_M_PVC[12] = $ILOSC_M_PVC[12] + $wygiecie_ramy_pvc_ilosc_m + $wygiecie_skrzydla_pvc_ilosc_m + $wygiecie_innego_pvc_ilosc_m;
					break;
			}		
		}

	$ILOSC_M_SUMA = 0;
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$ILOSC_M_PVC[$z] = number_format($ILOSC_M_PVC[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'">'.$ILOSC_M_PVC[$z].'</td>';
		if($ILOSC_M_PVC[$z] != 0) $na_ile_dzielic++;
		$ILOSC_M_SUMA += $ILOSC_M_PVC[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$ILOSC_M_SREDNIA = $ILOSC_M_SUMA/$na_ile_dzielic;
		$ILOSC_M_SREDNIA = number_format($ILOSC_M_SREDNIA, 2,'.',' ');
		$ILOSC_M_SUMA = number_format($ILOSC_M_SUMA, 2,'.',' ');
		echo '<td align="center" bgcolor="'.$kolor_tla.'">'.$ILOSC_M_SREDNIA.'</td></tr>';
	
	
	// ##############################################################################################################################################################################	
	$CENA_LUKI_PVC_SUMA = 0;
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		
		if($ILOSC_M_PVC[$z] != 0) $CENA_LUKI_PVC[$z] = $WARTOSC_PVC[$z]/$ILOSC_M_PVC[$z];
		$CENA_LUKI_PVC[$z] = number_format($CENA_LUKI_PVC[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'">'.$CENA_LUKI_PVC[$z].'</td>';
		if($CENA_LUKI_PVC[$z] != 0) $na_ile_dzielic++;
		$CENA_LUKI_PVC_SUMA += $CENA_LUKI_PVC[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$CENA_LUKI_PVC_SREDNIA = $CENA_LUKI_PVC_SUMA/$na_ile_dzielic;
		$CENA_LUKI_PVC_SREDNIA = number_format($CENA_LUKI_PVC_SREDNIA, 2,'.',' ');
		$CENA_LUKI_PVC_SUMA = number_format($CENA_LUKI_PVC_SUMA, 2,'.',' ');
		echo '<td align="center" bgcolor="'.$kolor_tla.'">'.$CENA_LUKI_PVC_SREDNIA.'</td></tr>';
	
	
	
	// ##############################################################################################################################################################################	
	// ###########################################################		  aluminium					###################################################################################	
	// ##############################################################################################################################################################################	
	$kolor_tla = $kolor_szary;
	$pytanie31 = mysqli_query($conn, "SELECT wygiecie_ramy_alu_wartosc, wygiecie_skrzydla_alu_wartosc, wygiecie_listwy_alu_wartosc, wygiecie_innego_alu_wartosc, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$wygiecie_ramy_alu_wartosc=$wynik31['wygiecie_ramy_alu_wartosc'];
		$wygiecie_skrzydla_alu_wartosc=$wynik31['wygiecie_skrzydla_alu_wartosc'];
		$wygiecie_listwy_alu_wartosc=$wynik31['wygiecie_listwy_alu_wartosc'];
		$wygiecie_innego_alu_wartosc=$wynik31['wygiecie_innego_alu_wartosc'];
		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_ALU[1] = $WARTOSC_ALU[1] + $wygiecie_ramy_alu_wartosc + $wygiecie_skrzydla_alu_wartosc + $wygiecie_listwy_alu_wartosc + $wygiecie_innego_alu_wartosc;
					break;
				case 2:
					$WARTOSC_ALU[2] = $WARTOSC_ALU[2] + $wygiecie_ramy_alu_wartosc + $wygiecie_skrzydla_alu_wartosc + $wygiecie_listwy_alu_wartosc + $wygiecie_innego_alu_wartosc;
					break;
				case 3:
					$WARTOSC_ALU[3] = $WARTOSC_ALU[3] + $wygiecie_ramy_alu_wartosc + $wygiecie_skrzydla_alu_wartosc + $wygiecie_listwy_alu_wartosc + $wygiecie_innego_alu_wartosc;
					break;
				case 4:
					$WARTOSC_ALU[4] = $WARTOSC_ALU[4] + $wygiecie_ramy_alu_wartosc + $wygiecie_skrzydla_alu_wartosc + $wygiecie_listwy_alu_wartosc + $wygiecie_innego_alu_wartosc;
					break;
				case 5:
					$WARTOSC_ALU[5] = $WARTOSC_ALU[5] + $wygiecie_ramy_alu_wartosc + $wygiecie_skrzydla_alu_wartosc + $wygiecie_listwy_alu_wartosc + $wygiecie_innego_alu_wartosc;
					break;
				case 6:
					$WARTOSC_ALU[6] = $WARTOSC_ALU[6] + $wygiecie_ramy_alu_wartosc + $wygiecie_skrzydla_alu_wartosc + $wygiecie_listwy_alu_wartosc + $wygiecie_innego_alu_wartosc;
					break;
				case 7:
					$WARTOSC_ALU[7] = $WARTOSC_ALU[7] + $wygiecie_ramy_alu_wartosc + $wygiecie_skrzydla_alu_wartosc + $wygiecie_listwy_alu_wartosc + $wygiecie_innego_alu_wartosc;
					break;
				case 8:
					$WARTOSC_ALU[8] = $WARTOSC_ALU[8] + $wygiecie_ramy_alu_wartosc + $wygiecie_skrzydla_alu_wartosc + $wygiecie_listwy_alu_wartosc + $wygiecie_innego_alu_wartosc;
					break;
				case 9:
					$WARTOSC_ALU[9] = $WARTOSC_ALU[9] + $wygiecie_ramy_alu_wartosc + $wygiecie_skrzydla_alu_wartosc + $wygiecie_listwy_alu_wartosc + $wygiecie_innego_alu_wartosc;
					break;
				case 10:
					$WARTOSC_ALU[10] = $WARTOSC_ALU[10] + $wygiecie_ramy_alu_wartosc + $wygiecie_skrzydla_alu_wartosc + $wygiecie_listwy_alu_wartosc + $wygiecie_innego_alu_wartosc;
					break;
				case 11:
					$WARTOSC_ALU[11] = $WARTOSC_ALU[11] + $wygiecie_ramy_alu_wartosc + $wygiecie_skrzydla_alu_wartosc + $wygiecie_listwy_alu_wartosc + $wygiecie_innego_alu_wartosc;
					break;
				case 12:
					$WARTOSC_ALU[12] = $WARTOSC_ALU[12] + $wygiecie_ramy_alu_wartosc + $wygiecie_skrzydla_alu_wartosc + $wygiecie_listwy_alu_wartosc + $wygiecie_innego_alu_wartosc;
					break;
			}		
		}
		
	$WARTOSC_SUMA = 0;
	echo '<tr align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_tla.'" rowspan="4" align="left">'.$kol_wartosc.' | '.$kol_ilosc.' | cena łuki z alu</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_ALU[$z] = number_format($WARTOSC_ALU[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_tla.'">'.$WARTOSC_ALU[$z].'</td>';
		if($WARTOSC_ALU[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA += $WARTOSC_ALU[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$WARTOSC_SREDNIA = $WARTOSC_SUMA/$na_ile_dzielic;
		$WARTOSC_SREDNIA = number_format($WARTOSC_SREDNIA, 2,'.',' ');
		$WARTOSC_SUMA = number_format($WARTOSC_SUMA, 2,'.',' ');
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SREDNIA.'</td>';
		echo '<td rowspan="4" bgcolor="'.$kolor_tla.'">'.$WARTOSC_SUMA.'</td></tr>';

	// ##############################################################################################################################################################################	
	$pytanie31 = mysqli_query($conn, "SELECT wygiecie_ramy_alu_ilosc_szt, wygiecie_skrzydla_alu_ilosc_szt, wygiecie_innego_alu_ilosc_szt, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$wygiecie_ramy_alu_ilosc_szt=$wynik31['wygiecie_ramy_alu_ilosc_szt'];
		$wygiecie_skrzydla_alu_ilosc_szt=$wynik31['wygiecie_skrzydla_alu_ilosc_szt'];
		$wygiecie_innego_alu_ilosc_szt=$wynik31['wygiecie_innego_alu_ilosc_szt'];
		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$ILOSC_SZT_ALU[1] = $ILOSC_SZT_ALU[1] + $wygiecie_ramy_alu_ilosc_szt + $wygiecie_skrzydla_alu_ilosc_szt + $wygiecie_innego_alu_ilosc_szt;
					break;
				case 2:
					$ILOSC_SZT_ALU[2] = $ILOSC_SZT_ALU[2] + $wygiecie_ramy_alu_ilosc_szt + $wygiecie_skrzydla_alu_ilosc_szt + $wygiecie_innego_alu_ilosc_szt;
					break;
				case 3:
					$ILOSC_SZT_ALU[3] = $ILOSC_SZT_ALU[3] + $wygiecie_ramy_alu_ilosc_szt + $wygiecie_skrzydla_alu_ilosc_szt + $wygiecie_innego_alu_ilosc_szt;
					break;
				case 4:
					$ILOSC_SZT_ALU[4] = $ILOSC_SZT_ALU[4] + $wygiecie_ramy_alu_ilosc_szt + $wygiecie_skrzydla_alu_ilosc_szt + $wygiecie_innego_alu_ilosc_szt;
					break;
				case 5:
					$ILOSC_SZT_ALU[5] = $ILOSC_SZT_ALU[5] + $wygiecie_ramy_alu_ilosc_szt + $wygiecie_skrzydla_alu_ilosc_szt + $wygiecie_innego_alu_ilosc_szt;
					break;
				case 6:
					$ILOSC_SZT_ALU[6] = $ILOSC_SZT_ALU[6] + $wygiecie_ramy_alu_ilosc_szt + $wygiecie_skrzydla_alu_ilosc_szt + $wygiecie_innego_alu_ilosc_szt;
					break;
				case 7:
					$ILOSC_SZT_ALU[7] = $ILOSC_SZT_ALU[7] + $wygiecie_ramy_alu_ilosc_szt + $wygiecie_skrzydla_alu_ilosc_szt + $wygiecie_innego_alu_ilosc_szt;
					break;
				case 8:
					$ILOSC_SZT_ALU[8] = $ILOSC_SZT_ALU[8] + $wygiecie_ramy_alu_ilosc_szt + $wygiecie_skrzydla_alu_ilosc_szt + $wygiecie_innego_alu_ilosc_szt;
					break;
				case 9:
					$ILOSC_SZT_ALU[9] = $ILOSC_SZT_ALU[9] + $wygiecie_ramy_alu_ilosc_szt + $wygiecie_skrzydla_alu_ilosc_szt + $wygiecie_innego_alu_ilosc_szt;
					break;
				case 10:
					$ILOSC_SZT_ALU[10] = $ILOSC_SZT_ALU[10] + $wygiecie_ramy_alu_ilosc_szt + $wygiecie_skrzydla_alu_ilosc_szt + $wygiecie_innego_alu_ilosc_szt;
					break;
				case 11:
					$ILOSC_SZT_ALU[11] = $ILOSC_SZT_ALU[11] + $wygiecie_ramy_alu_ilosc_szt + $wygiecie_skrzydla_alu_ilosc_szt + $wygiecie_innego_alu_ilosc_szt;
					break;
				case 12:
					$ILOSC_SZT_ALU[12] = $ILOSC_SZT_ALU[12] + $wygiecie_ramy_alu_ilosc_szt + $wygiecie_skrzydla_alu_ilosc_szt + $wygiecie_innego_alu_ilosc_szt;
					break;
			}		
		}

	$ILOSC_SZT_SUMA = 0;
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$ILOSC_SZT_ALU[$z] = number_format($ILOSC_SZT_ALU[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'">'.$ILOSC_SZT_ALU[$z].'</td>';
		if($ILOSC_SZT_ALU[$z] != 0) $na_ile_dzielic++;
		$ILOSC_SZT_SUMA += $ILOSC_SZT_ALU[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$ILOSC_SZT_SREDNIA = $ILOSC_SZT_SUMA/$na_ile_dzielic;
		$ILOSC_SZT_SREDNIA = number_format($ILOSC_SZT_SREDNIA, 2,'.',' ');
		$ILOSC_SZT_SUMA = number_format($ILOSC_SZT_SUMA, 2,'.',' ');
		echo '<td align="center" bgcolor="'.$kolor_tla.'">'.$ILOSC_SZT_SREDNIA.'</td></tr>';
	

	// ##############################################################################################################################################################################	
	$pytanie31 = mysqli_query($conn, "SELECT wygiecie_ramy_alu_ilosc_m, wygiecie_skrzydla_alu_ilosc_m, wygiecie_innego_alu_ilosc_m, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$wygiecie_ramy_alu_ilosc_m=$wynik31['wygiecie_ramy_alu_ilosc_m'];
		$wygiecie_skrzydla_alu_ilosc_m=$wynik31['wygiecie_skrzydla_alu_ilosc_m'];
		$wygiecie_innego_alu_ilosc_m=$wynik31['wygiecie_innego_alu_ilosc_m'];
		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$ILOSC_M_ALU[1] = $ILOSC_M_ALU[1] + $wygiecie_ramy_alu_ilosc_m + $wygiecie_skrzydla_alu_ilosc_m + $wygiecie_innego_alu_ilosc_m;
					break;
				case 2:
					$ILOSC_M_ALU[2] = $ILOSC_M_ALU[2] + $wygiecie_ramy_alu_ilosc_m + $wygiecie_skrzydla_alu_ilosc_m + $wygiecie_innego_alu_ilosc_m;
					break;
				case 3:
					$ILOSC_M_ALU[3] = $ILOSC_M_ALU[3] + $wygiecie_ramy_alu_ilosc_m + $wygiecie_skrzydla_alu_ilosc_m + $wygiecie_innego_alu_ilosc_m;
					break;
				case 4:
					$ILOSC_M_ALU[4] = $ILOSC_M_ALU[4] + $wygiecie_ramy_alu_ilosc_m + $wygiecie_skrzydla_alu_ilosc_m + $wygiecie_innego_alu_ilosc_m;
					break;
				case 5:
					$ILOSC_M_ALU[5] = $ILOSC_M_ALU[5] + $wygiecie_ramy_alu_ilosc_m + $wygiecie_skrzydla_alu_ilosc_m + $wygiecie_innego_alu_ilosc_m;
					break;
				case 6:
					$ILOSC_M_ALU[6] = $ILOSC_M_ALU[6] + $wygiecie_ramy_alu_ilosc_m + $wygiecie_skrzydla_alu_ilosc_m + $wygiecie_innego_alu_ilosc_m;
					break;
				case 7:
					$ILOSC_M_ALU[7] = $ILOSC_M_ALU[7] + $wygiecie_ramy_alu_ilosc_m + $wygiecie_skrzydla_alu_ilosc_m + $wygiecie_innego_alu_ilosc_m;
					break;
				case 8:
					$ILOSC_M_ALU[8] = $ILOSC_M_ALU[8] + $wygiecie_ramy_alu_ilosc_m + $wygiecie_skrzydla_alu_ilosc_m + $wygiecie_innego_alu_ilosc_m;
					break;
				case 9:
					$ILOSC_M_ALU[9] = $ILOSC_M_ALU[9] + $wygiecie_ramy_alu_ilosc_m + $wygiecie_skrzydla_alu_ilosc_m + $wygiecie_innego_alu_ilosc_m;
					break;
				case 10:
					$ILOSC_M_ALU[10] = $ILOSC_M_ALU[10] + $wygiecie_ramy_alu_ilosc_m + $wygiecie_skrzydla_alu_ilosc_m + $wygiecie_innego_alu_ilosc_m;
					break;
				case 11:
					$ILOSC_M_ALU[11] = $ILOSC_M_ALU[11] + $wygiecie_ramy_alu_ilosc_m + $wygiecie_skrzydla_alu_ilosc_m + $wygiecie_innego_alu_ilosc_m;
					break;
				case 12:
					$ILOSC_M_ALU[12] = $ILOSC_M_ALU[12] + $wygiecie_ramy_alu_ilosc_m + $wygiecie_skrzydla_alu_ilosc_m + $wygiecie_innego_alu_ilosc_m;
					break;
			}		
		}
		
	$ILOSC_M_SUMA = 0;
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$ILOSC_M_ALU[$z] = number_format($ILOSC_M_ALU[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'">'.$ILOSC_M_ALU[$z].'</td>';
		if($ILOSC_M_ALU[$z] != 0) $na_ile_dzielic++;
		$ILOSC_M_SUMA += $ILOSC_M_ALU[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$ILOSC_M_SREDNIA = $ILOSC_M_SUMA/$na_ile_dzielic;
		$ILOSC_M_SREDNIA = number_format($ILOSC_M_SREDNIA, 2,'.',' ');
		$ILOSC_M_SUMA = number_format($ILOSC_M_SUMA, 2,'.',' ');
		echo '<td align="center" bgcolor="'.$kolor_tla.'">'.$ILOSC_M_SREDNIA.'</td></tr>';
	
	// ##############################################################################################################################################################################	
		
	$CENA_LUKI_ALU_SUMA = 0;
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		
		if($ILOSC_M_ALU[$z] != 0) $CENA_LUKI_ALU[$z] = $WARTOSC_ALU[$z]/$ILOSC_M_ALU[$z];
		$CENA_LUKI_ALU[$z] = number_format($CENA_LUKI_ALU[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'">'.$CENA_LUKI_ALU[$z].'</td>';
		if($CENA_LUKI_ALU[$z] != 0) $na_ile_dzielic++;
		$CENA_LUKI_ALU_SUMA += $CENA_LUKI_ALU[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$CENA_LUKI_ALU_SREDNIA = $CENA_LUKI_ALU_SUMA/$na_ile_dzielic;
		$CENA_LUKI_ALU_SREDNIA = number_format($CENA_LUKI_ALU_SREDNIA, 2,'.',' ');
		$CENA_LUKI_ALU_SUMA = number_format($CENA_LUKI_ALU_SUMA, 2,'.',' ');
		echo '<td align="center" bgcolor="'.$kolor_tla.'">'.$CENA_LUKI_ALU_SREDNIA.'</td></tr>';



	// ##############################################################################################################################################################################	
	// ###########################################################		  wygiecie_wzmocnienia_okiennego_ilosc_szt				###################################################################################	
	// ###########################################################		  wygiecie_innego_ilosc_szt					###################################################################################	
	// ##############################################################################################################################################################################	
	$kolor_tla = $kolor_bialy;
	$pytanie31 = mysqli_query($conn, "SELECT wygiecie_wzmocnienia_okiennego_wartosc, wygiecie_innego_wartosc, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$wygiecie_wzmocnienia_okiennego_ilosc_wartosc=$wynik31['wygiecie_wzmocnienia_okiennego_wartosc'];
		$wygiecie_innego_ilosc_wartosc=$wynik31['wygiecie_innego_wartosc'];
		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_STALI[1] = $WARTOSC_STALI[1] + $wygiecie_wzmocnienia_okiennego_ilosc_wartosc + $wygiecie_innego_ilosc_wartosc;
					break;
				case 2:
					$WARTOSC_STALI[2] = $WARTOSC_STALI[2] + $wygiecie_wzmocnienia_okiennego_ilosc_wartosc + $wygiecie_innego_ilosc_wartosc;
					break;
				case 3:
					$WARTOSC_STALI[3] = $WARTOSC_STALI[3] + $wygiecie_wzmocnienia_okiennego_ilosc_wartosc + $wygiecie_innego_ilosc_wartosc;
					break;
				case 4:
					$WARTOSC_STALI[4] = $WARTOSC_STALI[4] + $wygiecie_wzmocnienia_okiennego_ilosc_wartosc + $wygiecie_innego_ilosc_wartosc;
					break;
				case 5:
					$WARTOSC_STALI[5] = $WARTOSC_STALI[5] + $wygiecie_wzmocnienia_okiennego_ilosc_wartosc + $wygiecie_innego_ilosc_wartosc;
					break;
				case 6:
					$WARTOSC_STALI[6] = $WARTOSC_STALI[6] + $wygiecie_wzmocnienia_okiennego_ilosc_wartosc + $wygiecie_innego_ilosc_wartosc;
					break;
				case 7:
					$WARTOSC_STALI[7] = $WARTOSC_STALI[7] + $wygiecie_wzmocnienia_okiennego_ilosc_wartosc + $wygiecie_innego_ilosc_wartosc;
					break;
				case 8:
					$WARTOSC_STALI[8] = $WARTOSC_STALI[8] + $wygiecie_wzmocnienia_okiennego_ilosc_wartosc + $wygiecie_innego_ilosc_wartosc;
					break;
				case 9:
					$WARTOSC_STALI[9] = $WARTOSC_STALI[9] + $wygiecie_wzmocnienia_okiennego_ilosc_wartosc + $wygiecie_innego_ilosc_wartosc;
					break;
				case 10:
					$WARTOSC_STALI[10] = $WARTOSC_STALI[10] + $wygiecie_wzmocnienia_okiennego_ilosc_wartosc + $wygiecie_innego_ilosc_wartosc;
					break;
				case 11:
					$WARTOSC_STALI[11] = $WARTOSC_STALI[11] + $wygiecie_wzmocnienia_okiennego_ilosc_wartosc + $wygiecie_innego_ilosc_wartosc;
					break;
				case 12:
					$WARTOSC_STALI[12] = $WARTOSC_STALI[12] + $wygiecie_wzmocnienia_okiennego_ilosc_wartosc + $wygiecie_innego_ilosc_wartosc;
					break;
			}		
		}
		
	$WARTOSC_SUMA = 0;
	echo '<tr align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_tla.'" rowspan="4" align="left">'.$kol_wartosc.' | '.$kol_ilosc.' | cena łuki ze stali</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_STALI[$z] = number_format($WARTOSC_STALI[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_tla.'">'.$WARTOSC_STALI[$z].'</td>';
		if($WARTOSC_STALI[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA += $WARTOSC_STALI[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$WARTOSC_SREDNIA = $WARTOSC_SUMA/$na_ile_dzielic;
		$WARTOSC_SREDNIA = number_format($WARTOSC_SREDNIA, 2,'.',' ');
		$WARTOSC_SUMA = number_format($WARTOSC_SUMA, 2,'.',' ');
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SREDNIA.'</td>';
		echo '<td rowspan="4" bgcolor="'.$kolor_tla.'">'.$WARTOSC_SUMA.'</td></tr>';

	// ##############################################################################################################################################################################	
	$pytanie31 = mysqli_query($conn, "SELECT wygiecie_wzmocnienia_okiennego_ilosc_szt, wygiecie_innego_ilosc_szt, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$wygiecie_wzmocnienia_okiennego_ilosc_szt=$wynik31['wygiecie_wzmocnienia_okiennego_ilosc_szt'];
		$wygiecie_innego_ilosc_szt=$wynik31['wygiecie_innego_ilosc_szt'];
		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$ILOSC_SZT_STALI[1] = $ILOSC_SZT_STALI[1] + $wygiecie_wzmocnienia_okiennego_ilosc_szt + $wygiecie_innego_ilosc_szt;
					break;
				case 2:
					$ILOSC_SZT_STALI[2] = $ILOSC_SZT_STALI[2] + $wygiecie_wzmocnienia_okiennego_ilosc_szt + $wygiecie_innego_ilosc_szt;
					break;
				case 3:
					$ILOSC_SZT_STALI[3] = $ILOSC_SZT_STALI[3] + $wygiecie_wzmocnienia_okiennego_ilosc_szt + $wygiecie_innego_ilosc_szt;
					break;
				case 4:
					$ILOSC_SZT_STALI[4] = $ILOSC_SZT_STALI[4] + $wygiecie_wzmocnienia_okiennego_ilosc_szt + $wygiecie_innego_ilosc_szt;
					break;
				case 5:
					$ILOSC_SZT_STALI[5] = $ILOSC_SZT_STALI[5] + $wygiecie_wzmocnienia_okiennego_ilosc_szt + $wygiecie_innego_ilosc_szt;
					break;
				case 6:
					$ILOSC_SZT_STALI[6] = $ILOSC_SZT_STALI[6] + $wygiecie_wzmocnienia_okiennego_ilosc_szt + $wygiecie_innego_ilosc_szt;
					break;
				case 7:
					$ILOSC_SZT_STALI[7] = $ILOSC_SZT_STALI[7] + $wygiecie_wzmocnienia_okiennego_ilosc_szt + $wygiecie_innego_ilosc_szt;
					break;
				case 8:
					$ILOSC_SZT_STALI[8] = $ILOSC_SZT_STALI[8] + $wygiecie_wzmocnienia_okiennego_ilosc_szt + $wygiecie_innego_ilosc_szt;
					break;
				case 9:
					$ILOSC_SZT_STALI[9] = $ILOSC_SZT_STALI[9] + $wygiecie_wzmocnienia_okiennego_ilosc_szt + $wygiecie_innego_ilosc_szt;
					break;
				case 10:
					$ILOSC_SZT_STALI[10] = $ILOSC_SZT_STALI[10] + $wygiecie_wzmocnienia_okiennego_ilosc_szt + $wygiecie_innego_ilosc_szt;
					break;
				case 11:
					$ILOSC_SZT_STALI[11] = $ILOSC_SZT_STALI[11] + $wygiecie_wzmocnienia_okiennego_ilosc_szt + $wygiecie_innego_ilosc_szt;
					break;
				case 12:
					$ILOSC_SZT_STALI[12] = $ILOSC_SZT_STALI[12] + $wygiecie_wzmocnienia_okiennego_ilosc_szt + $wygiecie_innego_ilosc_szt;
					break;
			}		
		}

	$ILOSC_SZT_SUMA = 0;
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$ILOSC_SZT_STALI[$z] = number_format($ILOSC_SZT_STALI[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'">'.$ILOSC_SZT_STALI[$z].'</td>';
		if($ILOSC_SZT_STALI[$z] != 0) $na_ile_dzielic++;
		$ILOSC_SZT_SUMA += $ILOSC_SZT_STALI[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$ILOSC_SZT_SREDNIA = $ILOSC_SZT_SUMA/$na_ile_dzielic;
		$ILOSC_SZT_SREDNIA = number_format($ILOSC_SZT_SREDNIA, 2,'.',' ');
		$ILOSC_SZT_SUMA = number_format($ILOSC_SZT_SUMA, 2,'.',' ');
		echo '<td align="center" bgcolor="'.$kolor_tla.'">'.$ILOSC_SZT_SREDNIA.'</td></tr>';
	

	// ##############################################################################################################################################################################	
	$pytanie31 = mysqli_query($conn, "SELECT wygiecie_wzmocnienia_okiennego_ilosc_m, wygiecie_innego_ilosc_m, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$wygiecie_wzmocnienia_okiennego_ilosc_m=$wynik31['wygiecie_wzmocnienia_okiennego_ilosc_m'];
		$wygiecie_innego_ilosc_m=$wynik31['wygiecie_innego_ilosc_m'];
		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$ILOSC_M_STALI[1] = $ILOSC_M_STALI[1] + $wygiecie_wzmocnienia_okiennego_ilosc_m + $wygiecie_innego_ilosc_m;
					break;
				case 2:
					$ILOSC_M_STALI[2] = $ILOSC_M_STALI[2] + $wygiecie_wzmocnienia_okiennego_ilosc_m + $wygiecie_innego_ilosc_m;
					break;
				case 3:
					$ILOSC_M_STALI[3] = $ILOSC_M_STALI[3] + $wygiecie_wzmocnienia_okiennego_ilosc_m + $wygiecie_innego_ilosc_m;
					break;
				case 4:
					$ILOSC_M_STALI[4] = $ILOSC_M_STALI[4] + $wygiecie_wzmocnienia_okiennego_ilosc_m + $wygiecie_innego_ilosc_m;
					break;
				case 5:
					$ILOSC_M_STALI[5] = $ILOSC_M_STALI[5] + $wygiecie_wzmocnienia_okiennego_ilosc_m + $wygiecie_innego_ilosc_m;
					break;
				case 6:
					$ILOSC_M_STALI[6] = $ILOSC_M_STALI[6] + $wygiecie_wzmocnienia_okiennego_ilosc_m + $wygiecie_innego_ilosc_m;
					break;
				case 7:
					$ILOSC_M_STALI[7] = $ILOSC_M_STALI[7] + $wygiecie_wzmocnienia_okiennego_ilosc_m + $wygiecie_innego_ilosc_m;
					break;
				case 8:
					$ILOSC_M_STALI[8] = $ILOSC_M_STALI[8] + $wygiecie_wzmocnienia_okiennego_ilosc_m + $wygiecie_innego_ilosc_m;
					break;
				case 9:
					$ILOSC_M_STALI[9] = $ILOSC_M_STALI[9] + $wygiecie_wzmocnienia_okiennego_ilosc_m + $wygiecie_innego_ilosc_m;
					break;
				case 10:
					$ILOSC_M_STALI[10] = $ILOSC_M_STALI[10] + $wygiecie_wzmocnienia_okiennego_ilosc_m + $wygiecie_innego_ilosc_m;
					break;
				case 11:
					$ILOSC_M_STALI[11] = $ILOSC_M_STALI[11] + $wygiecie_wzmocnienia_okiennego_ilosc_m + $wygiecie_innego_ilosc_m;
					break;
				case 12:
					$ILOSC_M_STALI[12] = $ILOSC_M_STALI[12] + $wygiecie_wzmocnienia_okiennego_ilosc_m + $wygiecie_innego_ilosc_m;
					break;
			}		
		}
		
	$ILOSC_M_SUMA = 0;
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$ILOSC_M_STALI[$z] = number_format($ILOSC_M_STALI[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'">'.$ILOSC_M_STALI[$z].'</td>';
		if($ILOSC_M_STALI[$z] != 0) $na_ile_dzielic++;
		$ILOSC_M_SUMA += $ILOSC_M_STALI[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$ILOSC_M_SREDNIA = $ILOSC_M_SUMA/$na_ile_dzielic;
		$ILOSC_M_SREDNIA = number_format($ILOSC_M_SREDNIA, 2,'.',' ');
		$ILOSC_M_SUMA = number_format($ILOSC_M_SUMA, 2,'.',' ');
		echo '<td align="center" bgcolor="'.$kolor_tla.'">'.$ILOSC_M_SREDNIA.'</td></tr>';
	
	// ##############################################################################################################################################################################	
		
	$CENA_LUKI_STALI_SUMA = 0;
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		
		if($ILOSC_M_STALI[$z] != 0) $CENA_LUKI_STALI[$z] = $WARTOSC_STALI[$z]/$ILOSC_M_STALI[$z];
		$CENA_LUKI_STALI[$z] = number_format($CENA_LUKI_STALI[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'">'.$CENA_LUKI_STALI[$z].'</td>';
		if($CENA_LUKI_STALI[$z] != 0) $na_ile_dzielic++;
		$CENA_LUKI_STALI_SUMA += $CENA_LUKI_STALI[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$CENA_LUKI_STALI_SREDNIA = $CENA_LUKI_STALI_SUMA/$na_ile_dzielic;
		$CENA_LUKI_STALI_SREDNIA = number_format($CENA_LUKI_STALI_SREDNIA, 2,'.',' ');
		$CENA_LUKI_STALI_SUMA = number_format($CENA_LUKI_STALI_SUMA, 2,'.',' ');
		echo '<td align="center" bgcolor="'.$kolor_tla.'">'.$CENA_LUKI_STALI_SREDNIA.'</td></tr>';




	// ##############################################################################################################################################################################	
	// ###########################################################		  zgrzanie				###################################################################################	
	// ###########################################################		  zgrzanie_wartosc					###################################################################################	
	// ##############################################################################################################################################################################	
	$kolor_tla = $kolor_szary;
	$pytanie31 = mysqli_query($conn, "SELECT zgrzanie_wartosc, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$zgrzanie_wartosc=$wynik31['zgrzanie_wartosc'];
		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_ZGRZANIE[1] = $WARTOSC_ZGRZANIE[1] + $zgrzanie_wartosc;
					break;
				case 2:
					$WARTOSC_ZGRZANIE[2] = $WARTOSC_ZGRZANIE[2] + $zgrzanie_wartosc;
					break;
				case 3:
					$WARTOSC_ZGRZANIE[3] = $WARTOSC_ZGRZANIE[3] + $zgrzanie_wartosc;
					break;
				case 4:
					$WARTOSC_ZGRZANIE[4] = $WARTOSC_ZGRZANIE[4] + $zgrzanie_wartosc;
					break;
				case 5:
					$WARTOSC_ZGRZANIE[5] = $WARTOSC_ZGRZANIE[5] + $zgrzanie_wartosc;
					break;
				case 6:
					$WARTOSC_ZGRZANIE[6] = $WARTOSC_ZGRZANIE[6] + $zgrzanie_wartosc;
					break;
				case 7:
					$WARTOSC_ZGRZANIE[7] = $WARTOSC_ZGRZANIE[7] + $zgrzanie_wartosc;
					break;
				case 8:
					$WARTOSC_ZGRZANIE[8] = $WARTOSC_ZGRZANIE[8] + $zgrzanie_wartosc;
					break;
				case 9:
					$WARTOSC_ZGRZANIE[9] = $WARTOSC_ZGRZANIE[9] + $zgrzanie_wartosc;
					break;
				case 10:
					$WARTOSC_ZGRZANIE[10] = $WARTOSC_ZGRZANIE[10] + $zgrzanie_wartosc;
					break;
				case 11:
					$WARTOSC_ZGRZANIE[11] = $WARTOSC_ZGRZANIE[11] + $zgrzanie_wartosc;
					break;
				case 12:
					$WARTOSC_ZGRZANIE[12] = $WARTOSC_ZGRZANIE[12] + $zgrzanie_wartosc;
					break;
			}		
		}
		
	$WARTOSC_SUMA = 0;
	echo '<tr align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_tla.'" rowspan="3" align="left">'.$kol_wartosc.' | '.$kol_ilosc.' | cena zgrzanie</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_ZGRZANIE[$z] = number_format($WARTOSC_ZGRZANIE[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_tla.'">'.$WARTOSC_ZGRZANIE[$z].'</td>';
		if($WARTOSC_ZGRZANIE[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA += $WARTOSC_ZGRZANIE[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$WARTOSC_SREDNIA = $WARTOSC_SUMA/$na_ile_dzielic;
		$WARTOSC_SREDNIA = number_format($WARTOSC_SREDNIA, 2,'.',' ');
		$WARTOSC_SUMA = number_format($WARTOSC_SUMA, 2,'.',' ');
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SREDNIA.'</td>';
		echo '<td rowspan="3" bgcolor="'.$kolor_tla.'">'.$WARTOSC_SUMA.'</td></tr>';

	// ##############################################################################################################################################################################	
	$pytanie31 = mysqli_query($conn, "SELECT zgrzanie_ilosc, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$zgrzanie_ilosc=$wynik31['zgrzanie_ilosc'];
		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$ILOSC_ZGRZANIE[1] = $ILOSC_ZGRZANIE[1] + $zgrzanie_ilosc;
					break;
				case 2:
					$ILOSC_ZGRZANIE[2] = $ILOSC_ZGRZANIE[2] + $zgrzanie_ilosc;
					break;
				case 3:
					$ILOSC_ZGRZANIE[3] = $ILOSC_ZGRZANIE[3] + $zgrzanie_ilosc;
					break;
				case 4:
					$ILOSC_ZGRZANIE[4] = $ILOSC_ZGRZANIE[4] + $zgrzanie_ilosc;
					break;
				case 5:
					$ILOSC_ZGRZANIE[5] = $ILOSC_ZGRZANIE[5] + $zgrzanie_ilosc;
					break;
				case 6:
					$ILOSC_ZGRZANIE[6] = $ILOSC_ZGRZANIE[6] + $zgrzanie_ilosc;
					break;
				case 7:
					$ILOSC_ZGRZANIE[7] = $ILOSC_ZGRZANIE[7] + $zgrzanie_ilosc;
					break;
				case 8:
					$ILOSC_ZGRZANIE[8] = $ILOSC_ZGRZANIE[8] + $zgrzanie_ilosc;
					break;
				case 9:
					$ILOSC_ZGRZANIE[9] = $ILOSC_ZGRZANIE[9] + $zgrzanie_ilosc;
					break;
				case 10:
					$ILOSC_ZGRZANIE[10] = $ILOSC_ZGRZANIE[10] + $zgrzanie_ilosc;
					break;
				case 11:
					$ILOSC_ZGRZANIE[11] = $ILOSC_ZGRZANIE[11] + $zgrzanie_ilosc;
					break;
				case 12:
					$ILOSC_ZGRZANIE[12] = $ILOSC_ZGRZANIE[12] + $zgrzanie_ilosc;
					break;
			}		
		}

	$ILOSC_SUMA = 0;
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$ILOSC_ZGRZANIE[$z] = number_format($ILOSC_ZGRZANIE[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'">'.$ILOSC_ZGRZANIE[$z].'</td>';
		if($ILOSC_ZGRZANIE[$z] != 0) $na_ile_dzielic++;
		$ILOSC_SUMA += $ILOSC_ZGRZANIE[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$ILOSC_SREDNIA = $ILOSC_SUMA/$na_ile_dzielic;
		$ILOSC_SREDNIA = number_format($ILOSC_SREDNIA, 2,'.',' ');
		$ILOSC_SUMA = number_format($ILOSC_SUMA, 2,'.',' ');
		echo '<td align="center" bgcolor="'.$kolor_tla.'">'.$ILOSC_SREDNIA.'</td></tr>';
	
	
	// ##############################################################################################################################################################################	
		
	$CENA_ZGRZANIE_SUMA = 0;
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		
		if($ILOSC_ZGRZANIE[$z] != 0) $CENA_ZGRZANIE[$z] = $WARTOSC_ZGRZANIE[$z]/$ILOSC_ZGRZANIE[$z];
		$CENA_ZGRZANIE[$z] = number_format($CENA_ZGRZANIE[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'">'.$CENA_ZGRZANIE[$z].'</td>';
		if($CENA_ZGRZANIE[$z] != 0) $na_ile_dzielic++;
		$CENA_ZGRZANIE_SUMA += $CENA_ZGRZANIE[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$CENA_ZGRZANIE_SREDNIA = $CENA_ZGRZANIE_SUMA/$na_ile_dzielic;
		$CENA_ZGRZANIE_SREDNIA = number_format($CENA_ZGRZANIE_SREDNIA, 2,'.',' ');
		$CENA_ZGRZANIE_SUMA = number_format($CENA_ZGRZANIE_SUMA, 2,'.',' ');
		echo '<td align="center" bgcolor="'.$kolor_tla.'">'.$CENA_ZGRZANIE_SREDNIA.'</td></tr>';



	// ##############################################################################################################################################################################	
	// ###########################################################		  wyfrezowanie_odwodnienia_wartosc 					###################################################################################	
	// ##############################################################################################################################################################################	
	$kolor_tla = $kolor_bialy;
	$pytanie31 = mysqli_query($conn, "SELECT wyfrezowanie_odwodnienia_wartosc, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$wyfrezowanie_odwodnienia_wartosc=$wynik31['wyfrezowanie_odwodnienia_wartosc'];
		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_WYFREZOWANIE_ODWODNIENIA[1] = $WARTOSC_WYFREZOWANIE_ODWODNIENIA[1] + $wyfrezowanie_odwodnienia_wartosc;
					break;
				case 2:
					$WARTOSC_WYFREZOWANIE_ODWODNIENIA[2] = $WARTOSC_WYFREZOWANIE_ODWODNIENIA[2] + $wyfrezowanie_odwodnienia_wartosc;
					break;
				case 3:
					$WARTOSC_WYFREZOWANIE_ODWODNIENIA[3] = $WARTOSC_WYFREZOWANIE_ODWODNIENIA[3] + $wyfrezowanie_odwodnienia_wartosc;
					break;
				case 4:
					$WARTOSC_WYFREZOWANIE_ODWODNIENIA[4] = $WARTOSC_WYFREZOWANIE_ODWODNIENIA[4] + $wyfrezowanie_odwodnienia_wartosc;
					break;
				case 5:
					$WARTOSC_WYFREZOWANIE_ODWODNIENIA[5] = $WARTOSC_WYFREZOWANIE_ODWODNIENIA[5] + $wyfrezowanie_odwodnienia_wartosc;
					break;
				case 6:
					$WARTOSC_WYFREZOWANIE_ODWODNIENIA[6] = $WARTOSC_WYFREZOWANIE_ODWODNIENIA[6] + $wyfrezowanie_odwodnienia_wartosc;
					break;
				case 7:
					$WARTOSC_WYFREZOWANIE_ODWODNIENIA[7] = $WARTOSC_WYFREZOWANIE_ODWODNIENIA[7] + $wyfrezowanie_odwodnienia_wartosc;
					break;
				case 8:
					$WARTOSC_WYFREZOWANIE_ODWODNIENIA[8] = $WARTOSC_WYFREZOWANIE_ODWODNIENIA[8] + $wyfrezowanie_odwodnienia_wartosc;
					break;
				case 9:
					$WARTOSC_WYFREZOWANIE_ODWODNIENIA[9] = $WARTOSC_WYFREZOWANIE_ODWODNIENIA[9] + $wyfrezowanie_odwodnienia_wartosc;
					break;
				case 10:
					$WARTOSC_WYFREZOWANIE_ODWODNIENIA[10] = $WARTOSC_WYFREZOWANIE_ODWODNIENIA[10] + $wyfrezowanie_odwodnienia_wartosc;
					break;
				case 11:
					$WARTOSC_WYFREZOWANIE_ODWODNIENIA[11] = $WARTOSC_WYFREZOWANIE_ODWODNIENIA[11] + $wyfrezowanie_odwodnienia_wartosc;
					break;
				case 12:
					$WARTOSC_WYFREZOWANIE_ODWODNIENIA[12] = $WARTOSC_WYFREZOWANIE_ODWODNIENIA[12] + $wyfrezowanie_odwodnienia_wartosc;
					break;
			}		
		}
		
	$WARTOSC_SUMA = 0;
	echo '<tr align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_tla.'" rowspan="3" align="left">'.$kol_wartosc.' | '.$kol_ilosc.' | cena wyfrezowanie odwodnienia</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_WYFREZOWANIE_ODWODNIENIA[$z] = number_format($WARTOSC_WYFREZOWANIE_ODWODNIENIA[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_tla.'">'.$WARTOSC_WYFREZOWANIE_ODWODNIENIA[$z].'</td>';
		if($WARTOSC_WYFREZOWANIE_ODWODNIENIA[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA += $WARTOSC_WYFREZOWANIE_ODWODNIENIA[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$WARTOSC_SREDNIA = $WARTOSC_SUMA/$na_ile_dzielic;
		$WARTOSC_SREDNIA = number_format($WARTOSC_SREDNIA, 2,'.',' ');
		$WARTOSC_SUMA = number_format($WARTOSC_SUMA, 2,'.',' ');
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SREDNIA.'</td>';
		echo '<td rowspan="3" bgcolor="'.$kolor_tla.'">'.$WARTOSC_SUMA.'</td></tr>';

	// ##############################################################################################################################################################################	
	$pytanie31 = mysqli_query($conn, "SELECT wyfrezowanie_odwodnienia_ilosc, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$wyfrezowanie_odwodnienia_ilosc=$wynik31['wyfrezowanie_odwodnienia_ilosc'];
		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$ILOSC_WYFREZOWANIE_ODWODNIENIA[1] = $ILOSC_WYFREZOWANIE_ODWODNIENIA[1] + $wyfrezowanie_odwodnienia_ilosc;
					break;
				case 2:
					$ILOSC_WYFREZOWANIE_ODWODNIENIA[2] = $ILOSC_WYFREZOWANIE_ODWODNIENIA[2] + $wyfrezowanie_odwodnienia_ilosc;
					break;
				case 3:
					$ILOSC_WYFREZOWANIE_ODWODNIENIA[3] = $ILOSC_WYFREZOWANIE_ODWODNIENIA[3] + $wyfrezowanie_odwodnienia_ilosc;
					break;
				case 4:
					$ILOSC_WYFREZOWANIE_ODWODNIENIA[4] = $ILOSC_WYFREZOWANIE_ODWODNIENIA[4] + $wyfrezowanie_odwodnienia_ilosc;
					break;
				case 5:
					$ILOSC_WYFREZOWANIE_ODWODNIENIA[5] = $ILOSC_WYFREZOWANIE_ODWODNIENIA[5] + $wyfrezowanie_odwodnienia_ilosc;
					break;
				case 6:
					$ILOSC_WYFREZOWANIE_ODWODNIENIA[6] = $ILOSC_WYFREZOWANIE_ODWODNIENIA[6] + $wyfrezowanie_odwodnienia_ilosc;
					break;
				case 7:
					$ILOSC_WYFREZOWANIE_ODWODNIENIA[7] = $ILOSC_WYFREZOWANIE_ODWODNIENIA[7] + $wyfrezowanie_odwodnienia_ilosc;
					break;
				case 8:
					$ILOSC_WYFREZOWANIE_ODWODNIENIA[8] = $ILOSC_WYFREZOWANIE_ODWODNIENIA[8] + $wyfrezowanie_odwodnienia_ilosc;
					break;
				case 9:
					$ILOSC_WYFREZOWANIE_ODWODNIENIA[9] = $ILOSC_WYFREZOWANIE_ODWODNIENIA[9] + $wyfrezowanie_odwodnienia_ilosc;
					break;
				case 10:
					$ILOSC_WYFREZOWANIE_ODWODNIENIA[10] = $ILOSC_WYFREZOWANIE_ODWODNIENIA[10] + $wyfrezowanie_odwodnienia_ilosc;
					break;
				case 11:
					$ILOSC_WYFREZOWANIE_ODWODNIENIA[11] = $ILOSC_WYFREZOWANIE_ODWODNIENIA[11] + $wyfrezowanie_odwodnienia_ilosc;
					break;
				case 12:
					$ILOSC_WYFREZOWANIE_ODWODNIENIA[12] = $ILOSC_WYFREZOWANIE_ODWODNIENIA[12] + $wyfrezowanie_odwodnienia_ilosc;
					break;
			}		
		}

	$ILOSC_SUMA = 0;
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$ILOSC_WYFREZOWANIE_ODWODNIENIA[$z] = number_format($ILOSC_WYFREZOWANIE_ODWODNIENIA[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'">'.$ILOSC_WYFREZOWANIE_ODWODNIENIA[$z].'</td>';
		if($ILOSC_WYFREZOWANIE_ODWODNIENIA[$z] != 0) $na_ile_dzielic++;
		$ILOSC_SUMA += $ILOSC_WYFREZOWANIE_ODWODNIENIA[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$ILOSC_SREDNIA = $ILOSC_SUMA/$na_ile_dzielic;
		$ILOSC_SREDNIA = number_format($ILOSC_SREDNIA, 2,'.',' ');
		$ILOSC_SUMA = number_format($ILOSC_SUMA, 2,'.',' ');
		echo '<td align="center" bgcolor="'.$kolor_tla.'">'.$ILOSC_SREDNIA.'</td></tr>';
	
	
	// ##############################################################################################################################################################################	
		
	$CENA_WYFREZOWANIE_ODWODNIENIA_SUMA = 0;
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		
		if($ILOSC_WYFREZOWANIE_ODWODNIENIA[$z] != 0) $CENA_WYFREZOWANIE_ODWODNIENIA[$z] = $WARTOSC_WYFREZOWANIE_ODWODNIENIA[$z]/$ILOSC_WYFREZOWANIE_ODWODNIENIA[$z];
		$CENA_WYFREZOWANIE_ODWODNIENIA[$z] = number_format($CENA_WYFREZOWANIE_ODWODNIENIA[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'">'.$CENA_WYFREZOWANIE_ODWODNIENIA[$z].'</td>';
		if($CENA_WYFREZOWANIE_ODWODNIENIA[$z] != 0) $na_ile_dzielic++;
		$CENA_WYFREZOWANIE_ODWODNIENIA_SUMA += $CENA_WYFREZOWANIE_ODWODNIENIA[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$CENA_WYFREZOWANIE_ODWODNIENIA_SREDNIA = $CENA_WYFREZOWANIE_ODWODNIENIA_SUMA/$na_ile_dzielic;
		$CENA_WYFREZOWANIE_ODWODNIENIA_SREDNIA = number_format($CENA_WYFREZOWANIE_ODWODNIENIA_SREDNIA, 2,'.',' ');
		$CENA_WYFREZOWANIE_ODWODNIENIA_SUMA = number_format($CENA_WYFREZOWANIE_ODWODNIENIA_SUMA, 2,'.',' ');
		echo '<td align="center" bgcolor="'.$kolor_tla.'">'.$CENA_WYFREZOWANIE_ODWODNIENIA_SREDNIA.'</td></tr>';




	// ##############################################################################################################################################################################	
	// ###########################################################		  wstawienie_slupka_wartosc 					###################################################################################	
	// ##############################################################################################################################################################################	
	$kolor_tla = $kolor_szary;
	$pytanie31 = mysqli_query($conn, "SELECT wstawienie_slupka_wartosc, wstawienie_slupka_ruchomego_wartosc, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$wstawienie_slupka_wartosc=$wynik31['wstawienie_slupka_wartosc'];
		$wstawienie_slupka_ruchomego_wartosc=$wynik31['wstawienie_slupka_ruchomego_wartosc'];

		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_WSTAWIENIE_SLUPKA[1] = $WARTOSC_WSTAWIENIE_SLUPKA[1] + $wstawienie_slupka_wartosc + $wstawienie_slupka_ruchomego_wartosc;
					break;
				case 2:
					$WARTOSC_WSTAWIENIE_SLUPKA[2] = $WARTOSC_WSTAWIENIE_SLUPKA[2] + $wstawienie_slupka_wartosc + $wstawienie_slupka_ruchomego_wartosc;
					break;
				case 3:
					$WARTOSC_WSTAWIENIE_SLUPKA[3] = $WARTOSC_WSTAWIENIE_SLUPKA[3] + $wstawienie_slupka_wartosc + $wstawienie_slupka_ruchomego_wartosc;
					break;
				case 4:
					$WARTOSC_WSTAWIENIE_SLUPKA[4] = $WARTOSC_WSTAWIENIE_SLUPKA[4] + $wstawienie_slupka_wartosc + $wstawienie_slupka_ruchomego_wartosc;
					break;
				case 5:
					$WARTOSC_WSTAWIENIE_SLUPKA[5] = $WARTOSC_WSTAWIENIE_SLUPKA[5] + $wstawienie_slupka_wartosc + $wstawienie_slupka_ruchomego_wartosc;
					break;
				case 6:
					$WARTOSC_WSTAWIENIE_SLUPKA[6] = $WARTOSC_WSTAWIENIE_SLUPKA[6] + $wstawienie_slupka_wartosc + $wstawienie_slupka_ruchomego_wartosc;
					break;
				case 7:
					$WARTOSC_WSTAWIENIE_SLUPKA[7] = $WARTOSC_WSTAWIENIE_SLUPKA[7] + $wstawienie_slupka_wartosc + $wstawienie_slupka_ruchomego_wartosc;
					break;
				case 8:
					$WARTOSC_WSTAWIENIE_SLUPKA[8] = $WARTOSC_WSTAWIENIE_SLUPKA[8] + $wstawienie_slupka_wartosc + $wstawienie_slupka_ruchomego_wartosc;
					break;
				case 9:
					$WARTOSC_WSTAWIENIE_SLUPKA[9] = $WARTOSC_WSTAWIENIE_SLUPKA[9] + $wstawienie_slupka_wartosc + $wstawienie_slupka_ruchomego_wartosc;
					break;
				case 10:
					$WARTOSC_WSTAWIENIE_SLUPKA[10] = $WARTOSC_WSTAWIENIE_SLUPKA[10] + $wstawienie_slupka_wartosc + $wstawienie_slupka_ruchomego_wartosc;
					break;
				case 11:
					$WARTOSC_WSTAWIENIE_SLUPKA[11] = $WARTOSC_WSTAWIENIE_SLUPKA[11] + $wstawienie_slupka_wartosc + $wstawienie_slupka_ruchomego_wartosc;
					break;
				case 12:
					$WARTOSC_WSTAWIENIE_SLUPKA[12] = $WARTOSC_WSTAWIENIE_SLUPKA[12] + $wstawienie_slupka_wartosc + $wstawienie_slupka_ruchomego_wartosc;
					break;
			}		
		}
		
	$WARTOSC_SUMA = 0;
	echo '<tr align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_tla.'" rowspan="3" align="left">'.$kol_wartosc.' | '.$kol_ilosc.' | cena wstawienie słupka</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_WSTAWIENIE_SLUPKA[$z] = number_format($WARTOSC_WSTAWIENIE_SLUPKA[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_tla.'">'.$WARTOSC_WSTAWIENIE_SLUPKA[$z].'</td>';
		if($WARTOSC_WSTAWIENIE_SLUPKA[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA += $WARTOSC_WSTAWIENIE_SLUPKA[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$WARTOSC_SREDNIA = $WARTOSC_SUMA/$na_ile_dzielic;
		$WARTOSC_SREDNIA = number_format($WARTOSC_SREDNIA, 2,'.',' ');
		$WARTOSC_SUMA = number_format($WARTOSC_SUMA, 2,'.',' ');
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SREDNIA.'</td>';
		echo '<td rowspan="3" bgcolor="'.$kolor_tla.'">'.$WARTOSC_SUMA.'</td></tr>';

	// ##############################################################################################################################################################################	
	$pytanie31 = mysqli_query($conn, "SELECT wstawienie_slupka_ilosc, wstawienie_slupka_ruchomego_ilosc, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$wstawienie_slupka_ilosc=$wynik31['wstawienie_slupka_ilosc'];
		$wstawienie_slupka_ruchomego_ilosc=$wynik31['wstawienie_slupka_ruchomego_ilosc'];

		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$ILOSC_WSTAWIENIE_SLUPKA[1] = $ILOSC_WSTAWIENIE_SLUPKA[1] + $wstawienie_slupka_ilosc + $wstawienie_slupka_ruchomego_ilosc;
					break;
				case 2:
					$ILOSC_WSTAWIENIE_SLUPKA[2] = $ILOSC_WSTAWIENIE_SLUPKA[2] + $wstawienie_slupka_ilosc + $wstawienie_slupka_ruchomego_ilosc;
					break;
				case 3:
					$ILOSC_WSTAWIENIE_SLUPKA[3] = $ILOSC_WSTAWIENIE_SLUPKA[3] + $wstawienie_slupka_ilosc + $wstawienie_slupka_ruchomego_ilosc;
					break;
				case 4:
					$ILOSC_WSTAWIENIE_SLUPKA[4] = $ILOSC_WSTAWIENIE_SLUPKA[4] + $wstawienie_slupka_ilosc + $wstawienie_slupka_ruchomego_ilosc;
					break;
				case 5:
					$ILOSC_WSTAWIENIE_SLUPKA[5] = $ILOSC_WSTAWIENIE_SLUPKA[5] + $wstawienie_slupka_ilosc + $wstawienie_slupka_ruchomego_ilosc;
					break;
				case 6:
					$ILOSC_WSTAWIENIE_SLUPKA[6] = $ILOSC_WSTAWIENIE_SLUPKA[6] + $wstawienie_slupka_ilosc + $wstawienie_slupka_ruchomego_ilosc;
					break;
				case 7:
					$ILOSC_WSTAWIENIE_SLUPKA[7] = $ILOSC_WSTAWIENIE_SLUPKA[7] + $wstawienie_slupka_ilosc + $wstawienie_slupka_ruchomego_ilosc;
					break;
				case 8:
					$ILOSC_WSTAWIENIE_SLUPKA[8] = $ILOSC_WSTAWIENIE_SLUPKA[8] + $wstawienie_slupka_ilosc + $wstawienie_slupka_ruchomego_ilosc;
					break;
				case 9:
					$ILOSC_WSTAWIENIE_SLUPKA[9] = $ILOSC_WSTAWIENIE_SLUPKA[9] + $wstawienie_slupka_ilosc + $wstawienie_slupka_ruchomego_ilosc;
					break;
				case 10:
					$ILOSC_WSTAWIENIE_SLUPKA[10] = $ILOSC_WSTAWIENIE_SLUPKA[10] + $wstawienie_slupka_ilosc + $wstawienie_slupka_ruchomego_ilosc;
					break;
				case 11:
					$ILOSC_WSTAWIENIE_SLUPKA[11] = $ILOSC_WSTAWIENIE_SLUPKA[11] + $wstawienie_slupka_ilosc + $wstawienie_slupka_ruchomego_ilosc;
					break;
				case 12:
					$ILOSC_WSTAWIENIE_SLUPKA[12] = $ILOSC_WSTAWIENIE_SLUPKA[12] + $wstawienie_slupka_ilosc + $wstawienie_slupka_ruchomego_ilosc;
					break;
			}		
		}

	$ILOSC_SUMA = 0;
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$ILOSC_WSTAWIENIE_SLUPKA[$z] = number_format($ILOSC_WSTAWIENIE_SLUPKA[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'">'.$ILOSC_WSTAWIENIE_SLUPKA[$z].'</td>';
		if($ILOSC_WSTAWIENIE_SLUPKA[$z] != 0) $na_ile_dzielic++;
		$ILOSC_SUMA += $ILOSC_WSTAWIENIE_SLUPKA[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$ILOSC_SREDNIA = $ILOSC_SUMA/$na_ile_dzielic;
		$ILOSC_SREDNIA = number_format($ILOSC_SREDNIA, 2,'.',' ');
		$ILOSC_SUMA = number_format($ILOSC_SUMA, 2,'.',' ');
		echo '<td align="center" bgcolor="'.$kolor_tla.'">'.$ILOSC_SREDNIA.'</td></tr>';
	
	
	// ##############################################################################################################################################################################	
		
	$CENA_WSTAWIENIE_SLUPKA_SUMA = 0;
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		if($ILOSC_WSTAWIENIE_SLUPKA[$z] != 0) 
			{
				$CENA_wstawienie_slupka[$z] = $WARTOSC_WSTAWIENIE_SLUPKA[$z]/$ILOSC_WSTAWIENIE_SLUPKA[$z];
				$CENA_wstawienie_slupka[$z] = number_format($CENA_wstawienie_slupka[$z], 2,'.','');
			}
		else $CENA_wstawienie_slupka[$z] = 0;
		echo '<td width="'.$szer_rozne.'" align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'">'.$CENA_wstawienie_slupka[$z].'</td>';
		if($CENA_wstawienie_slupka[$z] != 0) $na_ile_dzielic++;
		$CENA_WSTAWIENIE_SLUPKA_SUMA += $CENA_wstawienie_slupka[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$CENA_wstawienie_slupka_SREDNIA = $CENA_WSTAWIENIE_SLUPKA_SUMA/$na_ile_dzielic;
		$CENA_wstawienie_slupka_SREDNIA = number_format($CENA_wstawienie_slupka_SREDNIA, 2,'.',' ');
		$CENA_WSTAWIENIE_SLUPKA_SUMA = number_format($CENA_WSTAWIENIE_SLUPKA_SUMA, 2,'.',' ');
		echo '<td align="center" bgcolor="'.$kolor_tla.'">'.$CENA_wstawienie_slupka_SREDNIA.'</td></tr>';



	// ##############################################################################################################################################################################	
	// ###########################################################		   listwa_przyszybowa_wartosc 					###################################################################################	
	// ##############################################################################################################################################################################	
	$kolor_tla = $kolor_bialy;
	$pytanie31 = mysqli_query($conn, "SELECT listwa_przyszybowa_wartosc, dociecie_kompletu_listew_przyszybowych_wartosc, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$listwa_przyszybowa_wartosc=$wynik31['listwa_przyszybowa_wartosc'];
		$dociecie_kompletu_listew_przyszybowych_wartosc=$wynik31['dociecie_kompletu_listew_przyszybowych_wartosc'];
		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_LISTWA_PRZYSZYBOWA[1] = $WARTOSC_LISTWA_PRZYSZYBOWA[1] + $listwa_przyszybowa_wartosc + $dociecie_kompletu_listew_przyszybowych_wartosc;
					break;
				case 2:
					$WARTOSC_LISTWA_PRZYSZYBOWA[2] = $WARTOSC_LISTWA_PRZYSZYBOWA[2] + $listwa_przyszybowa_wartosc + $dociecie_kompletu_listew_przyszybowych_wartosc;
					break;
				case 3:
					$WARTOSC_LISTWA_PRZYSZYBOWA[3] = $WARTOSC_LISTWA_PRZYSZYBOWA[3] + $listwa_przyszybowa_wartosc + $dociecie_kompletu_listew_przyszybowych_wartosc;
					break;
				case 4:
					$WARTOSC_LISTWA_PRZYSZYBOWA[4] = $WARTOSC_LISTWA_PRZYSZYBOWA[4] + $listwa_przyszybowa_wartosc + $dociecie_kompletu_listew_przyszybowych_wartosc;
					break;
				case 5:
					$WARTOSC_LISTWA_PRZYSZYBOWA[5] = $WARTOSC_LISTWA_PRZYSZYBOWA[5] + $listwa_przyszybowa_wartosc + $dociecie_kompletu_listew_przyszybowych_wartosc;
					break;
				case 6:
					$WARTOSC_LISTWA_PRZYSZYBOWA[6] = $WARTOSC_LISTWA_PRZYSZYBOWA[6] + $listwa_przyszybowa_wartosc + $dociecie_kompletu_listew_przyszybowych_wartosc;
					break;
				case 7:
					$WARTOSC_LISTWA_PRZYSZYBOWA[7] = $WARTOSC_LISTWA_PRZYSZYBOWA[7] + $listwa_przyszybowa_wartosc + $dociecie_kompletu_listew_przyszybowych_wartosc;
					break;
				case 8:
					$WARTOSC_LISTWA_PRZYSZYBOWA[8] = $WARTOSC_LISTWA_PRZYSZYBOWA[8] + $listwa_przyszybowa_wartosc + $dociecie_kompletu_listew_przyszybowych_wartosc;
					break;
				case 9:
					$WARTOSC_LISTWA_PRZYSZYBOWA[9] = $WARTOSC_LISTWA_PRZYSZYBOWA[9] + $listwa_przyszybowa_wartosc + $dociecie_kompletu_listew_przyszybowych_wartosc;
					break;
				case 10:
					$WARTOSC_LISTWA_PRZYSZYBOWA[10] = $WARTOSC_LISTWA_PRZYSZYBOWA[10] + $listwa_przyszybowa_wartosc + $dociecie_kompletu_listew_przyszybowych_wartosc;
					break;
				case 11:
					$WARTOSC_LISTWA_PRZYSZYBOWA[11] = $WARTOSC_LISTWA_PRZYSZYBOWA[11] + $listwa_przyszybowa_wartosc + $dociecie_kompletu_listew_przyszybowych_wartosc;
					break;
				case 12:
					$WARTOSC_LISTWA_PRZYSZYBOWA[12] = $WARTOSC_LISTWA_PRZYSZYBOWA[12] + $listwa_przyszybowa_wartosc + $dociecie_kompletu_listew_przyszybowych_wartosc;
					break;
			}		
		}
		
	$WARTOSC_SUMA = 0;
	echo '<tr align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_tla.'" rowspan="3" align="left">'.$kol_wartosc.' | '.$kol_ilosc.' | cena docięcie listwy przyszybowej</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_LISTWA_PRZYSZYBOWA[$z] = number_format($WARTOSC_LISTWA_PRZYSZYBOWA[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_tla.'">'.$WARTOSC_LISTWA_PRZYSZYBOWA[$z].'</td>';
		if($WARTOSC_LISTWA_PRZYSZYBOWA[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA += $WARTOSC_LISTWA_PRZYSZYBOWA[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$WARTOSC_SREDNIA = $WARTOSC_SUMA/$na_ile_dzielic;
		$WARTOSC_SREDNIA = number_format($WARTOSC_SREDNIA, 2,'.',' ');
		$WARTOSC_SUMA = number_format($WARTOSC_SUMA, 2,'.',' ');
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SREDNIA.'</td>';
		echo '<td rowspan="3" bgcolor="'.$kolor_tla.'">'.$WARTOSC_SUMA.'</td></tr>';

	// ##############################################################################################################################################################################	
	$pytanie31 = mysqli_query($conn, "SELECT listwa_przyszybowa_ilosc, dociecie_kompletu_listew_przyszybowych_ilosc, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$listwa_przyszybowa_ilosc=$wynik31['listwa_przyszybowa_ilosc'];
		$dociecie_kompletu_listew_przyszybowych_ilosc=$wynik31['dociecie_kompletu_listew_przyszybowych_ilosc'];
		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$ILOSC_LISTWA_PRZYSZYBOWA[1] = $ILOSC_LISTWA_PRZYSZYBOWA[1] + $listwa_przyszybowa_ilosc + $dociecie_kompletu_listew_przyszybowych_ilosc;
					break;
				case 2:
					$ILOSC_LISTWA_PRZYSZYBOWA[2] = $ILOSC_LISTWA_PRZYSZYBOWA[2] + $listwa_przyszybowa_ilosc + $dociecie_kompletu_listew_przyszybowych_ilosc;
					break;
				case 3:
					$ILOSC_LISTWA_PRZYSZYBOWA[3] = $ILOSC_LISTWA_PRZYSZYBOWA[3] + $listwa_przyszybowa_ilosc + $dociecie_kompletu_listew_przyszybowych_ilosc;
					break;
				case 4:
					$ILOSC_LISTWA_PRZYSZYBOWA[4] = $ILOSC_LISTWA_PRZYSZYBOWA[4] + $listwa_przyszybowa_ilosc + $dociecie_kompletu_listew_przyszybowych_ilosc;
					break;
				case 5:
					$ILOSC_LISTWA_PRZYSZYBOWA[5] = $ILOSC_LISTWA_PRZYSZYBOWA[5] + $listwa_przyszybowa_ilosc + $dociecie_kompletu_listew_przyszybowych_ilosc;
					break;
				case 6:
					$ILOSC_LISTWA_PRZYSZYBOWA[6] = $ILOSC_LISTWA_PRZYSZYBOWA[6] + $listwa_przyszybowa_ilosc + $dociecie_kompletu_listew_przyszybowych_ilosc;
					break;
				case 7:
					$ILOSC_LISTWA_PRZYSZYBOWA[7] = $ILOSC_LISTWA_PRZYSZYBOWA[7] + $listwa_przyszybowa_ilosc + $dociecie_kompletu_listew_przyszybowych_ilosc;
					break;
				case 8:
					$ILOSC_LISTWA_PRZYSZYBOWA[8] = $ILOSC_LISTWA_PRZYSZYBOWA[8] + $listwa_przyszybowa_ilosc + $dociecie_kompletu_listew_przyszybowych_ilosc;
					break;
				case 9:
					$ILOSC_LISTWA_PRZYSZYBOWA[9] = $ILOSC_LISTWA_PRZYSZYBOWA[9] + $listwa_przyszybowa_ilosc + $dociecie_kompletu_listew_przyszybowych_ilosc;
					break;
				case 10:
					$ILOSC_LISTWA_PRZYSZYBOWA[10] = $ILOSC_LISTWA_PRZYSZYBOWA[10] + $listwa_przyszybowa_ilosc + $dociecie_kompletu_listew_przyszybowych_ilosc;
					break;
				case 11:
					$ILOSC_LISTWA_PRZYSZYBOWA[11] = $ILOSC_LISTWA_PRZYSZYBOWA[11] + $listwa_przyszybowa_ilosc + $dociecie_kompletu_listew_przyszybowych_ilosc;
					break;
				case 12:
					$ILOSC_LISTWA_PRZYSZYBOWA[12] = $ILOSC_LISTWA_PRZYSZYBOWA[12] + $listwa_przyszybowa_ilosc + $dociecie_kompletu_listew_przyszybowych_ilosc;
					break;
			}		
		}

	$ILOSC_SUMA = 0;
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$ILOSC_LISTWA_PRZYSZYBOWA[$z] = number_format($ILOSC_LISTWA_PRZYSZYBOWA[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'">'.$ILOSC_LISTWA_PRZYSZYBOWA[$z].'</td>';
		if($ILOSC_LISTWA_PRZYSZYBOWA[$z] != 0) $na_ile_dzielic++;
		$ILOSC_SUMA += $ILOSC_LISTWA_PRZYSZYBOWA[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$ILOSC_SREDNIA = $ILOSC_SUMA/$na_ile_dzielic;
		$ILOSC_SREDNIA = number_format($ILOSC_SREDNIA, 2,'.',' ');
		$ILOSC_SUMA = number_format($ILOSC_SUMA, 2,'.',' ');
		echo '<td align="center" bgcolor="'.$kolor_tla.'">'.$ILOSC_SREDNIA.'</td></tr>';
	
	
	// ##############################################################################################################################################################################	
		
	$CENA_LISTWA_PRZYSZYBOWA_SUMA = 0;
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		
		if($ILOSC_LISTWA_PRZYSZYBOWA[$z] != 0) 
			{
				$CENA_LISTWA_PRZYSZYBOWA[$z] = $WARTOSC_LISTWA_PRZYSZYBOWA[$z]/$ILOSC_LISTWA_PRZYSZYBOWA[$z];
				$CENA_LISTWA_PRZYSZYBOWA[$z] = number_format($CENA_LISTWA_PRZYSZYBOWA[$z], 2,'.','');
			}
		else $CENA_LISTWA_PRZYSZYBOWA[$z] = 0;
		echo '<td width="'.$szer_rozne.'" align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'">'.$CENA_LISTWA_PRZYSZYBOWA[$z].'</td>';
		if($CENA_LISTWA_PRZYSZYBOWA[$z] != 0) $na_ile_dzielic++;
		$CENA_LISTWA_PRZYSZYBOWA_SUMA += $CENA_LISTWA_PRZYSZYBOWA[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$CENA_LISTWA_PRZYSZYBOWA_SREDNIA = $CENA_LISTWA_PRZYSZYBOWA_SUMA/$na_ile_dzielic;
		$CENA_LISTWA_PRZYSZYBOWA_SREDNIA = number_format($CENA_LISTWA_PRZYSZYBOWA_SREDNIA, 2,'.',' ');
		$CENA_LISTWA_PRZYSZYBOWA_SUMA = number_format($CENA_LISTWA_PRZYSZYBOWA_SUMA, 2,'.',' ');
		echo '<td align="center" bgcolor="'.$kolor_tla.'">'.$CENA_LISTWA_PRZYSZYBOWA_SREDNIA.'</td></tr>';

	// ##############################################################################################################################################################################	
	// ###########################################################		   okucie_wartosc 					###################################################################################	
	// ##############################################################################################################################################################################	
	$kolor_tla = $kolor_szary;
	$pytanie31 = mysqli_query($conn, "SELECT okucie_wartosc, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$okucie_wartosc=$wynik31['okucie_wartosc'];
		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_okucie[1] = $WARTOSC_okucie[1] + $okucie_wartosc;
					break;
				case 2:
					$WARTOSC_okucie[2] = $WARTOSC_okucie[2] + $okucie_wartosc;
					break;
				case 3:
					$WARTOSC_okucie[3] = $WARTOSC_okucie[3] + $okucie_wartosc;
					break;
				case 4:
					$WARTOSC_okucie[4] = $WARTOSC_okucie[4] + $okucie_wartosc;
					break;
				case 5:
					$WARTOSC_okucie[5] = $WARTOSC_okucie[5] + $okucie_wartosc;
					break;
				case 6:
					$WARTOSC_okucie[6] = $WARTOSC_okucie[6] + $okucie_wartosc;
					break;
				case 7:
					$WARTOSC_okucie[7] = $WARTOSC_okucie[7] + $okucie_wartosc;
					break;
				case 8:
					$WARTOSC_okucie[8] = $WARTOSC_okucie[8] + $okucie_wartosc;
					break;
				case 9:
					$WARTOSC_okucie[9] = $WARTOSC_okucie[9] + $okucie_wartosc;
					break;
				case 10:
					$WARTOSC_okucie[10] = $WARTOSC_okucie[10] + $okucie_wartosc;
					break;
				case 11:
					$WARTOSC_okucie[11] = $WARTOSC_okucie[11] + $okucie_wartosc;
					break;
				case 12:
					$WARTOSC_okucie[12] = $WARTOSC_okucie[12] + $okucie_wartosc;
					break;
			}		
		}

	$WARTOSC_SUMA = 0;
	echo '<tr align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_tla.'" rowspan="3" align="left">'.$kol_wartosc.' | '.$kol_ilosc.' | cena okucie</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_okucie[$z] = number_format($WARTOSC_okucie[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_tla.'">'.$WARTOSC_okucie[$z].'</td>';
		if($WARTOSC_okucie[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA += $WARTOSC_okucie[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$WARTOSC_SREDNIA = $WARTOSC_SUMA/$na_ile_dzielic;
		$WARTOSC_SREDNIA = number_format($WARTOSC_SREDNIA, 2,'.',' ');
		$WARTOSC_SUMA = number_format($WARTOSC_SUMA, 2,'.',' ');
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SREDNIA.'</td>';
		echo '<td rowspan="3" bgcolor="'.$kolor_tla.'">'.$WARTOSC_SUMA.'</td></tr>';

	// ##############################################################################################################################################################################	
	$pytanie31 = mysqli_query($conn, "SELECT okucie_ilosc, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$okucie_ilosc=$wynik31['okucie_ilosc'];
		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$ILOSC_okucie[1] = $ILOSC_okucie[1] + $okucie_ilosc;
					break;
				case 2:
					$ILOSC_okucie[2] = $ILOSC_okucie[2] + $okucie_ilosc;
					break;
				case 3:
					$ILOSC_okucie[3] = $ILOSC_okucie[3] + $okucie_ilosc;
					break;
				case 4:
					$ILOSC_okucie[4] = $ILOSC_okucie[4] + $okucie_ilosc;
					break;
				case 5:
					$ILOSC_okucie[5] = $ILOSC_okucie[5] + $okucie_ilosc;
					break;
				case 6:
					$ILOSC_okucie[6] = $ILOSC_okucie[6] + $okucie_ilosc;
					break;
				case 7:
					$ILOSC_okucie[7] = $ILOSC_okucie[7] + $okucie_ilosc;
					break;
				case 8:
					$ILOSC_okucie[8] = $ILOSC_okucie[8] + $okucie_ilosc;
					break;
				case 9:
					$ILOSC_okucie[9] = $ILOSC_okucie[9] + $okucie_ilosc;
					break;
				case 10:
					$ILOSC_okucie[10] = $ILOSC_okucie[10] + $okucie_ilosc;
					break;
				case 11:
					$ILOSC_okucie[11] = $ILOSC_okucie[11] + $okucie_ilosc;
					break;
				case 12:
					$ILOSC_okucie[12] = $ILOSC_okucie[12] + $okucie_ilosc;
					break;
			}		
		}

	$ILOSC_SUMA = 0;
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$ILOSC_okucie[$z] = number_format($ILOSC_okucie[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'">'.$ILOSC_okucie[$z].'</td>';
		if($ILOSC_okucie[$z] != 0) $na_ile_dzielic++;
		$ILOSC_SUMA += $ILOSC_okucie[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$ILOSC_SREDNIA = $ILOSC_SUMA/$na_ile_dzielic;
		$ILOSC_SREDNIA = number_format($ILOSC_SREDNIA, 2,'.',' ');
		$ILOSC_SUMA = number_format($ILOSC_SUMA, 2,'.',' ');
		echo '<td align="center" bgcolor="'.$kolor_tla.'">'.$ILOSC_SREDNIA.'</td></tr>';
	
	
	// ##############################################################################################################################################################################	
		
	$CENA_okucie_SUMA = 0;
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		
		if($ILOSC_okucie[$z] != 0) 
			{
				$CENA_okucie[$z] = $WARTOSC_okucie[$z]/$ILOSC_okucie[$z];
				$CENA_okucie[$z] = number_format($CENA_okucie[$z], 2,'.','');
			}
		else $CENA_okucie[$z] = 0;
		echo '<td width="'.$szer_rozne.'" align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'">'.$CENA_okucie[$z].'</td>';
		if($CENA_okucie[$z] != 0) $na_ile_dzielic++;
		$CENA_okucie_SUMA += $CENA_okucie[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$CENA_okucie_SREDNIA = $CENA_okucie_SUMA/$na_ile_dzielic;
		$CENA_okucie_SREDNIA = number_format($CENA_okucie_SREDNIA, 2,'.',' ');
		$CENA_okucie_SUMA = number_format($CENA_okucie_SUMA, 2,'.',' ');
		echo '<td align="center" bgcolor="'.$kolor_tla.'">'.$CENA_okucie_SREDNIA.'</td></tr>';


	// ##############################################################################################################################################################################	
	// ###########################################################		   zaszklenie_wartosc 					###################################################################################	
	// ##############################################################################################################################################################################	
	$kolor_tla = $kolor_bialy;
	$pytanie31 = mysqli_query($conn, "SELECT zaszklenie_wartosc, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$zaszklenie_wartosc=$wynik31['zaszklenie_wartosc'];

		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_zaszklenie[1] = $WARTOSC_zaszklenie[1] + $zaszklenie_wartosc;
					break;
				case 2:
					$WARTOSC_zaszklenie[2] = $WARTOSC_zaszklenie[2] + $zaszklenie_wartosc;
					break;
				case 3:
					$WARTOSC_zaszklenie[3] = $WARTOSC_zaszklenie[3] + $zaszklenie_wartosc;
					break;
				case 4:
					$WARTOSC_zaszklenie[4] = $WARTOSC_zaszklenie[4] + $zaszklenie_wartosc;
					break;
				case 5:
					$WARTOSC_zaszklenie[5] = $WARTOSC_zaszklenie[5] + $zaszklenie_wartosc;
					break;
				case 6:
					$WARTOSC_zaszklenie[6] = $WARTOSC_zaszklenie[6] + $zaszklenie_wartosc;
					break;
				case 7:
					$WARTOSC_zaszklenie[7] = $WARTOSC_zaszklenie[7] + $zaszklenie_wartosc;
					break;
				case 8:
					$WARTOSC_zaszklenie[8] = $WARTOSC_zaszklenie[8] + $zaszklenie_wartosc;
					break;
				case 9:
					$WARTOSC_zaszklenie[9] = $WARTOSC_zaszklenie[9] + $zaszklenie_wartosc;
					break;
				case 10:
					$WARTOSC_zaszklenie[10] = $WARTOSC_zaszklenie[10] + $zaszklenie_wartosc;
					break;
				case 11:
					$WARTOSC_zaszklenie[11] = $WARTOSC_zaszklenie[11] + $zaszklenie_wartosc;
					break;
				case 12:
					$WARTOSC_zaszklenie[12] = $WARTOSC_zaszklenie[12] + $zaszklenie_wartosc;
					break;
			}		
		}
		
	$WARTOSC_SUMA = 0;
	echo '<tr align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_tla.'" rowspan="3" align="left">'.$kol_wartosc.' | '.$kol_ilosc.' | cena zaszklenie</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_zaszklenie[$z] = number_format($WARTOSC_zaszklenie[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_tla.'">'.$WARTOSC_zaszklenie[$z].'</td>';
		if($WARTOSC_zaszklenie[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA += $WARTOSC_zaszklenie[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$WARTOSC_SREDNIA = $WARTOSC_SUMA/$na_ile_dzielic;
		$WARTOSC_SREDNIA = number_format($WARTOSC_SREDNIA, 2,'.',' ');
		$WARTOSC_SUMA = number_format($WARTOSC_SUMA, 2,'.',' ');
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SREDNIA.'</td>';
		echo '<td rowspan="3" bgcolor="'.$kolor_tla.'">'.$WARTOSC_SUMA.'</td></tr>';

	// ##############################################################################################################################################################################	
	$pytanie31 = mysqli_query($conn, "SELECT zaszklenie_ilosc, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$zaszklenie_ilosc=$wynik31['zaszklenie_ilosc'];
		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$ILOSC_zaszklenie[1] = $ILOSC_zaszklenie[1] + $zaszklenie_ilosc;
					break;
				case 2:
					$ILOSC_zaszklenie[2] = $ILOSC_zaszklenie[2] + $zaszklenie_ilosc;
					break;
				case 3:
					$ILOSC_zaszklenie[3] = $ILOSC_zaszklenie[3] + $zaszklenie_ilosc;
					break;
				case 4:
					$ILOSC_zaszklenie[4] = $ILOSC_zaszklenie[4] + $zaszklenie_ilosc;
					break;
				case 5:
					$ILOSC_zaszklenie[5] = $ILOSC_zaszklenie[5] + $zaszklenie_ilosc;
					break;
				case 6:
					$ILOSC_zaszklenie[6] = $ILOSC_zaszklenie[6] + $zaszklenie_ilosc;
					break;
				case 7:
					$ILOSC_zaszklenie[7] = $ILOSC_zaszklenie[7] + $zaszklenie_ilosc;
					break;
				case 8:
					$ILOSC_zaszklenie[8] = $ILOSC_zaszklenie[8] + $zaszklenie_ilosc;
					break;
				case 9:
					$ILOSC_zaszklenie[9] = $ILOSC_zaszklenie[9] + $zaszklenie_ilosc;
					break;
				case 10:
					$ILOSC_zaszklenie[10] = $ILOSC_zaszklenie[10] + $zaszklenie_ilosc;
					break;
				case 11:
					$ILOSC_zaszklenie[11] = $ILOSC_zaszklenie[11] + $zaszklenie_ilosc;
					break;
				case 12:
					$ILOSC_zaszklenie[12] = $ILOSC_zaszklenie[12] + $zaszklenie_ilosc;
					break;
			}		
		}


	$ILOSC_SUMA = 0;
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$ILOSC_zaszklenie[$z] = number_format($ILOSC_zaszklenie[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'">'.$ILOSC_zaszklenie[$z].'</td>';
		if($ILOSC_zaszklenie[$z] != 0) $na_ile_dzielic++;
		$ILOSC_SUMA += $ILOSC_zaszklenie[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$ILOSC_SREDNIA = $ILOSC_SUMA/$na_ile_dzielic;
		$ILOSC_SREDNIA = number_format($ILOSC_SREDNIA, 2,'.',' ');
		$ILOSC_SUMA = number_format($ILOSC_SUMA, 2,'.',' ');
		echo '<td align="center" bgcolor="'.$kolor_tla.'">'.$ILOSC_SREDNIA.'</td></tr>';
	
	
	// ##############################################################################################################################################################################	
		
	$CENA_zaszklenie_SUMA = 0;
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		
		if($ILOSC_zaszklenie[$z] != 0) 
			{
				$CENA_zaszklenie[$z] = $WARTOSC_zaszklenie[$z]/$ILOSC_zaszklenie[$z];
				$CENA_zaszklenie[$z] = number_format($CENA_zaszklenie[$z], 2,'.',' ');
			}
		else $CENA_zaszklenie[$z] = 0;
		echo '<td width="'.$szer_rozne.'" align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'">'.$CENA_zaszklenie[$z].'</td>';
		if($CENA_zaszklenie[$z] != 0) $na_ile_dzielic++;
		$CENA_zaszklenie_SUMA += $CENA_zaszklenie[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$CENA_zaszklenie_SREDNIA = $CENA_zaszklenie_SUMA/$na_ile_dzielic;
		$CENA_zaszklenie_SREDNIA = number_format($CENA_zaszklenie_SREDNIA, 2,'.',' ');
		$CENA_zaszklenie_SUMA = number_format($CENA_zaszklenie_SUMA, 2,'.',' ');
		echo '<td align="center" bgcolor="'.$kolor_tla.'">'.$CENA_zaszklenie_SREDNIA.'</td></tr>';




	// ##############################################################################################################################################################################	
	// ###########################################################		   materiał					###################################################################################	
	// ##############################################################################################################################################################################	
	$kolor_tla = $kolor_szary;
	$pytanie31 = mysqli_query($conn, "SELECT oscieznica_wartosc, skrzydlo_wartosc, listwa_wartosc, slupek_wartosc, wzmocnienie_ramy_wartosc, wzmocnienie_skrzydla_wartosc, wzmocnienie_slupka_wartosc, wzmocnienie_luku_wartosc, okucia_wartosc, szyby_wartosc, inny_element_wartosc, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$oscieznica_wartosc=$wynik31['oscieznica_wartosc'];
		$skrzydlo_wartosc=$wynik31['skrzydlo_wartosc'];
		$listwa_wartosc=$wynik31['listwa_wartosc'];
		$slupek_wartosc=$wynik31['slupek_wartosc'];
		
		$wzmocnienie_ramy_wartosc=$wynik31['wzmocnienie_ramy_wartosc'];
		$wzmocnienie_skrzydla_wartosc=$wynik31['wzmocnienie_skrzydla_wartosc'];
		$wzmocnienie_slupka_wartosc=$wynik31['wzmocnienie_slupka_wartosc'];
		$wzmocnienie_luku_wartosc=$wynik31['wzmocnienie_luku_wartosc'];
		
		$okucia_wartosc=$wynik31['okucia_wartosc'];
		$szyby_wartosc=$wynik31['szyby_wartosc'];
		$inny_element_wartosc=$wynik31['inny_element_wartosc'];
		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_MATERIAL[1] = $WARTOSC_MATERIAL[1] + $oscieznica_wartosc + $skrzydlo_wartosc + $listwa_wartosc + $slupek_wartosc + $wzmocnienie_ramy_wartosc + $wzmocnienie_skrzydla_wartosc + $wzmocnienie_slupka_wartosc + $wzmocnienie_luku_wartosc + $okucia_wartosc + $szyby_wartosc + $inny_element_wartosc;
					break;
				case 2:
					$WARTOSC_MATERIAL[2] = $WARTOSC_MATERIAL[2] + $oscieznica_wartosc + $skrzydlo_wartosc + $listwa_wartosc + $slupek_wartosc + $wzmocnienie_ramy_wartosc + $wzmocnienie_skrzydla_wartosc + $wzmocnienie_slupka_wartosc + $wzmocnienie_luku_wartosc + $okucia_wartosc + $szyby_wartosc + $inny_element_wartosc;
					break;
				case 3:
					$WARTOSC_MATERIAL[3] = $WARTOSC_MATERIAL[3] + $oscieznica_wartosc + $skrzydlo_wartosc + $listwa_wartosc + $slupek_wartosc + $wzmocnienie_ramy_wartosc + $wzmocnienie_skrzydla_wartosc + $wzmocnienie_slupka_wartosc + $wzmocnienie_luku_wartosc + $okucia_wartosc + $szyby_wartosc + $inny_element_wartosc;
					break;
				case 4:
					$WARTOSC_MATERIAL[4] = $WARTOSC_MATERIAL[4] + $oscieznica_wartosc + $skrzydlo_wartosc + $listwa_wartosc + $slupek_wartosc + $wzmocnienie_ramy_wartosc + $wzmocnienie_skrzydla_wartosc + $wzmocnienie_slupka_wartosc + $wzmocnienie_luku_wartosc + $okucia_wartosc + $szyby_wartosc + $inny_element_wartosc;
					break;
				case 5:
					$WARTOSC_MATERIAL[5] = $WARTOSC_MATERIAL[5] + $oscieznica_wartosc + $skrzydlo_wartosc + $listwa_wartosc + $slupek_wartosc + $wzmocnienie_ramy_wartosc + $wzmocnienie_skrzydla_wartosc + $wzmocnienie_slupka_wartosc + $wzmocnienie_luku_wartosc + $okucia_wartosc + $szyby_wartosc + $inny_element_wartosc;
					break;
				case 6:
					$WARTOSC_MATERIAL[6] = $WARTOSC_MATERIAL[6] + $oscieznica_wartosc + $skrzydlo_wartosc + $listwa_wartosc + $slupek_wartosc + $wzmocnienie_ramy_wartosc + $wzmocnienie_skrzydla_wartosc + $wzmocnienie_slupka_wartosc + $wzmocnienie_luku_wartosc + $okucia_wartosc + $szyby_wartosc + $inny_element_wartosc;
					break;
				case 7:
					$WARTOSC_MATERIAL[7] = $WARTOSC_MATERIAL[7] + $oscieznica_wartosc + $skrzydlo_wartosc + $listwa_wartosc + $slupek_wartosc + $wzmocnienie_ramy_wartosc + $wzmocnienie_skrzydla_wartosc + $wzmocnienie_slupka_wartosc + $wzmocnienie_luku_wartosc + $okucia_wartosc + $szyby_wartosc + $inny_element_wartosc;
					break;
				case 8:
					$WARTOSC_MATERIAL[8] = $WARTOSC_MATERIAL[8] + $oscieznica_wartosc + $skrzydlo_wartosc + $listwa_wartosc + $slupek_wartosc + $wzmocnienie_ramy_wartosc + $wzmocnienie_skrzydla_wartosc + $wzmocnienie_slupka_wartosc + $wzmocnienie_luku_wartosc + $okucia_wartosc + $szyby_wartosc + $inny_element_wartosc;
					break;
				case 9:
					$WARTOSC_MATERIAL[9] = $WARTOSC_MATERIAL[9] + $oscieznica_wartosc + $skrzydlo_wartosc + $listwa_wartosc + $slupek_wartosc + $wzmocnienie_ramy_wartosc + $wzmocnienie_skrzydla_wartosc + $wzmocnienie_slupka_wartosc + $wzmocnienie_luku_wartosc + $okucia_wartosc + $szyby_wartosc + $inny_element_wartosc;
					break;
				case 10:
					$WARTOSC_MATERIAL[10] = $WARTOSC_MATERIAL[10] + $oscieznica_wartosc + $skrzydlo_wartosc + $listwa_wartosc + $slupek_wartosc + $wzmocnienie_ramy_wartosc + $wzmocnienie_skrzydla_wartosc + $wzmocnienie_slupka_wartosc + $wzmocnienie_luku_wartosc + $okucia_wartosc + $szyby_wartosc + $inny_element_wartosc;
					break;
				case 11:
					$WARTOSC_MATERIAL[11] = $WARTOSC_MATERIAL[11] + $oscieznica_wartosc + $skrzydlo_wartosc + $listwa_wartosc + $slupek_wartosc + $wzmocnienie_ramy_wartosc + $wzmocnienie_skrzydla_wartosc + $wzmocnienie_slupka_wartosc + $wzmocnienie_luku_wartosc + $okucia_wartosc + $szyby_wartosc + $inny_element_wartosc;
					break;
				case 12:
					$WARTOSC_MATERIAL[12] = $WARTOSC_MATERIAL[12] + $oscieznica_wartosc + $skrzydlo_wartosc + $listwa_wartosc + $slupek_wartosc + $wzmocnienie_ramy_wartosc + $wzmocnienie_skrzydla_wartosc + $wzmocnienie_slupka_wartosc + $wzmocnienie_luku_wartosc + $okucia_wartosc + $szyby_wartosc + $inny_element_wartosc;
					break;
			}		
		}
		
	$WARTOSC_SUMA = 0;
	echo '<tr align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_tla.'" align="left">'.$kol_wartosc.' materiał</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_MATERIAL[$z] = number_format($WARTOSC_MATERIAL[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_tla.'">'.$WARTOSC_MATERIAL[$z].'</td>';
		if($WARTOSC_MATERIAL[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA += $WARTOSC_MATERIAL[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$WARTOSC_SREDNIA = $WARTOSC_SUMA/$na_ile_dzielic;
		$WARTOSC_SREDNIA = number_format($WARTOSC_SREDNIA, 2,'.',' ');
		$WARTOSC_SUMA = number_format($WARTOSC_SUMA, 2,'.',' ');
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SREDNIA.'</td>';
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SUMA.'</td></tr>';


	// ##############################################################################################################################################################################	
	// ###########################################################		   okna 					###################################################################################	
	// ##############################################################################################################################################################################	
	$kolor_tla = $kolor_bialy;
	$pytanie31 = mysqli_query($conn, "SELECT okna, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$okna=$wynik31['okna'];
		

		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_okna[1] = $WARTOSC_okna[1] + $okna;
					break;
				case 2:
					$WARTOSC_okna[2] = $WARTOSC_okna[2] + $okna;
					break;
				case 3:
					$WARTOSC_okna[3] = $WARTOSC_okna[3] + $okna;
					break;
				case 4:
					$WARTOSC_okna[4] = $WARTOSC_okna[4] + $okna;
					break;
				case 5:
					$WARTOSC_okna[5] = $WARTOSC_okna[5] + $okna;
					break;
				case 6:
					$WARTOSC_okna[6] = $WARTOSC_okna[6] + $okna;
					break;
				case 7:
					$WARTOSC_okna[7] = $WARTOSC_okna[7] + $okna;
					break;
				case 8:
					$WARTOSC_okna[8] = $WARTOSC_okna[8] + $okna;
					break;
				case 9:
					$WARTOSC_okna[9] = $WARTOSC_okna[9] + $okna;
					break;
				case 10:
					$WARTOSC_okna[10] = $WARTOSC_okna[10] + $okna;
					break;
				case 11:
					$WARTOSC_okna[11] = $WARTOSC_okna[11] + $okna;
					break;
				case 12:
					$WARTOSC_okna[12] = $WARTOSC_okna[12] + $okna;
					break;
			}		
		}
		
	$WARTOSC_SUMA = 0;
	echo '<tr align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_tla.'" align="left">'.$kol_wartosc.' okna</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_okna[$z] = number_format($WARTOSC_okna[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_tla.'">'.$WARTOSC_okna[$z].'</td>';
		if($WARTOSC_okna[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA += $WARTOSC_okna[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$WARTOSC_SREDNIA = $WARTOSC_SUMA/$na_ile_dzielic;
		$WARTOSC_SREDNIA = number_format($WARTOSC_SREDNIA, 2,'.',' ');
		$WARTOSC_SUMA = number_format($WARTOSC_SUMA, 2,'.',' ');
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SREDNIA.'</td>';
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SUMA.'</td></tr>';
	// ##############################################################################################################################################################################	
	// ###########################################################		   drzwi wewnetrzne 					###################################################################################	
	// ##############################################################################################################################################################################	
	$kolor_tla = $kolor_szary;
	$pytanie31 = mysqli_query($conn, "SELECT drzwi_wewnetrzne, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$drzwi_wewnetrzne=$wynik31['drzwi_wewnetrzne'];
		
		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_drzwi_wewnetrzne[1] = $WARTOSC_drzwi_wewnetrzne[1] + $drzwi_wewnetrzne;
					break;
				case 2:
					$WARTOSC_drzwi_wewnetrzne[2] = $WARTOSC_drzwi_wewnetrzne[2] + $drzwi_wewnetrzne;
					break;
				case 3:
					$WARTOSC_drzwi_wewnetrzne[3] = $WARTOSC_drzwi_wewnetrzne[3] + $drzwi_wewnetrzne;
					break;
				case 4:
					$WARTOSC_drzwi_wewnetrzne[4] = $WARTOSC_drzwi_wewnetrzne[4] + $drzwi_wewnetrzne;
					break;
				case 5:
					$WARTOSC_drzwi_wewnetrzne[5] = $WARTOSC_drzwi_wewnetrzne[5] + $drzwi_wewnetrzne;
					break;
				case 6:
					$WARTOSC_drzwi_wewnetrzne[6] = $WARTOSC_drzwi_wewnetrzne[6] + $drzwi_wewnetrzne;
					break;
				case 7:
					$WARTOSC_drzwi_wewnetrzne[7] = $WARTOSC_drzwi_wewnetrzne[7] + $drzwi_wewnetrzne;
					break;
				case 8:
					$WARTOSC_drzwi_wewnetrzne[8] = $WARTOSC_drzwi_wewnetrzne[8] + $drzwi_wewnetrzne;
					break;
				case 9:
					$WARTOSC_drzwi_wewnetrzne[9] = $WARTOSC_drzwi_wewnetrzne[9] + $drzwi_wewnetrzne;
					break;
				case 10:
					$WARTOSC_drzwi_wewnetrzne[10] = $WARTOSC_drzwi_wewnetrzne[10] + $drzwi_wewnetrzne;
					break;
				case 11:
					$WARTOSC_drzwi_wewnetrzne[11] = $WARTOSC_drzwi_wewnetrzne[11] + $drzwi_wewnetrzne;
					break;
				case 12:
					$WARTOSC_drzwi_wewnetrzne[12] = $WARTOSC_drzwi_wewnetrzne[12] + $drzwi_wewnetrzne;
					break;
			}		
		}
		
	$WARTOSC_SUMA = 0;
	echo '<tr align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_tla.'" align="left">'.$kol_wartosc.' drzwi wewnętrzne</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_drzwi_wewnetrzne[$z] = number_format($WARTOSC_drzwi_wewnetrzne[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_tla.'">'.$WARTOSC_drzwi_wewnetrzne[$z].'</td>';
		if($WARTOSC_drzwi_wewnetrzne[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA += $WARTOSC_drzwi_wewnetrzne[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$WARTOSC_SREDNIA = $WARTOSC_SUMA/$na_ile_dzielic;
		$WARTOSC_SREDNIA = number_format($WARTOSC_SREDNIA, 2,'.',' ');
		$WARTOSC_SUMA = number_format($WARTOSC_SUMA, 2,'.',' ');
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SREDNIA.'</td>';
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SUMA.'</td></tr>';

	// ##############################################################################################################################################################################	
	// ###########################################################		   drzwi zewnetrzne 					###################################################################################	
	// ##############################################################################################################################################################################	
	$kolor_tla = $kolor_bialy;
	$pytanie31 = mysqli_query($conn, "SELECT drzwi_zewnetrzne, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$drzwi_zewnetrzne=$wynik31['drzwi_zewnetrzne'];
		
		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_drzwi_zewnetrzne[1] = $WARTOSC_drzwi_zewnetrzne[1] + $drzwi_zewnetrzne;
					break;
				case 2:
					$WARTOSC_drzwi_zewnetrzne[2] = $WARTOSC_drzwi_zewnetrzne[2] + $drzwi_zewnetrzne;
					break;
				case 3:
					$WARTOSC_drzwi_zewnetrzne[3] = $WARTOSC_drzwi_zewnetrzne[3] + $drzwi_zewnetrzne;
					break;
				case 4:
					$WARTOSC_drzwi_zewnetrzne[4] = $WARTOSC_drzwi_zewnetrzne[4] + $drzwi_zewnetrzne;
					break;
				case 5:
					$WARTOSC_drzwi_zewnetrzne[5] = $WARTOSC_drzwi_zewnetrzne[5] + $drzwi_zewnetrzne;
					break;
				case 6:
					$WARTOSC_drzwi_zewnetrzne[6] = $WARTOSC_drzwi_zewnetrzne[6] + $drzwi_zewnetrzne;
					break;
				case 7:
					$WARTOSC_drzwi_zewnetrzne[7] = $WARTOSC_drzwi_zewnetrzne[7] + $drzwi_zewnetrzne;
					break;
				case 8:
					$WARTOSC_drzwi_zewnetrzne[8] = $WARTOSC_drzwi_zewnetrzne[8] + $drzwi_zewnetrzne;
					break;
				case 9:
					$WARTOSC_drzwi_zewnetrzne[9] = $WARTOSC_drzwi_zewnetrzne[9] + $drzwi_zewnetrzne;
					break;
				case 10:
					$WARTOSC_drzwi_zewnetrzne[10] = $WARTOSC_drzwi_zewnetrzne[10] + $drzwi_zewnetrzne;
					break;
				case 11:
					$WARTOSC_drzwi_zewnetrzne[11] = $WARTOSC_drzwi_zewnetrzne[11] + $drzwi_zewnetrzne;
					break;
				case 12:
					$WARTOSC_drzwi_zewnetrzne[12] = $WARTOSC_drzwi_zewnetrzne[12] + $drzwi_zewnetrzne;
					break;
			}		
		}
		
	$WARTOSC_SUMA = 0;
	echo '<tr align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_tla.'" align="left">'.$kol_wartosc.' drzwi zewnętrzne</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_drzwi_zewnetrzne[$z] = number_format($WARTOSC_drzwi_zewnetrzne[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_tla.'">'.$WARTOSC_drzwi_zewnetrzne[$z].'</td>';
		if($WARTOSC_drzwi_zewnetrzne[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA += $WARTOSC_drzwi_zewnetrzne[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$WARTOSC_SREDNIA = $WARTOSC_SUMA/$na_ile_dzielic;
		$WARTOSC_SREDNIA = number_format($WARTOSC_SREDNIA, 2,'.',' ');
		$WARTOSC_SUMA = number_format($WARTOSC_SUMA, 2,'.',' ');
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SREDNIA.'</td>';
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SUMA.'</td></tr>';



	// ##############################################################################################################################################################################	
	// ###########################################################		   bramy 					###################################################################################	
	// ##############################################################################################################################################################################	
	$kolor_tla = $kolor_szary;
	$pytanie31 = mysqli_query($conn, "SELECT bramy, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$bramy=$wynik31['bramy'];
		

		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_bramy[1] = $WARTOSC_bramy[1] + $bramy;
					break;
				case 2:
					$WARTOSC_bramy[2] = $WARTOSC_bramy[2] + $bramy;
					break;
				case 3:
					$WARTOSC_bramy[3] = $WARTOSC_bramy[3] + $bramy;
					break;
				case 4:
					$WARTOSC_bramy[4] = $WARTOSC_bramy[4] + $bramy;
					break;
				case 5:
					$WARTOSC_bramy[5] = $WARTOSC_bramy[5] + $bramy;
					break;
				case 6:
					$WARTOSC_bramy[6] = $WARTOSC_bramy[6] + $bramy;
					break;
				case 7:
					$WARTOSC_bramy[7] = $WARTOSC_bramy[7] + $bramy;
					break;
				case 8:
					$WARTOSC_bramy[8] = $WARTOSC_bramy[8] + $bramy;
					break;
				case 9:
					$WARTOSC_bramy[9] = $WARTOSC_bramy[9] + $bramy;
					break;
				case 10:
					$WARTOSC_bramy[10] = $WARTOSC_bramy[10] + $bramy;
					break;
				case 11:
					$WARTOSC_bramy[11] = $WARTOSC_bramy[11] + $bramy;
					break;
				case 12:
					$WARTOSC_bramy[12] = $WARTOSC_bramy[12] + $bramy;
					break;
			}		
		}
		
	$WARTOSC_SUMA = 0;
	echo '<tr align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_tla.'" align="left">'.$kol_wartosc.' bramy</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_bramy[$z] = number_format($WARTOSC_bramy[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_tla.'">'.$WARTOSC_bramy[$z].'</td>';
		if($WARTOSC_bramy[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA += $WARTOSC_bramy[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$WARTOSC_SREDNIA = $WARTOSC_SUMA/$na_ile_dzielic;
		$WARTOSC_SREDNIA = number_format($WARTOSC_SREDNIA, 2,'.',' ');
		$WARTOSC_SUMA = number_format($WARTOSC_SUMA, 2,'.',' ');
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SREDNIA.'</td>';
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SUMA.'</td></tr>';



	// ##############################################################################################################################################################################	
	// ###########################################################		   parapety 					###################################################################################	
	// ##############################################################################################################################################################################	
	$kolor_tla = $kolor_bialy;
	$pytanie31 = mysqli_query($conn, "SELECT parapety, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$parapety=$wynik31['parapety'];
		

		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_parapety[1] = $WARTOSC_parapety[1] + $parapety;
					break;
				case 2:
					$WARTOSC_parapety[2] = $WARTOSC_parapety[2] + $parapety;
					break;
				case 3:
					$WARTOSC_parapety[3] = $WARTOSC_parapety[3] + $parapety;
					break;
				case 4:
					$WARTOSC_parapety[4] = $WARTOSC_parapety[4] + $parapety;
					break;
				case 5:
					$WARTOSC_parapety[5] = $WARTOSC_parapety[5] + $parapety;
					break;
				case 6:
					$WARTOSC_parapety[6] = $WARTOSC_parapety[6] + $parapety;
					break;
				case 7:
					$WARTOSC_parapety[7] = $WARTOSC_parapety[7] + $parapety;
					break;
				case 8:
					$WARTOSC_parapety[8] = $WARTOSC_parapety[8] + $parapety;
					break;
				case 9:
					$WARTOSC_parapety[9] = $WARTOSC_parapety[9] + $parapety;
					break;
				case 10:
					$WARTOSC_parapety[10] = $WARTOSC_parapety[10] + $parapety;
					break;
				case 11:
					$WARTOSC_parapety[11] = $WARTOSC_parapety[11] + $parapety;
					break;
				case 12:
					$WARTOSC_parapety[12] = $WARTOSC_parapety[12] + $parapety;
					break;
			}		
		}
		
	$WARTOSC_SUMA = 0;
	echo '<tr align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_tla.'" align="left">'.$kol_wartosc.' parapety</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_parapety[$z] = number_format($WARTOSC_parapety[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_tla.'">'.$WARTOSC_parapety[$z].'</td>';
		if($WARTOSC_parapety[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA += $WARTOSC_parapety[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$WARTOSC_SREDNIA = $WARTOSC_SUMA/$na_ile_dzielic;
		$WARTOSC_SREDNIA = number_format($WARTOSC_SREDNIA, 2,'.',' ');
		$WARTOSC_SUMA = number_format($WARTOSC_SUMA, 2,'.',' ');
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SREDNIA.'</td>';
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SUMA.'</td></tr>';


	// ##############################################################################################################################################################################	
	// ###########################################################		   rolety_zewnetrzne 					###################################################################################	
	// ##############################################################################################################################################################################	
	$kolor_tla = $kolor_szary;
	$pytanie31 = mysqli_query($conn, "SELECT rolety_zewnetrzne, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$rolety_zewnetrzne=$wynik31['rolety_zewnetrzne'];
		
	
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_rolety_zewnetrzne[1] = $WARTOSC_rolety_zewnetrzne[1] + $rolety_zewnetrzne;
					break;
				case 2:
					$WARTOSC_rolety_zewnetrzne[2] = $WARTOSC_rolety_zewnetrzne[2] + $rolety_zewnetrzne;
					break;
				case 3:
					$WARTOSC_rolety_zewnetrzne[3] = $WARTOSC_rolety_zewnetrzne[3] + $rolety_zewnetrzne;
					break;
				case 4:
					$WARTOSC_rolety_zewnetrzne[4] = $WARTOSC_rolety_zewnetrzne[4] + $rolety_zewnetrzne;
					break;
				case 5:
					$WARTOSC_rolety_zewnetrzne[5] = $WARTOSC_rolety_zewnetrzne[5] + $rolety_zewnetrzne;
					break;
				case 6:
					$WARTOSC_rolety_zewnetrzne[6] = $WARTOSC_rolety_zewnetrzne[6] + $rolety_zewnetrzne;
					break;
				case 7:
					$WARTOSC_rolety_zewnetrzne[7] = $WARTOSC_rolety_zewnetrzne[7] + $rolety_zewnetrzne;
					break;
				case 8:
					$WARTOSC_rolety_zewnetrzne[8] = $WARTOSC_rolety_zewnetrzne[8] + $rolety_zewnetrzne;
					break;
				case 9:
					$WARTOSC_rolety_zewnetrzne[9] = $WARTOSC_rolety_zewnetrzne[9] + $rolety_zewnetrzne;
					break;
				case 10:
					$WARTOSC_rolety_zewnetrzne[10] = $WARTOSC_rolety_zewnetrzne[10] + $rolety_zewnetrzne;
					break;
				case 11:
					$WARTOSC_rolety_zewnetrzne[11] = $WARTOSC_rolety_zewnetrzne[11] + $rolety_zewnetrzne;
					break;
				case 12:
					$WARTOSC_rolety_zewnetrzne[12] = $WARTOSC_rolety_zewnetrzne[12] + $rolety_zewnetrzne;
					break;
			}		
		}
		
	$WARTOSC_SUMA = 0;
	echo '<tr align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_tla.'" align="left">'.$kol_wartosc.' rolety zewnętrzne</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_rolety_zewnetrzne[$z] = number_format($WARTOSC_rolety_zewnetrzne[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_tla.'">'.$WARTOSC_rolety_zewnetrzne[$z].'</td>';
		if($WARTOSC_rolety_zewnetrzne[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA += $WARTOSC_rolety_zewnetrzne[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$WARTOSC_SREDNIA = $WARTOSC_SUMA/$na_ile_dzielic;
		$WARTOSC_SREDNIA = number_format($WARTOSC_SREDNIA, 2,'.',' ');
		$WARTOSC_SUMA = number_format($WARTOSC_SUMA, 2,'.',' ');
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SREDNIA.'</td>';
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SUMA.'</td></tr>';

	// ##############################################################################################################################################################################	
	// ###########################################################		   rolety_wewnetrzne 					###################################################################################	
	// ##############################################################################################################################################################################	
	$kolor_tla = $kolor_bialy;
	$pytanie31 = mysqli_query($conn, "SELECT rolety_wewnetrzne, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$rolety_wewnetrzne=$wynik31['rolety_wewnetrzne'];
		

		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_rolety_wewnetrzne[1] = $WARTOSC_rolety_wewnetrzne[1] + $rolety_wewnetrzne;
					break;
				case 2:
					$WARTOSC_rolety_wewnetrzne[2] = $WARTOSC_rolety_wewnetrzne[2] + $rolety_wewnetrzne;
					break;
				case 3:
					$WARTOSC_rolety_wewnetrzne[3] = $WARTOSC_rolety_wewnetrzne[3] + $rolety_wewnetrzne;
					break;
				case 4:
					$WARTOSC_rolety_wewnetrzne[4] = $WARTOSC_rolety_wewnetrzne[4] + $rolety_wewnetrzne;
					break;
				case 5:
					$WARTOSC_rolety_wewnetrzne[5] = $WARTOSC_rolety_wewnetrzne[5] + $rolety_wewnetrzne;
					break;
				case 6:
					$WARTOSC_rolety_wewnetrzne[6] = $WARTOSC_rolety_wewnetrzne[6] + $rolety_wewnetrzne;
					break;
				case 7:
					$WARTOSC_rolety_wewnetrzne[7] = $WARTOSC_rolety_wewnetrzne[7] + $rolety_wewnetrzne;
					break;
				case 8:
					$WARTOSC_rolety_wewnetrzne[8] = $WARTOSC_rolety_wewnetrzne[8] + $rolety_wewnetrzne;
					break;
				case 9:
					$WARTOSC_rolety_wewnetrzne[9] = $WARTOSC_rolety_wewnetrzne[9] + $rolety_wewnetrzne;
					break;
				case 10:
					$WARTOSC_rolety_wewnetrzne[10] = $WARTOSC_rolety_wewnetrzne[10] + $rolety_wewnetrzne;
					break;
				case 11:
					$WARTOSC_rolety_wewnetrzne[11] = $WARTOSC_rolety_wewnetrzne[11] + $rolety_wewnetrzne;
					break;
				case 12:
					$WARTOSC_rolety_wewnetrzne[12] = $WARTOSC_rolety_wewnetrzne[12] + $rolety_wewnetrzne;
					break;
			}		
		}
		
	$WARTOSC_SUMA = 0;
	echo '<tr align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_tla.'" align="left">'.$kol_wartosc.' rolety wewnętrzne</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_rolety_wewnetrzne[$z] = number_format($WARTOSC_rolety_wewnetrzne[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_tla.'">'.$WARTOSC_rolety_wewnetrzne[$z].'</td>';
		if($WARTOSC_rolety_wewnetrzne[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA += $WARTOSC_rolety_wewnetrzne[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$WARTOSC_SREDNIA = $WARTOSC_SUMA/$na_ile_dzielic;
		$WARTOSC_SREDNIA = number_format($WARTOSC_SREDNIA, 2,'.',' ');
		$WARTOSC_SUMA = number_format($WARTOSC_SUMA, 2,'.',' ');
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SREDNIA.'</td>';
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SUMA.'</td></tr>';

	// ##############################################################################################################################################################################	
	// ###########################################################		   moskitiery 					###################################################################################	
	// ##############################################################################################################################################################################	
	$kolor_tla = $kolor_szary;
	$pytanie31 = mysqli_query($conn, "SELECT moskitiery, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$moskitiery=$wynik31['moskitiery'];
		

		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_moskitiery[1] = $WARTOSC_moskitiery[1] + $moskitiery;
					break;
				case 2:
					$WARTOSC_moskitiery[2] = $WARTOSC_moskitiery[2] + $moskitiery;
					break;
				case 3:
					$WARTOSC_moskitiery[3] = $WARTOSC_moskitiery[3] + $moskitiery;
					break;
				case 4:
					$WARTOSC_moskitiery[4] = $WARTOSC_moskitiery[4] + $moskitiery;
					break;
				case 5:
					$WARTOSC_moskitiery[5] = $WARTOSC_moskitiery[5] + $moskitiery;
					break;
				case 6:
					$WARTOSC_moskitiery[6] = $WARTOSC_moskitiery[6] + $moskitiery;
					break;
				case 7:
					$WARTOSC_moskitiery[7] = $WARTOSC_moskitiery[7] + $moskitiery;
					break;
				case 8:
					$WARTOSC_moskitiery[8] = $WARTOSC_moskitiery[8] + $moskitiery;
					break;
				case 9:
					$WARTOSC_moskitiery[9] = $WARTOSC_moskitiery[9] + $moskitiery;
					break;
				case 10:
					$WARTOSC_moskitiery[10] = $WARTOSC_moskitiery[10] + $moskitiery;
					break;
				case 11:
					$WARTOSC_moskitiery[11] = $WARTOSC_moskitiery[11] + $moskitiery;
					break;
				case 12:
					$WARTOSC_moskitiery[12] = $WARTOSC_moskitiery[12] + $moskitiery;
					break;
			}		
		}
		
	$WARTOSC_SUMA = 0;
	echo '<tr align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_tla.'" align="left">'.$kol_wartosc.' moskitiery</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_moskitiery[$z] = number_format($WARTOSC_moskitiery[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_tla.'">'.$WARTOSC_moskitiery[$z].'</td>';
		if($WARTOSC_moskitiery[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA += $WARTOSC_moskitiery[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$WARTOSC_SREDNIA = $WARTOSC_SUMA/$na_ile_dzielic;
		$WARTOSC_SREDNIA = number_format($WARTOSC_SREDNIA, 2,'.',' ');
		$WARTOSC_SUMA = number_format($WARTOSC_SUMA, 2,'.',' ');
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SREDNIA.'</td>';
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SUMA.'</td></tr>';

	// ##############################################################################################################################################################################	
	// ###########################################################		   montaz 					###################################################################################	
	// ##############################################################################################################################################################################	
	$kolor_tla = $kolor_bialy;
	$pytanie31 = mysqli_query($conn, "SELECT montaz, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$montaz=$wynik31['montaz'];

		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_montaz[1] = $WARTOSC_montaz[1] + $montaz;
					break;
				case 2:
					$WARTOSC_montaz[2] = $WARTOSC_montaz[2] + $montaz;
					break;
				case 3:
					$WARTOSC_montaz[3] = $WARTOSC_montaz[3] + $montaz;
					break;
				case 4:
					$WARTOSC_montaz[4] = $WARTOSC_montaz[4] + $montaz;
					break;
				case 5:
					$WARTOSC_montaz[5] = $WARTOSC_montaz[5] + $montaz;
					break;
				case 6:
					$WARTOSC_montaz[6] = $WARTOSC_montaz[6] + $montaz;
					break;
				case 7:
					$WARTOSC_montaz[7] = $WARTOSC_montaz[7] + $montaz;
					break;
				case 8:
					$WARTOSC_montaz[8] = $WARTOSC_montaz[8] + $montaz;
					break;
				case 9:
					$WARTOSC_montaz[9] = $WARTOSC_montaz[9] + $montaz;
					break;
				case 10:
					$WARTOSC_montaz[10] = $WARTOSC_montaz[10] + $montaz;
					break;
				case 11:
					$WARTOSC_montaz[11] = $WARTOSC_montaz[11] + $montaz;
					break;
				case 12:
					$WARTOSC_montaz[12] = $WARTOSC_montaz[12] + $montaz;
					break;
			}		
		}
		
	$WARTOSC_SUMA = 0;
	echo '<tr align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_tla.'" align="left">'.$kol_wartosc.' montaż</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_montaz[$z] = number_format($WARTOSC_montaz[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_tla.'">'.$WARTOSC_montaz[$z].'</td>';
		if($WARTOSC_montaz[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA += $WARTOSC_montaz[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$WARTOSC_SREDNIA = $WARTOSC_SUMA/$na_ile_dzielic;
		$WARTOSC_SREDNIA = number_format($WARTOSC_SREDNIA, 2,'.',' ');
		$WARTOSC_SUMA = number_format($WARTOSC_SUMA, 2,'.',' ');
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SREDNIA.'</td>';
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SUMA.'</td></tr>';


	// ##############################################################################################################################################################################	
	// ###########################################################		   odpady_pvc 					###################################################################################	
	// ##############################################################################################################################################################################	
	$kolor_tla = $kolor_szary;
	$pytanie31 = mysqli_query($conn, "SELECT odpady_pvc, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$odpady_pvc=$wynik31['odpady_pvc'];
		

		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_odpady_pvc[1] = $WARTOSC_odpady_pvc[1] + $odpady_pvc;
					break;
				case 2:
					$WARTOSC_odpady_pvc[2] = $WARTOSC_odpady_pvc[2] + $odpady_pvc;
					break;
				case 3:
					$WARTOSC_odpady_pvc[3] = $WARTOSC_odpady_pvc[3] + $odpady_pvc;
					break;
				case 4:
					$WARTOSC_odpady_pvc[4] = $WARTOSC_odpady_pvc[4] + $odpady_pvc;
					break;
				case 5:
					$WARTOSC_odpady_pvc[5] = $WARTOSC_odpady_pvc[5] + $odpady_pvc;
					break;
				case 6:
					$WARTOSC_odpady_pvc[6] = $WARTOSC_odpady_pvc[6] + $odpady_pvc;
					break;
				case 7:
					$WARTOSC_odpady_pvc[7] = $WARTOSC_odpady_pvc[7] + $odpady_pvc;
					break;
				case 8:
					$WARTOSC_odpady_pvc[8] = $WARTOSC_odpady_pvc[8] + $odpady_pvc;
					break;
				case 9:
					$WARTOSC_odpady_pvc[9] = $WARTOSC_odpady_pvc[9] + $odpady_pvc;
					break;
				case 10:
					$WARTOSC_odpady_pvc[10] = $WARTOSC_odpady_pvc[10] + $odpady_pvc;
					break;
				case 11:
					$WARTOSC_odpady_pvc[11] = $WARTOSC_odpady_pvc[11] + $odpady_pvc;
					break;
				case 12:
					$WARTOSC_odpady_pvc[12] = $WARTOSC_odpady_pvc[12] + $odpady_pvc;
					break;
			}		
		}
		
	$WARTOSC_SUMA = 0;
	echo '<tr align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_tla.'" align="left">'.$kol_wartosc.' odpady z pvc</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_odpady_pvc[$z] = number_format($WARTOSC_odpady_pvc[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_tla.'">'.$WARTOSC_odpady_pvc[$z].'</td>';
		if($WARTOSC_odpady_pvc[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA += $WARTOSC_odpady_pvc[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$WARTOSC_SREDNIA = $WARTOSC_SUMA/$na_ile_dzielic;
		$WARTOSC_SREDNIA = number_format($WARTOSC_SREDNIA, 2,'.',' ');
		$WARTOSC_SUMA = number_format($WARTOSC_SUMA, 2,'.',' ');
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SREDNIA.'</td>';
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SUMA.'</td></tr>';


	// ##############################################################################################################################################################################	
	// ###########################################################		   odpady_alu_stal 					###################################################################################	
	// ##############################################################################################################################################################################	
	$kolor_tla = $kolor_bialy;
	$pytanie31 = mysqli_query($conn, "SELECT odpady_alu_stal, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$odpady_alu_stal=$wynik31['odpady_alu_stal'];
		



		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_odpady_alu_stal[1] = $WARTOSC_odpady_alu_stal[1] + $odpady_alu_stal;
					break;
				case 2:
					$WARTOSC_odpady_alu_stal[2] = $WARTOSC_odpady_alu_stal[2] + $odpady_alu_stal;
					break;
				case 3:
					$WARTOSC_odpady_alu_stal[3] = $WARTOSC_odpady_alu_stal[3] + $odpady_alu_stal;
					break;
				case 4:
					$WARTOSC_odpady_alu_stal[4] = $WARTOSC_odpady_alu_stal[4] + $odpady_alu_stal;
					break;
				case 5:
					$WARTOSC_odpady_alu_stal[5] = $WARTOSC_odpady_alu_stal[5] + $odpady_alu_stal;
					break;
				case 6:
					$WARTOSC_odpady_alu_stal[6] = $WARTOSC_odpady_alu_stal[6] + $odpady_alu_stal;
					break;
				case 7:
					$WARTOSC_odpady_alu_stal[7] = $WARTOSC_odpady_alu_stal[7] + $odpady_alu_stal;
					break;
				case 8:
					$WARTOSC_odpady_alu_stal[8] = $WARTOSC_odpady_alu_stal[8] + $odpady_alu_stal;
					break;
				case 9:
					$WARTOSC_odpady_alu_stal[9] = $WARTOSC_odpady_alu_stal[9] + $odpady_alu_stal;
					break;
				case 10:
					$WARTOSC_odpady_alu_stal[10] = $WARTOSC_odpady_alu_stal[10] + $odpady_alu_stal;
					break;
				case 11:
					$WARTOSC_odpady_alu_stal[11] = $WARTOSC_odpady_alu_stal[11] + $odpady_alu_stal;
					break;
				case 12:
					$WARTOSC_odpady_alu_stal[12] = $WARTOSC_odpady_alu_stal[12] + $odpady_alu_stal;
					break;
			}		
		}
		
	$WARTOSC_SUMA = 0;
	echo '<tr align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_tla.'" align="left">'.$kol_wartosc.' odpady ze stali i alu</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_odpady_alu_stal[$z] = number_format($WARTOSC_odpady_alu_stal[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_tla.'">'.$WARTOSC_odpady_alu_stal[$z].'</td>';
		if($WARTOSC_odpady_alu_stal[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA += $WARTOSC_odpady_alu_stal[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$WARTOSC_SREDNIA = $WARTOSC_SUMA/$na_ile_dzielic;
		$WARTOSC_SREDNIA = number_format($WARTOSC_SREDNIA, 2,'.',' ');
		$WARTOSC_SUMA = number_format($WARTOSC_SUMA, 2,'.',' ');
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SREDNIA.'</td>';
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SUMA.'</td></tr>';


	// ##############################################################################################################################################################################	
	// ###########################################################		   transport 					###################################################################################	
	// ##############################################################################################################################################################################	
	$kolor_tla = $kolor_szary;
	$pytanie31 = mysqli_query($conn, "SELECT transport, data_faktury_miesiac FROM wyceny WHERE data_faktury_rok = '".$SPRAWDZANY_ROK."' AND korekta_fv = 'NIE';");
	while($wynik31= mysqli_fetch_assoc($pytanie31))
		{
		$transport=$wynik31['transport'];
		
		
		$data_faktury_miesiac=$wynik31['data_faktury_miesiac'];
			switch ($data_faktury_miesiac) 
			{
				case 1:
					$WARTOSC_transport[1] = $WARTOSC_transport[1] + $transport;
					break;
				case 2:
					$WARTOSC_transport[2] = $WARTOSC_transport[2] + $transport;
					break;
				case 3:
					$WARTOSC_transport[3] = $WARTOSC_transport[3] + $transport;
					break;
				case 4:
					$WARTOSC_transport[4] = $WARTOSC_transport[4] + $transport;
					break;
				case 5:
					$WARTOSC_transport[5] = $WARTOSC_transport[5] + $transport;
					break;
				case 6:
					$WARTOSC_transport[6] = $WARTOSC_transport[6] + $transport;
					break;
				case 7:
					$WARTOSC_transport[7] = $WARTOSC_transport[7] + $transport;
					break;
				case 8:
					$WARTOSC_transport[8] = $WARTOSC_transport[8] + $transport;
					break;
				case 9:
					$WARTOSC_transport[9] = $WARTOSC_transport[9] + $transport;
					break;
				case 10:
					$WARTOSC_transport[10] = $WARTOSC_transport[10] + $transport;
					break;
				case 11:
					$WARTOSC_transport[11] = $WARTOSC_transport[11] + $transport;
					break;
				case 12:
					$WARTOSC_transport[12] = $WARTOSC_transport[12] + $transport;
					break;
			}		
		}
		
	$WARTOSC_SUMA = 0;
	echo '<tr align="center" bgcolor="'.$kolor_tla.'" height="'.$wysokosc_rozne.'"><td bgcolor="'.$kolor_tla.'" align="left">'.$kol_wartosc.' transport</td>';
	$na_ile_dzielic = 0;
	for($z=1; $z<=12; $z++) 
		{
		$WARTOSC_transport[$z] = number_format($WARTOSC_transport[$z], 2,'.','');
		echo '<td width="'.$szer_rozne.'" bgcolor="'.$kolor_tla.'">'.$WARTOSC_transport[$z].'</td>';
		if($WARTOSC_transport[$z] != 0) $na_ile_dzielic++;
		$WARTOSC_SUMA += $WARTOSC_transport[$z];
		}	
		if($na_ile_dzielic == 0) $na_ile_dzielic++;
		$WARTOSC_SREDNIA = $WARTOSC_SUMA/$na_ile_dzielic;
		$WARTOSC_SREDNIA = number_format($WARTOSC_SREDNIA, 2,'.',' ');
		$WARTOSC_SUMA = number_format($WARTOSC_SUMA, 2,'.',' ');
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SREDNIA.'</td>';
		echo '<td bgcolor="'.$kolor_tla.'">'.$WARTOSC_SUMA.'</td></tr>';

	echo '</table>';
echo '</form>';
?>