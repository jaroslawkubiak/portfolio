<?php

//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
// wszędzie gdzie produkt jest nr 7 zakomentowałem
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
//tabela główna
echo '<table align="left" width="100%" border="0"><tr><td align="left">';
echo '<FORM action="index.php?page=realizacja_produkcji_zamowienia_do_wykonania" method="post">';
echo '<INPUT type="hidden" name="page" value="'.$page.'">';
echo '<INPUT type="hidden" name="zlecenie_transportowe" value="'.$zlecenie_transportowe.'">';
echo '<INPUT type="hidden" name="rodzaj_produktu" value="">';
echo '<INPUT type="hidden" name="zamowienie_id_akord" value="">';
echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';

echo '<table align="left" cellspacing="5" cellpadding="5" border="0" bgcolor="'.$kolor_tabeli.'"><tr width="800px" align="center" class="text_ogromny"><td>ZLECENIA ZREALIZOWANE ZE ZLECENIA TRANSPORTOWEGO : </td>';
echo '<td align="center">'.$zlecenie_transportowe.'</td>';
echo '</tr></table>';
echo '</form>';

echo '</td></tr><tr><td align="left">';
//echo 'zlec transp='.$zlecenie_transportowe.'<br>';

$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[1] = 0;
$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[2] = 0;
$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[3] = 0;
$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[4] = 0;
$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[5] = 0;
$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[6] = 0;
// $SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[7] = 0;
$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[8] = 0;
$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[9] = 0;
$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[0] = 0;
$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[10] = 0;
$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[11] = 0;

if(preg_match("/ZT/", $zlecenie_transportowe))
	{
		// wybrano zlecenie transportowe
		$WARUNEK2 = '';
		$ilosc_zamowien = 0;
		if($klienci_do_planu_produkcji != '') $WARUNEK2 = " AND klient_id = ".$klienci_do_planu_produkcji."";
		$pytanie66 = mysqli_query($conn, "SELECT DISTINCT zamowienie_id FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego = '".$zlecenie_transportowe."' ".$WARUNEK2." ORDER BY kolejnosc ASC");
		while($wynik66= mysqli_fetch_assoc($pytanie66))
			{
			$ilosc_zamowien++;
			$zamowienie_id_temp = $wynik66['zamowienie_id'];
			$zamowienie_id[$ilosc_zamowien] = $wynik66['zamowienie_id'];
			//echo 'zam id='.$zamowienie_id[$ilosc_zamowien].'<br>';
			//echo 'id='.$zamowienie_id_temp.',     ';
			$ilosc_pozycji=0;
			$pytanie4 = mysqli_query($conn, "SELECT * FROM wyceny WHERE zamowienie_id = ".$zamowienie_id_temp." AND pozycja_transport = 'nie' ORDER BY pozycja ASC");
			while($wynik4= mysqli_fetch_assoc($pytanie4))
				{
				$ilosc_pozycji++;
					$suma_rodzaj_produktu_1_ZREAL[$ilosc_pozycji][$zamowienie_id_temp] = $wynik4['wygiecie_ramy_pvc_ilosc_szt']+$wynik4['wygiecie_skrzydla_pvc_ilosc_szt']+$wynik4['wygiecie_innego_pvc_ilosc_szt'];
					//$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[1] += $suma_rodzaj_produktu_1_ZREAL[$ilosc_pozycji][$zamowienie_id_temp];
					$wygiecie_listwy_pvc_ilosc_szt=$wynik4['wygiecie_listwy_pvc_ilosc_szt'];
					if(($suma_rodzaj_produktu_1_ZREAL[$ilosc_pozycji][$zamowienie_id_temp] == 0) && ($wygiecie_listwy_pvc_ilosc_szt != 0)) $suma_rodzaj_produktu_1_ZREAL[$ilosc_pozycji][$zamowienie_id_temp] = $wygiecie_listwy_pvc_ilosc_szt;
					
					$wygiecie_wzmocnienia_okiennego_ilosc_szt=$wynik4['wygiecie_wzmocnienia_okiennego_ilosc_szt'];
					$wygiecie_innego_ilosc_szt=$wynik4['wygiecie_innego_ilosc_szt'];
				$suma_rodzaj_produktu_2_ZREAL[$ilosc_pozycji][$zamowienie_id_temp] = $wygiecie_wzmocnienia_okiennego_ilosc_szt+$wygiecie_innego_ilosc_szt;
				//$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[2] += $suma_rodzaj_produktu_2_ZREAL[$ilosc_pozycji][$zamowienie_id_temp];
		
					$wygiecie_ramy_alu_ilosc_szt=$wynik4['wygiecie_ramy_alu_ilosc_szt'];
					$wygiecie_skrzydla_alu_ilosc_szt=$wynik4['wygiecie_skrzydla_alu_ilosc_szt'];
					$wygiecie_innego_alu_ilosc_szt=$wynik4['wygiecie_innego_alu_ilosc_szt'];
				$suma_rodzaj_produktu_3_ZREAL[$ilosc_pozycji][$zamowienie_id_temp] = $wygiecie_ramy_alu_ilosc_szt+$wygiecie_skrzydla_alu_ilosc_szt+$wygiecie_innego_alu_ilosc_szt;
				//$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[3] += $suma_rodzaj_produktu_3_ZREAL[$ilosc_pozycji][$zamowienie_id_temp];
	
				$suma_rodzaj_produktu_4_ZREAL[$ilosc_pozycji][$zamowienie_id_temp]=$wynik4['zgrzanie_ilosc'];
				$suma_rodzaj_produktu_5_ZREAL[$ilosc_pozycji][$zamowienie_id_temp]=$wynik4['wstawienie_slupka_ilosc']+$wynik4['wstawienie_slupka_ruchomego_ilosc'];
				$suma_rodzaj_produktu_6_ZREAL[$ilosc_pozycji][$zamowienie_id_temp]=$wynik4['wyfrezowanie_odwodnienia_ilosc'];
				// $suma_rodzaj_produktu_7_ZREAL[$ilosc_pozycji][$zamowienie_id_temp]=$wynik4['listwa_przyszybowa_ilosc'];
				$suma_rodzaj_produktu_11_ZREAL[$ilosc_pozycji][$zamowienie_id_temp]=$wynik4['dociecie_kompletu_listew_przyszybowych_ilosc'];
				$suma_rodzaj_produktu_8_ZREAL[$ilosc_pozycji][$zamowienie_id_temp]=$wynik4['okucie_ilosc'];
				$suma_rodzaj_produktu_9_ZREAL[$ilosc_pozycji][$zamowienie_id_temp]=$wynik4['zaszklenie_ilosc'];
				$suma_rodzaj_produktu_0_ZREAL[$ilosc_pozycji][$zamowienie_id_temp]=$wynik4['ilosc_sztuk'];
				$suma_rodzaj_produktu_10_ZREAL[$ilosc_pozycji][$zamowienie_id_temp]=$wynik4['ilosc_sztuk'];

			}	 // do while($wynik4= mysqli_fetch_assoc($pytanie4))
			$ilosc_pozycji_zamowienia[$zamowienie_id_temp] = $ilosc_pozycji;
			$pytanie = mysqli_query($conn, "SELECT * FROM realizacja_produkcji WHERE zamowienie_id=".$zamowienie_id_temp.";");
			while($wynik= mysqli_fetch_assoc($pytanie))
				{
				//$zamowienie_id[$ilosc_zamowien]=$wynik['zamowienie_id'];
				//$temp = $wynik['zamowienie_id'];
				$rodzaj_produktu=$wynik['rodzaj_produktu'];
				$ilosc=$wynik['ilosc'];
				$pozycja=$wynik['pozycja'];
				if($pozycja != 'on') // on to całe zamwienie
					{
					if($rodzaj_produktu == 1) $SUMA_1_WYKONANE_ZREAL[$pozycja][$zamowienie_id_temp] += $ilosc;
					if($rodzaj_produktu == 2) $SUMA_2_WYKONANE_ZREAL[$pozycja][$zamowienie_id_temp] += $ilosc;
					if($rodzaj_produktu == 3) $SUMA_3_WYKONANE_ZREAL[$pozycja][$zamowienie_id_temp] += $ilosc;
					if($rodzaj_produktu == 4) $SUMA_4_WYKONANE_ZREAL[$pozycja][$zamowienie_id_temp] += $ilosc;
					if($rodzaj_produktu == 5) $SUMA_5_WYKONANE_ZREAL[$pozycja][$zamowienie_id_temp] += $ilosc;
					if($rodzaj_produktu == 6) $SUMA_6_WYKONANE_ZREAL[$pozycja][$zamowienie_id_temp] += $ilosc;
					// if($rodzaj_produktu == 7) $SUMA_7_WYKONANE_ZREAL[$pozycja][$zamowienie_id_temp] += $ilosc;
					if($rodzaj_produktu == 8) $SUMA_8_WYKONANE_ZREAL[$pozycja][$zamowienie_id_temp] += $ilosc;
					if($rodzaj_produktu == 9) $SUMA_9_WYKONANE_ZREAL[$pozycja][$zamowienie_id_temp] += $ilosc;
					if($rodzaj_produktu == 0) $SUMA_0_WYKONANE_ZREAL[$pozycja][$zamowienie_id_temp] += $ilosc;
					if($rodzaj_produktu == 10) $SUMA_10_WYKONANE_ZREAL[$pozycja][$zamowienie_id_temp] += $ilosc;
					if($rodzaj_produktu == 11) $SUMA_11_WYKONANE_ZREAL[$pozycja][$zamowienie_id_temp] += $ilosc;
					} // do if($pozycja != 'on')
				else
					{
					for ($x=1; $x<=$ilosc_pozycji_zamowienia[$zamowienie_id_temp]; $x++)
						{
						if($rodzaj_produktu == 1) $SUMA_1_WYKONANE_ZREAL[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_1_ZREAL[$x][$zamowienie_id_temp];
						if($rodzaj_produktu == 2) $SUMA_2_WYKONANE_ZREAL[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_2_ZREAL[$x][$zamowienie_id_temp];
						if($rodzaj_produktu == 3) $SUMA_3_WYKONANE_ZREAL[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_3_ZREAL[$x][$zamowienie_id_temp];
						if($rodzaj_produktu == 4) $SUMA_4_WYKONANE_ZREAL[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_4_ZREAL[$x][$zamowienie_id_temp];
						if($rodzaj_produktu == 5) $SUMA_5_WYKONANE_ZREAL[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_5_ZREAL[$x][$zamowienie_id_temp];
						if($rodzaj_produktu == 6) $SUMA_6_WYKONANE_ZREAL[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_6_ZREAL[$x][$zamowienie_id_temp];
						// if($rodzaj_produktu == 7) $SUMA_7_WYKONANE_ZREAL[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_7_ZREAL[$x][$zamowienie_id_temp];
						if($rodzaj_produktu == 8) $SUMA_8_WYKONANE_ZREAL[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_8_ZREAL[$x][$zamowienie_id_temp];
						if($rodzaj_produktu == 9) $SUMA_9_WYKONANE_ZREAL[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_9_ZREAL[$x][$zamowienie_id_temp];
						if($rodzaj_produktu == 0) $SUMA_0_WYKONANE_ZREAL[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_0_ZREAL[$x][$zamowienie_id_temp];
						if($rodzaj_produktu == 10) $SUMA_10_WYKONANE_ZREAL[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_10_ZREAL[$x][$zamowienie_id_temp];
						if($rodzaj_produktu == 11) $SUMA_11_WYKONANE_ZREAL[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_11_ZREAL[$x][$zamowienie_id_temp];
						} // do for ($x=1; $x<=$ilosc_pozycji_zamowienia[$zamowienie_id_temp]; $x++)
					} // do else
				} // do while($wynik= mysqli_fetch_assoc($pytanie))
			} // while($wynik66= mysqli_fetch_assoc($pytanie66))
				
	
	$SUMA_DO_ZROBIENIA2_ZREAL[1]=0;
	$SUMA_DO_ZROBIENIA2_ZREAL[2]=0;
	$SUMA_DO_ZROBIENIA2_ZREAL[3]=0;
	$SUMA_DO_ZROBIENIA2_ZREAL[4]=0;
	$SUMA_DO_ZROBIENIA2_ZREAL[5]=0;
	$SUMA_DO_ZROBIENIA2_ZREAL[6]=0;
	// $SUMA_DO_ZROBIENIA2_ZREAL[7]=0;
	$SUMA_DO_ZROBIENIA2_ZREAL[8]=0;
	$SUMA_DO_ZROBIENIA2_ZREAL[9]=0;
	$SUMA_DO_ZROBIENIA2_ZREAL[0]=0;
	$SUMA_DO_ZROBIENIA2_ZREAL[10]=0;
	$SUMA_DO_ZROBIENIA2_ZREAL[11]=0;

	echo '<table width="100%" align="left" class="tabela" cellpadding="5"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
	echo '<td>Nr / pozycja zamówienia</td>';
	echo '<td width="15%">Klient</td>';

	//wyswietlanie nazw kolumn
	echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[0].'</td>';
	echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[1].'</td>';
	echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[2].'</td>';
	echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[3].'</td>';
	echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[4].'</td>';
	echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[5].'</td>';
	echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[6].'</td>';
	echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[7].'</td>';
	echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[11].'</td>';
	echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[8].'</td>';
	echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[9].'</td>';
	echo '<td width="6%">'.$TABELA_LISTA_PRODUKTOW[10].'</td>';



	echo '</tr>';
	for ($x=1; $x<=$ilosc_zamowien; $x++)
		{
		$pytanie77 = mysqli_query($conn, "SELECT nr_zamowienia, klient_nazwa FROM zamowienia WHERE id = ".$zamowienie_id[$x].";");
		while($wynik77= mysqli_fetch_assoc($pytanie77))
			{
			$klient_nazwa[$x]=$wynik77['klient_nazwa'];
			$nr_zamowienia[$x]=$wynik77['nr_zamowienia'];
			}	
		
		for ($y=1; $y<=$ilosc_pozycji_zamowienia[$zamowienie_id[$x]]; $y++)
			{
			//sprawdzamy czy ktoras z pozycji juz jest w 100% wykonana
			$czy_pozycja_w_100_procentach_zrobiona = 0;
			$do_zrobienia_ZREAL[1] = $suma_rodzaj_produktu_1_ZREAL[$y][$zamowienie_id[$x]]-$SUMA_1_WYKONANE_ZREAL[$y][$zamowienie_id[$x]];
			$SUMA_do_zrobienia_ZREAL[1] += $do_zrobienia_ZREAL[1];
			$do_zrobienia_ZREAL[2] = $suma_rodzaj_produktu_2_ZREAL[$y][$zamowienie_id[$x]]-$SUMA_2_WYKONANE_ZREAL[$y][$zamowienie_id[$x]];
			$SUMA_do_zrobienia_ZREAL[2] += $do_zrobienia_ZREAL[2];
			$do_zrobienia_ZREAL[3] = $suma_rodzaj_produktu_3_ZREAL[$y][$zamowienie_id[$x]]-$SUMA_3_WYKONANE_ZREAL[$y][$zamowienie_id[$x]];
			$SUMA_do_zrobienia_ZREAL[3] += $do_zrobienia_ZREAL[3];
			$do_zrobienia_ZREAL[4] = $suma_rodzaj_produktu_4_ZREAL[$y][$zamowienie_id[$x]]-$SUMA_4_WYKONANE_ZREAL[$y][$zamowienie_id[$x]];
			$SUMA_do_zrobienia_ZREAL[4] += $do_zrobienia_ZREAL[4];
			$do_zrobienia_ZREAL[5] = $suma_rodzaj_produktu_5_ZREAL[$y][$zamowienie_id[$x]]-$SUMA_5_WYKONANE_ZREAL[$y][$zamowienie_id[$x]];
			$SUMA_do_zrobienia_ZREAL[5] += $do_zrobienia_ZREAL[5];
			$do_zrobienia_ZREAL[6] = $suma_rodzaj_produktu_6_ZREAL[$y][$zamowienie_id[$x]]-$SUMA_6_WYKONANE_ZREAL[$y][$zamowienie_id[$x]];
			$SUMA_do_zrobienia_ZREAL[6] += $do_zrobienia_ZREAL[6];
			// $do_zrobienia_ZREAL[7] = $suma_rodzaj_produktu_7_ZREAL[$y][$zamowienie_id[$x]]-$SUMA_7_WYKONANE_ZREAL[$y][$zamowienie_id[$x]];
			// $SUMA_do_zrobienia_ZREAL[7] += $do_zrobienia_ZREAL[7];
			
			$do_zrobienia_ZREAL[8] = $suma_rodzaj_produktu_8_ZREAL[$y][$zamowienie_id[$x]]-$SUMA_8_WYKONANE_ZREAL[$y][$zamowienie_id[$x]];
			$SUMA_do_zrobienia_ZREAL[8] += $do_zrobienia_ZREAL[8];
			$do_zrobienia_ZREAL[9] = $suma_rodzaj_produktu_9_ZREAL[$y][$zamowienie_id[$x]]-$SUMA_9_WYKONANE_ZREAL[$y][$zamowienie_id[$x]];
			$SUMA_do_zrobienia_ZREAL[9] += $do_zrobienia_ZREAL[9];
			$do_zrobienia_ZREAL[0] = $suma_rodzaj_produktu_0_ZREAL[$y][$zamowienie_id[$x]]-$SUMA_0_WYKONANE_ZREAL[$y][$zamowienie_id[$x]];
			$SUMA_DO_ZROBIENIA_ZREAL[0] += $do_zrobienia_ZREAL[0];
			$do_zrobienia_ZREAL[10] = $suma_rodzaj_produktu_10[$y][$zamowienie_id[$x]]-$SUMA_10_WYKONANE_ZREAL[$y][$zamowienie_id[$x]];
			$SUMA_do_zrobienia_ZREAL[10] += $do_zrobienia_ZREAL[10];
			$do_zrobienia_ZREAL[11] = $suma_rodzaj_produktu_11[$y][$zamowienie_id[$x]]-$SUMA_11_WYKONANE_ZREAL[$y][$zamowienie_id[$x]];
			$SUMA_do_zrobienia_ZREAL[11] += $do_zrobienia_ZREAL[11];
			//for ($z=1; $z<=$dl_lista_produktow; $z++) $czy_pozycja_w_100_procentach_zrobiona += $do_zrobienia_ZREAL[$z];
			$czy_pozycja_w_100_procentach_zrobiona = $do_zrobienia_ZREAL[1] + $do_zrobienia_ZREAL[2] + $do_zrobienia_ZREAL[4] + $do_zrobienia_ZREAL[5] + $do_zrobienia_ZREAL[3] + $do_zrobienia_ZREAL[0] + $do_zrobienia_ZREAL[10]  + $do_zrobienia_ZREAL[11]; //%%%%%%%%%%%%%%%%%%%%%% + $do_zrobienia_ZREAL[7]


//echo 'czy_pozycja_w_100_procentach_zrobiona = '.$czy_pozycja_w_100_procentach_zrobiona.'<br>';
//echo 'do zrobienia_ZREAL 0='.$do_zrobienia_ZREAL[0].',  &nbsp;&nbsp; 1='.$do_zrobienia_ZREAL[1].',  &nbsp;&nbsp; 3='.$do_zrobienia_ZREAL[3].', &nbsp;&nbsp;  4='.$do_zrobienia_ZREAL[4].', &nbsp;&nbsp;  5='.$do_zrobienia_ZREAL[5].', &nbsp;&nbsp;  10='.$do_zrobienia_ZREAL[10].'<br><br>';
			
			if($czy_pozycja_w_100_procentach_zrobiona == 0)
				{
				$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[1] += $suma_rodzaj_produktu_1_ZREAL[$y][$zamowienie_id[$x]];
				$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[2] += $suma_rodzaj_produktu_2_ZREAL[$y][$zamowienie_id[$x]];
				$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[3] += $suma_rodzaj_produktu_3_ZREAL[$y][$zamowienie_id[$x]];
				$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[4] += $suma_rodzaj_produktu_4_ZREAL[$y][$zamowienie_id[$x]];
				$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[5] += $suma_rodzaj_produktu_5_ZREAL[$y][$zamowienie_id[$x]];
				$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[6] += $suma_rodzaj_produktu_6_ZREAL[$y][$zamowienie_id[$x]];
				// $SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[7] += $suma_rodzaj_produktu_7_ZREAL[$y][$zamowienie_id[$x]];
				$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[8] += $suma_rodzaj_produktu_8_ZREAL[$y][$zamowienie_id[$x]];
				$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[9] += $suma_rodzaj_produktu_9_ZREAL[$y][$zamowienie_id[$x]];
				$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[0] += $suma_rodzaj_produktu_0_ZREAL[$y][$zamowienie_id[$x]];
				$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[10] += $suma_rodzaj_produktu_10_ZREAL[$y][$zamowienie_id[$x]];
				$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[11] += $suma_rodzaj_produktu_11_ZREAL[$y][$zamowienie_id[$x]];
				$SUMA_DO_ZROBIENIA2_ZREAL[1] += $do_zrobienia_ZREAL[1];
				$SUMA_DO_ZROBIENIA2_ZREAL[2] += $do_zrobienia_ZREAL[2];
				$SUMA_DO_ZROBIENIA2_ZREAL[3] += $do_zrobienia_ZREAL[3];
				$SUMA_DO_ZROBIENIA2_ZREAL[4] += $do_zrobienia_ZREAL[4];
				$SUMA_DO_ZROBIENIA2_ZREAL[5] += $do_zrobienia_ZREAL[5];
				$SUMA_DO_ZROBIENIA2_ZREAL[6] += $do_zrobienia_ZREAL[6];
				// $SUMA_DO_ZROBIENIA2_ZREAL[7] += $do_zrobienia_ZREAL[7];
				$SUMA_DO_ZROBIENIA2_ZREAL[8] += $do_zrobienia_ZREAL[8];
				$SUMA_DO_ZROBIENIA2_ZREAL[9] += $do_zrobienia_ZREAL[9];
				$SUMA_DO_ZROBIENIA2_ZREAL[0] += $do_zrobienia_ZREAL[0];
				$SUMA_DO_ZROBIENIA2_ZREAL[10] += $do_zrobienia_ZREAL[10];
				$SUMA_DO_ZROBIENIA2_ZREAL[11] += $do_zrobienia_ZREAL[11];
				
				// jezeli wszystkie zgrzewy sa wykonane  - zerujemy luki stalowe, odwodnienia i ca reszt zlec tranp
				if($suma_rodzaj_produktu_4_ZREAL[$y][$zamowienie_id[$x]] != 0)
					if($do_zrobienia_ZREAL[4] == 0)
						{
							//echo 'tutaj2, id='.$zamowienie_id[$x].'<br>';
						// $do_zrobienia_ZREAL[2] = 0;
						$do_zrobienia_ZREAL[6] = 0;
						$do_zrobienia_ZREAL[8] = 0;
						$do_zrobienia_ZREAL[9] = 0;
						$do_zrobienia_ZREAL[11] = 0;
						// $do_zrobienia_ZREAL[7] = 0;
						}
				// if(($suma_rodzaj_produktu_4_ZREAL[$y][$zamowienie_id[$x]] == 0) && ($suma_rodzaj_produktu_1_ZREAL[$y][$zamowienie_id[$x]] != 0))
				// 	if($do_zrobienia_ZREAL[1] == 0) $do_zrobienia_ZREAL[2] = 0;
						
				// sprawdzamy czy dana pozycja jest zaznaczona w zleceniu tranpsortowym
				$pytanie646 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_tresc WHERE zamowienie_id = ".$zamowienie_id[$x]." AND pozycja_wyceny = ".$y.";");
				while($wynik646= mysqli_fetch_assoc($pytanie646))
					{
					echo '<tr align="center" class="text_duzy" bgcolor="'.$kolor_bialy.'" height="40px">';
					echo '<td class="'.$text_zmienny.'">'.$nr_zamowienia[$x].'&nbsp;&nbsp;&nbsp;'.$y.'/'.$ilosc_pozycji_zamowienia[$zamowienie_id[$x]].'</td>';
					echo '<td class="'.$text_zmienny.'">'.$klient_nazwa[$x].'</td>';
					
					if(($suma_rodzaj_produktu_0_ZREAL[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia_ZREAL[0] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia_ZREAL[0] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_0_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[0].')</td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu_0_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[0].')</td>';

					if(($suma_rodzaj_produktu_1_ZREAL[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia_ZREAL[1] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia_ZREAL[1] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_1_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[1].')</td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu_1_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[1].')</td>';
					
					if(($suma_rodzaj_produktu_2_ZREAL[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia_ZREAL[2] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia_ZREAL[2] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_2_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[2].')</td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu_2_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[2].')</td>';
	
					if(($suma_rodzaj_produktu_3_ZREAL[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia_ZREAL[3] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia_ZREAL[3] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_3_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[3].')</td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu_3_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[3].')</td>';
					
					if(($suma_rodzaj_produktu_4_ZREAL[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia_ZREAL[4] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia_ZREAL[4] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_4_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[4].')</td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu_4_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[4].')</td>';
					
					if(($suma_rodzaj_produktu_5_ZREAL[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia_ZREAL[5] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia_ZREAL[5] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_5_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[5].')</td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu_5_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[5].')</td>';
					
					if(($suma_rodzaj_produktu_6_ZREAL[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia_ZREAL[6] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia_ZREAL[6] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_6_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[6].')</td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu_6_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[6].')</td>';
	
					//%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
					// if(($suma_rodzaj_produktu_7_ZREAL[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia_ZREAL[7] == 0)) echo '<td align="center">&nbsp;</td>';
					// elseif($do_zrobienia_ZREAL[7] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">hh'.$suma_rodzaj_produktu_7_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[7].')</td>';
					// else echo '<td align="center">gg'.$suma_rodzaj_produktu_7_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[7].')</td>';
					
					if(($suma_rodzaj_produktu_7_ZREAL[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia_ZREAL[7] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia_ZREAL[7] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_7_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[7].')</td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu_7_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[7].')</td>';
					
					if(($suma_rodzaj_produktu_11_ZREAL[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia_ZREAL[11] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia_ZREAL[11] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_11_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[11].')</td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu_11_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[11].')</td>';

					if(($suma_rodzaj_produktu_8_ZREAL[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia_ZREAL[8] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia_ZREAL[8] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_8_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[8].')</td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu_8_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[8].')</td>';
					
					if(($suma_rodzaj_produktu_9_ZREAL[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia_ZREAL[9] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia_ZREAL[9] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_9_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[9].')</td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu_9_ZREAL[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[9].')</td>';
					
					if(($suma_rodzaj_produktu_10[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia_ZREAL[10] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia_ZREAL[10] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_10[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[10].')</td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu_10[$y][$zamowienie_id[$x]].' ('.$do_zrobienia_ZREAL[10].')</td>';
					echo '</tr>';
					}
				} // do if($czy_pozycja_w_100_procentach_zrobiona != 0)
			} // do for ($y=1; $y<=$ilosc_pozycji_zamowienia[$zamowienie_id[$x]]; $y++)
			
		} // do for ($x=1; $x<=$ilosc_zamowien; $x++)
	echo '<tr align="center" class="text_duzy" bgcolor="'.$kolor_tabeli.'">';
	echo '<td align="right" colspan="2">SUMA >>> </td>';
	
	//wyswietlanie sumy
	echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[0].'&nbsp;('.$SUMA_DO_ZROBIENIA2_ZREAL[0].')</td>';
	echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[1].'&nbsp;('.$SUMA_DO_ZROBIENIA2_ZREAL[1].')</td>';
	echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[2].'&nbsp;('.$SUMA_DO_ZROBIENIA2_ZREAL[2].')</td>';
	echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[3].'&nbsp;('.$SUMA_DO_ZROBIENIA2_ZREAL[3].')</td>';
	echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[4].'&nbsp;('.$SUMA_DO_ZROBIENIA2_ZREAL[4].')</td>';
	echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[5].'&nbsp;('.$SUMA_DO_ZROBIENIA2_ZREAL[5].')</td>';
	echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[6].'&nbsp;('.$SUMA_DO_ZROBIENIA2_ZREAL[6].')</td>';
	echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[7].'&nbsp;('.$SUMA_DO_ZROBIENIA2_ZREAL[7].')</td>';
	echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[11].'&nbsp;('.$SUMA_DO_ZROBIENIA2_ZREAL[11].')</td>';
	echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[8].'&nbsp;('.$SUMA_DO_ZROBIENIA2_ZREAL[8].')</td>';
	echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[9].'&nbsp;('.$SUMA_DO_ZROBIENIA2_ZREAL[9].')</td>';
	echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_ZREAL[10].'&nbsp;('.$SUMA_DO_ZROBIENIA2_ZREAL[10].')</td>';


	echo '</tr></table>';
		} // if(preg_match("/ZT/", $zlecenie_transportowe))



echo '</td></tr></table>';
?>