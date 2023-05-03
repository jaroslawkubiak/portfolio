<style type="text/css">
	a:link {
		color: #000000;
		font-weight: Bold;
		font-family: arial;
		text-decoration: none;
		font-size: 12px;
	}

	a:visited {
		color: #000000;
		font-weight: Bold;
		font-family: arial;
		text-decoration: none;
		font-size: 12px;
	}

	a:active {
		color: #000000;
		font-weight: Bold;
		font-family: arial;
		text-decoration: none;
		font-size: 12px;
	}

	a:hover {
		color: #000000;
		font-weight: Bold;
		font-family: arial;
		text-decoration: underline;
		font-size: 12px;
	}

	input.produkcja_checkbox {
		/* Double-sized Checkboxes */
		-ms-transform: scale(3);
		/* IE */
		-moz-transform: scale(3);
		/* FF */
		-webkit-transform: scale(3);
		/* Safari and Chrome */
		-o-transform: scale(3);
		/* Opera */
		padding: 100px;
	}

	input.button_do_menu {
		width: 200px;
		height: 70px;
		font: Arial, Helvetica, sans-serif;
		font-size: 16px;
		font-weight: Bold;
		white-space: normal;
	}


	input.button_produkcja {
		width: 300px;
		height: 300px;
		font: Arial, Helvetica, sans-serif;
		font-size: 36px;
		font-weight: Bold;
		white-space: normal;
	}

	input.button_produkcja_maly {
		width: 200px;
		height: 200px;
		font: Arial, Helvetica, sans-serif;
		font-size: 24px;
		font-weight: Bold;
		white-space: normal;
	}

	input.button_produkcja_mniejszy {
		width: 150px;
		height: 50px;
		font: Arial, Helvetica, sans-serif;
		font-size: 30px;
		font-weight: Bold;
		white-space: normal;
	}


	input.button_zapisz_produkcja {
		width: 150px;
		height: 100px;
		font: Arial, Helvetica, sans-serif;
		font-size: 36px;
		font-weight: Bold;
		white-space: normal;
	}

	.pole_input_produkcja {
		width: 100%;
		height: 40px;
		border: #000000 1px solid;
		background-color: #e24139;
		color: #000000;
		font-family: Arial, Verdana, Helvetica, sans-serif;
		font-size: 22px;
		font-style: normal;
		font-weight: bold;
		text-decoration: none;
		text-transform: none;
		border-radius: 5px;
	}

	.pole_input_produkcja_kalendarz {
		height: 60px;
		border: #000000 1px solid;
		background-color: #e24139;
		color: #000000;
		text-align: center;
		font-family: Arial, Verdana, Helvetica, sans-serif;
		font-size: 24px;
		font-style: normal;
		font-weight: bold;
		text-decoration: none;
		text-transform: none;
	}
</style>

<?php
// echo 'realizacja<br>';
$klient_nazwa_2 = '';

if(($zapisz == 'Zapisz') && ($pracownik_a != ''))
	{
	// kopiowanie nazwisk pracownikow, aby nie było tak że 1 jest, 2 pusty, 3 jest itp
	
	$pytanie123 = mysqli_query($conn, "SELECT nr_zamowienia FROM zamowienia WHERE id = ".$zamowienie_id_akord.";");
	while($wynik123= mysqli_fetch_assoc($pytanie123))
		$nr_zamowienia=$wynik123['nr_zamowienia'];
		
	if($pracownik_b == '') 
		{
		$pracownik_b = $pracownik_c;
		$pracownik_c = '';
		}

	if($pracownik_c == '') 
		{
		$pracownik_c = $pracownik_d;
		$pracownik_d = '';
		}
		
	if($pracownik_b == '') 
		{
		$pracownik_b = $pracownik_c;
		$pracownik_c = '';
		}
	
	// zapis uzytkownikow do tymczasowej bazy danych
	$data_dopisania = date('d-m-Y', time());
	$pytanie = mysqli_query($conn, "DELETE FROM pracownicy_do_akordow WHERE data_dopisania = '".$data_dopisania."' AND rodzaj_produktu = '".$rodzaj_produktu."';");

	$query = "INSERT INTO `pracownicy_do_akordow` (`data_dopisania`, `rodzaj_produktu`, `pracownik_a`, `pracownik_b`, `pracownik_c`, `pracownik_d`) VALUES ('$data_dopisania', '$rodzaj_produktu', '$pracownik_a', '$pracownik_b', '$pracownik_c', '$pracownik_d');";
	mysqli_query($conn, $query);

	//sprawdzamy czy wpis do tego zamowienia juz istnieje. jak istnieje to update. jak nie to insert
	include("php/realizacja_produkcji_szablony.php");

	
	$odswiez = 0;
	$pytanie = mysqli_query($conn, "SELECT data_wykonania FROM realizacja_produkcji WHERE data_wykonania = '".$data_wykonania."';");
	while($wynik= mysqli_fetch_assoc($pytanie))
		$odswiez++;

	if($odswiez == 0)
		{
		// dodajemy ilosc paczek do zlecenia transp, zap nie działa, jak nie ma nr zlec transp
		if($ilosc_paczek != 0)
			{
			//sprtawdzamy czy zamowienie ma wpisany nr zlec tranp
			$pytanie1 = mysqli_query($conn, "SELECT nr_zlecenia_transportowego FROM zamowienia WHERE id = ".$zamowienie_id_akord." LIMIT 1;");
			while($wynik1= mysqli_fetch_assoc($pytanie1))
				$nr_zlecenia_transportowego_temp=$wynik1['nr_zlecenia_transportowego'];
			if($nr_zlecenia_transportowego_temp == '') 
				{
					echo '<div class="text_error_duzy" align="center">Liczba paczek NIE została dodana do zlecenia transportowego.<br> W zamówieniu brak zdefiniowanego numeru.</div>';
					$sql = "INSERT INTO `bledy` (`user_id`, `tresc`, `blad`, `time`, `zamowienie_id`) VALUES ('$zalogowany_user', 'Liczba paczek NIE została dodana do zlecenia transportowego', 'W zamówieniu brak zdefiniowanego numeru zlec trasnp', '$time', $zamowienie_id_akord);";
					$pytanie12 = mysqli_query($conn, $sql);	
				}
			else
				{
				//dodaje liczbe paczek do zlec transp
				$pytanie4 = mysqli_query($conn, "SELECT liczba_paczek_wyrobow FROM zlecenia_transportowe_tresc WHERE zamowienie_id = ".$zamowienie_id_akord.";");
				while($wynik4= mysqli_fetch_assoc($pytanie4))
					$liczba_paczek_wyrobow=$wynik4['liczba_paczek_wyrobow'];
				$ilosc_paczek_temp = $ilosc_paczek + $liczba_paczek_wyrobow;
				
				$pytanie1343 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_tresc WHERE zamowienie_id = ".$zamowienie_id_akord." LIMIT 1;");
				while($wynik1343= mysqli_fetch_assoc($pytanie1343))
					{
					$klient_id_temp=$wynik1343['klient_id'];
					$nr_zlecenia_transportowego_temp=$wynik1343['nr_zlecenia_transportowego'];
					}		
				$sql = "UPDATE zlecenia_transportowe_tresc SET liczba_paczek_wyrobow = ".$ilosc_paczek_temp." WHERE klient_id = ".$klient_id_temp." AND nr_zlecenia_transportowego = '".$nr_zlecenia_transportowego_temp."';";
				$pytanie124 = mysqli_query($conn, $sql);
				
				//sprawdzamy czy byl blad
				$blad_zapytania = mysqli_error($conn);
				$szukaj = "'";
				$zamien_na = " ";
				$przerobione_sql = zamien_dowolne_znaki($sql, $szukaj, $zamien_na);
				$szukaj = '"';
				$zamien_na = ' ';
				$przerobione_sql = zamien_dowolne_znaki($przerobione_sql, $szukaj, $zamien_na);
				if($blad_zapytania != '')
					{
					$szukaj = "'";
					$zamien_na = " ";
					$przerobione_blad_zapytania = zamien_dowolne_znaki($blad_zapytania, $szukaj, $zamien_na);
					$szukaj = '"';
					$zamien_na = ' ';
					$przerobione_blad_zapytania = zamien_dowolne_znaki($przerobione_blad_zapytania, $szukaj, $zamien_na);
					}
				else $przerobione_blad_zapytania = 'BRAK BŁĘDU.';
				$sql = "INSERT INTO `bledy` (`user_id`, `tresc`, `blad`, `time`, `zamowienie_id`) VALUES ('$zalogowany_user', '$przerobione_sql', '$przerobione_blad_zapytania', '$time', '$zamowienie_id_akord');";
				$pytanie12 = mysqli_query($conn, $sql);	
				}
			
			}
	
		//echo '$nazwa_wszystkie_pozycje='.$nazwa_wszystkie_pozycje.'<br>';
		if($nazwa_wszystkie_pozycje == 'on')
			{
			$jedna_z_pozycji_jest_rowna_0 = 0;
			$ilosc = 0;
			$zamowic_profile_pozycja = '';
			for ($x=1; $x<=$ilosc_pozycji; $x++) 
				{
				$ilosc += $ilosc_dla_pozycji[$rodzaj_produktu][$x];
				if($ilosc_dla_pozycji[$rodzaj_produktu][$x] == 0) $jedna_z_pozycji_jest_rowna_0 = 1;
				if(isset($zamowic_profile[$x]) == 'on') $zamowic_profile_pozycja = 'on';
				}
			if($jedna_z_pozycji_jest_rowna_0 == 0) 
				{
				if(!$ilosc_paczek) $ilosc_paczek = 0;
				$query = "INSERT INTO `realizacja_produkcji` (`zamowienie_id`, `data_wykonania`, `pozycja`, `rodzaj_produktu`, `ilosc`, `pracownik_a`, `pracownik_b`, `pracownik_c`, `pracownik_d`, `nr_zamowienia`, `zamowic_profile`, `ilosc_paczek`) VALUES ('$zamowienie_id_akord', '$data_wykonania', 'on', '$rodzaj_produktu', '$ilosc', '$pracownik_a', '$pracownik_b', '$pracownik_c', '$pracownik_d', '$nr_zamowienia', '$zamowic_profile_pozycja', '$ilosc_paczek');";
				mysqli_query($conn, $query);	
				$realizacja_produkcji_id = mysqli_insert_id($conn);
				
				include("php/wartosc_produkcji_oblicz.php");
				// jak rodzaj produktu inny niż wyroby to zmieniam status na w realizacji
				if(($rodzaj_produktu == 0) || ($rodzaj_produktu == 1) || ($rodzaj_produktu == 3) || ($rodzaj_produktu == 4) || ($rodzaj_produktu == 5) || ($rodzaj_produktu == 11)) $pytanie103 = mysqli_query($conn, "UPDATE zamowienia SET status = 'W realizacji' WHERE id = ".$zamowienie_id_akord.";"); // || ($rodzaj_produktu == 7)
				}
			else
				{
				for ($x=1; $x<=$ilosc_pozycji; $x++)
					{
					$ilosc = $ilosc_dla_pozycji[$rodzaj_produktu][$x];
					if(($pozycja[$x] == 'on') && ($ilosc != 0)) 
						{
						// echo 'insert 2<br>';
						if(!$ilosc_paczek) $ilosc_paczek = 0;
						mysqli_query($conn, "INSERT INTO `realizacja_produkcji` (`zamowienie_id`, `data_wykonania`, `pozycja`, `rodzaj_produktu`, `ilosc`, `pracownik_a`, `pracownik_b`, `pracownik_c`, `pracownik_d`, `nr_zamowienia`, `zamowic_profile`, `ilosc_paczek`) 
						VALUES ('$zamowienie_id_akord', '$data_wykonania', '$x', '$rodzaj_produktu', '$ilosc', '$pracownik_a', '$pracownik_b', '$pracownik_c', '$pracownik_d', '$nr_zamowienia', '$zamowic_profile[$x]', '$ilosc_paczek');");
						$realizacja_produkcji_id = mysqli_insert_id($conn);

	
						include("php/wartosc_produkcji_oblicz.php");
						// jak rodzaj produktu inny niż wyroby to zmieniam status na w realizacji
						if(($rodzaj_produktu == 0) || ($rodzaj_produktu == 1) || ($rodzaj_produktu == 3) || ($rodzaj_produktu == 4) || ($rodzaj_produktu == 5) || ($rodzaj_produktu == 11) ) $pytanie103 = mysqli_query($conn, "UPDATE zamowienia SET status = 'W realizacji' WHERE id = ".$zamowienie_id_akord.";"); //|| ($rodzaj_produktu == 7)
						}
					}
					
				}
				
			}
		else
			{
			for ($x=1; $x<=$ilosc_pozycji; $x++)
				{
				$ilosc = $ilosc_dla_pozycji[$rodzaj_produktu][$x];
				if(isset($zamowic_profile[$x]) == 'on') $pytanie122 = mysqli_query($conn, "UPDATE zamowienia SET stan = 'Zamówić' WHERE id = ".$zamowienie_id_akord.";"); // zmieniamy stan w zamówieniu
				else $zamowic_profile[$x] = ' ';
				if(($pozycja[$x] == 'on') && ($ilosc != 0) && ($nazwa_wszystkie_pozycje != 'on')) 
					{
					// echo 'insert 3<br>';
					if(!$ilosc_paczek) $ilosc_paczek = 0;

					mysqli_query($conn, "INSERT INTO `realizacja_produkcji` (`zamowienie_id`, `data_wykonania`, `pozycja`, `rodzaj_produktu`, `ilosc`, `pracownik_a`, `pracownik_b`, `pracownik_c`, `pracownik_d`, `nr_zamowienia`, `zamowic_profile`, `ilosc_paczek`) 
					VALUES ('$zamowienie_id_akord', '$data_wykonania', '$x', '$rodzaj_produktu', '$ilosc', '$pracownik_a', '$pracownik_b', '$pracownik_c', '$pracownik_d', '$nr_zamowienia', '$zamowic_profile[$x]', '$ilosc_paczek');");
					$realizacja_produkcji_id = mysqli_insert_id($conn);

					include("php/wartosc_produkcji_oblicz.php");
					// jak rodzaj produktu inny niż wyroby to zmieniam status na w realizacji
					if(($rodzaj_produktu == 0) || ($rodzaj_produktu == 1) || ($rodzaj_produktu == 3) || ($rodzaj_produktu == 4) || ($rodzaj_produktu == 5) || ($rodzaj_produktu == 11)) $pytanie103 = mysqli_query($conn, "UPDATE zamowienia SET status = 'W realizacji' WHERE id = ".$zamowienie_id_akord.";"); // || ($rodzaj_produktu == 7)
					}
				
				//jezeli wybralismy 0 i zamów profile
				if(($pozycja[$x] == 'on') && ($ilosc == 0) && ($rodzaj_produktu == 0) && ($zamowic_profile[$x] == 'on')) 
					{
					if(!$ilosc_paczek) $ilosc_paczek = 0;
					// echo 'insert 4<br>';
					mysqli_query($conn, "INSERT INTO `realizacja_produkcji` (`zamowienie_id`, `data_wykonania`, `pozycja`, `rodzaj_produktu`, `ilosc`, `pracownik_a`, `pracownik_b`, `pracownik_c`, `pracownik_d`, `nr_zamowienia`, `zamowic_profile`, `ilosc_paczek`) VALUES ('$zamowienie_id_akord', '$data_wykonania', '$x', '$rodzaj_produktu', '$ilosc', '$pracownik_a', '$pracownik_b', '$pracownik_c', '$pracownik_d', '$nr_zamowienia', '$zamowic_profile[$x]', '$ilosc_paczek');");
					$realizacja_produkcji_id = mysqli_insert_id($conn);

					//include("php/wartosc_produkcji_oblicz.php");
					}
				} // do for
			} // do else
	
			
		// #############################################################################
		// ##########      zmiana statusu gdy wszystkie pozycje są wyzerowane     ######
		// #############################################################################
		$SUMA_ELEMENTOW_DANEGO_TYPU[0] = 0;
		$SUMA_ELEMENTOW_DANEGO_TYPU[1] = 0;
		$SUMA_ELEMENTOW_DANEGO_TYPU[2] = 0;
		$SUMA_ELEMENTOW_DANEGO_TYPU[3] = 0;
		$SUMA_ELEMENTOW_DANEGO_TYPU[4] = 0;
		$SUMA_ELEMENTOW_DANEGO_TYPU[5] = 0;
		$SUMA_ELEMENTOW_DANEGO_TYPU[6] = 0;
		$SUMA_ELEMENTOW_DANEGO_TYPU[7] = 0;
		$SUMA_ELEMENTOW_DANEGO_TYPU[8] = 0;
		$SUMA_ELEMENTOW_DANEGO_TYPU[9] = 0;
		$SUMA_ELEMENTOW_DANEGO_TYPU[10] = 0;
		$SUMA_ELEMENTOW_DANEGO_TYPU[11] = 0;

		// $suma_rodzaj_produktu = [];
		for($j=0; $j<=11; $j++) {
			$suma_rodzaj_produktu[$j] = array();
			// $suma_rodzaj_produktu[$j] = 0;
		}
		
		$ilosc_zamowien = 1;
		$ilosc_pozycji=0;
		$pytanie4 = mysqli_query($conn, "SELECT * FROM wyceny WHERE zamowienie_id = ".$zamowienie_id_akord." ORDER BY pozycja ASC;");
		while($wynik4= mysqli_fetch_assoc($pytanie4))
			{
				// echo 'zapytanie';
			$ilosc_pozycji++;
			$wygiecie_ramy_pvc_ilosc_szt=$wynik4['wygiecie_ramy_pvc_ilosc_szt'];
			$wygiecie_skrzydla_pvc_ilosc_szt=$wynik4['wygiecie_skrzydla_pvc_ilosc_szt'];
			$wygiecie_innego_pvc_ilosc_szt=$wynik4['wygiecie_innego_pvc_ilosc_szt'];
			$wygiecie_listwy_pvc_ilosc_szt=$wynik4['wygiecie_listwy_pvc_ilosc_szt'];
			
			$suma_rodzaj_produktu[1][$ilosc_pozycji] = $wygiecie_ramy_pvc_ilosc_szt + $wygiecie_skrzydla_pvc_ilosc_szt + $wygiecie_innego_pvc_ilosc_szt; // usunąłem to  + $wygiecie_listwy_pvc_ilosc_szt
			if(($suma_rodzaj_produktu[1][$ilosc_pozycji] == 0) && ($wygiecie_listwy_pvc_ilosc_szt != 0)) $suma_rodzaj_produktu[1][$ilosc_pozycji] = $wygiecie_listwy_pvc_ilosc_szt; 



/*
jezeli rama, skrzydlo i listwa : ilosc sztuk do odpisania rama i skrzydlo. to listawa ma sie liczyc do wart produkcji
zamowienia jest tylko listwa
*/


			$SUMA_ELEMENTOW_DANEGO_TYPU[1] += $suma_rodzaj_produktu[1][$ilosc_pozycji];
			//echo 'suma PO='.$SUMA_ELEMENTOW_DANEGO_TYPU[1].'<br>';
				$wygiecie_wzmocnienia_okiennego_ilosc_szt=$wynik4['wygiecie_wzmocnienia_okiennego_ilosc_szt'];
				$wygiecie_innego_ilosc_szt=$wynik4['wygiecie_innego_ilosc_szt'];
			$suma_rodzaj_produktu[2][$ilosc_pozycji] = $wygiecie_wzmocnienia_okiennego_ilosc_szt+$wygiecie_innego_ilosc_szt;
			$SUMA_ELEMENTOW_DANEGO_TYPU[2] += $suma_rodzaj_produktu[2][$ilosc_pozycji];
			//echo '$SUMA_ELEMENTOW_DANEGO_TYPU[2]='.$SUMA_ELEMENTOW_DANEGO_TYPU[2].'<br>';
				$wygiecie_ramy_alu_ilosc_szt=$wynik4['wygiecie_ramy_alu_ilosc_szt'];
				$wygiecie_skrzydla_alu_ilosc_szt=$wynik4['wygiecie_skrzydla_alu_ilosc_szt'];
				$wygiecie_innego_alu_ilosc_szt=$wynik4['wygiecie_innego_alu_ilosc_szt'];
			$suma_rodzaj_produktu[3][$ilosc_pozycji] = $wygiecie_ramy_alu_ilosc_szt+$wygiecie_skrzydla_alu_ilosc_szt+$wygiecie_innego_alu_ilosc_szt;
			$SUMA_ELEMENTOW_DANEGO_TYPU[3] += $suma_rodzaj_produktu[3][$ilosc_pozycji];

			$suma_rodzaj_produktu[4][$ilosc_pozycji]=$wynik4['zgrzanie_ilosc'];
			// echo '$wynik4[zgrzanie_ilosc]='.$wynik4['zgrzanie_ilosc'].'<br>';

			$suma_rodzaj_produktu[5][$ilosc_pozycji]=$wynik4['wstawienie_slupka_ilosc']+$wynik4['wstawienie_slupka_ruchomego_ilosc'];
			$suma_rodzaj_produktu[6][$ilosc_pozycji]=$wynik4['wyfrezowanie_odwodnienia_ilosc'];
			$suma_rodzaj_produktu[7][$ilosc_pozycji]=$wynik4['listwa_przyszybowa_ilosc'];
			$suma_rodzaj_produktu[11][$ilosc_pozycji]=$wynik4['dociecie_kompletu_listew_przyszybowych_ilosc'];
			$suma_rodzaj_produktu[8][$ilosc_pozycji]=$wynik4['okucie_ilosc'];
			$suma_rodzaj_produktu[9][$ilosc_pozycji]=$wynik4['zaszklenie_ilosc'];

// echo '$wynik4[ilosc_sztuk]='.$wynik4['ilosc_sztuk'].'<br>';

			$suma_rodzaj_produktu[10][$ilosc_pozycji]=$wynik4['ilosc_sztuk'];
			$suma_rodzaj_produktu[0][$ilosc_pozycji]=$wynik4['ilosc_sztuk'];
			
			$SUMA_ELEMENTOW_DANEGO_TYPU[4] += $suma_rodzaj_produktu[4][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[5] += $suma_rodzaj_produktu[5][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[6] += $suma_rodzaj_produktu[6][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[7] += $suma_rodzaj_produktu[7][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[8] += $suma_rodzaj_produktu[8][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[9] += $suma_rodzaj_produktu[9][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[0] += $suma_rodzaj_produktu[0][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[10] += $suma_rodzaj_produktu[10][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[11] += $suma_rodzaj_produktu[11][$ilosc_pozycji];
			}	 // do while($wynik4= mysqli_fetch_assoc($pytanie4))
		//$ilosc_pozycji_zamowienia = $ilosc_pozycji;

		$SUMA_0_WYKONANE = array();
		$SUMA_1_WYKONANE = array();
		$SUMA_2_WYKONANE = array();
		$SUMA_3_WYKONANE = array();
		$SUMA_4_WYKONANE = array();
		$SUMA_5_WYKONANE = array();
		$SUMA_6_WYKONANE = array();
		$SUMA_7_WYKONANE = array();
		$SUMA_8_WYKONANE = array();
		$SUMA_9_WYKONANE = array();
		$SUMA_10_WYKONANE = array();
		$SUMA_11_WYKONANE = array();
		$pytanie = mysqli_query($conn, "SELECT * FROM realizacja_produkcji WHERE zamowienie_id=".$zamowienie_id_akord.";");
		while($wynik= mysqli_fetch_assoc($pytanie))
			{
			//$zamowienie_id[$ilosc_zamowien]=$wynik['zamowienie_id'];
			//$temp = $wynik['zamowienie_id'];
			
			$rodzaj_produktu=$wynik['rodzaj_produktu'];
			$ilosc=$wynik['ilosc'];
			$pozycja=$wynik['pozycja'];
			
			$SUMA_0_WYKONANE[$pozycja] = 0;
			$SUMA_1_WYKONANE[$pozycja] = 0;
			$SUMA_2_WYKONANE[$pozycja] = 0;
			$SUMA_3_WYKONANE[$pozycja] = 0;
			$SUMA_4_WYKONANE[$pozycja] = 0;
			$SUMA_5_WYKONANE[$pozycja] = 0;
			$SUMA_6_WYKONANE[$pozycja] = 0;
			$SUMA_7_WYKONANE[$pozycja] = 0;
			$SUMA_8_WYKONANE[$pozycja] = 0;
			$SUMA_9_WYKONANE[$pozycja] = 0;
			$SUMA_10_WYKONANE[$pozycja] = 0;
			$SUMA_11_WYKONANE[$pozycja] = 0;

			if($pozycja != 'on')
				{
				if($rodzaj_produktu == 1) $SUMA_1_WYKONANE[$pozycja] += $ilosc;
				if($rodzaj_produktu == 2) $SUMA_2_WYKONANE[$pozycja] += $ilosc;
				if($rodzaj_produktu == 3) $SUMA_3_WYKONANE[$pozycja] += $ilosc;
				if($rodzaj_produktu == 4) $SUMA_4_WYKONANE[$pozycja] += $ilosc;
				if($rodzaj_produktu == 5) $SUMA_5_WYKONANE[$pozycja] += $ilosc;
				if($rodzaj_produktu == 6) $SUMA_6_WYKONANE[$pozycja] += $ilosc;
				if($rodzaj_produktu == 7) $SUMA_7_WYKONANE[$pozycja] += $ilosc;
				if($rodzaj_produktu == 8) $SUMA_8_WYKONANE[$pozycja] += $ilosc;
				if($rodzaj_produktu == 9) $SUMA_9_WYKONANE[$pozycja] += $ilosc;
				if($rodzaj_produktu == 0) $SUMA_0_WYKONANE[$pozycja] += $ilosc;
				if($rodzaj_produktu == 10) $SUMA_10_WYKONANE[$pozycja] += $ilosc;
				if($rodzaj_produktu == 11) $SUMA_11_WYKONANE[$pozycja] += $ilosc;
				} // do if($pozycja != 'on')
			else
				{
				for ($x=1; $x<=$ilosc_pozycji; $x++)
					{
					$SUMA_0_WYKONANE[$x] = 0;
					$SUMA_1_WYKONANE[$x] = 0;
					$SUMA_2_WYKONANE[$x] = 0;
					$SUMA_3_WYKONANE[$x] = 0;
					$SUMA_4_WYKONANE[$x] = 0;
					$SUMA_5_WYKONANE[$x] = 0;
					$SUMA_6_WYKONANE[$x] = 0;
					$SUMA_7_WYKONANE[$x] = 0;
					$SUMA_8_WYKONANE[$x] = 0;
					$SUMA_9_WYKONANE[$x] = 0;
					$SUMA_10_WYKONANE[$x] = 0;
					$SUMA_11_WYKONANE[$x] = 0;
					if($rodzaj_produktu == 1) $SUMA_1_WYKONANE[$x] = $suma_rodzaj_produktu[1][$x];
					if($rodzaj_produktu == 2) $SUMA_2_WYKONANE[$x] = $suma_rodzaj_produktu[2][$x];
					if($rodzaj_produktu == 3) $SUMA_3_WYKONANE[$x] = $suma_rodzaj_produktu[3][$x];
					if($rodzaj_produktu == 4) $SUMA_4_WYKONANE[$x] = $suma_rodzaj_produktu[4][$x];
					if($rodzaj_produktu == 5) $SUMA_5_WYKONANE[$x] = $suma_rodzaj_produktu[5][$x];
					if($rodzaj_produktu == 6) $SUMA_6_WYKONANE[$x] = $suma_rodzaj_produktu[6][$x];
					if($rodzaj_produktu == 7) $SUMA_7_WYKONANE[$x] = $suma_rodzaj_produktu[7][$x];
					if($rodzaj_produktu == 8) $SUMA_8_WYKONANE[$x] = $suma_rodzaj_produktu[8][$x];
					if($rodzaj_produktu == 9) $SUMA_9_WYKONANE[$x] = $suma_rodzaj_produktu[9][$x];
					if($rodzaj_produktu == 0) $SUMA_0_WYKONANE[$x] = $suma_rodzaj_produktu[0][$x];
					if($rodzaj_produktu == 10) $SUMA_10_WYKONANE[$x] = $suma_rodzaj_produktu[10][$x];
					if($rodzaj_produktu == 11) $SUMA_11_WYKONANE[$x] = $suma_rodzaj_produktu[11][$x];
					} // do for ($x=1; $x<=$ilosc_pozycji_zamowienia; $x++)
				} // do else
			} // do while($wynik= mysqli_fetch_assoc($pytanie))
			
			//zerowanie zmiennych
			$SUMA_DO_ZROBIENIA = array();
			$do_zrobienia = array();
			for($z=0; $z<=11; $z++) {
				$do_zrobienia[$z] = 0;
				$SUMA_DO_ZROBIENIA[$z] = 0;
			}


			$czy_zmieniac_status_na_przygotowane_do_wysylki = 0;
			$czy_zmieniac_status_na_zrealizowane = 0;
			for ($y=1; $y<=$ilosc_pozycji; $y++)
				{
				//echo '<br><br>y='.$y.'<br>';
				//sprawdzamy czy ktoras z pozycji juz jest w 100% wykonana
				//$czy_pozycja_w_100_procentach_zrobiona[$y] = 0;
				$do_zrobienia[1] = $SUMA_1_WYKONANE[$y]; //$suma_rodzaj_produktu[1][$y]-$SUMA_1_WYKONANE[$y]
				$do_zrobienia[1] = $suma_rodzaj_produktu[1][$y]; 


				$SUMA_DO_ZROBIENIA[1] += $do_zrobienia[1];
				$do_zrobienia[2] = $suma_rodzaj_produktu[2][$y]-$SUMA_2_WYKONANE[$y];
				$SUMA_DO_ZROBIENIA[2] += $do_zrobienia[2];
				$do_zrobienia[3] = $suma_rodzaj_produktu[3][$y]-$SUMA_3_WYKONANE[$y];
				$SUMA_DO_ZROBIENIA[3] += $do_zrobienia[3];
				$do_zrobienia[4] = $suma_rodzaj_produktu[4][$y]-$SUMA_4_WYKONANE[$y];
				$SUMA_DO_ZROBIENIA[4] += $do_zrobienia[4];
				$do_zrobienia[5] = $suma_rodzaj_produktu[5][$y]-$SUMA_5_WYKONANE[$y];
				$SUMA_DO_ZROBIENIA[5] += $do_zrobienia[5];
				$do_zrobienia[6] = $suma_rodzaj_produktu[6][$y]-$SUMA_6_WYKONANE[$y];
				$SUMA_DO_ZROBIENIA[6] += $do_zrobienia[6];
				$do_zrobienia[7] = $suma_rodzaj_produktu[7][$y]-$SUMA_7_WYKONANE[$y];
				$SUMA_DO_ZROBIENIA[7] += $do_zrobienia[7];
				$do_zrobienia[8] = $suma_rodzaj_produktu[8][$y]-$SUMA_8_WYKONANE[$y];
				$SUMA_DO_ZROBIENIA[8] += $do_zrobienia[8];
				$do_zrobienia[9] = $suma_rodzaj_produktu[9][$y]-$SUMA_9_WYKONANE[$y];
				$SUMA_DO_ZROBIENIA[9] += $do_zrobienia[9];


				$do_zrobienia[0] = $suma_rodzaj_produktu[0][$y]-$SUMA_0_WYKONANE[$y]; 


				$SUMA_DO_ZROBIENIA[0] += $do_zrobienia[0];
				$do_zrobienia[10] = $suma_rodzaj_produktu[10][$y]-$SUMA_10_WYKONANE[$y];
				$SUMA_DO_ZROBIENIA[10] += $do_zrobienia[10];
				$do_zrobienia[11] = $suma_rodzaj_produktu[11][$y]-$SUMA_11_WYKONANE[$y];
				$SUMA_DO_ZROBIENIA[11] += $do_zrobienia[11];
				/*
			
			echo 'czy_zmieniac_status_na_przygotowane_do_wysylki='.$czy_zmieniac_status_na_przygotowane_do_wysylki.'<br>';
			echo 'czy_zmieniac_status_na_zrealizowane='.$czy_zmieniac_status_na_zrealizowane.'<br>';
*/
				//for ($z=1; $z<=$dl_lista_produktow; $z++) $czy_pozycja_w_100_procentach_zrobiona += $do_zrobienia[$z];
				$czy_zmieniac_status_na_przygotowane_do_wysylki += $do_zrobienia[0] + $do_zrobienia[1] + $do_zrobienia[2] + $do_zrobienia[3] + $do_zrobienia[4] + $do_zrobienia[5] + $do_zrobienia[10] + $do_zrobienia[11]; // + $do_zrobienia[7]
				$czy_zmieniac_status_na_zrealizowane += $do_zrobienia[0] + $do_zrobienia[1] + $do_zrobienia[2] + $do_zrobienia[3] + $do_zrobienia[4] + $do_zrobienia[5] + $do_zrobienia[11]; // + $do_zrobienia[7]
				}
		
		//sprawdzamy jaki był wcześniej status
		$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT status FROM zamowienia WHERE id = ".$zamowienie_id_akord.";"));
		$stary_status = $sql['status'];
	
		if(($czy_zmieniac_status_na_zrealizowane == 0) && ($czy_zmieniac_status_na_przygotowane_do_wysylki != 0))
			{
			$pytanie103 = mysqli_query($conn, "UPDATE zamowienia SET status = 'Zrealizowane' WHERE id = ".$zamowienie_id_akord.";");
			if($stary_status != 'Zrealizowane') echo '<div class="text_duzy_niebieski" align="center">Status zamówienia został zmieniony na : Zrealizowane.</div>';
			}
		
		if($czy_zmieniac_status_na_przygotowane_do_wysylki == 0)
			{
			$pytanie103 = mysqli_query($conn, "UPDATE zamowienia SET status = 'Przygotowane do wysyłki' WHERE id = ".$zamowienie_id_akord.";");
			if($stary_status != 'Przygotowane do wysyłki')  echo '<div class="text_duzy_niebieski" align="center">Status zamówienia został zmieniony na : Przygotowane do wysyłki.</div>';
			}
			
			
		// ###########################################################################################################################
		// ##############################    KONIEC    zmiana statusu gdy wszystkie pozycje są wyzerowane     ########################
		// ###########################################################################################################################
		
		
		//echo 'zamowienie_id_akord='.zamowienie_id_akord.'<br>';
		//zmiana stanu gdy wszsytkie pozycje dla profili są wyzerowane
		$ilosc_pozycji=0;
		$SUMA_ELEMENTOW_DANEGO_TYPU[0] = 0;
		$pytanie4 = mysqli_query($conn, "SELECT * FROM wyceny WHERE zamowienie_id = ".$zamowienie_id_akord." AND pozycja_transport = 'nie' ORDER BY pozycja ASC;");
		while($wynik4= mysqli_fetch_assoc($pytanie4))
			{
			$ilosc_pozycji++;
			$suma_rodzaj_produktu[0][$ilosc_pozycji]=$wynik4['ilosc_sztuk'];
			$SUMA_ELEMENTOW_DANEGO_TYPU[0] += $suma_rodzaj_produktu[0][$ilosc_pozycji];
			}
		
		$SUMA_WYKONANE[0] = 0;
		$pytanie = mysqli_query($conn, "SELECT * FROM realizacja_produkcji WHERE zamowienie_id=".$zamowienie_id_akord.";");
		while($wynik= mysqli_fetch_assoc($pytanie))
			{
			$rodzaj_produktu=$wynik['rodzaj_produktu'];
			$ilosc=$wynik['ilosc'];
			if($rodzaj_produktu == 0) $SUMA_WYKONANE[0] += $ilosc;
			}
		
		//echo 'SUMA_ELEMENTOW_DANEGO_TYPU='.$SUMA_ELEMENTOW_DANEGO_TYPU[0].'<br>';
		//echo 'SUMA_WYKONANE='.$SUMA_WYKONANE[0].'<br>';

		//sprawdzamy jaki był wcześniej stan
		$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT stan FROM zamowienia WHERE id = ".$zamowienie_id_akord.";"));
		$stary_stan = $sql['stan'];
		
		if(($SUMA_ELEMENTOW_DANEGO_TYPU[0] - $SUMA_WYKONANE[0]) == 0) 
			{
			$pytanie122 = mysqli_query($conn, "UPDATE zamowienia SET stan = 'OK' WHERE id = ".$zamowienie_id_akord.";"); // zmieniamy stan w zamówieniu
			if($stary_stan != 'OK')  echo '<div align="center" class="text_duzy_niebieski"><br>Stan zamówienia został zmieniony na OK.</div>';
			}
			
		echo '<div align="center" class="text_duzy_niebieski"><br>Dane zostały zapisane.</div>';
		}
	else echo '<div align="center" class="text_duzy_czerwony">Proszę nie odświeżać strony.</div>';
	echo $powrot_do_realizacja_produkcji;

	}
else
	{
	//########################################################################################################
	//########################################################################################################
	if(($pracownik_a == '') && ($zapisz == 'Zapisz')) echo '<div align="center" class="text_duzy_czerwony">Proszę wybrać przynajmniej jednego pracownika (górna lista rozwijana).</div>';


	// echo 'przeladuj='.$przeladuj.'<br>';
	//sprawdzamy czy wpis do tego zamowienia juz istnieje. jak istnieje to update. jak nie to insert
	include("php/realizacja_produkcji_szablony.php");


	$baza_zamowienie_id = [];
	$baza_nr_zamowienia = [];
	$i=0;
	$ilosc_zamowien = 0;
	// echo 'zlecenie_transportowe='.$zlecenie_transportowe.'<br>';
	$WARUNEK = " status <> 'Dostarczone' && status <> 'Anulowane' && status <> 'Odebrane'";
	if((preg_match("/ZT/", $zlecenie_transportowe)) || ($zlecenie_transportowe == 'Kurier') || ($zlecenie_transportowe == 'Odbiór własny')) $WARUNEK = " nr_zlecenia_transportowego = '".$zlecenie_transportowe."'"; //jezeli wybrano zlec transp wyszukaj tylko te zamowienia ze zlecenia transportowego
	elseif($zlecenie_transportowe == 'WSZYSTKIE') $WARUNEK = " status <> 'Dostarczone' && status <> 'Anulowane' && status <> 'Odebrane'";
	elseif($zlecenie_transportowe == 'DO SPRAWDZENIA') $WARUNEK = " status <> 'Dostarczone' && status <> 'Anulowane' && status <> 'Odebrane' AND stan = 'Sprawdzić' AND magazyn = 'Własny'";
	elseif($zlecenie_transportowe != '') $WARUNEK = " nr_zamowienia = '".$zlecenie_transportowe."'"; // jeżeli wybrano zamówienie, pokaż tylko to zamówienie
	// echo 'warunek='.$WARUNEK.'<br>';
	$pytanie = mysqli_query($conn, "SELECT * FROM zamowienia WHERE ".$WARUNEK." ORDER BY id DESC;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$ilosc_zamowien++;
		$baza_zamowienie_id[$ilosc_zamowien]=$wynik['id'];
		$baza_nr_zamowienia[$ilosc_zamowien]=$wynik['nr_zamowienia'];
		}
	
	//$czy_zaznaczone_wszystkie = 0;
	//for ($z=1; $z<=$ilosc_pozycji; $z++) if($pozycja[$z] == 'on') $czy_zaznaczone_wszystkie++;
// tabela główna
echo '<table align="left" border="0"><tr><td>';
	echo '<table align="left" class="tabela" border="0"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
		echo '<td width="200px">Nr zamówienia</td>';
		echo '<td width="490px">Rodzaj produktu</td>';
		echo '<td width="300px">Pozycja</td>';
		echo '<td width="100px">Ilość</td>';
		if(($rodzaj_produktu == 0) && ($rodzaj_produktu != '')) echo '<td width="100px">Profile do<br>zamówienia</td>'; // jezeli wybrane profile
		if($rodzaj_produktu == 10) echo '<td width="100px">Ilość<br>paczek</td>'; // jezeli wybrane profile
		echo '<td width="300px">Pracownicy</td></tr>';
	
		echo '<FORM id="myForm" method="post">';
		echo '<INPUT type="hidden" name="page" value="realizacja_produkcji_zamowienia_do_wykonania">';
		echo '<INPUT type="hidden" name="zamowienie_id_akord" value="'.$zamowienie_id_akord.'">';
		$data_wykonania = time();
		echo '<INPUT type="hidden" name="data_wykonania" value="'.$data_wykonania.'">';
		echo '<INPUT type="hidden" name="zlecenie_transportowe" value="'.$zlecenie_transportowe.'">';
		echo '<INPUT type="hidden" name="klienci_do_planu_produkcji" value="'.$klienci_do_planu_produkcji.'">';
		echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
		echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';

		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'" class="text"><td>';
		if($rodzaj_produktu != '') $disabled=" disabled"; else $disabled=";";
		echo '<table border="0" align="center" width="100%"><tr height="50px"><td>&nbsp;</td></tr><tr height="50px"><td align="center">';



		echo '<select name="zamowienie_id_akord" onchange="submit();" class="pole_input_produkcja" '.$disabled.'>';
			echo '<option></option>';
			for ($k=1; $k<=$ilosc_zamowien; $k++) 
				if ($baza_zamowienie_id[$k] == $zamowienie_id_akord) echo '<option value="'.$baza_zamowienie_id[$k].'" selected="selected">'.$baza_nr_zamowienia[$k].'</option>';
				else echo '<option value="'.$baza_zamowienie_id[$k].'">'.$baza_nr_zamowienia[$k].'</option>';
			echo '</select>';
			
			
			if($zamowienie_id_akord) {
				$ilosc_pozycji=0;
				
				$pytanie4 = mysqli_query($conn, "SELECT * FROM wyceny WHERE zamowienie_id = ".$zamowienie_id_akord." AND pozycja_transport = 'nie' ORDER BY pozycja ASC;");
				while($wynik4= mysqli_fetch_assoc($pytanie4))
				{
					$ilosc_pozycji++;
					$klient_nazwa_2=$wynik4['klient_nazwa'];
				}
			}
			echo '<INPUT type="hidden" name="ilosc_pozycji" id="'.$zamowienie_id_akord.'" value="'.$ilosc_pozycji.'">';
		echo '</td></tr><tr height="50px"><td align="center" class="text_duzy">';
			if($klient_nazwa_2 != '') echo $klient_nazwa_2;
		echo '</td></tr></table>';
			echo '</td>';
		
		// rodzaj produktu   zmien_rodzaj_produktu('.$zamowienie_id.');
		echo '<td>';
			echo '<select name="rodzaj_produktu" onchange="submit();" class="pole_input_produkcja">';
			echo '<option></option>';

				if (($rodzaj_produktu == 0) && ($rodzaj_produktu != '')) echo '<option value="0" selected="selected">'.$TABELA_LISTA_PRODUKTOW[0].'</option>';
				else echo '<option value="0">'.$TABELA_LISTA_PRODUKTOW[0].'</option>';
				if ($rodzaj_produktu == 1) echo '<option value="1" selected="selected">'.$TABELA_LISTA_PRODUKTOW[1].'</option>';
				else echo '<option value="1">'.$TABELA_LISTA_PRODUKTOW[1].'</option>';
				if ($rodzaj_produktu == 2) echo '<option value="2" selected="selected">'.$TABELA_LISTA_PRODUKTOW[2].'</option>';
				else echo '<option value="2">'.$TABELA_LISTA_PRODUKTOW[2].'</option>';
				if ($rodzaj_produktu == 3) echo '<option value="3" selected="selected">'.$TABELA_LISTA_PRODUKTOW[3].'</option>';
				else echo '<option value="3">'.$TABELA_LISTA_PRODUKTOW[3].'</option>';
				if ($rodzaj_produktu == 4) echo '<option value="4" selected="selected">'.$TABELA_LISTA_PRODUKTOW[4].'</option>';
				else echo '<option value="4">'.$TABELA_LISTA_PRODUKTOW[4].'</option>';
				if ($rodzaj_produktu == 5) echo '<option value="5" selected="selected">'.$TABELA_LISTA_PRODUKTOW[5].'</option>';
				else echo '<option value="5">'.$TABELA_LISTA_PRODUKTOW[5].'</option>';
				// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% poniższe do odkomentowania
				// if ($rodzaj_produktu == 7) echo '<option value="7" selected="selected">'.$TABELA_LISTA_PRODUKTOW[7].'</option>';
				// else echo '<option value="7">'.$TABELA_LISTA_PRODUKTOW[7].'</option>';
				if ($rodzaj_produktu == 11) echo '<option value="11" selected="selected">'.$TABELA_LISTA_PRODUKTOW[11].'</option>';
				else echo '<option value="11">'.$TABELA_LISTA_PRODUKTOW[11].'</option>';
				if ($rodzaj_produktu == 10) echo '<option value="10" selected="selected">'.$TABELA_LISTA_PRODUKTOW[10].'</option>';
				else echo '<option value="10">'.$TABELA_LISTA_PRODUKTOW[10].'</option>';
			
			echo '</select>';
		echo '</td>';

	$SUMA_ELEMENTOW_DANEGO_TYPU = [];
	$suma_rodzaj_produktu = [];

		// pozycje
		echo '<td align="center">';
		for ($m=0; $m<=11; $m++) $SUMA_ELEMENTOW_DANEGO_TYPU[$m] = 0;

	if ($zamowienie_id_akord) {

		$ilosc_pozycji = 0;
		$pytanie4 = mysqli_query($conn, "SELECT * FROM wyceny WHERE zamowienie_id = " . $zamowienie_id_akord . " AND pozycja_transport = 'nie' ORDER BY pozycja ASC;");
		while ($wynik4 = mysqli_fetch_assoc($pytanie4)) {
			$ilosc_pozycji++;
			$wygiecie_ramy_pvc_ilosc_szt[$ilosc_pozycji] = $wynik4['wygiecie_ramy_pvc_ilosc_szt'];
			$wygiecie_skrzydla_pvc_ilosc_szt[$ilosc_pozycji] = $wynik4['wygiecie_skrzydla_pvc_ilosc_szt'];
			$wygiecie_innego_pvc_ilosc_szt[$ilosc_pozycji] = $wynik4['wygiecie_innego_pvc_ilosc_szt'];
			$suma_rodzaj_produktu[1][$ilosc_pozycji] = $wygiecie_ramy_pvc_ilosc_szt[$ilosc_pozycji] + $wygiecie_skrzydla_pvc_ilosc_szt[$ilosc_pozycji] + $wygiecie_innego_pvc_ilosc_szt[$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[1] += $suma_rodzaj_produktu[1][$ilosc_pozycji];
			$wygiecie_listwy_pvc_ilosc_szt[$ilosc_pozycji] = $wynik4['wygiecie_listwy_pvc_ilosc_szt'];
			if (($suma_rodzaj_produktu[1][$ilosc_pozycji] == 0) && ($wygiecie_listwy_pvc_ilosc_szt[$ilosc_pozycji] != 0))
				$suma_rodzaj_produktu[1][$ilosc_pozycji] = $wygiecie_listwy_pvc_ilosc_szt[$ilosc_pozycji];

			$wygiecie_wzmocnienia_okiennego_ilosc_szt[$ilosc_pozycji] = $wynik4['wygiecie_wzmocnienia_okiennego_ilosc_szt'];
			$wygiecie_innego_ilosc_szt[$ilosc_pozycji] = $wynik4['wygiecie_innego_ilosc_szt'];
			$suma_rodzaj_produktu[2][$ilosc_pozycji] = $wygiecie_wzmocnienia_okiennego_ilosc_szt[$ilosc_pozycji] + $wygiecie_innego_ilosc_szt[$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[2] += $suma_rodzaj_produktu[2][$ilosc_pozycji];

			$wygiecie_ramy_alu_ilosc_szt[$ilosc_pozycji] = $wynik4['wygiecie_ramy_alu_ilosc_szt'];
			$wygiecie_skrzydla_alu_ilosc_szt[$ilosc_pozycji] = $wynik4['wygiecie_skrzydla_alu_ilosc_szt'];
			$wygiecie_innego_alu_ilosc_szt[$ilosc_pozycji] = $wynik4['wygiecie_innego_alu_ilosc_szt'];
			$suma_rodzaj_produktu[3][$ilosc_pozycji] = $wygiecie_ramy_alu_ilosc_szt[$ilosc_pozycji] + $wygiecie_skrzydla_alu_ilosc_szt[$ilosc_pozycji] + $wygiecie_innego_alu_ilosc_szt[$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[3] += $suma_rodzaj_produktu[3][$ilosc_pozycji];

			$suma_rodzaj_produktu[4][$ilosc_pozycji] = $wynik4['zgrzanie_ilosc'];
			$suma_rodzaj_produktu[5][$ilosc_pozycji] = $wynik4['wstawienie_slupka_ilosc'] + $wynik4['wstawienie_slupka_ruchomego_ilosc'];
			$suma_rodzaj_produktu[6][$ilosc_pozycji] = $wynik4['wyfrezowanie_odwodnienia_ilosc'];
			$suma_rodzaj_produktu[7][$ilosc_pozycji] = $wynik4['listwa_przyszybowa_ilosc'];
			$suma_rodzaj_produktu[11][$ilosc_pozycji] = $wynik4['dociecie_kompletu_listew_przyszybowych_ilosc'];
			$suma_rodzaj_produktu[8][$ilosc_pozycji] = $wynik4['okucie_ilosc'];
			$suma_rodzaj_produktu[9][$ilosc_pozycji] = $wynik4['zaszklenie_ilosc'];
			$suma_rodzaj_produktu[0][$ilosc_pozycji] = $wynik4['ilosc_sztuk'];
			$suma_rodzaj_produktu[10][$ilosc_pozycji] = $wynik4['ilosc_sztuk'];

			$SUMA_ELEMENTOW_DANEGO_TYPU[4] += $suma_rodzaj_produktu[4][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[5] += $suma_rodzaj_produktu[5][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[6] += $suma_rodzaj_produktu[6][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[7] += $suma_rodzaj_produktu[7][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[8] += $suma_rodzaj_produktu[8][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[9] += $suma_rodzaj_produktu[9][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[0] += $suma_rodzaj_produktu[0][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[10] += $suma_rodzaj_produktu[10][$ilosc_pozycji];
			$SUMA_ELEMENTOW_DANEGO_TYPU[11] += $suma_rodzaj_produktu[11][$ilosc_pozycji];
		}
	}
			
			
	$zapytanie_wykonane = 0;
		//echo 'zamowienie_id_akord='.$zamowienie_id_akord.'<br>';
		//echo 'rodzaj produktu='.$rodzaj_produktu.'<br>';
		if($zamowienie_id_akord != '')
		// if(($zamowienie_id_akord != '') && ($rodzaj_produktu != ''))
			{
			if($rodzaj_produktu != '')
				{
				//sprawdzamy czy do tego zamówienia i do tego produktu ktoś już wydawał jakieś ilości. Jeżeli tak, to blokujemy możliwość zaznaczenia wszystkich pozycji - bo nie policzy dobrze wartości realizacji, gdy już ktoś wydał np 5szt, to przy ponownej opcji policzy wszsytkie ilości sztuk, już z tymi 5 które ktoś już wydał
				$disabled_wszystkie_pozycje = '';
				$pytanie43 = mysqli_query($conn, "SELECT ilosc FROM realizacja_produkcji WHERE zamowienie_id = ".$zamowienie_id_akord." AND rodzaj_produktu = ".$rodzaj_produktu." AND ilosc <> 0 LIMIT 1;");
				while($wynik43= mysqli_fetch_assoc($pytanie43)) $disabled_wszystkie_pozycje = "disabled";	
				echo '<div class="produkcja_szablony font_size_18">Wszystkie pozycje : </div>';

				$id_test = 'id_'.$zamowienie_id_akord;
				//if($czy_zaznaczone_wszystkie != $ilosc_pozycji) $nazwa_wszystkie_pozycje = ''; else $nazwa_wszystkie_pozycje = 'on';
				if($nazwa_wszystkie_pozycje == 'on') $checked_wszystkie_pozycje = "checked";			
				else $checked_wszystkie_pozycje = '';
				
				$ilosc_juz_wykonanych = [];
				echo '<div class="produkcja_szablony_checkbox"><input type="checkbox" class="produkcja_checkbox" id="'.$id_test.'" name="nazwa_wszystkie_pozycje" '.$checked_wszystkie_pozycje.' '.$disabled_wszystkie_pozycje.' onClick="zaznacz_pozycje('.$zamowienie_id_akord.')"></div>';
				echo '<INPUT type="hidden" name="ilosc_pozycji" id="'.$zamowienie_id_akord.'" value="'.$ilosc_pozycji.'">';
				for ($m=1; $m<=$ilosc_pozycji; $m++) 
					{
					$zapytanie_wykonane = 0;
					$pytanie43 = mysqli_query($conn, "SELECT ilosc FROM realizacja_produkcji WHERE zamowienie_id = ".$zamowienie_id_akord." AND rodzaj_produktu = ".$rodzaj_produktu." AND pozycja = 'on';");
					while($wynik43= mysqli_fetch_assoc($pytanie43))
						{
						$zapytanie_wykonane = 1;
						$ilosc_juz_wykonanych_on = $wynik43['ilosc'];
						}
						
					if($zapytanie_wykonane == 0) //jezeli nie sa wpisane wszystkie pozycje jako ON|!!!
						{
						$ilosc_juz_wykonanych[$m] = 0;
						//sprawdzamy czy już jakies elementy nie zostały zrobione
						$pytanie43 = mysqli_query($conn, "SELECT ilosc FROM realizacja_produkcji WHERE zamowienie_id = ".$zamowienie_id_akord." AND rodzaj_produktu = ".$rodzaj_produktu." AND pozycja = ".$m.";");
						while($wynik43= mysqli_fetch_assoc($pytanie43))
							{
							//$zapytanie_wykonane = 1;
							$temp=$wynik43['ilosc'];
							$ilosc_juz_wykonanych[$m] += $temp;
							}
						$suma_rodzaj_produktu[$rodzaj_produktu][$m] = $suma_rodzaj_produktu[$rodzaj_produktu][$m] - $ilosc_juz_wykonanych[$m]; //odliczamy juz wykonane elementy
						$SUMA_ELEMENTOW_DANEGO_TYPU[$rodzaj_produktu] = $SUMA_ELEMENTOW_DANEGO_TYPU[$rodzaj_produktu] - $ilosc_juz_wykonanych[$m];
						}
					else
						{
						$suma_rodzaj_produktu[$rodzaj_produktu][$m] = 0; //odliczamy juz wykonane elementy
						}
					
					if(isset($pozycja[$m]) == 'on') $checked = "checked"; else $checked = ''; //back here

					$nazwa_pozycja = 'pozycja['.$m.']';
					echo '<div class="produkcja_szablony font_size_18">Pozycja '.$m.' : </div>';
					echo '<div class="produkcja_szablony_checkbox"><input name="'.$nazwa_pozycja.'" type="checkbox" '.$checked.' class="produkcja_checkbox" onchange="this.form.submit()"></div>';
					}
					
				if($zapytanie_wykonane == 1)
					{
					$SUMA_ELEMENTOW_DANEGO_TYPU[$rodzaj_produktu] = $SUMA_ELEMENTOW_DANEGO_TYPU[$rodzaj_produktu] - $ilosc_juz_wykonanych_on;
					}	
				//wyswietlanie opcji szablonów, profili i uszczelek
				if(($rodzaj_produktu == 0) || ($rodzaj_produktu == 10)) echo '<div class="hr">&nbsp;</div>';
				}

			//szblony wczytujemy tylko dla profili i wyrobów, czyli rodzaj_produktu = 0 i 10

			if(($rodzaj_produktu == 0) || ($rodzaj_produktu == 10))
			{
				//sprawdzamy czy już to zamówienie nie ma wpisów w bazie szablonów
				$sql1 = "SELECT * FROM realizacja_produkcji_szablony WHERE zamowienie_id = ".$zamowienie_id_akord.";";
				$result = mysqli_query($conn, $sql1);
				if(mysqli_num_rows($result) > 0) 
					while ($wynik = mysqli_fetch_assoc($result)) 
					{
						$szablony_przy_wyrobach_ilosc=$wynik['szablony_przy_wyrobach_ilosc'];
						if($szablony_przy_wyrobach_ilosc != 0) $szablony_przy_wyrobach = 'on';
						
						$szablony_luzem_ilosc=$wynik['szablony_luzem_ilosc'];
						if($szablony_luzem_ilosc != 0) $szablony_luzem = 'on';

						$profile_ilosc=$wynik['profile_ilosc'];
						if($profile_ilosc != 0) $profile = 'on';

						$uszczelki_ilosc=$wynik['uszczelki_ilosc'];
						if($uszczelki_ilosc != 0) $uszczelki = 'on';
					}

				if($szablony_przy_wyrobach_on == 'on') $szablony_przy_wyrobach_checked = "checked"; else $szablony_przy_wyrobach_checked = '';
				if($szablony_luzem_on == 'on') $szablony_luzem_checked = "checked"; else $szablony_luzem_checked = '';
				if($profile_on == 'on') $profile_checked = "checked"; else $profile_checked = '';
				if($uszczelki_on == 'on') $uszczelki_checked = "checked"; else $uszczelki_checked = '';

				echo '<div class="produkcja_szablony font_size_12">Szablony przy wyrobach : </div>';
				echo '<div class="produkcja_szablony_checkbox"><input type="checkbox" class="produkcja_checkbox" name="szablony_przy_wyrobach_on" '.$szablony_przy_wyrobach_checked.' onchange="submit();"></div>';

				echo '<div class="produkcja_szablony font_size_12">Szablony luzem : </div>';
				echo '<div class="produkcja_szablony_checkbox"><input type="checkbox" class="produkcja_checkbox" name="szablony_luzem_on" '.$szablony_luzem_checked.' onchange="submit();"></div>';

				echo '<div class="produkcja_szablony font_size_12">Profile : </div>';
				echo '<div class="produkcja_szablony_checkbox"><input type="checkbox" class="produkcja_checkbox" name="profile_on" '.$profile_checked.' onchange="submit();"></div>';

				echo '<div class="produkcja_szablony font_size_12">Uszczelki : </div>';
				echo '<div class="produkcja_szablony_checkbox"><input type="checkbox" class="produkcja_checkbox" name="uszczelki_on" '.$uszczelki_checked.' onchange="submit();"></div>';
				echo '<div style="clear:both;"></div>';
			}

		echo '</td>';

		}

		//###############################   ilość dla pozycji   #####################################
		echo '<td valign="top">';
		if($rodzaj_produktu != '') echo '<div class="produkcja_select"></div>';
		$suma_do_zrobienia = 0;
		$zamowic_profile = [];
		if(($zamowienie_id_akord != '') && ($rodzaj_produktu != ''))
			{
			for ($m=1; $m<=$ilosc_pozycji; $m++) 
				{
				if(isset($pozycja[$m]) == 'on')
					{
					$suma_do_zrobienia += $suma_rodzaj_produktu[$rodzaj_produktu][$m];
					
					if($suma_rodzaj_produktu[$rodzaj_produktu][$m] != 0)
						{
						$nazwa_ilosc_dla_pozycji = 'ilosc_dla_pozycji['.$rodzaj_produktu.']['.$m.']';
						if($nazwa_wszystkie_pozycje == 'on') 
							{
							echo '<INPUT type="hidden" name="'.$nazwa_ilosc_dla_pozycji.'"  value="'.$suma_rodzaj_produktu[$rodzaj_produktu][$m].'">';
							$disabled = ' disabled';
							}
						else $disabled = '';
						
						if($rodzaj_produktu == 0) $odliczanie = 0; else $odliczanie = 1;
						echo '<div class="produkcja_select">';
						echo '<div class="produkcja_select_top"></div>';
						echo '<select name="'.$nazwa_ilosc_dla_pozycji.'" class="pole_input_produkcja" onchange="submit();" '.$disabled.'>';
						for ($a=$odliczanie; $a<=$suma_rodzaj_produktu[$rodzaj_produktu][$m]; $a++) 
							{
							if(($a == $suma_rodzaj_produktu[$rodzaj_produktu][$m]) && ($ilosc_dla_pozycji[$rodzaj_produktu][$m] == '')) 
								{
								echo '<option value="'.$a.'" selected="selected">'.$a.'</option>';
								$disabled_wszystkie_pozycje[$m] = " disabled";		//do checkboxa od zamawiania profili
								}
							elseif($ilosc_dla_pozycji[$rodzaj_produktu][$m] == $a) 
								{
								echo '<option value="'.$a.'" selected="selected">'.$a.'</option>';
								$disabled_wszystkie_pozycje[$m] = " disabled";		//do checkboxa od zamawiania profili
								}
								else 
									{
									echo '<option value="'.$a.'">'.$a.'</option>';
									$disabled_wszystkie_pozycje[$m] = " ";		//do checkboxa od zamawiania profili
									}
							}
						echo '</select></div>';
						}
					else 
						{
						echo '<div class="produkcja_select"></div>';
						echo '<div class="produkcja_select">0</div>';
						$disabled_wszystkie_pozycje[$m] = "disabled";
						// odznaczamy ptaszka jeżeli jest wydana cała ilosc elementu z pozycji
						$pytanie121 = mysqli_query($conn, "SELECT * FROM realizacja_produkcji WHERE zamowienie_id = ".$zamowienie_id_akord." AND pozycja = ".$m." AND rodzaj_produktu = '0' ORDER BY id DESC LIMIT 1;");
						while($wynik121= mysqli_fetch_assoc($pytanie121))
							{
							$zamowic_profile[$m]=$wynik121['zamowic_profile'];
							$id_zamowic_profile = $wynik121['id'];
							$pytanie122 = mysqli_query($conn, "UPDATE realizacja_produkcji SET zamowic_profile = '' WHERE id = ".$id_zamowic_profile.";");
							}
						}
					}
				else echo '<div class="produkcja_select">&nbsp;</div>';
				}
			if(($rodzaj_produktu == 0) || ($rodzaj_produktu == 10)) echo '<div class="hr">&nbsp;</div>';
			}

		//ilość dla szablonów, profili i uszczelek
		// if($zamowienie_id_akord != '') echo '<div class="hr">&nbsp;</div>';
		// if(($zamowienie_id_akord != '') && ($rodzaj_produktu != '')) echo '<div class="hr">&nbsp;</div>';
		if(($rodzaj_produktu == 0) || ($rodzaj_produktu == 10))
		{

			if($szablony_przy_wyrobach_on == 'on') 
			{
				echo '<div class="produkcja_select">';
					echo '<div class="produkcja_select_top">&nbsp;</div>';
					echo '<select name="szablony_przy_wyrobach_ilosc" class="pole_input_produkcja" onchange="submit();">';
					for($s=1; $s <=10; $s++) if($szablony_przy_wyrobach_ilosc == $s) echo '<option value="'.$s.'" selected="selected">'.$s.'</option>'; else echo '<option value="'.$s.'">'.$s.'</option>';
					echo '</select>';
				echo '</div>'; 
			}
			else echo '<div class="produkcja_select">&nbsp;</div>';

			if($szablony_luzem_on == 'on') 
			{
				echo '<div class="produkcja_select">';
					echo '<div class="produkcja_select_top">&nbsp;</div>';
					echo '<select name="szablony_luzem_ilosc" class="pole_input_produkcja" onchange="submit();">';
					for($s=1; $s <=10; $s++) if($szablony_luzem_ilosc == $s) echo '<option value="'.$s.'" selected="selected">'.$s.'</option>'; else echo '<option value="'.$s.'">'.$s.'</option>';
					echo '</select>';
				echo '</div>'; 
			}
			else echo '<div class="produkcja_select">&nbsp;</div>';

			if($profile_on == 'on') 
			{
				echo '<div class="produkcja_select">';
					echo '<div class="produkcja_select_top">&nbsp;</div>';
					echo '<select name="profile_ilosc" class="pole_input_produkcja" onchange="submit();">';
					for($s=1; $s <=10; $s++) if($profile_ilosc == $s) echo '<option value="'.$s.'" selected="selected">'.$s.'</option>'; else echo '<option value="'.$s.'">'.$s.'</option>';
					echo '</select>';
				echo '</div>'; 
			}
			else echo '<div class="produkcja_select">&nbsp;</div>';

			if($uszczelki_on == 'on') 
			{
				echo '<div class="produkcja_select">';
					echo '<div class="produkcja_select_top">&nbsp;</div>';
					echo '<select name="uszczelki_ilosc" class="pole_input_produkcja" onchange="submit();">';
					for($s=1; $s <=10; $s++) if($uszczelki_ilosc == $s) echo '<option value="'.$s.'" selected="selected">'.$s.'</option>'; else echo '<option value="'.$s.'">'.$s.'</option>';
					echo '</select>';
				echo '</div>'; 
			}
			else echo '<div class="produkcja_select">&nbsp;</div>';

			echo '<div style="clear:both;"></div>';
		}

		echo '</td>';

	$ilosc_pracownikow=0;
	$id_pracownika = [];
	$imie = [];
	$nazwisko = [];
	$pytanie = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE stanowisko = 'produkcja' AND aktywny = 'on' ORDER BY id ASC;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$ilosc_pracownikow++;
		$id_pracownika[$ilosc_pracownikow]=$wynik['id'];
		$imie[$ilosc_pracownikow]=$wynik['imie'];
		$nazwisko[$ilosc_pracownikow]=$wynik['nazwisko'];
		}
		
		
	// ############################################################################################################################
	// do ilosc paczek
	// ############################################################################################################################
	if(($zamowienie_id_akord != '') && ($rodzaj_produktu == 10))
		{
		echo '<td>';
		$ilosc_paczek_juz_dodanych = 0;
		//sprawdzamy czy jakaś ilosc paczki nie została już wpisana
		
		$pytanie1343 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_tresc WHERE zamowienie_id = ".$zamowienie_id_akord." LIMIT 1;");
		while($wynik1343= mysqli_fetch_assoc($pytanie1343))
			{
			$klient_id=$wynik1343['klient_id'];
			$nr_zlecenia_transportowego=$wynik1343['nr_zlecenia_transportowego'];
			}		
			
		//echo 'ilosc dodanych='.$ilosc_paczek_juz_dodanych.'<br>';
		$pozycja_zaznaczona = 0;
		for ($n=1; $n<=$ilosc_pozycji; $n++) if(isset($pozycja[$n]) == 'on') $pozycja_zaznaczona = 1;
		
		if($pozycja_zaznaczona == 1)
			{
			//if($zamowienie_dodane_do_zlec_trans == 1)
				//{
				if($ilosc_paczek_juz_dodanych != 0) echo 'Ilość paczek: '.$ilosc_paczek_juz_dodanych.'<br>';
				echo '<table align="center" border="0" cellpadding="0" cellspacing="0" class="text_duzy">';
				echo '<tr align="center" height="80px"><td width="100px">';
				echo '<select name="ilosc_paczek" class="pole_input_produkcja">';
					echo '<option></option>';
					for($z=1; $z<=10; $z++)	echo '<option value="'.$z.'">'.$z.'</option>';
				echo '</select>';
				echo '</td></tr></table>';
				//}
			//else echo 'Zamówienie NIE istnieje w żadnym zleceniu transportowym';
			}
		
		echo '</td>';
		}



		// ############################################################################################################################
		// do zamówić profile
		// ############################################################################################################################
		if(($rodzaj_produktu == 0) && ($rodzaj_produktu != ''))
			{
			echo '<td valign="top">';
			echo '<div class="produkcja_szablony_checkbox">&nbsp;</div>';
			
			echo '<INPUT type="hidden" name="ilosc_pozycji" id="'.$zamowienie_id_akord.'" value="'.$ilosc_pozycji.'">';
			for ($m=1; $m<=$ilosc_pozycji; $m++) 
				{
				if(isset($pozycja[$m]) == 'on')
					{
					//sprawdzamy czy nie został już wcześniej zaznaczony dla danej pozycji
					$pytanie121 = mysqli_query($conn, "SELECT * FROM realizacja_produkcji WHERE zamowienie_id = ".$zamowienie_id_akord." AND pozycja = ".$m." AND rodzaj_produktu = '0' ORDER BY id DESC LIMIT 1;");
					while($wynik121= mysqli_fetch_assoc($pytanie121))
						$zamowic_profile[$m]=$wynik121['zamowic_profile'];
					
					if(isset($zamowic_profile[$m]) == 'on') 
						{
						$checked_zamowic_profile = 'checked'; 
						$disabled_wszystkie_pozycje[$m] = ' ';
						}
					else $checked_zamowic_profile = '';
					$nazwa_zamowic_profile = 'zamowic_profile['.$m.']';
					echo '<div class="produkcja_szablony_checkbox"><input name="'.$nazwa_zamowic_profile.'" type="checkbox" '.$disabled_wszystkie_pozycje[$m].'  '.$checked_zamowic_profile.' class="produkcja_checkbox"></div>';
					}
				else echo '<div class="produkcja_szablony_checkbox">&nbsp;</div>';
				}
				if($zapytanie_wykonane == 1) $SUMA_ELEMENTOW_DANEGO_TYPU[$rodzaj_produktu] = $SUMA_ELEMENTOW_DANEGO_TYPU[$rodzaj_produktu] - $ilosc_juz_wykonanych_on;
			
			echo '</td>';
			}


	// lista pracownikow
	echo '<td align="left">';
		echo '<table align="left" border="0" cellpadding="0" cellspacing="0" class="text">';
		
		//sprawdzamy czy domyślni pracownicy są juz zapisani w bazie
		$data_dopisania = date('d-m-Y', time());
		$pytanie33 = mysqli_query($conn, "SELECT * FROM pracownicy_do_akordow WHERE rodzaj_produktu = '".$rodzaj_produktu."' AND data_dopisania='".$data_dopisania."';");
		while($wynik33= mysqli_fetch_assoc($pytanie33))
			{
			$pracownik_a=$wynik33['pracownik_a'];
			$pracownik_b=$wynik33['pracownik_b'];
			$pracownik_c=$wynik33['pracownik_c'];
			$pracownik_d=$wynik33['pracownik_d'];
			}
			
				
		echo '<tr align="center"><td>';
			echo '<select name="pracownik_a" class="pole_input_produkcja">';
			echo '<option></option>';
			for ($a=1; $a<=$ilosc_pracownikow; $a++) 
			if($pracownik_a == $id_pracownika[$a]) echo '<option value="'.$id_pracownika[$a].'" selected="selected">'.$imie[$a].' '.$nazwisko[$a].'</option>';
			else echo '<option value="'.$id_pracownika[$a].'">'.$imie[$a].' '.$nazwisko[$a].'</option>';
			echo '</select>';
		echo '</td></tr>';
		
		echo '<tr align="center"><td>';
			echo '<select name="pracownik_b" class="pole_input_produkcja">';
			echo '<option></option>';
			for ($a=1; $a<=$ilosc_pracownikow; $a++) 
			if($pracownik_b == $id_pracownika[$a]) echo '<option value="'.$id_pracownika[$a].'" selected="selected">'.$imie[$a].' '.$nazwisko[$a].'</option>';
			else echo '<option value="'.$id_pracownika[$a].'">'.$imie[$a].' '.$nazwisko[$a].'</option>';
			echo '</select>';
		echo '</td></tr>';
		echo '<tr align="center"><td>';
			echo '<select name="pracownik_c" class="pole_input_produkcja">';
			echo '<option></option>';
			for ($a=1; $a<=$ilosc_pracownikow; $a++) 
			if($pracownik_c == $id_pracownika[$a]) echo '<option value="'.$id_pracownika[$a].'" selected="selected">'.$imie[$a].' '.$nazwisko[$a].'</option>';
			else echo '<option value="'.$id_pracownika[$a].'">'.$imie[$a].' '.$nazwisko[$a].'</option>';
			echo '</select>';
		echo '</td></tr>';
		echo '<tr align="center"><td>';
			echo '<select name="pracownik_d" class="pole_input_produkcja">';
			echo '<option></option>';
			for ($a=1; $a<=$ilosc_pracownikow; $a++) 
			if($pracownik_d == $id_pracownika[$a]) echo '<option value="'.$id_pracownika[$a].'" selected="selected">'.$imie[$a].' '.$nazwisko[$a].'</option>';
			else echo '<option value="'.$id_pracownika[$a].'">'.$imie[$a].' '.$nazwisko[$a].'</option>';
			echo '</select>';
		echo '</td></tr></table>';
	echo '</td></tr>';
echo '</table>';

echo '</td><td align="left" width="150px">&nbsp;';
		echo '<div align="center"><input type="submit" value="Zapisz" name="zapisz" class="button_zapisz_produkcja"></div>';

echo '</td></tr><tr><td align="left" colspan="2"><br>';
echo '</form>';
if($zamowienie_id_akord == '') include("php/planowanie_produkcji.php");

echo '</td></tr></table>';




//if(($czy_zaznaczone_wszystkie != 0) && ($suma_do_zrobienia != 0)) echo '<div align="center"><input type="submit" value="Zapisz" name="zapisz" class="button_zapisz_produkcja"></div>';
} // do else if zapisz -== zapsiz
?>