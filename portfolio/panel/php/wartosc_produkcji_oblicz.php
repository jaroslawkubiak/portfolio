<?php
//############ zliczam i uzupelniam daty i wartosc produckji ORAZ stopien trudnosci #############################
$id_oblicz = [];
$wartosc_realizacji = [];
$wartosc_profili = [];
$rodzaj_produktu_oblicz = [];
$ilosc_oblicz = [];
$zamowienie_id = [];
$pozycja_oblicz = [];
$data_wykonania_baza = [];
$data_wykonania_dzien = [];
$data_wykonania_miesiac = [];
$data_wykonania_rok = [];
$SUMA_stopien_trudnosci = 0;

	$z = 0;
	$pytanie5 = mysqli_query($conn, "SELECT * FROM realizacja_produkcji WHERE id = '".$realizacja_produkcji_id."';");
	while($wynik5= mysqli_fetch_assoc($pytanie5))
		{
		$z++;
		$id_oblicz[$z]=$wynik5['id'];
		$rodzaj_produktu_oblicz[$z]=$wynik5['rodzaj_produktu'];
		$ilosc_oblicz[$z]=$wynik5['ilosc'];
		
		$zamowienie_id[$z]=$wynik5['zamowienie_id'];
		$pozycja_oblicz[$z]=$wynik5['pozycja'];
		
		$data_wykonania_baza[$z] = $wynik5['data_wykonania'];
		$data_wykonania_dzien[$z] = date('j', $data_wykonania_baza[$z]);
		$data_wykonania_miesiac[$z] = date('n', $data_wykonania_baza[$z]);
		$data_wykonania_rok[$z] = date('Y', $data_wykonania_baza[$z]);
		
		// wydalismy wszystkie ilosci z danej pozycji - nie musimy dzielic przez ilosc sztuk 
		if($pozycja_oblicz[$z] == 'on')
			{
			// echo 'wydaliśmy całą pozycję<br>';
			$pytanie46 = mysqli_query($conn, "SELECT * FROM wyceny WHERE zamowienie_id = ".$zamowienie_id[$z].";");
			while($wynik46= mysqli_fetch_assoc($pytanie46))
				{
				$ilosc_pozycji_wyceny = $wynik46['ilosc_pozycji'];
				}		

			$cena = [];
			for($j=0; $j<=11; $j++) {

				$cena[$j] = array();
				$cena[$j] = 0;
				$wartosc_profili[$j] = 0;

			}

			$wygiecie_innego_wartosc = 0;
			$wygiecie_wzmocnienia_okiennego_wartosc = 0;
			$wyfrezowanie_odwodnienia_wartosc = 0;
			$okucie_wartosc = 0;
			$zaszklenie_wartosc = 0;
			$listwa_przyszybowa_wartosc = 0;
			$zgrzanie_ilosc = 0;
			$suma_sztuk_rodzaj_1 = 0;
			$suma_sztuk_rodzaj_3 = 0;

			for($k=1; $k<=$ilosc_pozycji_wyceny; $k++) 
				{
				// $suma_wartosc_pozostalych_dla_zgrzewow[$k] = 0;
				// echo 'zam id='.$zamowienie_id[$z].'<br>';
				// echo 'pozycja='.$k.'<br>';

				$pytanie4 = mysqli_query($conn, "SELECT * FROM wyceny WHERE zamowienie_id = ".$zamowienie_id[$z]." AND pozycja = ".$k.";");
				while($wynik4= mysqli_fetch_assoc($pytanie4))
					{
					$suma_sztuk_rodzaj_1 = 0;
					$suma_metrow_rodzaj_1 = 0;
					// ########### rodzaj produktu 0 profile  ########
					if($rodzaj_produktu_oblicz[$z] == 0) 
						{
						$wartosc_profili[0] += $wynik4['oscieznica_wartosc'] + $wynik4['skrzydlo_wartosc'] + $wynik4['listwa_wartosc'] + $wynik4['slupek_wartosc'] + $wynik4['wzmocnienie_ramy_wartosc'] + $wynik4['wzmocnienie_skrzydla_wartosc'] + $wynik4['wzmocnienie_slupka_wartosc'] + $wynik4['wzmocnienie_luku_wartosc'] + $wynik4['okucia_wartosc'] + $wynik4['szyby_wartosc'] + $wynik4['inny_element_wartosc'];
						}
					// ########### rodzaj produktu 1  - Łuki pvc   #############
					if($rodzaj_produktu_oblicz[$z] == 1)
						{
						//pobieram ilosci sztuk
						$wygiecie_ramy_pvc_ilosc_szt = $wynik4['wygiecie_ramy_pvc_ilosc_szt'];
						$wygiecie_skrzydla_pvc_ilosc_szt = $wynik4['wygiecie_skrzydla_pvc_ilosc_szt'];
						$wygiecie_innego_pvc_ilosc_szt = $wynik4['wygiecie_innego_pvc_ilosc_szt'];
						$suma_sztuk_rodzaj_1 += $wygiecie_ramy_pvc_ilosc_szt+$wygiecie_skrzydla_pvc_ilosc_szt+$wygiecie_innego_pvc_ilosc_szt;
						$luki_pvc_stopien_trudnosci = $wynik4['stopien_trudnosci'];
						
						//pobieram METRY dla wyliczenia stopnia trudnosci
						$wygiecie_ramy_pvc_ilosc_m = $wynik4['wygiecie_ramy_pvc_ilosc_m'];
						$wygiecie_skrzydla_pvc_ilosc_m = $wynik4['wygiecie_skrzydla_pvc_ilosc_m'];
						$wygiecie_innego_pvc_ilosc_m = $wynik4['wygiecie_innego_pvc_ilosc_m'];
						$suma_metrow_rodzaj_1 += $wygiecie_ramy_pvc_ilosc_m+$wygiecie_skrzydla_pvc_ilosc_m+$wygiecie_innego_pvc_ilosc_m;
						//jak te sztuki sa puste to bierzemy pod uwage listwe
						if(($wygiecie_ramy_pvc_ilosc_szt == 0) && ($wygiecie_skrzydla_pvc_ilosc_szt == 0) && ($wygiecie_innego_pvc_ilosc_szt == 0))
							{
							
							$cena[1] += $wynik4['wygiecie_listwy_pvc_wartosc'];
							$suma_sztuk_rodzaj_1 = $wynik4['wygiecie_listwy_pvc_ilosc_szt'];
							$suma_metrow_rodzaj_1 = $wynik4['wygiecie_listwy_pvc_ilosc_m'];
							}
						else
							{
							$wygiecie_ramy_pvc_wartosc = $wynik4['wygiecie_ramy_pvc_wartosc'];
							$wygiecie_skrzydla_pvc_wartosc = $wynik4['wygiecie_skrzydla_pvc_wartosc'];
							$wygiecie_innego_pvc_wartosc = $wynik4['wygiecie_innego_pvc_wartosc'];
							$wygiecie_listwy_pvc_wartosc = $wynik4['wygiecie_listwy_pvc_wartosc'];
							$cena[1] += ($wygiecie_ramy_pvc_wartosc + $wygiecie_skrzydla_pvc_wartosc + $wygiecie_innego_pvc_wartosc + $wygiecie_listwy_pvc_wartosc);
							}

						//obliczamy ilosci sztuk na metry i stopien trudnosci
						if($suma_sztuk_rodzaj_1 != 0) 
							{
								echo '1<br>';
							$sredni_stopien_trudnosci = $luki_pvc_stopien_trudnosci * ($suma_metrow_rodzaj_1 / $suma_sztuk_rodzaj_1);
							$SUMA_stopien_trudnosci += $suma_sztuk_rodzaj_1 * $sredni_stopien_trudnosci;	
							}
echo '1 SUMA_stopien_trudnosci='.$SUMA_stopien_trudnosci.'<br>';
						
						// sprawdzamy czy jakas część pozycji nie zostala już zrobiona wcześniej 
						$pytanie335 = mysqli_query($conn, "SELECT * FROM realizacja_produkcji where zamowienie_id = '".$zamowienie_id[$z]."' AND pozycja = '".$k."' AND rodzaj_produktu = '".$rodzaj_produktu_oblicz[$z]."' AND id <> '".$realizacja_produkcji_id."';");
						while($wynik335= mysqli_fetch_assoc($pytanie335))
								$SUMA_stopien_trudnosci -= $wynik335['stopien_trudnosci'];
						}

					// ########### rodzaj produktu 2  - łuki ze stali   #############
					if($rodzaj_produktu_oblicz[$z] == 2) $cena[2] += $wynik4['wygiecie_wzmocnienia_okiennego_wartosc'];
					// ########### rodzaj produktu 3  - łuki z alu #############
					if($rodzaj_produktu_oblicz[$z] == 3)
						{
						$wygiecie_ramy_alu_ilosc_szt = $wynik4['wygiecie_ramy_alu_ilosc_szt'];
						$wygiecie_skrzydla_alu_ilosc_szt = $wynik4['wygiecie_skrzydla_alu_ilosc_szt'];
						$wygiecie_innego_alu_ilosc_szt = $wynik4['wygiecie_innego_alu_ilosc_szt'];
						$suma_sztuk_rodzaj_3 += $wygiecie_ramy_alu_ilosc_szt+$wygiecie_skrzydla_alu_ilosc_szt+$wygiecie_innego_alu_ilosc_szt;
						//jak te sztuki sa puste to bierzemy pod uwage listwe
						if(($wygiecie_ramy_alu_ilosc_szt == 0) && ($wygiecie_skrzydla_alu_ilosc_szt == 0) && ($wygiecie_innego_alu_ilosc_szt == 0))
							{
							$cena[3] += $wynik4['wygiecie_listwy_alu_wartosc'];
							}
						else
							{
							$wygiecie_ramy_alu_wartosc = $wynik4['wygiecie_ramy_alu_wartosc'];
							$wygiecie_skrzydla_alu_wartosc = $wynik4['wygiecie_skrzydla_alu_wartosc'];
							$wygiecie_innego_alu_wartosc = $wynik4['wygiecie_innego_alu_wartosc'];
							$wygiecie_listwy_alu_wartosc = $wynik4['wygiecie_listwy_alu_wartosc'];
							$cena[3] += ($wygiecie_ramy_alu_wartosc + $wygiecie_skrzydla_alu_wartosc + $wygiecie_innego_alu_wartosc + $wygiecie_listwy_alu_wartosc);

							// echo 'cena[3]='.$cena[3].'<br>';


							}
						}
					
					// ########### rodzaj produktu 4 - zgrzewy  #############
					$suma_wartosc_pozostalych_dla_zgrzewow = [];
					$suma_wartosc_pozostalych_dla_zgrzewow[$k] = 0;
					if($rodzaj_produktu_oblicz[$z] == 4)
						{
						$wygiecie_innego_wartosc = $wynik4['wygiecie_innego_wartosc'];
						$wyfrezowanie_odwodnienia_wartosc = $wynik4['wyfrezowanie_odwodnienia_wartosc'];
						$okucie_wartosc = $wynik4['okucie_wartosc'];
						$zaszklenie_wartosc = $wynik4['zaszklenie_wartosc'];
						$listwa_przyszybowa_wartosc = $wynik4['listwa_przyszybowa_wartosc'];
						$zgrzanie_ilosc = $wynik4['zgrzanie_ilosc'];
						$zgrzanie_stopien_trudnosci = $wynik4['stopien_trudnosci'];
						$SUMA_stopien_trudnosci += $zgrzanie_ilosc * $zgrzanie_stopien_trudnosci;	
						echo '$SUMA_stopien_trudnosci='.$SUMA_stopien_trudnosci.'<br>';
						echo '$zgrzanie_ilosc='.$zgrzanie_ilosc.'<br>';
						echo '$zgrzanie_stopien_trudnosci='.$zgrzanie_stopien_trudnosci.'<br>';

						//sprawdzamy czy jakas część pozycji nie zostala już zrobiona wcześniej 
						$pytanie335 = mysqli_query($conn, "SELECT * FROM realizacja_produkcji where zamowienie_id = '".$zamowienie_id[$z]."' AND pozycja = '".$k."' AND rodzaj_produktu = '".$rodzaj_produktu_oblicz[$z]."' AND id <> '".$realizacja_produkcji_id."';");
						while($wynik335= mysqli_fetch_assoc($pytanie335)) $SUMA_stopien_trudnosci -= $wynik335['stopien_trudnosci'];
												
						$suma_wartosc_pozostalych_dla_zgrzewow[$k] = $wygiecie_innego_wartosc + $wyfrezowanie_odwodnienia_wartosc + $okucie_wartosc + $zaszklenie_wartosc + $listwa_przyszybowa_wartosc;
						}
					
					// ########### rodzaj produktu 5  - słupki   #############
					if($rodzaj_produktu_oblicz[$z] == 5) $cena[5] += $wynik4['wstawienie_slupka_wartosc']+$wynik4['wstawienie_slupka_ruchomego_wartosc'];
					// ########### rodzaj produktu 11 docięcie kompletu listew przyszybowych  ########
					if($rodzaj_produktu_oblicz[$z] == 11) $cena[11] += $wynik4['dociecie_kompletu_listew_przyszybowych_wartosc'];
					}
				}




			$cena_44 = 0;
			$wartosc_realizacji[$z] = 0;
			for($k=1; $k<=$ilosc_pozycji_wyceny; $k++) {
				$cena_44 += $cena[4][$k] + $suma_wartosc_pozostalych_dla_zgrzewow[$k];
			}
			if($rodzaj_produktu_oblicz[$z] == 4) $wartosc_realizacji[$z] = $cena_44;

			if($rodzaj_produktu_oblicz[$z] == 1) $wartosc_realizacji[$z] = $cena[1];
			if($rodzaj_produktu_oblicz[$z] == 2) $wartosc_realizacji[$z] = $cena[2];
			if($rodzaj_produktu_oblicz[$z] == 3) $wartosc_realizacji[$z] = $cena[3];
			if($rodzaj_produktu_oblicz[$z] == 5) $wartosc_realizacji[$z] = $cena[5];
			if($rodzaj_produktu_oblicz[$z] == 11) $wartosc_realizacji[$z] = $cena[11];



			$wartosc_realizacji[$z] = number_format($wartosc_realizacji[$z], 2,'.','');
			$SUMA_stopien_trudnosci = number_format($SUMA_stopien_trudnosci, 2,'.','');


			if($rodzaj_produktu_oblicz[$z] == 0) 
			{
				$wartosc_profili[0] = number_format($wartosc_profili[0], 2,'.','');
				// echo 'WARTOSC PROFILI (on)='.$wartosc_profili[0].'<br>';
				$sql = "UPDATE realizacja_produkcji SET wartosc_profili = ".$wartosc_profili[0]." WHERE id = ".$id_oblicz[$z].";";
				mysqli_query($conn, $sql);
			}
echo '2 SUMA_stopien_trudnosci='.$SUMA_stopien_trudnosci.'<br>';

			// echo 'wartosc_realizacji (on)='.$wartosc_realizacji[$z].'<br>';
			$SQL = [];
			//tresc zapytan
			$SQL[1] = "UPDATE realizacja_produkcji SET wartosc_realizacji = ".$wartosc_realizacji[$z]." WHERE id = ".$id_oblicz[$z].";";
			$SQL[2] = "UPDATE realizacja_produkcji SET data_wykonania_dzien = '".$data_wykonania_dzien[$z]."' WHERE id = ".$id_oblicz[$z].";";
			$SQL[3] = "UPDATE realizacja_produkcji SET data_wykonania_miesiac = '".$data_wykonania_miesiac[$z]."' WHERE id = ".$id_oblicz[$z].";";
			$SQL[4] = "UPDATE realizacja_produkcji SET data_wykonania_rok = '".$data_wykonania_rok[$z]."' WHERE id = ".$id_oblicz[$z].";";
			$SQL[5] = "UPDATE realizacja_produkcji SET stopien_trudnosci = ".$SUMA_stopien_trudnosci." WHERE id = ".$id_oblicz[$z].";";
		
			//wykonanie zapytan
			for($s=1; $s<=5; $s++) mysqli_query($conn, $SQL[$s]);
			}
		// ##########   dla kazdej pozycji z osobna ####################
		else // do if($pozycja_oblicz[$z] == 'on')
			{
			$cena_0 = 0;
			$cena_1 = 0;
			$cena_2 = 0;
			$cena_3 = 0;
			$cena_4 = 0;
			$cena_5 = 0;
			$cena_11 = 0;
			$suma_sztuk_rodzaj_1 = 0;
			$suma_sztuk_rodzaj_3 = 0;
			$suma_wartosc_pozostalych_dla_zgrzewow1 = 0;
			$pytanie4 = mysqli_query($conn, "SELECT * FROM wyceny WHERE zamowienie_id = ".$zamowienie_id[$z]." AND pozycja = ".$pozycja_oblicz[$z].";");
			while($wynik4= mysqli_fetch_assoc($pytanie4))
				{
				// ########### rodzaj produktu 1  - Łuki pvc   #############
				if($rodzaj_produktu_oblicz[$z] == 1)
					{
					//pobieram metry dla wyliczenia stopnia trudnosci
					$wygiecie_ramy_pvc_ilosc_m = $wynik4['wygiecie_ramy_pvc_ilosc_m'];
					$wygiecie_skrzydla_pvc_ilosc_m = $wynik4['wygiecie_skrzydla_pvc_ilosc_m'];
					$wygiecie_innego_pvc_ilosc_m = $wynik4['wygiecie_innego_pvc_ilosc_m'];
					$luki_pvc_stopien_trudnosci = $wynik4['stopien_trudnosci'];
					$suma_metrow_rodzaj_1 = $wygiecie_ramy_pvc_ilosc_m+$wygiecie_skrzydla_pvc_ilosc_m+$wygiecie_innego_pvc_ilosc_m;
					
					//pobieram ilosc sztuk
					$wygiecie_ramy_pvc_ilosc_szt = $wynik4['wygiecie_ramy_pvc_ilosc_szt'];
					$wygiecie_skrzydla_pvc_ilosc_szt = $wynik4['wygiecie_skrzydla_pvc_ilosc_szt'];
					$wygiecie_innego_pvc_ilosc_szt = $wynik4['wygiecie_innego_pvc_ilosc_szt'];
					$suma_sztuk_rodzaj_1 = $wygiecie_ramy_pvc_ilosc_szt+$wygiecie_skrzydla_pvc_ilosc_szt+$wygiecie_innego_pvc_ilosc_szt;
					//jak te sztuki sa puste to bierzemy pod uwage listwe
					if(($wygiecie_ramy_pvc_ilosc_szt == 0) && ($wygiecie_skrzydla_pvc_ilosc_szt == 0) && ($wygiecie_innego_pvc_ilosc_szt == 0))
						{
						$cena_1 = $wynik4['wygiecie_listwy_pvc_wartosc'];
						$suma_sztuk_rodzaj_1 = $wynik4['wygiecie_listwy_pvc_ilosc_szt'];
						$suma_metrow_rodzaj_1 = $wynik4['wygiecie_listwy_pvc_ilosc_m'];

						if($wynik4['wygiecie_listwy_pvc_szt'] != 0) $cena_1 = ($cena_1)/$wynik4['wygiecie_listwy_pvc_szt'];
						}
					else
						{
						$wygiecie_ramy_pvc_wartosc = $wynik4['wygiecie_ramy_pvc_wartosc'];
						$wygiecie_skrzydla_pvc_wartosc = $wynik4['wygiecie_skrzydla_pvc_wartosc'];
						$wygiecie_innego_pvc_wartosc = $wynik4['wygiecie_innego_pvc_wartosc'];
						$wygiecie_listwy_pvc_wartosc = $wynik4['wygiecie_listwy_pvc_wartosc'];
						$cena_1 = ($wygiecie_ramy_pvc_wartosc + $wygiecie_skrzydla_pvc_wartosc + $wygiecie_innego_pvc_wartosc + $wygiecie_listwy_pvc_wartosc)/$suma_sztuk_rodzaj_1;
						}

					//obliczamy stopien trudnosci dla METRÓW, metry dzielimy na sztuki
					if($suma_sztuk_rodzaj_1 != 0) 
						{
						$obliczony_luki_pvc_stopien_trudnosci = $luki_pvc_stopien_trudnosci * ($ilosc_oblicz[$z] * ($suma_metrow_rodzaj_1 / $suma_sztuk_rodzaj_1));
						$obliczony_luki_pvc_stopien_trudnosci = number_format($obliczony_luki_pvc_stopien_trudnosci, 2,'.','');
						$pytanie122 = mysqli_query($conn, "UPDATE realizacja_produkcji SET stopien_trudnosci = ".$obliczony_luki_pvc_stopien_trudnosci." WHERE id = ".$id_oblicz[$z].";");
						}

					}

				// ########### rodzaj produktu 2  - łuki ze stali   #############
				if($rodzaj_produktu_oblicz[$z] == 2) $cena_2 = $wynik4['wygiecie_wzmocnienia_okiennego_wartosc']/$wynik4['wygiecie_wzmocnienia_okiennego_ilosc_szt'];

				// ########### rodzaj produktu 3  - łuki z alu #############
				if($rodzaj_produktu_oblicz[$z] == 3)
					{
					$wygiecie_ramy_alu_ilosc_szt = $wynik4['wygiecie_ramy_alu_ilosc_szt'];
					$wygiecie_skrzydla_alu_ilosc_szt = $wynik4['wygiecie_skrzydla_alu_ilosc_szt'];
					$wygiecie_innego_alu_ilosc_szt = $wynik4['wygiecie_innego_alu_ilosc_szt'];
					$suma_sztuk_rodzaj_3 = $wygiecie_ramy_alu_ilosc_szt + $wygiecie_skrzydla_alu_ilosc_szt + $wygiecie_innego_alu_ilosc_szt;
					//jak te sztuki sa puste to bierzemy pod uwage listwe
					if(($wygiecie_ramy_alu_ilosc_szt == 0) && ($wygiecie_skrzydla_alu_ilosc_szt == 0) && ($wygiecie_innego_alu_ilosc_szt == 0))
						{
						$cena_3 = $wynik4['wygiecie_listwy_alu_wartosc'];
						$cena_3 = ($cena_3)/$wynik4['wygiecie_listwy_alu_szt'];
						}
					else
						{
						$wygiecie_ramy_alu_wartosc = $wynik4['wygiecie_ramy_alu_wartosc'];
						$wygiecie_skrzydla_alu_wartosc = $wynik4['wygiecie_skrzydla_alu_wartosc'];
						$wygiecie_innego_alu_wartosc = $wynik4['wygiecie_innego_alu_wartosc'];
						$wygiecie_listwy_alu_wartosc = $wynik4['wygiecie_listwy_alu_wartosc'];
						$cena_3 = ($wygiecie_ramy_alu_wartosc + $wygiecie_skrzydla_alu_wartosc + $wygiecie_innego_alu_wartosc + $wygiecie_listwy_alu_wartosc)/$suma_sztuk_rodzaj_3;

						// echo 'cena_3='.$cena_3.'<br>';
						}
					}
	
				// ########### rodzaj produktu 4  - zgrzewy #############
				if($rodzaj_produktu_oblicz[$z] == 4)
					{
					$wygiecie_innego_wartosc = $wynik4['wygiecie_innego_wartosc'];
					$wyfrezowanie_odwodnienia_wartosc = $wynik4['wyfrezowanie_odwodnienia_wartosc'];
					$okucie_wartosc = $wynik4['okucie_wartosc'];
					$zaszklenie_wartosc = $wynik4['zaszklenie_wartosc'];
					$listwa_przyszybowa_wartosc = $wynik4['listwa_przyszybowa_wartosc'];
					$zgrzanie_ilosc = $wynik4['zgrzanie_ilosc'];
					$zgrzanie_stopien_trudnosci = $wynik4['stopien_trudnosci'];

					$obliczony_stopien_trudnosci_zgrzewy = number_format($ilosc_oblicz[$z] * $zgrzanie_stopien_trudnosci, 2,'.','');
					$pytanie122 = mysqli_query($conn, "UPDATE realizacja_produkcji SET stopien_trudnosci = ".$obliczony_stopien_trudnosci_zgrzewy." WHERE id = ".$id_oblicz[$z].";");

					if($zgrzanie_ilosc != 0) $suma_wartosc_pozostalych_dla_zgrzewow1 = ($wygiecie_innego_wartosc + $wyfrezowanie_odwodnienia_wartosc + $okucie_wartosc + $zaszklenie_wartosc + $listwa_przyszybowa_wartosc)/$zgrzanie_ilosc;
					$cena_4 = $wynik4['zgrzanie_cena']+$suma_wartosc_pozostalych_dla_zgrzewow1;

					}

				// ########### rodzaj produktu 5  - słupki #############
				if($rodzaj_produktu_oblicz[$z] == 5) $cena_5 = $wynik4['wstawienie_slupka_cena']+$wynik4['wstawienie_slupka_ruchomego_cena'];

				// ########### rodzaj produktu 11 docięcie kompletu listew przyszybowych  ########
				if($rodzaj_produktu_oblicz[$z] == 11) $cena_11 = $wynik4['dociecie_kompletu_listew_przyszybowych_cena'];
			
				// ########### rodzaj produktu 0 profile  ########
				if($rodzaj_produktu_oblicz[$z] == 0) 
					{
					//sprawdzamy ilosc sztuk w pozycji wyceny
					$ilosc_sztuk_wycena = $wynik4['ilosc_sztuk'];
					$cena_0 = $wynik4['oscieznica_wartosc'] + $wynik4['skrzydlo_wartosc'] + $wynik4['listwa_wartosc'] + $wynik4['slupek_wartosc'] + $wynik4['wzmocnienie_ramy_wartosc'] + $wynik4['wzmocnienie_skrzydla_wartosc'] + $wynik4['wzmocnienie_slupka_wartosc'] + $wynik4['wzmocnienie_luku_wartosc'] + $wynik4['okucia_wartosc'] + $wynik4['szyby_wartosc'] + $wynik4['inny_element_wartosc'];

					//wydalismy całą pozycje
					if($ilosc_oblicz[$z] == $ilosc_sztuk_wycena) $wartosc_profili[$z] = $cena_0;
					//nie wydaliśmy całej pozycji
					else $wartosc_profili[$z] = $cena_0 * ($ilosc_oblicz[$z]/$ilosc_sztuk_wycena);
					}
				} // do while
			
			if($rodzaj_produktu_oblicz[$z] == 0) 
			{
				$wartosc_profili[$z] = number_format($wartosc_profili[$z], 2,'.','');
				// echo 'WARTOSC PROFILI (pozycja)='.$wartosc_profili[$z].'<br>';
				$sql = "UPDATE realizacja_produkcji SET wartosc_profili = ".$wartosc_profili[$z]." WHERE id = ".$id_oblicz[$z].";";
				mysqli_query($conn, $sql);
			}

			if($rodzaj_produktu_oblicz[$z] == 1) $wartosc_realizacji[$z] = $ilosc_oblicz[$z] * $cena_1;
			if($rodzaj_produktu_oblicz[$z] == 2) $wartosc_realizacji[$z] = $ilosc_oblicz[$z] * $cena_2;
			if($rodzaj_produktu_oblicz[$z] == 3) $wartosc_realizacji[$z] = $ilosc_oblicz[$z] * $cena_3;
			if($rodzaj_produktu_oblicz[$z] == 4) $wartosc_realizacji[$z] = $ilosc_oblicz[$z] * $cena_4;
			if($rodzaj_produktu_oblicz[$z] == 5) $wartosc_realizacji[$z] = $ilosc_oblicz[$z] * $cena_5;
			if($rodzaj_produktu_oblicz[$z] == 11) $wartosc_realizacji[$z] = $ilosc_oblicz[$z] * $cena_11;
			
			if(isset($wartosc_realizacji[$z])) $wartosc_realizacji[$z] = number_format($wartosc_realizacji[$z], 2,'.','');
			else $wartosc_realizacji[$z] = 0;
			
			
			// echo 'WARTOSC realizacji (pozycja)='.$wartosc_realizacji[$z].'<br>';

			$SQL = [];
			//tresc zapytan
			$SQL[1] = "UPDATE realizacja_produkcji SET wartosc_realizacji = ".$wartosc_realizacji[$z]." WHERE id = ".$id_oblicz[$z].";";
			$SQL[2] = "UPDATE realizacja_produkcji SET data_wykonania_dzien = '".$data_wykonania_dzien[$z]."' WHERE id = ".$id_oblicz[$z].";";
			$SQL[3] = "UPDATE realizacja_produkcji SET data_wykonania_miesiac = '".$data_wykonania_miesiac[$z]."' WHERE id = ".$id_oblicz[$z].";";
			$SQL[4] = "UPDATE realizacja_produkcji SET data_wykonania_rok = '".$data_wykonania_rok[$z]."' WHERE id = ".$id_oblicz[$z].";";
		
			//wykonanie zapytan
			for($s=1; $s<=4; $s++) mysqli_query($conn, $SQL[$s]);
			}// do else
		}

?>