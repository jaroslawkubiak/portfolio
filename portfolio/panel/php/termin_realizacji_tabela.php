<?php
	//szukamy wszystkich terminow realizacji z aktywnych zamowien
	$ilosc_terminow = 0;
	$pytanie4 = mysqli_query($conn, "SELECT DISTINCT termin_realizacji FROM zamowienia WHERE status <> 'Dostarczone' AND status <> 'Odebrane' AND status <> 'Anulowane' AND termin_realizacji <> '' ORDER BY termin_realizacji ASC;");
	while($wynik4= mysqli_fetch_assoc($pytanie4))
		{
		$ilosc_terminow++;
		$TABELA_TERMINOW[$ilosc_terminow]=$wynik4['termin_realizacji'];
		}

	// echo '$ilosc_terminow='.$ilosc_terminow.'<br>';
	for($y = 1; $y<=$ilosc_terminow; $y++) 
		{
		$luki_pvc_zamowienia[$TABELA_TERMINOW[$y]] = 0;
		// $luki_stal_zamowienia[$TABELA_TERMINOW[$y]] = 0;
		// $luki_alu_zamowienia[$TABELA_TERMINOW[$y]] = 0;
		$zgrzewy_zamowienia[$TABELA_TERMINOW[$y]] = 0;
		// $odwodnienia_zamowienia[$TABELA_TERMINOW[$y]] = 0;
		// $slupki_zamowienia[$TABELA_TERMINOW[$y]] = 0;
		// $szklenie_zamowienia[$TABELA_TERMINOW[$y]] = 0;
		// $okuwanie_zamowienia[$TABELA_TERMINOW[$y]] = 0;
		// $dociecie_listwy_zamowienia[$TABELA_TERMINOW[$y]] = 0;

		$luki_pvc_relizacja[$TABELA_TERMINOW[$y]] = 0;
		// $luki_stal_relizacja[$TABELA_TERMINOW[$y]] = 0;
		// $luki_alu_relizacja[$TABELA_TERMINOW[$y]] = 0;
		$zgrzewy_relizacja[$TABELA_TERMINOW[$y]] = 0;
		// $odwodnienia_relizacja[$TABELA_TERMINOW[$y]] = 0;
		// $slupki_relizacja[$TABELA_TERMINOW[$y]] = 0;
		// $szklenie_relizacja[$TABELA_TERMINOW[$y]] = 0;
		// $okuwanie_relizacja[$TABELA_TERMINOW[$y]] = 0;
		// $dociecie_listwy_relizacja[$TABELA_TERMINOW[$y]] = 0;
		
		$pytanie47 = mysqli_query($conn, "SELECT luki_pvc, zgrzewy, id FROM zamowienia WHERE termin_realizacji = '".$TABELA_TERMINOW[$y]."' AND status <> 'Odebrane' AND status <> 'Anulowane' AND status <> 'Dostarczone';");
		while($wynik47= mysqli_fetch_assoc($pytanie47))
			{
			$luki_pvc_zamowienia[$TABELA_TERMINOW[$y]] += $wynik47['luki_pvc'];
			// $luki_stal_zamowienia[$TABELA_TERMINOW[$y]] += $wynik47['luki_stal'];
			// $luki_alu_zamowienia[$TABELA_TERMINOW[$y]] += $wynik47['luki_alu'];
			$zgrzewy_zamowienia[$TABELA_TERMINOW[$y]] += $wynik47['zgrzewy'];
            // $odwodnienia_zamowienia[$TABELA_TERMINOW[$y]] += $wynik47['odwodnienia'];
			// $szklenie_zamowienia[$TABELA_TERMINOW[$y]] += $wynik47['szklenie'];
			// $okuwanie_zamowienia[$TABELA_TERMINOW[$y]] += $wynik47['okuwanie'];
            
            // $slupki_zamowienia[$TABELA_TERMINOW[$y]] += $wynik47['slupki'];
            // $slupki_zamowienia[$TABELA_TERMINOW[$y]] += $wynik47['slupek_ruchomy']; //dodajemy tez słupek ruchomy
            
            // $dociecie_listwy_zamowienia[$TABELA_TERMINOW[$y]] += $wynik47['dociecie_listwy'];
            // $dociecie_listwy_zamowienia[$TABELA_TERMINOW[$y]] += $wynik47['komplet_listew']; // dodajemy tez komplet listew
            
			$zamowienie_id_temp = $wynik47['id'];
			$pytanie347 = mysqli_query($conn, "SELECT ilosc, rodzaj_produktu FROM realizacja_produkcji WHERE zamowienie_id = ".$zamowienie_id_temp.";");
			while($wynik347= mysqli_fetch_assoc($pytanie347))
				{
				if($wynik347['rodzaj_produktu'] == 1) $luki_pvc_relizacja[$TABELA_TERMINOW[$y]] += $wynik347['ilosc'];
				// echo 'ilosc='.$wynik347['ilosc'].'<br>';
				// if($wynik347['rodzaj_produktu'] == 2) $luki_stal_relizacja[$TABELA_TERMINOW[$y]] += $wynik347['ilosc'];
				// if($wynik347['rodzaj_produktu'] == 3) $luki_alu_relizacja[$TABELA_TERMINOW[$y]] += $wynik347['ilosc'];
				if($wynik347['rodzaj_produktu'] == 4) $zgrzewy_relizacja[$TABELA_TERMINOW[$y]] += $wynik347['ilosc'];
				// if($wynik347['rodzaj_produktu'] == 5) $slupki_relizacja[$TABELA_TERMINOW[$y]] += $wynik347['ilosc'];
				// if($wynik347['rodzaj_produktu'] == 6) $odwodnienia_relizacja[$TABELA_TERMINOW[$y]] += $wynik347['ilosc'];
				// if($wynik347['rodzaj_produktu'] == 7) $dociecie_listwy_relizacja[$TABELA_TERMINOW[$y]] += $wynik347['ilosc'];
				// if($wynik347['rodzaj_produktu'] == 8) $okuwanie_relizacja[$TABELA_TERMINOW[$y]] += $wynik347['ilosc'];
				// if($wynik347['rodzaj_produktu'] == 9) $szklenie_relizacja[$TABELA_TERMINOW[$y]] += $wynik347['ilosc'];
				}
			}
		}
		
	echo '<tr align="center"><td align="right">';  
	$szer_kol = "100px";
	echo '<table cellspacing="0" cellpadding="0" class="text" border="1" frame="box" rules="all" BORDERCOLOR="black"><tr bgcolor="'.$kolor_tabeli.'" align="center"><td width="'.$szer_kol.'">Termin</td>';
	echo '<td width="'.$szer_kol.'">Łuki pvc</td>';
	// echo '<td width="'.$szer_kol.'">Łuki stal</td>';
	// echo '<td width="'.$szer_kol.'">Łuki alu</td>';
	echo '<td width="'.$szer_kol.'">Zgrzewy</td>';
	// echo '<td width="'.$szer_kol.'">Słupki</td>';
	// echo '<td width="'.$szer_kol.'">Odwodnienia</td>';
	// echo '<td width="'.$szer_kol.'">Docięcie listwy</td>';
	// echo '<td width="'.$szer_kol.'">Okuwanie</td>';
	// echo '<td width="'.$szer_kol.'">Szklenie</td>';
	echo '</tr>';
	
		for($y = 1; $y<=$ilosc_terminow; $y++) 
			{
			echo '<tr bgcolor="'.$kolor_bialy.'" class="text_zmienny" align="center"><td bgcolor="'.$kolor_tabeli.'">'.$TABELA_TERMINOW[$y].'</td>';
			$temp1 = $luki_pvc_zamowienia[$TABELA_TERMINOW[$y]]-$luki_pvc_relizacja[$TABELA_TERMINOW[$y]];
			// $temp2 = $luki_stal_zamowienia[$TABELA_TERMINOW[$y]]-$luki_stal_relizacja[$TABELA_TERMINOW[$y]];
			// $temp3 = $luki_alu_zamowienia[$TABELA_TERMINOW[$y]]-$luki_alu_relizacja[$TABELA_TERMINOW[$y]];
			$temp4 = $zgrzewy_zamowienia[$TABELA_TERMINOW[$y]]-$zgrzewy_relizacja[$TABELA_TERMINOW[$y]];
			// $temp5 = $slupki_zamowienia[$TABELA_TERMINOW[$y]]-$slupki_relizacja[$TABELA_TERMINOW[$y]];
			// $temp6 = $odwodnienia_zamowienia[$TABELA_TERMINOW[$y]]-$odwodnienia_relizacja[$TABELA_TERMINOW[$y]];
			// $temp7 = $dociecie_listwy_zamowienia[$TABELA_TERMINOW[$y]]-$dociecie_listwy_relizacja[$TABELA_TERMINOW[$y]];
			// $temp8 = $okuwanie_zamowienia[$TABELA_TERMINOW[$y]]-$okuwanie_relizacja[$TABELA_TERMINOW[$y]];
			// $temp9 = $szklenie_zamowienia[$TABELA_TERMINOW[$y]]-$szklenie_relizacja[$TABELA_TERMINOW[$y]];
            
            //zabezpieczenie przed minusowymi wartościami
			if($temp1 < 0) $temp1 = 0;
			// if($temp2 < 0) $temp2 = 0;
			// if($temp3 < 0) $temp3 = 0;
			if($temp4 < 0) $temp4 = 0;
			// if($temp5 < 0) $temp5 = 0;
			// if($temp6 < 0) $temp6 = 0;
			// if($temp7 < 0) $temp7 = 0;
			// if($temp8 < 0) $temp8 = 0;
			// if($temp9 < 0) $temp9 = 0;
			echo '<td>'.$luki_pvc_zamowienia[$TABELA_TERMINOW[$y]].' ('.$temp1.')</td>';
			// echo '<td>'.$temp2.'</td>';
			// echo '<td>'.$temp3.'</td>';
			echo '<td>'.$zgrzewy_zamowienia[$TABELA_TERMINOW[$y]].' ('.$temp4.')</td>';
			// echo '<td>'.$temp5.'</td>';
			// echo '<td>'.$temp6.'</td>';
			// echo '<td>'.$temp7.'</td>';
			// echo '<td>'.$temp8.'</td>';
			// echo '<td>'.$temp9.'</td>';
			echo '</tr>';
			}
	echo '</table>';
	echo '</td><td></td><td></td></tr>';
	// koniec wyliczania wykonanych elementw

?>