<?php
$przeladuj = 1;
// dane do druku planu produkcji
if($page == 'realizacja_produkcji_zamowienia_do_wykonania')
	{
	$text_zmienny = 'text_zmienny';
	}
else
	{
	$text_zmienny = 'text_duzy';
	$kolor_tabeli = $kolor_szary;
	echo '<div align="left" class="text_duzy">PLAN PRODUKCJI : '.$zlecenie_transportowe.'</div><br>';
	}

$id = [];
$nr_zlecenia_transportowego = [];
$ilosc_zlecen_transportowych=0;
$pytanie = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_naglowek WHERE status <> 'Dostarczone' ORDER BY id DESC");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$ilosc_zlecen_transportowych++;
	$id[$ilosc_zlecen_transportowych]=$wynik['id'];
	$nr_zlecenia_transportowego[$ilosc_zlecen_transportowych]=$wynik['nr_zlecenia_transportowego'];
	}
	
$ilosc_zamowien=0;
$nr_zamowienia = [];
$pytanie3 = mysqli_query($conn, "SELECT * FROM zamowienia WHERE status <> 'Dostarczone' AND status <> 'Odebrane' AND status <> 'Anulowane' ORDER BY id DESC");
while($wynik3= mysqli_fetch_assoc($pytanie3))
	{
	$ilosc_zamowien++;
	$id[$ilosc_zamowien]=$wynik3['id'];
	$nr_zamowienia[$ilosc_zamowien]=$wynik3['nr_zamowienia'];
	}

//tabela główna
echo '<table align="left" width="100%" border="0"><tr><td align="left">';
if($page == 'realizacja_produkcji_zamowienia_do_wykonania')
	{
	echo '<FORM action="index.php?page=realizacja_produkcji_zamowienia_do_wykonania" method="post">';
	
	echo '<INPUT type="hidden" name="page" value="'.$page.'">';
	echo '<INPUT type="hidden" name="zlecenie_transportowe" value="'.$zlecenie_transportowe.'">';
	echo '<INPUT type="hidden" name="rodzaj_produktu" value="">';
	echo '<INPUT type="hidden" name="zamowienie_id_akord" value="">';
	echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
	echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';

	echo '<table align="left" cellspacing="5" cellpadding="5" border="0" bgcolor="'.$kolor_tabeli.'"><tr width="800px" align="center" class="text_ogromny"><td>PLAN PRODUKCJI : </td>';
	echo '<td align="center">';
		echo '<select name="zlecenie_transportowe" class="pole_input_produkcja" onchange="submit();">';
		echo '<option></option>';
		if($zlecenie_transportowe == 'DO SPRAWDZENIA') echo '<option selected="selected" value="DO SPRAWDZENIA">DO SPRAWDZENIA</option>';
		else echo '<option value="DO SPRAWDZENIA">DO SPRAWDZENIA</option>';
		if($zlecenie_transportowe == 'WSZYSTKIE') echo '<option selected="selected" value="WSZYSTKIE">WSZYSTKIE</option>';
		else echo '<option value="WSZYSTKIE">WSZYSTKIE</option>';
		for ($a=1; $a<=$ilosc_zlecen_transportowych; $a++) 
		if($zlecenie_transportowe == $nr_zlecenia_transportowego[$a]) echo '<option selected="selected" value="'.$nr_zlecenia_transportowego[$a].'">'.$nr_zlecenia_transportowego[$a].'</option>';
		else echo '<option value="'.$nr_zlecenia_transportowego[$a].'">'.$nr_zlecenia_transportowego[$a].'</option>';
		for ($a=1; $a<=$ilosc_zamowien; $a++) 
		if($zlecenie_transportowe == $nr_zamowienia[$a]) echo '<option selected="selected" value="'.$nr_zamowienia[$a].'">'.$nr_zamowienia[$a].'</option>';
		else echo '<option value="'.$nr_zamowienia[$a].'">'.$nr_zamowienia[$a].'</option>';
		echo '</select>';
	echo '</td><td>';			
	
	$klient_id = [];
	$klient_nazwa = [];
	if($zlecenie_transportowe != '')
		{
		if(preg_match("/ZT/", $zlecenie_transportowe))
			{
			$ilosc_klientow_do_planu_produkcji=0;

			$pytanie35 = mysqli_query($conn, "SELECT DISTINCT klient_nazwa FROM zamowienia WHERE nr_zlecenia_transportowego ='".$zlecenie_transportowe."' ORDER BY klient_nazwa ASC");
			while($wynik35= mysqli_fetch_assoc($pytanie35))
				{
				$ilosc_klientow_do_planu_produkcji++;
				$klient_nazwa[$ilosc_klientow_do_planu_produkcji]=$wynik35['klient_nazwa'];
				// $query = mysqli_query($conn, "SELECT klient_id FROM zamowienia WHERE klient_nazwa = '".$klient_nazwa[$ilosc_klientow_do_planu_produkcji]."'");
				// $klient_id[$ilosc_klientow_do_planu_produkcji] = mysql_result($query, 0, 0);
				$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT klient_id FROM zamowienia WHERE klient_nazwa = '".$klient_nazwa[$ilosc_klientow_do_planu_produkcji]."';"));
				$klient_id[$ilosc_klientow_do_planu_produkcji] = $sql['klient_id'];
				}
			echo '<select name="klienci_do_planu_produkcji" class="pole_input_produkcja" onchange="submit();">';
			echo '<option></option>';
			for ($a=1; $a<=$ilosc_klientow_do_planu_produkcji; $a++) 
			if($klienci_do_planu_produkcji == $klient_id[$a]) echo '<option selected="selected" value="'.$klient_id[$a].'">'.$klient_nazwa[$a].'</option>';
			else echo '<option value="'.$klient_id[$a].'">'.$klient_nazwa[$a].'</option>';
			echo '</select>';
			}
		elseif($zlecenie_transportowe == 'WSZYSTKIE') 
			{
			$ilosc_klientow_do_planu_produkcji=0;
			$pytanie35 = mysqli_query($conn, "SELECT DISTINCT klient_nazwa FROM zamowienia WHERE status <> 'Dostarczone' && status <> 'Anulowane' && status <> 'Odebrane' ORDER BY klient_nazwa ASC");
			while($wynik35= mysqli_fetch_assoc($pytanie35))
				{
				$ilosc_klientow_do_planu_produkcji++;
				$klient_nazwa[$ilosc_klientow_do_planu_produkcji]=$wynik35['klient_nazwa'];
				// $query = mysqli_query($conn, "SELECT klient_id FROM zamowienia WHERE klient_nazwa = '".$klient_nazwa[$ilosc_klientow_do_planu_produkcji]."'");
				// $klient_id[$ilosc_klientow_do_planu_produkcji] = mysql_result($query, 0, 0);
				$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT klient_id FROM zamowienia WHERE klient_nazwa = '".$klient_nazwa[$ilosc_klientow_do_planu_produkcji]."';"));
				$klient_id[$ilosc_klientow_do_planu_produkcji] = $sql['klient_id'];
			}
			echo '<select name="klienci_do_planu_produkcji" class="pole_input_produkcja" onchange="submit();">';
			echo '<option></option>';
			for ($a=1; $a<=$ilosc_klientow_do_planu_produkcji; $a++) 
			if($klienci_do_planu_produkcji == $klient_id[$a]) echo '<option selected="selected" value="'.$klient_id[$a].'">'.$klient_nazwa[$a].'</option>';
			else echo '<option value="'.$klient_id[$a].'">'.$klient_nazwa[$a].'</option>';
			echo '</select>';
			}
		}
	echo '</td>';
		if(($zlecenie_transportowe != '') && ($zlecenie_transportowe != 'DO SPRAWDZENIA')) echo '<td><a href="php/drukuj/drukuj_plan_produkcji2.php?zlecenie_transportowe='.$zlecenie_transportowe.'&klienci_do_planu_produkcji='.$klienci_do_planu_produkcji.'&jak='.$jak.'&wg_czego='.$wg_czego.'" target="_blank">'.$image_printer.'</a></td>';
		if(preg_match("/ZT/", $zlecenie_transportowe)) echo '<td><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&jak=DESC&wg_czego=id&zlecenie_transportowe='.$zlecenie_transportowe.'&klienci_do_planu_produkcji='.$klienci_do_planu_produkcji.'&pokaz_zrealizowane=1"><font color="black" size="+2">ZLECENIA ZREALIZOWANE</font></a></td>';
	echo '</tr></table>';
	echo '</form>';
}

echo '</td></tr><tr><td align="left">';
//echo 'zlec transp='.$zlecenie_transportowe.'<br>';

// $SUMA_ELEMENTOW_DANEGO_TYPU[0] = 0;
// $SUMA_ELEMENTOW_DANEGO_TYPU[1] = 0;
// $SUMA_ELEMENTOW_DANEGO_TYPU[2] = 0;
// $SUMA_ELEMENTOW_DANEGO_TYPU[3] = 0;
// $SUMA_ELEMENTOW_DANEGO_TYPU[4] = 0;
// $SUMA_ELEMENTOW_DANEGO_TYPU[5] = 0;
// $SUMA_ELEMENTOW_DANEGO_TYPU[6] = 0;
// $SUMA_ELEMENTOW_DANEGO_TYPU[7] = 0;
// $SUMA_ELEMENTOW_DANEGO_TYPU[8] = 0;
// $SUMA_ELEMENTOW_DANEGO_TYPU[9] = 0;
// $SUMA_ELEMENTOW_DANEGO_TYPU[10] = 0;
// $SUMA_ELEMENTOW_DANEGO_TYPU[11] = 0;


$zamowienie_id = [];
$suma_rodzaj_produktu_0 = array();
$suma_rodzaj_produktu_1 = array();
$suma_rodzaj_produktu_2 = array();
$suma_rodzaj_produktu_3 = array();
$suma_rodzaj_produktu_4 = array();
$suma_rodzaj_produktu_5 = array();
$suma_rodzaj_produktu_6 = array();
$suma_rodzaj_produktu_7 = array();
$suma_rodzaj_produktu_8 = array();
$suma_rodzaj_produktu_9 = array();
$suma_rodzaj_produktu_10 = array();
$suma_rodzaj_produktu_11 = array();

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
//zerowanie tabcli do 20 - ilość pozycji
// for($z=1; $z<= 20; $z++) {
// 	$SUMA_0_WYKONANE[$z] = 0;
// 	$SUMA_1_WYKONANE[$z] = 0;
// 	$SUMA_2_WYKONANE[$z] = 0;
// 	$SUMA_3_WYKONANE[$z] = 0;
// 	$SUMA_4_WYKONANE[$z] = 0;
// 	$SUMA_5_WYKONANE[$z] = 0;
// 	$SUMA_6_WYKONANE[$z] = 0;
// 	$SUMA_7_WYKONANE[$z] = 0;
// 	$SUMA_8_WYKONANE[$z] = 0;
// 	$SUMA_9_WYKONANE[$z] = 0;
// 	$SUMA_10_WYKONANE[$z] = 0;
// 	$SUMA_11_WYKONANE[$z] = 0;
// 	}

if($zlecenie_transportowe != '')
	{
	$ilosc_zamowien = 0;
	// ################################################################################################################################################################
	// wybrano WSZYSTKIE
	if($zlecenie_transportowe == 'DO SPRAWDZENIA')
		include ("php/planowanie_produkcji_do_sprawdzenia.php");
	elseif($zlecenie_transportowe == 'WSZYSTKIE')
		{
		$WARUNEK2 = '';
		if($klienci_do_planu_produkcji != '') $WARUNEK2 = " AND klient_id = ".$klienci_do_planu_produkcji."";
		$pytanie366 = mysqli_query($conn, "SELECT id, nr_zamowienia FROM zamowienia WHERE status <> 'Dostarczone' AND status <> 'Anulowane' AND status <> 'Odebrane' ".$WARUNEK2." ORDER BY ".$wg_czego." ".$jak.";");
		while($wynik366= mysqli_fetch_assoc($pytanie366))
			{
			$ilosc_zamowien++;
			$zamowienie_id_temp = $wynik366['id'];
			$zamowienie_id[$ilosc_zamowien] = $wynik366['id'];
			$nr_zamowienia[$ilosc_zamowien] = $wynik366['nr_zamowienia'];
				
			$ilosc_pozycji=0;
			$pytanie4 = mysqli_query($conn, "SELECT * FROM wyceny WHERE zamowienie_id = ".$zamowienie_id_temp." AND pozycja_transport = 'nie' ORDER BY pozycja ASC");
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

				$czy_pozycja_w_100_procentach_zrobiona = $do_zrobienia[1] + $do_zrobienia[2] + $do_zrobienia[4] + $do_zrobienia[5] + $do_zrobienia[3] + $do_zrobienia[0] + $do_zrobienia[10] + $do_zrobienia[7] + $do_zrobienia[11];

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
					
					// jezeli wszystkie zgrzewy sa wykonane  - zerujemy luki stalowe, odwodnienia i całą resztę WSZYstkie
					if($suma_rodzaj_produktu_4[$y][$zamowienie_id[$x]] != 0)
						if($do_zrobienia[4] == 0)
							{
							// $do_zrobienia[2] = 0;
							$do_zrobienia[6] = 0;
							// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% poniższe do zakomentowania
							$do_zrobienia[7] = 0;
							$do_zrobienia[8] = 0;
							$do_zrobienia[9] = 0;
							}
					// elseif(($suma_rodzaj_produktu_4[$y][$zamowienie_id[$x]] == 0) && ($suma_rodzaj_produktu_1[$y][$zamowienie_id[$x]] != 0))
						// if($do_zrobienia[1] == 0) $do_zrobienia[2] = 0;
			
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
					else echo '<td align="center">'.$suma_rodzaj_produktu_2[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[2].')</td>';
					
					// if(($suma_rodzaj_produktu_2[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[2] == 0)) echo '<td align="center">&nbsp;</td>';
					// elseif($do_zrobienia[2] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_2[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[2].')</td>';
					// else echo '<td align="center">'.$suma_rodzaj_produktu_2[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[2].')</td>';

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
					
					
					// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
					// if(($suma_rodzaj_produktu_7[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[7] == 0)) echo '<td align="center">&nbsp;</td>';
					// elseif($do_zrobienia[7] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_7[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[7].')</td>';
					// elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&klienci_do_planu_produkcji='.$klienci_do_planu_produkcji.'&jak='.$jak.'&wg_czego='.$wg_czego.'&zamowienie_id_akord='.$zamowienie_id[$x].'&rodzaj_produktu=7"><font size="+1" color="black">'.$suma_rodzaj_produktu_7[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[7].')</font></a></td>';
					// else echo '<td align="center">'.$suma_rodzaj_produktu_7[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[7].')</td>';

					if(($suma_rodzaj_produktu_7[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[7] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[7] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_7[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[7].')</td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu_7[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[7].')</td>';
					

					if(($suma_rodzaj_produktu_11[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[11] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[11] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_11[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[11].')</td>';
					elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&klienci_do_planu_produkcji='.$klienci_do_planu_produkcji.'&jak='.$jak.'&wg_czego='.$wg_czego.'&zamowienie_id_akord='.$zamowienie_id[$x].'&rodzaj_produktu=11"><font size="+1" color="black">'.$suma_rodzaj_produktu_11[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[11].')</font></a></td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu_11[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[11].')</td>';

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

		//wyswietlanie sumy
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
		}

	elseif((preg_match("/ZT/", $zlecenie_transportowe)) || ($zlecenie_transportowe == 'Kurier') || ($zlecenie_transportowe == 'Odbiór własny'))
		{
		// ################################################################################################################################################################
		// 	wybrano zlecenie transportowe
		// jeżeli zamówienia dublują się na liście to może być błąd w zlec tranp treść - np żle wpisane pozycje. albo zamówienie widnieje na dwóch różnych zleceniach transportowych
		// ################################################################################################################################################################
		$WARUNEK2 = '';
		// echo 'zlec transp='.$zlecenie_transportowe.'<br>';
		if($klienci_do_planu_produkcji != '') $WARUNEK2 = " AND klient_id = ".$klienci_do_planu_produkcji."";
		$pytanie66 = mysqli_query($conn, "SELECT DISTINCT zamowienie_id FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego = '".$zlecenie_transportowe."' ".$WARUNEK2." ORDER BY kolejnosc ASC;");
		while($wynik66= mysqli_fetch_assoc($pytanie66))
			{
			$temp_zamowienie_id=$wynik66['zamowienie_id'];
			// echo 'temp_zamowienie_id='.$temp_zamowienie_id.'<br>';
			//sprawdzamy status zamówienia - jak Dostarczone, to nie wyświetlamy na liście.
			$pytanie125 = mysqli_query($conn, "SELECT status FROM zamowienia WHERE id=".$temp_zamowienie_id.";");
			while($wynik125= mysqli_fetch_assoc($pytanie125))
					$temp_status=$wynik125['status'];
				// echo 'status='.$temp_status.'<br>';
			if(($temp_status != 'Dostarczone') && ($temp_status != 'Odebrane') && ($temp_status != 'Anulowane'))
				{
				$ilosc_zamowien++;
				$zamowienie_id_temp = $wynik66['zamowienie_id'];
				$zamowienie_id[$ilosc_zamowien] = $wynik66['zamowienie_id'];
				//    echo 'zam id['.$ilosc_zamowien.']='.$zamowienie_id[$ilosc_zamowien].', ';
				//    echo 'id='.$zamowienie_id_temp.'<br>';
				$ilosc_pozycji=0;
				$pytanie4 = mysqli_query($conn, "SELECT wygiecie_ramy_pvc_ilosc_szt, wygiecie_skrzydla_pvc_ilosc_szt, wygiecie_innego_pvc_ilosc_szt, wygiecie_listwy_pvc_ilosc_szt, wygiecie_wzmocnienia_okiennego_ilosc_szt, wygiecie_innego_ilosc_szt, wygiecie_ramy_alu_ilosc_szt, wygiecie_skrzydla_alu_ilosc_szt, wygiecie_innego_alu_ilosc_szt, zgrzanie_ilosc, wstawienie_slupka_ilosc, wstawienie_slupka_ruchomego_ilosc, wyfrezowanie_odwodnienia_ilosc, listwa_przyszybowa_ilosc, dociecie_kompletu_listew_przyszybowych_ilosc, okucie_ilosc, zaszklenie_ilosc, ilosc_sztuk FROM wyceny WHERE zamowienie_id = ".$zamowienie_id_temp." AND pozycja_transport = 'nie' ORDER BY pozycja ASC;");
				while($wynik4= mysqli_fetch_assoc($pytanie4))
					{
					$ilosc_pozycji++;
					$suma_rodzaj_produktu_1[$ilosc_pozycji][$zamowienie_id_temp] = $wynik4['wygiecie_ramy_pvc_ilosc_szt']+$wynik4['wygiecie_skrzydla_pvc_ilosc_szt']+$wynik4['wygiecie_innego_pvc_ilosc_szt'];
					$wygiecie_listwy_pvc_ilosc_szt=$wynik4['wygiecie_listwy_pvc_ilosc_szt'];
					if(($suma_rodzaj_produktu_1[$ilosc_pozycji][$zamowienie_id_temp] == 0) && ($wygiecie_listwy_pvc_ilosc_szt != 0)) $suma_rodzaj_produktu_1[$ilosc_pozycji][$zamowienie_id_temp] = $wygiecie_listwy_pvc_ilosc_szt;
					
					$wygiecie_wzmocnienia_okiennego_ilosc_szt=$wynik4['wygiecie_wzmocnienia_okiennego_ilosc_szt'];
					$wygiecie_innego_ilosc_szt=$wynik4['wygiecie_innego_ilosc_szt'];
					$suma_rodzaj_produktu_2[$ilosc_pozycji][$zamowienie_id_temp] = $wygiecie_wzmocnienia_okiennego_ilosc_szt+$wygiecie_innego_ilosc_szt;
			
					$wygiecie_ramy_alu_ilosc_szt=$wynik4['wygiecie_ramy_alu_ilosc_szt'];
					$wygiecie_skrzydla_alu_ilosc_szt=$wynik4['wygiecie_skrzydla_alu_ilosc_szt'];
					$wygiecie_innego_alu_ilosc_szt=$wynik4['wygiecie_innego_alu_ilosc_szt'];
					$suma_rodzaj_produktu_3[$ilosc_pozycji][$zamowienie_id_temp] = $wygiecie_ramy_alu_ilosc_szt+$wygiecie_skrzydla_alu_ilosc_szt+$wygiecie_innego_alu_ilosc_szt;
		
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
					//$zamowienie_id[$ilosc_zamowien]=$wynik['zamowienie_id'];
					//$temp = $wynik['zamowienie_id'];
					$rodzaj_produktu=$wynik['rodzaj_produktu'];
					$ilosc=$wynik['ilosc'];
					$pozycja=$wynik['pozycja'];
					if($pozycja != 'on') // on to całe zamówienie
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
							if($rodzaj_produktu == 0) {
								$SUMA_0_WYKONANE[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_0[$x][$zamowienie_id_temp];
							}
							if($rodzaj_produktu == 10) $SUMA_10_WYKONANE[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_10[$x][$zamowienie_id_temp];
							if($rodzaj_produktu == 11) $SUMA_11_WYKONANE[$x][$zamowienie_id_temp] = $suma_rodzaj_produktu_11[$x][$zamowienie_id_temp];
							} // do for ($x=1; $x<=$ilosc_pozycji_zamowienia[$zamowienie_id_temp]; $x++)
					} // do while($wynik= mysqli_fetch_assoc($pytanie))
				} // do if($temp_status != 'Dostarczone')
			
			} // while($wynik66= mysqli_fetch_assoc($pytanie66))
			
			$SUMA_DO_ZROBIENIA2[1]=0;
			$SUMA_DO_ZROBIENIA2[2]=0;
			$SUMA_DO_ZROBIENIA2[3]=0;
			$SUMA_DO_ZROBIENIA2[4]=0;
			$SUMA_DO_ZROBIENIA2[5]=0;
			$SUMA_DO_ZROBIENIA2[6]=0;
			$SUMA_DO_ZROBIENIA2[7]=0;
			$SUMA_DO_ZROBIENIA2[8]=0;
			$SUMA_DO_ZROBIENIA2[9]=0;
			$SUMA_DO_ZROBIENIA2[0]=0;
			$SUMA_DO_ZROBIENIA2[10]=0;
			$SUMA_DO_ZROBIENIA2[11]=0;

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
		
		for ($x=0; $x<=$dl_lista_produktow; $x++) 
			{
			$SUMA_ELEMENTOW_DANEGO_TYPU_test[$x] = 0;
			$SUMA_DO_ZROBIENIA2_test[$x] = 0;
			}
			
		echo '</tr>';
	for ($x=1; $x<=$ilosc_zamowien; $x++)
		{
		$pytanie77 = mysqli_query($conn, "SELECT nr_zamowienia, klient_nazwa FROM zamowienia WHERE id = ".$zamowienie_id[$x].";");
		while($wynik77= mysqli_fetch_assoc($pytanie77))
			{
			$klient_nazwa[$x]=$wynik77['klient_nazwa'];
			$nr_zamowienia[$x]=$wynik77['nr_zamowienia'];
			}	
		if($zamowienie_id[$x] != 0)
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

			$czy_pozycja_w_100_procentach_zrobiona = $do_zrobienia[1] + $do_zrobienia[2] + $do_zrobienia[4] + $do_zrobienia[5] + $do_zrobienia[3] + $do_zrobienia[0] + $do_zrobienia[10] + $do_zrobienia[11]; //%%%%%%%%%%%%%%%%%%%%%% $do_zrobienia[7]
			// echo '$czy_pozycja_w_100_procentach_zrobiona='.$czy_pozycja_w_100_procentach_zrobiona.'<br>';
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
				
				// jezeli wszystkie zgrzewy sa wykonane  - zerujemy luki stalowe, odwodnienia i całą reszt zlec tranp
				if($suma_rodzaj_produktu_4[$y][$zamowienie_id[$x]] != 0)
					if($do_zrobienia[4] == 0)
						{
						// $do_zrobienia[2] = 0;
						$do_zrobienia[6] = 0;
						// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% poniższe do zakomentowania
						$do_zrobienia[7] = 0;
						$do_zrobienia[8] = 0;
						$do_zrobienia[9] = 0;
						}
				// elseif(($suma_rodzaj_produktu_4[$y][$zamowienie_id[$x]] == 0) && ($suma_rodzaj_produktu_1[$y][$zamowienie_id[$x]] != 0))
					// if($do_zrobienia[1] == 0) $do_zrobienia[2] = 0;

				// sprawdzamy czy dana pozycja jest zaznaczona w zleceniu tranpsortowym
				$pytanie646 = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_tresc WHERE zamowienie_id = ".$zamowienie_id[$x]." AND nr_zlecenia_transportowego = '".$zlecenie_transportowe."' AND pozycja_wyceny = ".$y.";");
				while($wynik646= mysqli_fetch_assoc($pytanie646))
					{
					// echo 'zamowienie_id['.$x.']='.$zamowienie_id[$x].', ';
					// echo 'y='.$y.'<br>';
					echo '<tr align="center" class="text_duzy" bgcolor="'.$kolor_bialy.'" height="40px">';
					echo '<td class="'.$text_zmienny.'">'.$nr_zamowienia[$x].'&nbsp;&nbsp;&nbsp;'.$y.'/'.$ilosc_pozycji_zamowienia[$zamowienie_id[$x]].'</td>';
					echo '<td class="'.$text_zmienny.'">'.$klient_nazwa[$x].'</td>';
					
					if(($suma_rodzaj_produktu_0[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[0] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[0] == 0) 
						{
						echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_0[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[0].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[0] += $suma_rodzaj_produktu_0[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[0] += $do_zrobienia[0];
						}
					elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') 
						{
						echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&klienci_do_planu_produkcji='.$klienci_do_planu_produkcji.'&jak='.$jak.'&wg_czego='.$wg_czego.'&zamowienie_id_akord='.$zamowienie_id[$x].'&rodzaj_produktu=0"><font size="+1" color="black">'.$suma_rodzaj_produktu_0[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[0].')</font></a></td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[0] += $suma_rodzaj_produktu_0[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[0] += $do_zrobienia[0];
						}
					else 
						{
						echo '<td align="center">'.$suma_rodzaj_produktu_0[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[0].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[0] += $suma_rodzaj_produktu_0[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[0] += $do_zrobienia[0];
						}

					if(($suma_rodzaj_produktu_1[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[1] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[1] == 0) 
						{
						echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_1[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[1].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[1] += $suma_rodzaj_produktu_1[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[1] += $do_zrobienia[1];
						}
					elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') 
						{
						echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&klienci_do_planu_produkcji='.$klienci_do_planu_produkcji.'&jak='.$jak.'&wg_czego='.$wg_czego.'&zamowienie_id_akord='.$zamowienie_id[$x].'&rodzaj_produktu=1"><font size="+1" color="black">'.$suma_rodzaj_produktu_1[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[1].')</font></a></td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[1] += $suma_rodzaj_produktu_1[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[1] += $do_zrobienia[1];
						}
					else 
						{
						echo '<td align="center">'.$suma_rodzaj_produktu_1[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[1].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[1] += $suma_rodzaj_produktu_1[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[1] += $do_zrobienia[1];
						}
					

					if(($suma_rodzaj_produktu_2[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[2] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[2] == 0) 
						{
						echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_2[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[2].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[2] += $suma_rodzaj_produktu_2[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[2] += $do_zrobienia[2];
						}
					elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') 
						{
						echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&klienci_do_planu_produkcji='.$klienci_do_planu_produkcji.'&jak='.$jak.'&wg_czego='.$wg_czego.'&zamowienie_id_akord='.$zamowienie_id[$x].'&rodzaj_produktu=2"><font size="+1" color="black">'.$suma_rodzaj_produktu_2[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[2].')</font></a></td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[2] += $suma_rodzaj_produktu_2[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[2] += $do_zrobienia[2];
						}
					else 
						{
						echo '<td align="center">'.$suma_rodzaj_produktu_2[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[2].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[2] += $suma_rodzaj_produktu_2[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[2] += $do_zrobienia[2];
						}
	



					if(($suma_rodzaj_produktu_3[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[3] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[3] == 0) 
						{
						echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_3[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[3].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[3] += $suma_rodzaj_produktu_3[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[3] += $do_zrobienia[3];
						}
					elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') 
						{
						echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&klienci_do_planu_produkcji='.$klienci_do_planu_produkcji.'&jak='.$jak.'&wg_czego='.$wg_czego.'&zamowienie_id_akord='.$zamowienie_id[$x].'&rodzaj_produktu=3"><font size="+1" color="black">'.$suma_rodzaj_produktu_3[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[3].')</font></a></td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[3] += $suma_rodzaj_produktu_3[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[3] += $do_zrobienia[3];
						}
					else 
						{
						echo '<td align="center">'.$suma_rodzaj_produktu_3[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[3].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[3] += $suma_rodzaj_produktu_3[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[3] += $do_zrobienia[3];
						}
					
					if(($suma_rodzaj_produktu_4[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[4] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[4] == 0) 
						{
						echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_4[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[4].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[4] += $suma_rodzaj_produktu_4[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[4] += $do_zrobienia[4];
						}
					elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') 
						{
						echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&klienci_do_planu_produkcji='.$klienci_do_planu_produkcji.'&jak='.$jak.'&wg_czego='.$wg_czego.'&zamowienie_id_akord='.$zamowienie_id[$x].'&rodzaj_produktu=4"><font size="+1" color="black">'.$suma_rodzaj_produktu_4[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[4].')</font></a></td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[4] += $suma_rodzaj_produktu_4[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[4] += $do_zrobienia[4];
						}
					else 
						{
						echo '<td align="center">'.$suma_rodzaj_produktu_4[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[4].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[4] += $suma_rodzaj_produktu_4[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[4] += $do_zrobienia[4];
						}
					
					if(($suma_rodzaj_produktu_5[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[5] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[5] == 0) 
						{
						echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_5[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[5].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[5] += $suma_rodzaj_produktu_5[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[5] += $do_zrobienia[5];
						}
					elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') 
						{
						echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&klienci_do_planu_produkcji='.$klienci_do_planu_produkcji.'&jak='.$jak.'&wg_czego='.$wg_czego.'&zamowienie_id_akord='.$zamowienie_id[$x].'&rodzaj_produktu=5"><font size="+1" color="black">'.$suma_rodzaj_produktu_5[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[5].')</font></a></td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[5] += $suma_rodzaj_produktu_5[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[5] += $do_zrobienia[5];
						}
					else 
						{
						echo '<td align="center">'.$suma_rodzaj_produktu_5[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[5].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[5] += $suma_rodzaj_produktu_5[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[5] += $do_zrobienia[5];
						}
					
					if(($suma_rodzaj_produktu_6[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[6] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[6] == 0) 
						{
						echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_6[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[6].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[6] += $suma_rodzaj_produktu_6[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[6] += $do_zrobienia[6];
						}
					else 
						{
						echo '<td align="center">'.$suma_rodzaj_produktu_6[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[6].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[6] += $suma_rodzaj_produktu_6[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[6] += $do_zrobienia[6];
						}
	
					if(($suma_rodzaj_produktu_7[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[7] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[7] == 0) 
						{
						echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_7[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[7].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[7] += $suma_rodzaj_produktu_7[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[7] += $do_zrobienia[7];
						}
					elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') 
						{
						// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% poniższe do odkomentowania
						// echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&klienci_do_planu_produkcji='.$klienci_do_planu_produkcji.'&jak='.$jak.'&wg_czego='.$wg_czego.'&zamowienie_id_akord='.$zamowienie_id[$x].'&rodzaj_produktu=7"><font size="+1" color="black">'.$suma_rodzaj_produktu_7[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[7].')</font></a></td>';
						echo '<td align="center">'.$suma_rodzaj_produktu_7[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[7].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[7] += $suma_rodzaj_produktu_7[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[7] += $do_zrobienia[7];
						}
					else 
						{
						echo '<td align="center">'.$suma_rodzaj_produktu_7[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[7].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[7] += $suma_rodzaj_produktu_7[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[7] += $do_zrobienia[7];
						}

					if(($suma_rodzaj_produktu_11[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[11] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[11] == 0) 
						{
						echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_11[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[11].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[11] += $suma_rodzaj_produktu_11[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[11] += $do_zrobienia[11];
						}
					elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') 
						{
						echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&klienci_do_planu_produkcji='.$klienci_do_planu_produkcji.'&jak='.$jak.'&wg_czego='.$wg_czego.'&zamowienie_id_akord='.$zamowienie_id[$x].'&rodzaj_produktu=11"><font size="+1" color="black">'.$suma_rodzaj_produktu_11[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[11].')</font></a></td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[11] += $suma_rodzaj_produktu_11[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[11] += $do_zrobienia[11];
						}
					else 
						{
						echo '<td align="center">'.$suma_rodzaj_produktu_11[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[11].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[11] += $suma_rodzaj_produktu_11[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[11] += $do_zrobienia[11];
						}

						
					if(($suma_rodzaj_produktu_8[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[8] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[8] == 0) 
						{
						echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_8[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[8].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[8] += $suma_rodzaj_produktu_8[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[8] += $do_zrobienia[8];
						}
					else 
						{
						echo '<td align="center">'.$suma_rodzaj_produktu_8[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[8].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[8] += $suma_rodzaj_produktu_8[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[8] += $do_zrobienia[8];
						}
					
					if(($suma_rodzaj_produktu_9[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[9] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[9] == 0) 
						{
						echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_9[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[9].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[9] += $suma_rodzaj_produktu_9[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[9] += $do_zrobienia[9];
						}
					else 
						{
						echo '<td align="center">'.$suma_rodzaj_produktu_9[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[9].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[9] += $suma_rodzaj_produktu_9[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[9] += $do_zrobienia[9];
						}
					
					if(($suma_rodzaj_produktu_10[$y][$zamowienie_id[$x]] == 0) && ($do_zrobienia[10] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[10] == 0) 
						{
						echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu_10[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[10].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[10] += $suma_rodzaj_produktu_10[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[10] += $do_zrobienia[10];
						}
					elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') 
						{
						echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&klienci_do_planu_produkcji='.$klienci_do_planu_produkcji.'&jak='.$jak.'&wg_czego='.$wg_czego.'&zamowienie_id_akord='.$zamowienie_id[$x].'&rodzaj_produktu=10"><font size="+1" color="black">'.$suma_rodzaj_produktu_10[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[10].')</font></a></td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[10] += $suma_rodzaj_produktu_10[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[10] += $do_zrobienia[10];
						}
					else 
						{
						echo '<td align="center">'.$suma_rodzaj_produktu_10[$y][$zamowienie_id[$x]].' ('.$do_zrobienia[10].')</td>';
						$SUMA_ELEMENTOW_DANEGO_TYPU_test[10] += $suma_rodzaj_produktu_10[$y][$zamowienie_id[$x]];
						$SUMA_DO_ZROBIENIA2_test[10] += $do_zrobienia[10];
						}

					echo '</tr>';
					}
		
				} // do if($czy_pozycja_w_100_procentach_zrobiona != 0)
			} // do for ($y=1; $y<=$ilosc_pozycji_zamowienia[$zamowienie_id[$x]]; $y++)
			
		} // do for ($x=1; $x<=$ilosc_zamowien; $x++)
		echo '<tr align="center" class="text_duzy" bgcolor="'.$kolor_tabeli.'">';
		echo '<td align="right" colspan="2">SUMA >>> </td>';

		//wystietlanie sumy
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_test[0].'&nbsp;('.$SUMA_DO_ZROBIENIA2_test[0].')</td>';
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_test[1].'&nbsp;('.$SUMA_DO_ZROBIENIA2_test[1].')</td>';
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_test[2].'&nbsp;('.$SUMA_DO_ZROBIENIA2_test[2].')</td>';
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_test[3].'&nbsp;('.$SUMA_DO_ZROBIENIA2_test[3].')</td>';
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_test[4].'&nbsp;('.$SUMA_DO_ZROBIENIA2_test[4].')</td>';
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_test[5].'&nbsp;('.$SUMA_DO_ZROBIENIA2_test[5].')</td>';
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_test[6].'&nbsp;('.$SUMA_DO_ZROBIENIA2_test[6].')</td>';
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_test[7].'&nbsp;('.$SUMA_DO_ZROBIENIA2_test[7].')</td>';
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_test[11].'&nbsp;('.$SUMA_DO_ZROBIENIA2_test[11].')</td>';
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_test[8].'&nbsp;('.$SUMA_DO_ZROBIENIA2_test[8].')</td>';
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_test[9].'&nbsp;('.$SUMA_DO_ZROBIENIA2_test[9].')</td>';
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU_test[10].'&nbsp;('.$SUMA_DO_ZROBIENIA2_test[10].')</td>';

		echo '</tr></table>';

		} // if(preg_match("/ZT/", $zlecenie_transportowe))
	else
		{
		// ################################################################################################################################################################
		// wybrano zamówienie
		$SUMA_ELEMENTOW_DANEGO_TYPU[1] = 0;
		$SUMA_ELEMENTOW_DANEGO_TYPU[2] = 0;
		$SUMA_ELEMENTOW_DANEGO_TYPU[3] = 0;
		$SUMA_ELEMENTOW_DANEGO_TYPU[4] = 0;
		$SUMA_ELEMENTOW_DANEGO_TYPU[5] = 0;
		$SUMA_ELEMENTOW_DANEGO_TYPU[6] = 0;
		$SUMA_ELEMENTOW_DANEGO_TYPU[7] = 0;
		$SUMA_ELEMENTOW_DANEGO_TYPU[8] = 0;
		$SUMA_ELEMENTOW_DANEGO_TYPU[9] = 0;
		$SUMA_ELEMENTOW_DANEGO_TYPU[0] = 0;
		$SUMA_ELEMENTOW_DANEGO_TYPU[10] = 0;
		$SUMA_ELEMENTOW_DANEGO_TYPU[11] = 0;
		
		// mamy doczynienia z zamowieniem!! nie ze zleceniem transportowym
		//echo 'spr zamowienie<br>';
		$ilosc_zamowien = 1;
		$WARUNEK = ' zamowienia = "'.$zlecenie_transportowe.'" ';
		
		$pytanie4 = mysqli_query($conn, "SELECT id, klient_nazwa FROM zamowienia WHERE nr_zamowienia = '".$zlecenie_transportowe."' LIMIT 1;");
		while($wynik4= mysqli_fetch_assoc($pytanie4))
			{
			$zamowienie_id=$wynik4['id'];
			$klient_nazwa=$wynik4['klient_nazwa'];
			}		
		$ilosc_pozycji=0;
		$pytanie4 = mysqli_query($conn, "SELECT * FROM wyceny WHERE nr_zamowienia = '".$zlecenie_transportowe."' AND pozycja_transport = 'nie' ORDER BY pozycja ASC;");
		while($wynik4= mysqli_fetch_assoc($pytanie4))
			{
			$ilosc_pozycji++;
			$suma_rodzaj_produktu[1][$ilosc_pozycji] = $wynik4['wygiecie_ramy_pvc_ilosc_szt']+$wynik4['wygiecie_skrzydla_pvc_ilosc_szt']+$wynik4['wygiecie_innego_pvc_ilosc_szt'];
				$wygiecie_listwy_pvc_ilosc_szt=$wynik4['wygiecie_listwy_pvc_ilosc_szt'];
				if(($suma_rodzaj_produktu[1][$ilosc_pozycji] == 0) && ($wygiecie_listwy_pvc_ilosc_szt != 0)) $suma_rodzaj_produktu[1][$ilosc_pozycji] = $wygiecie_listwy_pvc_ilosc_szt;

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
			$suma_rodzaj_produktu[5][$ilosc_pozycji]=$wynik4['wstawienie_slupka_ilosc']+$wynik4['wstawienie_slupka_ruchomego_ilosc'];
			$suma_rodzaj_produktu[6][$ilosc_pozycji]=$wynik4['wyfrezowanie_odwodnienia_ilosc'];
			$suma_rodzaj_produktu[7][$ilosc_pozycji]=$wynik4['listwa_przyszybowa_ilosc'];
			$suma_rodzaj_produktu[11][$ilosc_pozycji]=$wynik4['dociecie_kompletu_listew_przyszybowych_ilosc'];
			$suma_rodzaj_produktu[8][$ilosc_pozycji]=$wynik4['okucie_ilosc'];
			$suma_rodzaj_produktu[9][$ilosc_pozycji]=$wynik4['zaszklenie_ilosc'];

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
		
		$pytanie = mysqli_query($conn, "SELECT * FROM realizacja_produkcji WHERE zamowienie_id=".$zamowienie_id.";");
		while($wynik= mysqli_fetch_assoc($pytanie))
			{
			//$zamowienie_id[$ilosc_zamowien]=$wynik['zamowienie_id'];
			//$temp = $wynik['zamowienie_id'];
			$rodzaj_produktu=$wynik['rodzaj_produktu'];
			$ilosc=$wynik['ilosc'];
			$pozycja=$wynik['pozycja'];
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
			
// echo 'WARUNEK='.$WARUNEK.'<br>';
//echo 'ilosc zamowien='.$ilosc_zamowien.'<br>';
///echo 'ilosc_pozycji='.$ilosc_pozycji.'<br>';
	
//echo '$SUMA_2_WYKONANE[$x]='.$SUMA_2_WYKONANE[$x].'<br>';

		echo '<table width="100%" align="left" class="tabela"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
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
			//deklaracja i zerowanie zmiennych
			$do_zrobienia = [];
			$SUMA_DO_ZROBIENIA = [];
				for ($z=0; $z<=11; $z++) {
					$do_zrobienia[$z] = 0;
					$SUMA_DO_ZROBIENIA[$z] = 0;
				}
			
			for ($y=1; $y<=$ilosc_pozycji; $y++)
				{
				//sprawdzamy czy ktoras z pozycji juz jest w 100% wykonana
				$czy_pozycja_w_100_procentach_zrobiona = 0;
				$do_zrobienia[1] = $suma_rodzaj_produktu[1][$y]-$SUMA_1_WYKONANE[$y];
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

				
				//for ($z=1; $z<=$dl_lista_produktow; $z++) $czy_pozycja_w_100_procentach_zrobiona += $do_zrobienia[$z];
				$czy_pozycja_w_100_procentach_zrobiona = $do_zrobienia[0] + $do_zrobienia[1] + $do_zrobienia[2] + $do_zrobienia[3] + $do_zrobienia[4] + $do_zrobienia[5] + $do_zrobienia[10] + $do_zrobienia[7] + $do_zrobienia[11];
				
				if($czy_pozycja_w_100_procentach_zrobiona != 0)
					{
					// jezeli wszystkie zgrzewy sa wykonane  - zerujemy luki stalowe, odwodnienia i ca reszt zlec tranp
					if($suma_rodzaj_produktu[4][$y] != 0)
						{
						if($do_zrobienia[4] == 0)
							{
							// $do_zrobienia[2] = 0;
							$do_zrobienia[6] = 0;
							// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% poniższe do zakomentowania
							$do_zrobienia[7] = 0;
							$do_zrobienia[8] = 0;
							$do_zrobienia[9] = 0;
							}
						}
					// if(($suma_rodzaj_produktu[4][$y] == 0) && ($suma_rodzaj_produktu[1][$y] != 0))
						// if($do_zrobienia[1] == 0) $do_zrobienia[2] = 0;
						
					echo '<tr align="center" class="text_duzy" bgcolor="'.$kolor_bialy.'" height="40px">';
					echo '<td class="'.$text_zmienny.'">'.$zlecenie_transportowe.'&nbsp;&nbsp;&nbsp;'.$y.'/'.$ilosc_pozycji.'</td>';
					echo '<td class="'.$text_zmienny.'">'.$klient_nazwa.'</td>';
					
					if(($suma_rodzaj_produktu[0][$y] == 0) && ($do_zrobienia[0] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[0] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu[0][$y].' ('.$do_zrobienia[0].')</td>';
					elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&zamowienie_id_akord='.$zamowienie_id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&rodzaj_produktu=0"><font size="+1" color="black">'.$suma_rodzaj_produktu[0][$y].' ('.$do_zrobienia[0].')</font></a></td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu[0][$y].' ('.$do_zrobienia[0].')</td>';

					if(($suma_rodzaj_produktu[1][$y] == 0) && ($do_zrobienia[1] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[1] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu[1][$y].' ('.$do_zrobienia[1].')</td>';
					elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&zamowienie_id_akord='.$zamowienie_id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&rodzaj_produktu=1"><font size="+1" color="black">'.$suma_rodzaj_produktu[1][$y].' ('.$do_zrobienia[1].')</font></a></td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu[1][$y].' ('.$do_zrobienia[1].')</td>';
		
					if(($suma_rodzaj_produktu[2][$y] == 0) && ($do_zrobienia[2] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[2] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu[2][$y].' ('.$do_zrobienia[2].')</td>';
					elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&zamowienie_id_akord='.$zamowienie_id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&rodzaj_produktu=2"><font size="+1" color="black">'.$suma_rodzaj_produktu[2][$y].' ('.$do_zrobienia[2].')</font></a></td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu[2][$y].' ('.$do_zrobienia[2].')</td>';
					
					if(($suma_rodzaj_produktu[3][$y] == 0) && ($do_zrobienia[3] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[3] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu[3][$y].' ('.$do_zrobienia[3].')</td>';
					elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&zamowienie_id_akord='.$zamowienie_id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&rodzaj_produktu=3"><font size="+1" color="black">'.$suma_rodzaj_produktu[3][$y].' ('.$do_zrobienia[3].')</font></a></td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu[3][$y].' ('.$do_zrobienia[3].')</td>';
				
					
					/*
					if(($suma_rodzaj_produktu[3][$y] == 0) && ($do_zrobienia[3] == 0)) echo '<td align="center">&nbsp;</td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu[3][$y].' ('.$do_zrobienia[3].')</td>';
					*/
					if(($suma_rodzaj_produktu[4][$y] == 0) && ($do_zrobienia[4] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[4] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu[4][$y].' ('.$do_zrobienia[4].')</td>';
					elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&zamowienie_id_akord='.$zamowienie_id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&rodzaj_produktu=4"><font size="+1" color="black">'.$suma_rodzaj_produktu[4][$y].' ('.$do_zrobienia[4].')</font></a></td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu[4][$y].' ('.$do_zrobienia[4].')</td>';
					
					if(($suma_rodzaj_produktu[5][$y] == 0) && ($do_zrobienia[5] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[5] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu[5][$y].' ('.$do_zrobienia[5].')</td>';
					elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&zamowienie_id_akord='.$zamowienie_id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&rodzaj_produktu=5"><font size="+1" color="black">'.$suma_rodzaj_produktu[5][$y].' ('.$do_zrobienia[5].')</font></a></td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu[5][$y].' ('.$do_zrobienia[5].')</td>';
					
					if(($suma_rodzaj_produktu[6][$y] == 0) && ($do_zrobienia[6] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[6] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu[6][$y].' ('.$do_zrobienia[6].')</td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu[6][$y].' ('.$do_zrobienia[6].')</td>';

					if(($suma_rodzaj_produktu[7][$y] == 0) && ($do_zrobienia[7] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[7] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu[7][$y].' ('.$do_zrobienia[7].')</td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu[7][$y].' ('.$do_zrobienia[7].')</td>';
					
					
					// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% poniższe do odkomentowania
					// if(($suma_rodzaj_produktu[7][$y] == 0) && ($do_zrobienia[7] == 0)) echo '<td align="center">&nbsp;</td>';
					// elseif($do_zrobienia[7] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu[7][$y].' ('.$do_zrobienia[7].')</td>';
					// elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&zamowienie_id_akord='.$zamowienie_id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&rodzaj_produktu=7"><font size="+1" color="black">'.$suma_rodzaj_produktu[7][$y].' ('.$do_zrobienia[7].')</font></a></td>';
					// else echo '<td align="center">'.$suma_rodzaj_produktu[7][$y].' ('.$do_zrobienia[7].')</td>';

					if(($suma_rodzaj_produktu[11][$y] == 0) && ($do_zrobienia[11] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[11] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu[11][$y].' ('.$do_zrobienia[11].')</td>';
					elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&zamowienie_id_akord='.$zamowienie_id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&rodzaj_produktu=11"><font size="+1" color="black">'.$suma_rodzaj_produktu[11][$y].' ('.$do_zrobienia[11].')</font></a></td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu[11][$y].' ('.$do_zrobienia[11].')</td>';
					
					if(($suma_rodzaj_produktu[8][$y] == 0) && ($do_zrobienia[8] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[8] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu[8][$y].' ('.$do_zrobienia[8].')</td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu[8][$y].' ('.$do_zrobienia[8].')</td>';
					
					if(($suma_rodzaj_produktu[9][$y] == 0) && ($do_zrobienia[9] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[9] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu[9][$y].' ('.$do_zrobienia[9].')</td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu[9][$y].' ('.$do_zrobienia[9].')</td>';
	
					if(($suma_rodzaj_produktu[10][$y] == 0) && ($do_zrobienia[10] == 0)) echo '<td align="center">&nbsp;</td>';
					elseif($do_zrobienia[10] == 0) echo '<td align="center" bgcolor="'.$kolor_ciemno_szary.'">'.$suma_rodzaj_produktu[10][$y].' ('.$do_zrobienia[10].')</td>';
					elseif($page == 'realizacja_produkcji_zamowienia_do_wykonania') echo '<td align="center"><a href="index.php?page=realizacja_produkcji_zamowienia_do_wykonania&zlecenie_transportowe='.$zlecenie_transportowe.'&zamowienie_id_akord='.$zamowienie_id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&rodzaj_produktu=10"><font size="+1" color="black">'.$suma_rodzaj_produktu[10][$y].' ('.$do_zrobienia[10].')</font></a></td>';
					else echo '<td align="center">'.$suma_rodzaj_produktu[10][$y].' ('.$do_zrobienia[10].')</td>';
	
					echo '</tr>';
					} // do if($czy_pozycja_w_100_procentach_zrobiona != 0)
			} // do for ($x=1; $x<=$ilosc_pozycji; $x++)
		echo '<tr align="center" class="text_duzy" bgcolor="'.$kolor_tabeli.'">';
		echo '<td align="right" colspan="2">SUMA >>> </td>';
		//wyswietlenie sumy
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[0].'&nbsp;('.$SUMA_DO_ZROBIENIA[0].')</td>';
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[1].'&nbsp;('.$SUMA_DO_ZROBIENIA[1].')</td>';
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[2].'&nbsp;('.$SUMA_DO_ZROBIENIA[2].')</td>';
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[3].'&nbsp;('.$SUMA_DO_ZROBIENIA[3].')</td>';
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[4].'&nbsp;('.$SUMA_DO_ZROBIENIA[4].')</td>';
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[5].'&nbsp;('.$SUMA_DO_ZROBIENIA[5].')</td>';
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[6].'&nbsp;('.$SUMA_DO_ZROBIENIA[6].')</td>';
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[7].'&nbsp;('.$SUMA_DO_ZROBIENIA[7].')</td>';
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[11].'&nbsp;('.$SUMA_DO_ZROBIENIA[11].')</td>';
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[8].'&nbsp;('.$SUMA_DO_ZROBIENIA[8].')</td>';
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[9].'&nbsp;('.$SUMA_DO_ZROBIENIA[9].')</td>';
		echo '<td>'.$SUMA_ELEMENTOW_DANEGO_TYPU[10].'&nbsp;('.$SUMA_DO_ZROBIENIA[10].')</td>';
		echo '</tr></table>';
		} // do else
	
} // do if zlecenie_transportowe != ''

if($pokaz_zrealizowane == 1) 
	{
	echo '</td></tr><tr><td>';
	include("php/planowanie_produkcji_zrealizowane.php");
	
	}

echo '</td></tr></table>';
?>