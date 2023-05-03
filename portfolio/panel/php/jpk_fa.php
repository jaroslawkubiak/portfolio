<?php
// jak miesiac to styczen to zaznaczamy styczen zeszlego roku
if($aktualny_miesiac == 1) 
	{
	$AKTUALNY_ROK--;
	$zaznaczyc = 12; 
	}
else $zaznaczyc = $aktualny_miesiac-1;


if($etap == 1)
	{
	$ilosc_lat_w_fakturach=0;
	for($y=2018; $y<=$AKTUALNY_ROK; $y++) 
		{
		$ilosc_lat_w_fakturach++;
		$TABELA_LAT_JPK[$ilosc_lat_w_fakturach] = $y;
		}
	echo '<div class="text_duzy_niebieski" align="center">Generuj plik JPK_FA</div><br>';
	
	echo '<table border="0" class="text" align="left" cellpadding="5" cellspacing="5" bgcolor="'.$kolor_bialy.'"><tr class="text" align="center">';
	echo '<FORM action="index.php?page=jpk_fa" method="post">';
	echo '<INPUT type="hidden" name="page" value="jpk_fa">';
	echo '<INPUT type="hidden" name="etap" value="2">';
	
		echo '<td align="left" width="100%" colspan="5">Wybierz zakres :</td></tr>';
			echo '<tr><td>Od : <select name="miesiac_od" class="pole_input" style="width: 100px">';
			for($x=1; $x<=12; $x++) if($zaznaczyc == $x) echo '<option selected="selected" value="'.$x.'">'.$TABELA_MIESIECY[$x].'</option>'; else echo '<option value="'.$x.'">'.$TABELA_MIESIECY[$x].'</option>';
			echo '</select></td>';
			
			echo '<td><select name="rok_od" class="pole_input" style="width: 50px">';
			for($y=1; $y<=$ilosc_lat_w_fakturach; $y++)
				{
				if($AKTUALNY_ROK == $TABELA_LAT_JPK[$y]) echo '<option selected="selected">'.$TABELA_LAT_JPK[$y].'</option>'; else echo '<option>'.$TABELA_LAT_JPK[$y].'</option>';
				}
			echo '</select></td>';
			
			echo '<td>Do : <select name="miesiac_do" class="pole_input" style="width: 100px">';
			for($x=1; $x<=12; $x++) if($zaznaczyc == $x) echo '<option selected="selected" value="'.$x.'">'.$TABELA_MIESIECY[$x].'</option>'; else echo '<option value="'.$x.'">'.$TABELA_MIESIECY[$x].'</option>';
			echo '</select></td>';
			
			echo '<td><select name="rok_do" class="pole_input" style="width: 50px">';
			for($y=1; $y<=$ilosc_lat_w_fakturach; $y++)
				{
				if($AKTUALNY_ROK == $TABELA_LAT_JPK[$y]) echo '<option selected="selected">'.$TABELA_LAT_JPK[$y].'</option>'; else echo '<option>'.$TABELA_LAT_JPK[$y].'</option>';
				}
			echo '</select></td>';
		echo '<td><input type="submit" value="Dalej"></td>';
	echo '</tr></table>';
	echo '</form>';
	}


if($etap == 2)
	{
	$pytanie = mysqli_query($conn, "SELECT * FROM fv_ustawienia;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$sprzedawca_nazwa=$wynik['nazwa'];
		$sprzedawca_ulica=$wynik['ulica'];
		$sprzedawca_miasto=$wynik['miasto'];
		$sprzedawca_kod_pocztowy=$wynik['kod_pocztowy'];
		$sprzedawca_nip=$wynik['nip'];
		}
	echo '<div class="text_duzy_niebieski" align="center">Wygenerowano plik JPK_FA</div><br>';
	
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

	$SUMA_BRUTTO = 0;
	$i = 0;
	$WARUNEK = "data_wystawienia_miesiac >= '".$miesiac_od."' AND data_wystawienia_miesiac <= '".$miesiac_do."' AND data_wystawienia_rok >= '".$rok_od."' AND data_wystawienia_rok <= '".$rok_do."' AND waluta = 'PLN' AND (typ_dok = 'Faktura' OR typ_dok = 'Korekta')";
	// echo $WARUNEK.'<br>';

	$pytanie33 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE $WARUNEK ORDER BY id ASC;");
	while($wynik33= mysqli_fetch_assoc($pytanie33))
		{
		$i++;
		$id_fv[$i]=$wynik33['id'];
		$nabywca_nazwa[$i]=$wynik33['nabywca_nazwa'];
		$nabywca_ulica[$i]=$wynik33['nabywca_ulica'];
		$nabywca_miasto[$i]=$wynik33['nabywca_miasto'];
		$nabywca_kod_pocztowy[$i]=$wynik33['nabywca_kod_pocztowy'];
		$nabywca_nip[$i]=$wynik33['nabywca_nip'];
		
		$nabywca_nip[$i] = zamien_dowolne_znaki($nabywca_nip[$i], '-', '');
		
		// szukamy kodu kraju
		$pytanie44 = mysqli_query($conn, "SELECT kod_kraju FROM klienci WHERE nip='".$nabywca_nip[$i]."'");
		while($wynik44= mysqli_fetch_assoc($pytanie44))
			{
			$nabywca_kod_kraju[$i]=$wynik44['kod_kraju'];
			}
		
		$nr_fv[$i]=$wynik33['nr_dok'];
		$typ_dok[$i]=$wynik33['typ_dok'];
		if($typ_dok[$i] == 'Korekta')
			{
			$wartosc_netto_korekty[$i]=$wynik33['wartosc_netto_fv'];
			$wartosc_brutto_korekty[$i]=$wynik33['wartosc_brutto_fv'];
			$nr_fv_korygowanej[$i]=$wynik33['nr_fv_korygowanej'];
			$pytanie44 = mysqli_query($conn, "SELECT * FROM fv_naglowek WHERE nr_dok='".$nr_fv_korygowanej[$i]."'");
			while($wynik44= mysqli_fetch_assoc($pytanie44))
				{
				$wartosc_netto_faktury[$i]=$wynik44['wartosc_netto_fv'];
				$wartosc_brutto_faktury[$i]=$wynik44['wartosc_brutto_fv'];
				}
			$wartosc_netto_fv[$i] = $wartosc_netto_korekty[$i] - $wartosc_netto_faktury[$i];
			$wartosc_brutto_fv[$i] = $wartosc_brutto_korekty[$i] - $wartosc_brutto_faktury[$i];

			//był mega problem z tą korektą, dlatego wartości muszą być recznie
			if($nr_fv[$i] == '3/2020/K') 
			{
				$wartosc_netto_fv[$i] = 0;
				$wartosc_brutto_fv[$i] = 29.52;
			}


			$stawka_vat[$i]=$wynik33['vat'];
			}
		else
			{
			$wartosc_netto_fv[$i]=$wynik33['wartosc_netto_fv'];
			$wartosc_brutto_fv[$i]=$wynik33['wartosc_brutto_fv'];
			$stawka_vat[$i]=$wynik33['vat'];
			}
		$data_wystawienia[$i]=$wynik33['data_wystawienia'];
		$data_zakonczenia_dostawy[$i]=$wynik33['data_zakonczenia_dostawy'];
		
		$wartosc_vat[$i] = $wartosc_brutto_fv[$i] - $wartosc_netto_fv[$i];
		$SUMA_BRUTTO += $wartosc_brutto_fv[$i];
		
		// $pokaz_wartosc_netto_fv[$i] = number_format($wartosc_netto_fv[$i], 2,',','');
		// $pokaz_wartosc_vat[$i] = number_format($wartosc_vat[$i], 2,',','');
		}


	$SUMA_BRUTTO = number_format($SUMA_BRUTTO, 2,'.',' ');
	echo '<div align="left" class="text">Wygenerowano plik JPK_FA za okres od : <font color="red">'.$TABELA_MIESIECY[$miesiac_od].' '.$rok_od.'</font> do :  <font color="red">'.$TABELA_MIESIECY[$miesiac_do].' '.$rok_do.'</font>.';
	echo $tabulator.' Liczba wystawionych faktur <font color="red">'.$i.'.'.$tabulator.'</font> Wartość faktur <font color="red">'.$SUMA_BRUTTO.' '.$waluta.'</font></div><br>';
	
	echo '<a href="php/drukuj/drukuj_jpk_fa.php?etap=2&miesiac_od='.$miesiac_od.'&miesiac_do='.$miesiac_do.'&rok_od='.$rok_od.'&rok_do='.$rok_do.'" target="_blank"><font class="text_duzy_niebieski">Pokaż listę faktur w osobnej karcie</font></a><br><br>';

	echo '<a href="php/drukuj/drukuj_jpk_fa_pozycje.php?miesiac_od='.$miesiac_od.'&miesiac_do='.$miesiac_do.'&rok_od='.$rok_od.'&rok_do='.$rok_do.'" target="_blank"><font class="text_duzy_niebieski">Pokaż listę pozycji faktur w osobnej karcie</font></a><br><br>';

echo '<table border="0"><tr><td>';

	echo '<table border="0" width="100%"><tr><td width="33%">';
	echo '<div align="left"><a href="index.php?page=jpk_fa_pozycje&miesiac_od='.$miesiac_od.'&miesiac_do='.$miesiac_do.'&rok_od='.$rok_od.'&rok_do='.$rok_do.'"><font class="text_duzy_niebieski">JPK FA - pozycje faktur</font></a></div>';
	echo '</td><td width="33%">';
	echo '<div align="center"><a href="index.php?page=jpk_fa_pozycje&miesiac_od='.$miesiac_od.'&miesiac_do='.$miesiac_do.'&rok_od='.$rok_od.'&rok_do='.$rok_do.'"><font class="text_duzy_niebieski">JPK FA - pozycje faktur</font></a></div>';
	echo '</td><td width="33%">';
	echo '<div align="right"><a href="index.php?page=jpk_fa_pozycje&miesiac_od='.$miesiac_od.'&miesiac_do='.$miesiac_do.'&rok_od='.$rok_od.'&rok_do='.$rok_do.'"><font class="text_duzy_niebieski">JPK FA - pozycje faktur</font></a></div>';
	echo '</td></tr></table>';

echo '</td></tr><tr><td><br>';
	
	
	$atrybut_kolumn = 'align="right" width="80px"';
	echo '<table border="1" cellspacing="1" cellpadding="3" class="text" width="4000px" BORDERCOLOR="black" frame="box" RULES="all">';
		echo '<tr class="text_mini" bgcolor="'.$kolor_szary.'" align="center">';
		// echo '<td>lp</td>';
		echo '<td>P 1</td>'; 	//data wystawienia
		echo '<td>P 2A</td>'; 	//nr faktury
		echo '<td width="300px">P 3A</td>'; 	//podmiot faktury
		echo '<td width="300px">P 3B</td>'; 	//adres podmiotu fv
		echo '<td width="300px">P 3C</td>';	//nazwa sprzedawcy
		echo '<td width="300px">P 3D</td>';	//adres sprzedawcy
		echo '<td>P 4A</td>';	
		echo '<td>P 4B</td>';	//nip sprzedawcy
		echo '<td>P 5A</td>';	//Kod (prefiks) nabywcy - podatnika VAT UE dla przypadkw okrelonych w art. 97 ust. 10 ustawy
		echo '<td>P 5B</td>';	//Numer, za pomoc ktrego nabywca towarw lub usug jest identyfikowany dla podatku lub podatku od wartoci dodanej, pod ktrym otrzyma on towary lub usugi, z zastrzeeniem pkt 24 lit. b ustawy. Pole opcjonalne dla przypadku okrelonego w art. 106e ust. 5 pkt 2 ustawy.
		echo '<td>P 6</td>';
		echo '<td>Kod Waluty</td>'; //kod waluty
		
		echo '<td '.$atrybut_kolumn.'>P 13 1</td>'; //wartosc netto dla vat 23
		echo '<td '.$atrybut_kolumn.'>P 14 1</td>'; //wartosc vat dla vat 23
		echo '<td '.$atrybut_kolumn.'>P 14 1W</td>';
		echo '<td '.$atrybut_kolumn.'>P 13 2</td>'; //wartosc netto dla vat 8
		echo '<td '.$atrybut_kolumn.'>P 14 2</td>'; //wartosc vat dla vat 8
		echo '<td '.$atrybut_kolumn.'>P 14 2W</td>';
		echo '<td '.$atrybut_kolumn.'>P 13 3</td>'; //rezerwowe
		echo '<td '.$atrybut_kolumn.'>P 14 3</td>'; //rezerwowe
		echo '<td '.$atrybut_kolumn.'>P 14 3W</td>';
		echo '<td '.$atrybut_kolumn.'>P 13 4</td>'; //rezerwowe
		echo '<td '.$atrybut_kolumn.'>P 14 4</td>'; //rezerwowe
		echo '<td '.$atrybut_kolumn.'>P 14 4W</td>';
		echo '<td '.$atrybut_kolumn.'>P 13 5</td>'; //rezerwowe
		echo '<td '.$atrybut_kolumn.'>P 13 6</td>'; //wartosc netto dla vat 0
		echo '<td '.$atrybut_kolumn.'>P 13 7</td>'; //wartosc vat dla vat 0
		
		echo '<td '.$atrybut_kolumn.'>P 15</td>';	// wartosc brutto
		echo '<td>P 16</td>';
		echo '<td>P 17</td>';
		echo '<td>P 18</td>';
		echo '<td>P 18A</td>';
		echo '<td>P 19</td>';
		echo '<td>P 19A</td>';
		echo '<td>P 19B</td>';
		echo '<td>P 19C</td>';
		echo '<td>P 20</td>';
		echo '<td>P 20A</td>';

		echo '<td>P 20B</td>';
		echo '<td>P 21</td>';
		echo '<td>P 21A</td>';
		echo '<td>P 21B</td>';
		echo '<td>P 21C</td>';
		echo '<td>P 22</td>';
		echo '<td>P 22A</td>';
		echo '<td>P 22B</td>';
		echo '<td>P 22C</td>';
		echo '<td>P 23</td>';
		echo '<td>P 106E 2</td>';
		echo '<td>P 106E 3</td>';
		echo '<td>P 106E 3A</td>';
		echo '<td>Rodzaj Faktury</td>';
		echo '<td>Przyczyna korekty</td>';
		echo '<td>Nr fa. korygowanej</td>';
		echo '<td>Okres fa. Korygowanej</td>';
		echo '<td>Nr fa zaliczkowej</td>';
		echo '</tr>';
		
		
	for($x=1; $x<=$i; $x++)
		{
		echo '<tr align="left" class="text_mini" bgcolor="white" height="10px">';
		// echo '<td>'.$x.'</td>';
		echo '<td align="center">'.$data_wystawienia[$x].'</td>';
		echo '<td align="center">'.$nr_fv[$x].'</td>';
		echo '<td>'.$nabywca_nazwa[$x].'</td>';
		echo '<td>'.$nabywca_kod_pocztowy[$x].' '.$nabywca_miasto[$x].' '.$nabywca_ulica[$x].'</td>';
		echo '<td>'.$sprzedawca_nazwa.'</td>';
		echo '<td>'.$sprzedawca_kod_pocztowy.' '.$sprzedawca_miasto.' '.$sprzedawca_ulica.'</td>';

		echo '<td></td>'; //p 4a
		echo '<td>'.$sprzedawca_nip.'</td>';//p 4b
			if($nabywca_kod_kraju[$x] == 'PL') echo '<td align="center"></td>';//p 5a
			else echo '<td align="center">'.$nabywca_kod_kraju[$x].'</td>';//p 5a
		echo '<td align="center">'.$nabywca_nip[$x].'</td>';//p 5b
		echo '<td align="center">'.$data_wystawienia[$x].'</td>'; // p 6
		echo '<td align="center">PLN</td>'; // kod waluty


		//########	P 13 1 - wartosc netto	################
		if($stawka_vat[$x] == 23) echo '<td '.$atrybut_kolumn.'>'.$wartosc_netto_fv[$x].'</td>';
		else echo '<td '.$atrybut_kolumn.'>0</td>';
		//########	P 14 1 - wartosc vat	################
		if($stawka_vat[$x] == 23) echo '<td '.$atrybut_kolumn.'>'.$wartosc_vat[$x].'</td>';
		else echo '<td '.$atrybut_kolumn.'>0</td>';

		echo '<td '.$atrybut_kolumn.'>0</td>'; //P 14 1W

		//########	P 13 2 - wartosc netto	################
		if($stawka_vat[$x] == 8) echo '<td '.$atrybut_kolumn.'>'.$wartosc_netto_fv[$x].'</td>';
		else echo '<td '.$atrybut_kolumn.'>0</td>';
		//########	P 14 2 - wartosc vat	################
		if($stawka_vat[$x] == 8) echo '<td '.$atrybut_kolumn.'>'.$wartosc_vat[$x].'</td>';
		else echo '<td '.$atrybut_kolumn.'>0</td>';
		echo '<td '.$atrybut_kolumn.'>0</td>'; //P 14 2W

		echo '<td '.$atrybut_kolumn.'>0</td>'; //P 13 3
		echo '<td '.$atrybut_kolumn.'>0</td>'; //P 14 3
		echo '<td '.$atrybut_kolumn.'>0</td>'; //P 14 3W
		echo '<td '.$atrybut_kolumn.'>0</td>'; //P 13 4
		echo '<td '.$atrybut_kolumn.'>0</td>'; //P 14 4
		echo '<td '.$atrybut_kolumn.'>0</td>'; //P 14 4W
		echo '<td '.$atrybut_kolumn.'>0</td>'; //P 13 5
		//########	P 13 6 - wartosc netto	################
		if($stawka_vat[$x] == 0) echo '<td '.$atrybut_kolumn.'>'.$wartosc_netto_fv[$x].'</td>';
		else echo '<td '.$atrybut_kolumn.'>0</td>';

		echo '<td '.$atrybut_kolumn.'>0</td>'; //P 13 7
	
		//########	P 15 - wartosc brutto	################
		echo '<td '.$atrybut_kolumn.'>'.$wartosc_brutto_fv[$x].'</td>';

		//########	P 16 	################
		echo '<td '.$atrybut_kolumn.'>FAŁSZ</td>';

		//########	P 17	################
		echo '<td '.$atrybut_kolumn.'>FAŁSZ</td>';

		//########	P 18	################
		echo '<td '.$atrybut_kolumn.'>FAŁSZ</td>';

		//########	P 18 A	################
		echo '<td '.$atrybut_kolumn.'>FAŁSZ</td>';

		//########	P 19	################
		echo '<td '.$atrybut_kolumn.'>FAŁSZ</td>';	

		//########	P 19A - P_106E_3A	################
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>'; //P 19A
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';	//P 19B
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';	//P 19C
		echo '<td '.$atrybut_kolumn.'>FAŁSZ</td>';	//P 20
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';	//P 20A
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';	//P 20B
		echo '<td '.$atrybut_kolumn.'>FAŁSZ</td>';	//P 21
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';	//P 21A
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';	//P 21B
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';	//P 21C
		echo '<td '.$atrybut_kolumn.'>FAŁSZ</td>';	//P 22
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';	//P 22A
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';	//P 22B
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';	//P 22C
		echo '<td '.$atrybut_kolumn.'>FAŁSZ</td>';	//P 23
		echo '<td '.$atrybut_kolumn.'>FAŁSZ</td>';	//P 106E 2
		echo '<td '.$atrybut_kolumn.'>FAŁSZ</td>';	//P 106E 3
		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';	//P 106E 3A


		//########	Rodzaj faktury	################
		if($typ_dok[$x] == 'Faktura') 
			{
			echo '<td '.$atrybut_kolumn.'>VAT</td>';
			echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';
			echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';
			echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';
			}
		elseif($typ_dok[$x] == 'Korekta') 
			{
			// szukamy szczegw korekty
			$pytanie424 = mysqli_query($conn, "SELECT nr_fv_korygowanej, data_fv_korygowanej, tytul_korekty FROM fv_naglowek WHERE nr_dok ='".$nr_fv[$x]."'");
			while($wynik424= mysqli_fetch_assoc($pytanie424))
				{
				$nr_fv_korygowanej[$x]=$wynik424['nr_fv_korygowanej'];
				$data_fv_korygowanej[$x]=$wynik424['data_fv_korygowanej'];
				$tytul_korekty[$x]=$wynik424['tytul_korekty'];
				}
			echo '<td '.$atrybut_kolumn.'>KOREKTA</td>';
			echo '<td '.$atrybut_kolumn.'>'.$tytul_korekty[$x].'</td>'; //przyczyna korekty
			echo '<td '.$atrybut_kolumn.'>'.$nr_fv_korygowanej[$x].'</td>'; // nr fa korygowanej
			echo '<td '.$atrybut_kolumn.'>'.$data_fv_korygowanej[$x].'</td>'; //okres fa korygowanej
			}
		//########	KONIEC Rodzaj faktury	################


		echo '<td '.$atrybut_kolumn.'>&nbsp;</td>';
		
		echo '</tr>';
		}

		// podsumowanie
		echo '<tr class="text" bgcolor="'.$kolor_szary.'" align="center">';
		
		echo '</tr>';

		
	echo '</table>';

	echo '</td></tr>';

	echo '<tr><td><br>';

		echo '<table border="0" width="100%"><tr><td width="33%">';
		echo '<div align="left"><a href="index.php?page=jpk_fa_pozycje&miesiac_od='.$miesiac_od.'&miesiac_do='.$miesiac_do.'&rok_od='.$rok_od.'&rok_do='.$rok_do.'"><font class="text_duzy_niebieski">JPK FA - pozycje faktur</font></a></div>';
		echo '</td><td width="33%">';
		echo '<div align="center"><a href="index.php?page=jpk_fa_pozycje&miesiac_od='.$miesiac_od.'&miesiac_do='.$miesiac_do.'&rok_od='.$rok_od.'&rok_do='.$rok_do.'"><font class="text_duzy_niebieski">JPK FA - pozycje faktur</font></a></div>';
		echo '</td><td width="33%">';
		echo '<div align="right"><a href="index.php?page=jpk_fa_pozycje&miesiac_od='.$miesiac_od.'&miesiac_do='.$miesiac_do.'&rok_od='.$rok_od.'&rok_do='.$rok_do.'"><font class="text_duzy_niebieski">JPK FA - pozycje faktur</font></a></div>';
		echo '</td></tr></table>';
		
	echo '</td></tr></table>';
	}
?>