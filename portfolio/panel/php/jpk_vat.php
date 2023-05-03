<?php
if($etap == 1)
	{
	$ilosc_lat_w_fakturach=0;
	for($y=2018; $y<=$AKTUALNY_ROK; $y++) 
		{
		$ilosc_lat_w_fakturach++;
		$TABELA_LAT_JPK[$ilosc_lat_w_fakturach] = $y;
		}
	
	echo '<table border="0" class="text" width="350px" align="left" cellpadding="5" cellspacing="5" bgcolor="'.$kolor_bialy.'"><tr class="text" align="center">';
	echo '<FORM action="index.php?page=jpk_vat" method="post">';
	echo '<INPUT type="hidden" name="page" value="jpk_vat">';
	echo '<INPUT type="hidden" name="etap" value="2">';
	
		echo '<td align="left" width="100%" colspan="3">Wybierz zakres :</td></tr>';
			echo '<td><select name="wybrany_miesiac" class="pole_input" style="width: 200px">';
			for($x=1; $x<=12; $x++) if($aktualny_miesiac == $x) echo '<option selected="selected" value="'.$x.'">'.$TABELA_MIESIECY[$x].'</option>'; else echo '<option value="'.$x.'">'.$TABELA_MIESIECY[$x].'</option>';
			echo '</select></td>';
			
			echo '<td><select name="wybrany_rok" class="pole_input" style="width: 50px">';
			for($y=1; $y<=$ilosc_lat_w_fakturach; $y++)
				{
				
				echo '<option>'.$TABELA_LAT_JPK[$y].'</option>';
				}
			echo '</select></td>';
			
		echo '<td><input type="submit" value="Dalej"></td>';
	echo '</form>';
	echo '</tr></table>';
	}


if($etap == 2)
	{
	$SUMA['K_10'] = 0;
	$SUMA['K_11'] = 0;
	$SUMA['K_12'] = 0;
	$SUMA['K_13'] = 0;
	$SUMA['K_14'] = 0;
	$SUMA['K_15'] = 0;
	$SUMA['K_16'] = 0;
	$SUMA['K_17'] = 0;
	$SUMA['K_18'] = 0;
	$SUMA['K_19'] = 0;
	$SUMA['K_20'] = 0;
	$SUMA['K_21'] = 0;
	$SUMA['K_22'] = 0;
	$SUMA['K_23'] = 0;
	$SUMA['K_24'] = 0;
	$SUMA['K_25'] = 0;
	$SUMA['K_26'] = 0;
	$SUMA['K_27'] = 0;
	$SUMA['K_28'] = 0;
	$SUMA['K_29'] = 0;
	$SUMA['K_30'] = 0;
	$SUMA['K_31'] = 0;
	$SUMA['K_32'] = 0;
	$SUMA['K_33'] = 0;
	$SUMA['K_34'] = 0;
	$SUMA['K_35'] = 0;
	$SUMA['K_36'] = 0;
	$SUMA['K_37'] = 0;
	$SUMA['K_38'] = 0;
	$SUMA['K_39'] = 0;
	$SUMA_PODATKU = 0;

	$id_fv = [];
	$nr_fv = [];
	$nabywca_nazwa = [];
	$nabywca_ulica = [];
	$nabywca_miasto = [];
	$nabywca_kod_pocztowy = [];
	$nabywca_nip = [];
	$nazwa_pliku = [];
	$link_folder = [];
	$pole_jpk_nabywca = [];
	$data_wystawienia = [];
	$data_zakonczenia_dostawy = [];
	$wartosc_netto_fv = [];
	$wartosc_brutto_fv = [];
	$wartosc_vat = [];
	$SUMA = [];
	$pokaz_wartosc_netto_fv = [];
	$pokaz_wartosc_vat = [];
	
	$nr_fv_korygowanej = [];
	$typ_dok = [];
	$data_wystawienia = [];
	$data_zakonczenia_dostawy = [];

	$i = 0;
	$pytanie33 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE data_wystawienia_miesiac = '".$wybrany_miesiac."' AND data_wystawienia_rok = '".$wybrany_rok."' AND waluta = 'PLN' AND (typ_dok = 'faktura' OR typ_dok = 'Korekta') ORDER BY id ASC");
	while($wynik33= mysqli_fetch_assoc($pytanie33))
		{
		$i++;
		$id_fv[$i]=$wynik33['id'];
		$nabywca_nazwa[$i]=$wynik33['nabywca_nazwa'];
		$nabywca_ulica[$i]=$wynik33['nabywca_ulica'];
		$nabywca_miasto[$i]=$wynik33['nabywca_miasto'];
		$nabywca_kod_pocztowy[$i]=$wynik33['nabywca_kod_pocztowy'];
		$nabywca_nip[$i]=$wynik33['nabywca_nip'];
		$nr_fv[$i]=$wynik33['nr_dok'];
		$nazwa_pliku[$i]=$wynik33['nazwa_pliku'];
		$link_folder[$i]=$wynik33['link_folder'];
		
		
		$pole_jpk_nabywca[$i]=$wynik33['pole_jpk'];
		$data_wystawienia[$i]=$wynik33['data_wystawienia'];
		$data_zakonczenia_dostawy[$i]=$wynik33['data_zakonczenia_dostawy'];
		$wartosc_netto_fv[$i]=$wynik33['wartosc_netto_fv'];
		$wartosc_brutto_fv[$i]=$wynik33['wartosc_brutto_fv'];
		
		$wartosc_vat[$i] = $wartosc_brutto_fv[$i] - $wartosc_netto_fv[$i];
		$SUMA[$pole_jpk_nabywca[$i]] += $wartosc_netto_fv[$i];
		
		$pokaz_wartosc_netto_fv[$i] = number_format($wartosc_netto_fv[$i], 2,',','');
		$pokaz_wartosc_vat[$i] = number_format($wartosc_vat[$i], 2,',','');


		//$stawka_vat[$i]=$wynik33['vat'];
		$SUMA[] += $wartosc_netto_fv[$i];
		}
	
	echo '<div align="left" class="text">Wygenerowano plik JPK VAT za miesiąc '.$TABELA_MIESIECY[$wybrany_miesiac].' '.$wybrany_rok.'. Liczba wystawionych faktur '.$i.'.</div><br>';

	echo '<table border="1" cellspacing="1" cellpadding="3" class="text" BORDERCOLOR="black" frame="box" RULES="all">';
		echo '<tr class="text" bgcolor="'.$kolor_szary.'" align="center">';
		//echo '<td>typSprzedazy</td>';
		echo '<td>LpSprzedazy</td>';
		echo '<td>NrKontrahenta</td>';
		echo '<td>NazwaKontrahenta</td>';
		echo '<td>AdresKontrahenta</td>';
		echo '<td>DowodSprzedazy</td>'; // NR faktury
		echo '<td>DataWystawienia</td>';
		echo '<td>DataSprzedazy</td>';
		
		echo '<td>K_10</td>';
		echo '<td>K_11</td>';
		echo '<td>K_12</td>';
		echo '<td>K_13</td>';
		echo '<td>K_14</td>';
		echo '<td>K_15</td>';
		echo '<td>K_16</td>';
		echo '<td>K_17</td>';
		echo '<td>K_18</td>';
		echo '<td>K_19</td>';
		echo '<td>K_20</td>';
		echo '<td>K_21</td>';
		echo '<td>K_22</td>';
		echo '<td>K_23</td>';
		echo '<td>K_24</td>';
		echo '<td>K_25</td>';
		echo '<td>K_26</td>';
		echo '<td>K_27</td>';
		echo '<td>K_28</td>';
		echo '<td>K_29</td>';
		echo '<td>K_30</td>';
		echo '<td>K_31</td>';
		echo '<td>K_32</td>';
		echo '<td>K_33</td>';
		echo '<td>K_34</td>';
		echo '<td>K_35</td>';
		echo '<td>K_36</td>';
		echo '<td>K_37</td>';
		echo '<td>K_38</td>';
		echo '<td>K_39</td>';
	
		echo '<td>LiczbaWierszySprzedazy</td>';
		echo '<td>PodatekNalezny</td>';
		echo '</tr>';
		
		
	for($x=1; $x<=$i; $x++)
		{
		
		echo '<tr align="left" class="text" bgcolor="white" height="10px">';
		//echo '<td>LpSprzedazy</td>';
		echo '<td>'.$x.'</td>';
		//echo '<td>NrKontrahenta</td>'; NIP
		echo '<td align="center">'.$nabywca_nip[$x].'</td>';
		//echo '<td>NazwaKontrahenta</td>';
		echo '<td>'.$nabywca_nazwa[$x].'</td>';
		//echo '<td>AdresKontrahenta</td>';
		echo '<td>'.$nabywca_ulica[$x].' '.$nabywca_kod_pocztowy[$i].' '.$nabywca_miasto[$i].' </td>';
		//echo '<td>DowodSprzedazy</td>'; NR faktury
		//echo '<td align="center"><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/'.$link_folder[$x].'/'.$nazwa_pliku[$x].'" target="_blank">'.$nr_fv[$x].'</a></td>';
		echo '<td align="center">'.$nr_fv[$x].'</td>';
		//echo '<td>DataWystawienia</td>';
		echo '<td align="center">'.$data_wystawienia[$x].'</td>';
		//echo '<td>DataSprzedazy</td>';
		echo '<td align="center">'.$data_zakonczenia_dostawy[$x].'</td>';
		
		
		
		$atrybut_kolumn = 'align="right" width="80px"';
		//########	K_10	################
		if($pole_jpk_nabywca[$x] == 'K_10') echo '<td '.$atrybut_kolumn.'>'.$pokaz_wartosc_netto_fv[$x].'</td>';
		else echo '<td '.$atrybut_kolumn.'>0</td>';
		
		//########	K_11	################
		if($pole_jpk_nabywca[$x] == 'K_11') echo '<td '.$atrybut_kolumn.'>'.$pokaz_wartosc_netto_fv[$x].'</td>';
		else echo '<td '.$atrybut_kolumn.'>0</td>';
		
		//########	K_12	################
		if($pole_jpk_nabywca[$x] == 'K_12') echo '<td '.$atrybut_kolumn.'>'.$pokaz_wartosc_netto_fv[$x].'</td>';
		else echo '<td '.$atrybut_kolumn.'>0</td>';
		
		//########	K_13	################
		if($pole_jpk_nabywca[$x] == 'K_13') echo '<td '.$atrybut_kolumn.'>'.$pokaz_wartosc_netto_fv[$x].'</td>';
		else echo '<td '.$atrybut_kolumn.'>0</td>';
		
		//########	K_14	################
		if($pole_jpk_nabywca[$x] == 'K_14') echo '<td '.$atrybut_kolumn.'>'.$pokaz_wartosc_netto_fv[$x].'</td>';
		else echo '<td '.$atrybut_kolumn.'>0</td>';
		
		//########	K_15 i K_16	################################################################################################
		if($pole_jpk_nabywca[$x] == 'K_15') 
			{
			echo '<td '.$atrybut_kolumn.'>'.$pokaz_wartosc_netto_fv[$x].'</td><td '.$atrybut_kolumn.'>'.$pokaz_wartosc_vat[$x].'</td>';
			$SUMA['K_16'] += $wartosc_vat[$x];
			$SUMA_PODATKU += $wartosc_vat[$x];
			}
		else echo '<td '.$atrybut_kolumn.'>0</td><td '.$atrybut_kolumn.'>0</td>';
	
		//########	K_17 i K_18	################################################################################################
		if($pole_jpk_nabywca[$x] == 'K_17') 
			{
			echo '<td '.$atrybut_kolumn.'>'.$pokaz_wartosc_netto_fv[$x].'</td><td '.$atrybut_kolumn.'>'.$pokaz_wartosc_vat[$x].'</td>';
			$SUMA['K_18'] += $wartosc_vat[$x];
			$SUMA_PODATKU += $wartosc_vat[$x];
			}
		else echo '<td '.$atrybut_kolumn.'>0</td><td '.$atrybut_kolumn.'>0</td>';
		
		//########	K_19 i K_20	################################################################################################
		if($pole_jpk_nabywca[$x] == 'K_19') 
			{
			echo '<td '.$atrybut_kolumn.'>'.$pokaz_wartosc_netto_fv[$x].'</td><td '.$atrybut_kolumn.'>'.$pokaz_wartosc_vat[$x].'</td>';
			$SUMA['K_20'] += $wartosc_vat[$x];
			$SUMA_PODATKU += $wartosc_vat[$x];
			}
		else echo '<td '.$atrybut_kolumn.'>0</td><td '.$atrybut_kolumn.'>0</td>';
				
		//########	K_21	################
		if($pole_jpk_nabywca[$x] == 'K_21') echo '<td '.$atrybut_kolumn.'>'.$pokaz_wartosc_netto_fv[$x].'</td>';
		else echo '<td '.$atrybut_kolumn.'>0</td>';
		
		//########	K_22	################
		if($pole_jpk_nabywca[$x] == 'K_22') echo '<td '.$atrybut_kolumn.'>'.$pokaz_wartosc_netto_fv[$x].'</td>';
		else echo '<td '.$atrybut_kolumn.'>0</td>';
		
		//########	K_23 i K_24	################################################################################################
		if($pole_jpk_nabywca[$x] == 'K_23') 
			{
			echo '<td '.$atrybut_kolumn.'>'.$pokaz_wartosc_netto_fv[$x].'</td><td '.$atrybut_kolumn.'>'.$pokaz_wartosc_vat[$x].'</td>';
			$SUMA_PODATKU += $wartosc_vat[$x];
			$SUMA['K_24'] += $wartosc_vat[$x];
			}
		else echo '<td '.$atrybut_kolumn.'>0</td><td '.$atrybut_kolumn.'>0</td>';
		
		//########	K_25 i K_26	################################################################################################
		if($pole_jpk_nabywca[$x] == 'K_25') 
			{
			echo '<td '.$atrybut_kolumn.'>'.$pokaz_wartosc_netto_fv[$x].'</td><td '.$atrybut_kolumn.'>'.$pokaz_wartosc_vat[$x].'</td>';
			$SUMA_PODATKU += $wartosc_vat[$x];
			$SUMA['K_26'] += $wartosc_vat[$x];
			}
		else echo '<td '.$atrybut_kolumn.'>0</td><td '.$atrybut_kolumn.'>0</td>';
		
		//########	K_27 i K_28	################################################################################################
		if($pole_jpk_nabywca[$x] == 'K_27') 
			{
			echo '<td '.$atrybut_kolumn.'>'.$pokaz_wartosc_netto_fv[$x].'</td><td '.$atrybut_kolumn.'>'.$pokaz_wartosc_vat[$x].'</td>';
			$SUMA_PODATKU += $wartosc_vat[$x];
			$SUMA['K_28'] += $wartosc_vat[$x];
			}
		else echo '<td '.$atrybut_kolumn.'>0</td><td '.$atrybut_kolumn.'>0</td>';
		
		//########	K_29 i K_30	################################################################################################
		if($pole_jpk_nabywca[$x] == 'K_29') 
			{
			echo '<td '.$atrybut_kolumn.'>'.$pokaz_wartosc_netto_fv[$x].'</td><td '.$atrybut_kolumn.'>'.$pokaz_wartosc_vat[$x].'</td>';
			$SUMA_PODATKU += $wartosc_vat[$x];
			$SUMA['K_30'] += $wartosc_vat[$x];
			}
		else echo '<td '.$atrybut_kolumn.'>0</td><td '.$atrybut_kolumn.'>0</td>';
		
		//########	K_31	################
		if($pole_jpk_nabywca[$x] == 'K_31') echo '<td '.$atrybut_kolumn.'>'.$pokaz_wartosc_netto_fv[$x].'</td>';
		else echo '<td '.$atrybut_kolumn.'>0</td>';
		
		//########	K_32 i K_33	################################################################################################
		if($pole_jpk_nabywca[$x] == 'K_32') 
			{
			echo '<td '.$atrybut_kolumn.'>'.$pokaz_wartosc_netto_fv[$x].'</td><td '.$atrybut_kolumn.'>'.$pokaz_wartosc_vat[$x].'</td>';
			$SUMA_PODATKU += $wartosc_vat[$x];
			$SUMA['K_33'] += $wartosc_vat[$x];
			}
		else echo '<td '.$atrybut_kolumn.'>0</td><td '.$atrybut_kolumn.'>0</td>';
		
		//########	K_34 i K_35	################################################################################################
		if($pole_jpk_nabywca[$x] == 'K_34') 
			{
			echo '<td '.$atrybut_kolumn.'>'.$pokaz_wartosc_netto_fv[$x].'</td><td '.$atrybut_kolumn.'>'.$pokaz_wartosc_vat[$x].'</td>';
			$SUMA_PODATKU += $wartosc_vat[$x];
			$SUMA['K_35'] += $wartosc_vat[$x];
			}
		else echo '<td '.$atrybut_kolumn.'>0</td><td '.$atrybut_kolumn.'>0</td>';
		
		//########	K_36	################
		if($pole_jpk_nabywca[$x] == 'K_36') echo '<td '.$atrybut_kolumn.'>'.$pokaz_wartosc_netto_fv[$x].'</td>';
		else echo '<td '.$atrybut_kolumn.'>0</td>';
		
		//########	K_37	################
		if($pole_jpk_nabywca[$x] == 'K_37') echo '<td '.$atrybut_kolumn.'>'.$pokaz_wartosc_netto_fv[$x].'</td>';
		else echo '<td '.$atrybut_kolumn.'>0</td>';
		
		//########	K_38	################
		if($pole_jpk_nabywca[$x] == 'K_38') echo '<td '.$atrybut_kolumn.'>'.$pokaz_wartosc_netto_fv[$x].'</td>';
		else echo '<td '.$atrybut_kolumn.'>0</td>';

		//########	K_39	################
		if($pole_jpk_nabywca[$x] == 'K_39') echo '<td '.$atrybut_kolumn.'>'.$pokaz_wartosc_netto_fv[$x].'</td>';
		else echo '<td '.$atrybut_kolumn.'>0</td>';

		echo '<td></td>';
		echo '<td></td>';

		echo '</tr>';
		}

		// podsumowanie
		echo '<tr class="text" bgcolor="'.$kolor_szary.'" align="center">';
		echo '<td colspan="7"></td>';
		
		$SUMA['K_10'] = number_format($SUMA['K_10'], 2,',','');
		$SUMA['K_11'] = number_format($SUMA['K_11'], 2,',','');
		$SUMA['K_12'] = number_format($SUMA['K_12'], 2,',','');
		$SUMA['K_13'] = number_format($SUMA['K_13'], 2,',','');
		$SUMA['K_14'] = number_format($SUMA['K_14'], 2,',','');
		$SUMA['K_15'] = number_format($SUMA['K_15'], 2,',','');
		$SUMA['K_16'] = number_format($SUMA['K_16'], 2,',','');
		$SUMA['K_17'] = number_format($SUMA['K_17'], 2,',','');
		$SUMA['K_18'] = number_format($SUMA['K_18'], 2,',','');
		$SUMA['K_19'] = number_format($SUMA['K_19'], 2,',','');
		$SUMA['K_20'] = number_format($SUMA['K_20'], 2,',','');
		$SUMA['K_21'] = number_format($SUMA['K_21'], 2,',','');
		$SUMA['K_22'] = number_format($SUMA['K_22'], 2,',','');
		$SUMA['K_23'] = number_format($SUMA['K_23'], 2,',','');
		$SUMA['K_24'] = number_format($SUMA['K_24'], 2,',','');
		$SUMA['K_25'] = number_format($SUMA['K_25'], 2,',','');
		$SUMA['K_26'] = number_format($SUMA['K_26'], 2,',','');
		$SUMA['K_27'] = number_format($SUMA['K_27'], 2,',','');
		$SUMA['K_28'] = number_format($SUMA['K_28'], 2,',','');
		$SUMA['K_29'] = number_format($SUMA['K_29'], 2,',','');
		$SUMA['K_30'] = number_format($SUMA['K_30'], 2,',','');
		$SUMA['K_31'] = number_format($SUMA['K_31'], 2,',','');
		$SUMA['K_32'] = number_format($SUMA['K_32'], 2,',','');
		$SUMA['K_33'] = number_format($SUMA['K_33'], 2,',','');
		$SUMA['K_34'] = number_format($SUMA['K_34'], 2,',','');
		$SUMA['K_35'] = number_format($SUMA['K_35'], 2,',','');
		$SUMA['K_36'] = number_format($SUMA['K_36'], 2,',','');
		$SUMA['K_37'] = number_format($SUMA['K_37'], 2,',','');
		$SUMA['K_38'] = number_format($SUMA['K_38'], 2,',','');
		$SUMA['K_39'] = number_format($SUMA['K_39'], 2,',','');
		$SUMA_PODATKU = number_format($SUMA_PODATKU, 2,',','');
		
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_10'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_11'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_12'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_13'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_14'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_15'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_16'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_17'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_18'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_19'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_20'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_21'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_22'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_23'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_24'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_25'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_26'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_27'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_28'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_29'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_30'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_31'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_32'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_33'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_34'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_35'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_36'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_37'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_38'].'</td>';
		echo '<td '.$atrybut_kolumn.'>'.$SUMA['K_39'].'</td>';

		echo '<td>'.$i.'</td>';
		echo '<td>'.$SUMA_PODATKU.'</td>';
		echo '</tr>';

	echo '</table>';
	}
?>
