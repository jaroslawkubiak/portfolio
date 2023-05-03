<?php
$WARUNEK2 = '';
if($klienci_do_planu_produkcji != '') $WARUNEK2 = " AND klient_id = ".$klienci_do_planu_produkcji."";
$pytanie366 = mysqli_query($conn, "SELECT id, nr_zamowienia FROM zamowienia WHERE status <> 'Dostarczone' AND status <> 'Anulowane' AND status <> 'Odebrane' AND stan = 'Sprawdzić' AND magazyn = 'Własny' ".$WARUNEK2." ORDER BY ".$wg_czego." ".$jak.";");
while($wynik366= mysqli_fetch_assoc($pytanie366))
	{
	$ilosc_zamowien++;
	$zamowienie_id_temp = $wynik366['id'];
	$zamowienie_id[$ilosc_zamowien] = $wynik366['id'];
	$nr_zamowienia[$ilosc_zamowien] = $wynik366['nr_zamowienia'];
		
	$ilosc_pozycji=0;
	$pytanie4 = mysqli_query($conn, "SELECT * FROM wyceny WHERE zamowienie_id = ".$zamowienie_id_temp." AND pozycja_transport = 'nie' ORDER BY pozycja ASC;");
	while($wynik4= mysqli_fetch_assoc($pytanie4))
		{
		$ilosc_pozycji++;
			$suma_rodzaj_produktu_1[$ilosc_pozycji][$zamowienie_id_temp] = $wynik4['wygiecie_ramy_pvc_ilosc_szt']+$wynik4['wygiecie_skrzydla_pvc_ilosc_szt']+$wynik4['wygiecie_innego_pvc_ilosc_szt'];
			//$SUMA_ELEMENTOW_DANEGO_TYPU[1] += $suma_rodzaj_produktu_1[$ilosc_pozycji][$zamowienie_id_temp];
			$wygiecie_listwy_pvc_ilosc_szt=$wynik4['wygiecie_listwy_pvc_ilosc_szt'];
			if(($suma_rodzaj_produktu_1[$ilosc_pozycji][$zamowienie_id_temp] == 0) && ($wygiecie_listwy_pvc_ilosc_szt != 0)) $suma_rodzaj_produktu_1[$ilosc_pozycji][$zamowienie_id_temp] = $wygiecie_listwy_pvc_ilosc_szt;
			
			$wygiecie_wzmocnienia_okiennego_ilosc_szt=$wynik4['wygiecie_wzmocnienia_okiennego_ilosc_szt'];
			$wygiecie_innego_ilosc_szt=$wynik4['wygiecie_innego_ilosc_szt'];
		$suma_rodzaj_produktu_2[$ilosc_pozycji][$zamowienie_id_temp] = $wygiecie_wzmocnienia_okiennego_ilosc_szt+$wygiecie_innego_ilosc_szt;
		//$SUMA_ELEMENTOW_DANEGO_TYPU[2] += $suma_rodzaj_produktu_2[$ilosc_pozycji][$zamowienie_id_temp];

			$wygiecie_ramy_alu_ilosc_szt=$wynik4['wygiecie_ramy_alu_ilosc_szt'];
			$wygiecie_skrzydla_alu_ilosc_szt=$wynik4['wygiecie_skrzydla_alu_ilosc_szt'];
			$wygiecie_innego_alu_ilosc_szt=$wynik4['wygiecie_innego_alu_ilosc_szt'];
		$suma_rodzaj_produktu_3[$ilosc_pozycji][$zamowienie_id_temp] = $wygiecie_ramy_alu_ilosc_szt+$wygiecie_skrzydla_alu_ilosc_szt+$wygiecie_innego_alu_ilosc_szt;
		//$SUMA_ELEMENTOW_DANEGO_TYPU[3] += $suma_rodzaj_produktu_3[$ilosc_pozycji][$zamowienie_id_temp];

		$suma_rodzaj_produktu_4[$ilosc_pozycji][$zamowienie_id_temp]=$wynik4['zgrzanie_ilosc'];
		$suma_rodzaj_produktu_5[$ilosc_pozycji][$zamowienie_id_temp]=$wynik4['wstawienie_slupka_ilosc']+$wynik4['wstawienie_slupka_ruchomego_ilosc'];
		$suma_rodzaj_produktu_6[$ilosc_pozycji][$zamowienie_id_temp]=$wynik4['wyfrezowanie_odwodnienia_ilosc'];
		$suma_rodzaj_produktu_7[$ilosc_pozycji][$zamowienie_id_temp]=$wynik4['listwa_przyszybowa_ilosc'];
		$suma_rodzaj_produktu_11[$ilosc_pozycji][$zamowienie_id_temp]=$wynik4['dociecie_kompletu_listew_przyszybowych_ilosc'];
		$suma_rodzaj_produktu_8[$ilosc_pozycji][$zamowienie_id_temp]=$wynik4['okucie_ilosc'];
		$suma_rodzaj_produktu_9[$ilosc_pozycji][$zamowienie_id_temp]=$wynik4['zaszklenie_ilosc'];
		$suma_rodzaj_produktu_0[$ilosc_pozycji][$zamowienie_id_temp]=$wynik4['ilosc_sztuk'];
		$suma_rodzaj_produktu_10[$ilosc_pozycji][$zamowienie_id_temp]=$wynik4['ilosc_sztuk'];
		}	 // do while($wynik4= mysqli_fetch_assoc($pytanie4))
	$ilosc_pozycji_zamowienia[$zamowienie_id_temp] = $ilosc_pozycji;
					
	$pytanie = mysqli_query($conn, "SELECT * FROM realizacja_produkcji WHERE zamowienie_id=".$zamowienie_id_temp.";");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		//$zamowienie_id[$w]=$wynik['zamowienie_id'];
		//$temp = $wynik['zamowienie_id'];
		$rodzaj_produktu=$wynik['rodzaj_produktu'];
		$ilosc=$wynik['ilosc'];
		$pozycja=$wynik['pozycja'];
		if($pozycja != 'on')
			{
			if($rodzaj_produktu == 1) $SUMA_1_WYKONANE[$pozycja][$zamowienie_id_temp] += $ilosc;
			if($rodzaj_produktu == 2) $SUMA_2_WYKONANE[$pozycja][$zamowienie_id_temp] += $ilosc;
			if($rodzaj_produktu == 3) $SUMA_3_WYKONANE[$pozycja][$zamowienie_id_temp] += $ilosc;
			if($rodzaj_produktu == 4) $SUMA_4_WYKONANE[$pozycja][$zamowienie_id_temp] += $ilosc;
			if($rodzaj_produktu == 5) $SUMA_5_WYKONANE[$pozycja][$zamowienie_id_temp] += $ilosc;
			if($rodzaj_produktu == 6) $SUMA_6_WYKONANE[$pozycja][$zamowienie_id_temp] += $ilosc;
			if($rodzaj_produktu == 7) $SUMA_7_WYKONANE[$pozycja][$zamowienie_id_temp] += $ilosc;
			if($rodzaj_produktu == 8) $SUMA_8_WYKONANE[$pozycja][$zamowienie_id_temp] += $ilosc;
			if($rodzaj_produktu == 9) $SUMA_9_WYKONANE[$pozycja][$zamowienie_id_temp] += $ilosc;
			if($rodzaj_produktu == 0) $SUMA_0_WYKONANE[$pozycja][$zamowienie_id_temp] += $ilosc;
			if($rodzaj_produktu == 10) $SUMA_10_WYKONANE[$pozycja][$zamowienie_id_temp] += $ilosc;
			if($rodzaj_produktu == 11) $SUMA_11_WYKONANE[$pozycja][$zamowienie_id_temp] += $ilosc;
			} // do if($pozycja != 'on')
		else
			{
			for ($x=1; $x<=$ilosc_pozycji_zamowienia[$zamowienie_id_temp]; $x++)
				{
				if($rodzaj_produktu == 1) $SUMA_1_WYKONANE[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_1[$x][$zamowienie_id_temp];
				if($rodzaj_produktu == 2) $SUMA_2_WYKONANE[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_2[$x][$zamowienie_id_temp];
				if($rodzaj_produktu == 3) $SUMA_3_WYKONANE[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_3[$x][$zamowienie_id_temp];
				if($rodzaj_produktu == 4) $SUMA_4_WYKONANE[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_4[$x][$zamowienie_id_temp];
				if($rodzaj_produktu == 5) $SUMA_5_WYKONANE[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_5[$x][$zamowienie_id_temp];
				if($rodzaj_produktu == 6) $SUMA_6_WYKONANE[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_6[$x][$zamowienie_id_temp];
				if($rodzaj_produktu == 7) $SUMA_7_WYKONANE[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_7[$x][$zamowienie_id_temp];
				if($rodzaj_produktu == 8) $SUMA_8_WYKONANE[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_8[$x][$zamowienie_id_temp];
				if($rodzaj_produktu == 9) $SUMA_9_WYKONANE[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_9[$x][$zamowienie_id_temp];
				if($rodzaj_produktu == 0) $SUMA_0_WYKONANE[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_0[$x][$zamowienie_id_temp];
				if($rodzaj_produktu == 10) $SUMA_10_WYKONANE[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_10[$x][$zamowienie_id_temp];
				if($rodzaj_produktu == 11) $SUMA_11_WYKONANE[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_11[$x][$zamowienie_id_temp];
			} // do for ($x=1; $x<=$ilosc_pozycji_zamowienia[$zamowienie_id_temp]; $x++)
			} // do else
		} // do while($wynik= mysqli_fetch_assoc($pytanie))
	} //  do while($wynik366= mysqli_fetch_assoc($pytanie366))
	
$SUMA_DO_ZROBIENIA2[0]=0;
$SUMA_DO_ZROBIENIA2[1]=0;
$SUMA_DO_ZROBIENIA2[2]=0;
$SUMA_DO_ZROBIENIA2[3]=0;
$SUMA_DO_ZROBIENIA2[4]=0;
$SUMA_DO_ZROBIENIA2[5]=0;
$SUMA_DO_ZROBIENIA2[6]=0;
$SUMA_DO_ZROBIENIA2[7]=0;
$SUMA_DO_ZROBIENIA2[8]=0;
$SUMA_DO_ZROBIENIA2[9]=0;
$SUMA_DO_ZROBIENIA2[10]=0;
$SUMA_DO_ZROBIENIA2[11]=0;

echo '<table width="100%" align="left" class="tabela" cellpadding="6"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
if($page == 'realizacja_produkcji_zamowienia_do_wykonania')
	{
	echo '<td>Nr / pozycja zamówienia<div align="right"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania'.$SORTOWANIE_DIV.'&zlecenie_transportowe='.$zlecenie_transportowe.'&jak=DESC&wg_czego=nr_zamowienia">'.$image_arrow_down.'</a><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania'.$SORTOWANIE_DIV.'&zlecenie_transportowe='.$zlecenie_transportowe.'&jak=ASC&wg_czego=nr_zamowienia">'.$image_arrow_up.'</a></div></td>';
	echo '<td width="15%">Klient<div align="right"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania'.$SORTOWANIE_DIV.'&zlecenie_transportowe='.$zlecenie_transportowe.'&jak=DESC&wg_czego=klient_nazwa">'.$image_arrow_down.'</a><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania'.$SORTOWANIE_DIV.'&zlecenie_transportowe='.$zlecenie_transportowe.'&jak=ASC&wg_czego=klient_nazwa">'.$image_arrow_up.'</a></div></td>';
	}
else
	{
	echo '<td>Nr / pozycja zamówienia</td>';
	echo '<td width="15%">Klient</td>';
	}

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
		//echo 'id='.$zamowienie_id[$x].'&nbsp;&nbsp;&nbsp;&nbsp;';
		$klient_nazwa[$x]=$wynik77['klient_nazwa'];
		$nr_zamowienia[$x]=$wynik77['nr_zamowienia'];
		}	
	
	for ($y=1; $y<=$ilosc_pozycji_zamowienia[$zamowienie_id[$x]]; $y++)
		{
		//sprawdzamy czy ktoras z pozycji juz jest w 100% wykonana
		$czy_pozycja_w_100_procentach_zrobiona = 0;
		$do_zrobienia[1] = $suma_rodzaj_produktu_1[$y][$zamowienie_id[$x]]-$SUMA_1_WYKONANE[$y][$zamowienie_id[$x]];
		$SUMA_DO_ZROBIENIA[1] += $do_zrobienia[1];
		$do_zrobienia[2] = $suma_rodzaj_produktu_2[$y][$zamowienie_id[$x]]-$SUMA_2_WYKONANE[$y][$zamowienie_id[$x]];
		$SUMA_DO_ZROBIENIA[2] += $do_zrobienia[2];
		$do_zrobienia[3] = $suma_rodzaj_produktu_3[$y][$zamowienie_id[$x]]-$SUMA_3_WYKONANE[$y][$zamowienie_id[$x]];
		$SUMA_DO_ZROBIENIA[3] += $do_zrobienia[3];
		$do_zrobienia[4] = $suma_rodzaj_produktu_4[$y][$zamowienie_id[$x]]-$SUMA_4_WYKONANE[$y][$zamowienie_id[$x]];
		$SUMA_DO_ZROBIENIA[4] += $do_zrobienia[4];
		$do_zrobienia[5] = $suma_rodzaj_produktu_5[$y][$zamowienie_id[$x]]-$SUMA_5_WYKONANE[$y][$zamowienie_id[$x]];
		$SUMA_DO_ZROBIENIA[5] += $do_zrobienia[5];
		$do_zrobienia[6] = $suma_rodzaj_produktu_6[$y][$zamowienie_id[$x]]-$SUMA_6_WYKONANE[$y][$zamowienie_id[$x]];
		$SUMA_DO_ZROBIENIA[6] += $do_zrobienia[6];
		$do_zrobienia[7] = $suma_rodzaj_produktu_7[$y][$zamowienie_id[$x]]-$SUMA_7_WYKONANE[$y][$zamowienie_id[$x]];
		$SUMA_DO_ZROBIENIA[7] += $do_zrobienia[7];
		$do_zrobienia[8] = $suma_rodzaj_produktu_8[$y][$zamowienie_id[$x]]-$SUMA_8_WYKONANE[$y][$zamowienie_id[$x]];
		$SUMA_DO_ZROBIENIA[8] += $do_zrobienia[8];
		$do_zrobienia[9] = $suma_rodzaj_produktu_9[$y][$zamowienie_id[$x]]-$SUMA_9_WYKONANE[$y][$zamowienie_id[$x]];
		$SUMA_DO_ZROBIENIA[9] += $do_zrobienia[9];

		$do_zrobienia[0] = $suma_rodzaj_produktu_0[$y][$zamowienie_id[$x]]-$SUMA_0_WYKONANE[$y][$zamowienie_id[$x]];
		$SUMA_DO_ZROBIENIA[0] += $do_zrobienia[0];
		$do_zrobienia[10] = $suma_rodzaj_produktu_10[$y][$zamowienie_id[$x]]-$SUMA_10_WYKONANE[$y][$zamowienie_id[$x]];
		$SUMA_DO_ZROBIENIA[10] += $do_zrobienia[10];
		$do_zrobienia[11] = $suma_rodzaj_produktu_11[$y][$zamowienie_id[$x]]-$SUMA_11_WYKONANE[$y][$zamowienie_id[$x]];
		$SUMA_DO_ZROBIENIA[11] += $do_zrobienia[11];

		//for ($z=1; $z<=$dl_lista_produktow; $z++) $czy_pozycja_w_100_procentach_zrobiona += $do_zrobienia[$z];
		$czy_pozycja_w_100_procentach_zrobiona = $do_zrobienia[1] + $do_zrobienia[4] + $do_zrobienia[5] + $do_zrobienia[3] + $do_zrobienia[0] + $do_zrobienia[10] + $do_zrobienia[7] + $do_zrobienia[11];

		if($czy_pozycja_w_100_procentach_zrobiona != 0)
			{
			$SUMA_ELEMENTOW_DANEGO_TYPU[1] += $suma_rodzaj_produktu_1[$y][$zamowienie_id[$x]];
			$SUMA_ELEMENTOW_DANEGO_TYPU[2] += $suma_rodzaj_produktu_2[$y][$zamowienie_id[$x]];
			$SUMA_ELEMENTOW_DANEGO_TYPU[3] += $suma_rodzaj_produktu_3[$y][$zamowienie_id[$x]];
			$SUMA_ELEMENTOW_DANEGO_TYPU[4] += $suma_rodzaj_produktu_4[$y][$zamowienie_id[$x]];
			$SUMA_ELEMENTOW_DANEGO_TYPU[5] += $suma_rodzaj_produktu_5[$y][$zamowienie_id[$x]];
			$SUMA_ELEMENTOW_DANEGO_TYPU[6] += $suma_rodzaj_produktu_6[$y][$zamowienie_id[$x]];
			$SUMA_ELEMENTOW_DANEGO_TYPU[7] += $suma_rodzaj_produktu_7[$y][$zamowienie_id[$x]];
			$SUMA_ELEMENTOW_DANEGO_TYPU[8] += $suma_rodzaj_produktu_8[$y][$zamowienie_id[$x]];
			$SUMA_ELEMENTOW_DANEGO_TYPU[9] += $suma_rodzaj_produktu_9[$y][$zamowienie_id[$x]];
			$SUMA_ELEMENTOW_DANEGO_TYPU[0] += $suma_rodzaj_produktu_0[$y][$zamowienie_id[$x]];
			$SUMA_ELEMENTOW_DANEGO_TYPU[10] += $suma_rodzaj_produktu_10[$y][$zamowienie_id[$x]];
			$SUMA_ELEMENTOW_DANEGO_TYPU[11] += $suma_rodzaj_produktu_11[$y][$zamowienie_id[$x]];
			
			$SUMA_DO_ZROBIENIA2[1] += $do_zrobienia[1];
			$SUMA_DO_ZROBIENIA2[2] += $do_zrobienia[2];
			$SUMA_DO_ZROBIENIA2[3] += $do_zrobienia[3];
			$SUMA_DO_ZROBIENIA2[4] += $do_zrobienia[4];
			$SUMA_DO_ZROBIENIA2[5] += $do_zrobienia[5];
			$SUMA_DO_ZROBIENIA2[6] += $do_zrobienia[6];
			$SUMA_DO_ZROBIENIA2[7] += $do_zrobienia[7];
			$SUMA_DO_ZROBIENIA2[8] += $do_zrobienia[8];
			$SUMA_DO_ZROBIENIA2[9] += $do_zrobienia[9];
			$SUMA_DO_ZROBIENIA2[0] += $do_zrobienia[0];
			$SUMA_DO_ZROBIENIA2[10] += $do_zrobienia[10];
			$SUMA_DO_ZROBIENIA2[11] += $do_zrobienia[11];
			
			// jezeli wszystkie zgrzewy sa wykonane  - zerujemy luki stalowe, odwodnienia i ca reszt WSZYstkie
			if($suma_rodzaj_produktu_4[$y][$zamowienie_id[$x]] != 0)
				if($do_zrobienia[4] == 0)
					{
					// $do_zrobienia[2] = 0;
					$do_zrobienia[6] = 0;
					$do_zrobienia[7] = 0;
					$do_zrobienia[8] = 0;
					$do_zrobienia[9] = 0;
					}
			// elseif(($suma_rodzaj_produktu_4[$y][$zamowienie_id[$x]] == 0) && ($suma_rodzaj_produktu_1[$y][$zamowienie_id[$x]] != 0))
			// 	if($do_zrobienia[1] == 0) $do_zrobienia[2] = 0;
	
			echo '<tr align="center" class="text_duzy" bgcolor="'.$kolor_bialy.'" height="40px">';
			echo '<td class="'.$text_zmienny.'">'.$nr_zamowienia[$x].'&nbsp;&nbsp;&nbsp;'.$y.'/'.$ilosc_pozycji_zamowienia[$zamowienie_id[$x]].'</td>';
			echo '<td class="'.$text_zmienny.'">'.$klient_nazwa[$x].'</td>';
			
			if(($suma_rodzaj_produktu_0[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[0] == 0)) echo '<td align="center">&nbsp;</td>';
			elseif($do_zrobienia[0] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_0[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[0].')</td>';
			elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&klienci_do_planu_produkcji='.$klienci_do_planu_produkcji.'&jak='.$jak.'&wg_czego='.$wg_czego.'&zamowienie_id_akord='.$zamowienie_id[$x].'&rodzaj_produktu=0"><font size="+1" color="black">'.$suma_rodzaj_produktu_0[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[0].')</font></a></td>';
			else echo '<td align="center">'.$suma_rodzaj_produktu_0[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[0].')</td>';
		
			if(($suma_rodzaj_produktu_1[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[1] == 0)) echo '<td align="center">&nbsp;</td>';
			elseif($do_zrobienia[1] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_1[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[1].')</td>';
			elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&klienci_do_planu_produkcji='.$klienci_do_planu_produkcji.'&jak='.$jak.'&wg_czego='.$wg_czego.'&zamowienie_id_akord='.$zamowienie_id[$x].'&rodzaj_produktu=1"><font size="+1" color="black">'.$suma_rodzaj_produktu_1[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[1].')</font></a></td>';
			else echo '<td align="center">'.$suma_rodzaj_produktu_1[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[1].')</td>';
			
			if(($suma_rodzaj_produktu_2[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[2] == 0)) echo '<td align="center">&nbsp;</td>';
			elseif($do_zrobienia[2] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_2[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[2].')</td>';
			elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&klienci_do_planu_produkcji='.$klienci_do_planu_produkcji.'&jak='.$jak.'&wg_czego='.$wg_czego.'&zamowienie_id_akord='.$zamowienie_id[$x].'&rodzaj_produktu=2"><font size="+1" color="black">'.$suma_rodzaj_produktu_2[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[2].')</font></a></td>';
			else  echo '<td align="center">'.$suma_rodzaj_produktu_2[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[2].')</td>';

			if(($suma_rodzaj_produktu_3[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[3] == 0)) echo '<td align="center">&nbsp;</td>';
			elseif($do_zrobienia[3] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_3[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[3].')</td>';
			elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&klienci_do_planu_produkcji='.$klienci_do_planu_produkcji.'&jak='.$jak.'&wg_czego='.$wg_czego.'&zamowienie_id_akord='.$zamowienie_id[$x].'&rodzaj_produktu=3"><font size="+1" color="black">'.$suma_rodzaj_produktu_3[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[3].')</font></a></td>';
			else  echo '<td align="center">'.$suma_rodzaj_produktu_3[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[3].')</td>';
			
			if(($suma_rodzaj_produktu_4[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[4] == 0)) echo '<td align="center">&nbsp;</td>';
			elseif($do_zrobienia[4] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_4[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[4].')</td>';
			elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&klienci_do_planu_produkcji='.$klienci_do_planu_produkcji.'&jak='.$jak.'&wg_czego='.$wg_czego.'&zamowienie_id_akord='.$zamowienie_id[$x].'&rodzaj_produktu=4"><font size="+1" color="black">'.$suma_rodzaj_produktu_4[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[4].')</font></a></td>';
			else  echo '<td align="center">'.$suma_rodzaj_produktu_4[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[4].')</td>';
			
			if(($suma_rodzaj_produktu_5[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[5] == 0)) echo '<td align="center">&nbsp;</td>';
			elseif($do_zrobienia[5] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_5[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[5].')</td>';
			elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&klienci_do_planu_produkcji='.$klienci_do_planu_produkcji.'&jak='.$jak.'&wg_czego='.$wg_czego.'&zamowienie_id_akord='.$zamowienie_id[$x].'&rodzaj_produktu=5"><font size="+1" color="black">'.$suma_rodzaj_produktu_5[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[5].')</font></a></td>';
			else  echo '<td align="center">'.$suma_rodzaj_produktu_5[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[5].')</td>';
			
			if(($suma_rodzaj_produktu_6[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[6] == 0)) echo '<td align="center">&nbsp;</td>';
			elseif($do_zrobienia[6] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_6[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[6].')</td>';
			else echo '<td align="center">'.$suma_rodzaj_produktu_6[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[6].')</td>';

			if(($suma_rodzaj_produktu_7[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[7] == 0)) echo '<td align="center">&nbsp;</td>';
			elseif($do_zrobienia[7] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_7[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[7].')</td>';
			elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&klienci_do_planu_produkcji='.$klienci_do_planu_produkcji.'&jak='.$jak.'&wg_czego='.$wg_czego.'&zamowienie_id_akord='.$zamowienie_id[$x].'&rodzaj_produktu=7"><font size="+1" color="black">'.$suma_rodzaj_produktu_7[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[7].')</font></a></td>';
			else  echo '<td align="center">'.$suma_rodzaj_produktu_7[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[7].')</td>';

			if(($suma_rodzaj_produktu_11[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[11] == 0)) echo '<td align="center">&nbsp;</td>';
			elseif($do_zrobienia[11] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_11[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[11].')</td>';
			elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&klienci_do_planu_produkcji='.$klienci_do_planu_produkcji.'&jak='.$jak.'&wg_czego='.$wg_czego.'&zamowienie_id_akord='.$zamowienie_id[$x].'&rodzaj_produktu=11"><font size="+1" color="black">'.$suma_rodzaj_produktu_11[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[11].')</font></a></td>';
			else  echo '<td align="center">'.$suma_rodzaj_produktu_11[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[11].')</td>';

			if(($suma_rodzaj_produktu_8[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[8] == 0)) echo '<td align="center">&nbsp;</td>';
			elseif($do_zrobienia[8] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_8[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[8].')</td>';
			else echo '<td align="center">'.$suma_rodzaj_produktu_8[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[8].')</td>';
		
			if(($suma_rodzaj_produktu_9[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[9] == 0)) echo '<td align="center">&nbsp;</td>';
			elseif($do_zrobienia[9] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_9[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[9].')</td>';
			else echo '<td align="center">'.$suma_rodzaj_produktu_9[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[9].')</td>';

			if(($suma_rodzaj_produktu_10[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[10] == 0)) echo '<td align="center">&nbsp;</td>';
			elseif($do_zrobienia[10] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_10[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[10].')</td>';
			elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&klienci_do_planu_produkcji='.$klienci_do_planu_produkcji.'&jak='.$jak.'&wg_czego='.$wg_czego.'&zamowienie_id_akord='.$zamowienie_id[$x].'&rodzaj_produktu=10"><font size="+1" color="black">'.$suma_rodzaj_produktu_10[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[10].')</font></a></td>';
			else echo '<td align="center">'.$suma_rodzaj_produktu_10[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[10].')</td>';
			echo '</tr>';
			} // do if($czy_pozycja_w_100_procentach_zrobiona != 0)
		} // do for ($y=1; $y<=$ilosc_pozycji_zamowienia[$zamowienie_id[$x]]; $y++)
		
		
	} // do for ($x=1; $x<=$w; $x++)
echo '<tr align="center" class="text_duzy" bgcolor="'.$kolor_tabeli.'">';
echo '<td align="right" colspan="2">SUMA >>> </td>';

//wystietlanie sumy
echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[0].'&nbsp;('.$SUMA_DO_ZROBIENIA2[0].')</td>';
echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[1].'&nbsp;('.$SUMA_DO_ZROBIENIA2[1].')</td>';
echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[2].'&nbsp;('.$SUMA_DO_ZROBIENIA2[2].')</td>';
echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[3].'&nbsp;('.$SUMA_DO_ZROBIENIA2[3].')</td>';
echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[4].'&nbsp;('.$SUMA_DO_ZROBIENIA2[4].')</td>';
echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[5].'&nbsp;('.$SUMA_DO_ZROBIENIA2[5].')</td>';
echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[6].'&nbsp;('.$SUMA_DO_ZROBIENIA2[6].')</td>';
echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[7].'&nbsp;('.$SUMA_DO_ZROBIENIA2[7].')</td>';
echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[11].'&nbsp;('.$SUMA_DO_ZROBIENIA2[11].')</td>';
echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[8].'&nbsp;('.$SUMA_DO_ZROBIENIA2[8].')</td>';
echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[9].'&nbsp;('.$SUMA_DO_ZROBIENIA2[9].')</td>';
echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[10].'&nbsp;('.$SUMA_DO_ZROBIENIA2[10].')</td>';


echo '</tr></table>';


?>