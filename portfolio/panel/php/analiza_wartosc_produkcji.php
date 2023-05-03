<?php
echo '<FORM name="szukaj">';
echo '<input type="hidden" name="page" value="'.$page.'">';

	echo '<table valign="top" align="center" border="0" cellspacing="3" cellpadding="3" class="text" BORDERCOLOR="black" frame="box" RULES="all">';
	echo '<tr align="center" bgcolor="'.$kolor_tabeli.'"><td width="100%">';
		echo 'Wybierz rok : ';
		echo '<select name="SPRAWDZANY_ROK" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
		if($SPRAWDZANY_ROK == "") $SPRAWDZANY_ROK = $AKTUALNY_ROK;
		for($x= 1; $x<= $DLUGOSC_TABELA_LISTA_LAT_WYCENA_DANE; $x++) 
			{
			if ($TABELA_LISTA_LAT_WYCENA_DANE[$x] == $SPRAWDZANY_ROK) echo '<option value="'.$TABELA_LISTA_LAT_WYCENA_DANE[$x].'" selected="selected">'.$TABELA_LISTA_LAT_WYCENA_DANE[$x].'</option>';
			else echo '<option value="'.$TABELA_LISTA_LAT_WYCENA_DANE[$x].'">'.$TABELA_LISTA_LAT_WYCENA_DANE[$x].'</option>';
			}
		echo '</select>';
	echo '</td></tr></table><br>';

	//include("php/wartosc_produkcji_oblicz.php");

	//############################################# tabela glowna ##########################################################################################################################################################
	
	//$i= 0;
	$SUMA = array();
	// $SUMA_SUM = 0;
	$SUMA_DZIEN = [];
	$SUMA_MIESIAC = [];
	$SREDNIA_MIESIAC = [];

	$SUMA_wartosc_profili = [];
	// $SUMA_SUM_wartosc_profili = 0;
	$SUMA_DZIEN_wartosc_profili = [];
	$SUMA_MIESIAC_wartosc_profili = [];
	$SREDNIA_MIESIAC_wartosc_profili = [];
	$SREDNIA_MIESIAC2_wartosc_profili = [];


	$SUMA_alu = [];
	// $SUMA_SUM_alu = 0;
	$SUMA_DZIEN_alu = [];
	$SUMA_MIESIAC_alu = [];
	$SREDNIA_MIESIAC_alu = [];
	$SREDNIA_MIESIAC2_alu = [];


	for($d=1; $d<=31; $d++)
		for($m=1; $m<=12; $m++) {
			$SUMA[$d][$m] = 0;
			$SUMA_alu[$d][$m] = 0;
		}
		
	for($d=1; $d<=31; $d++) {
		$SUMA_DZIEN[$d] = 0;
		$SUMA_DZIEN_wartosc_profili[$d] = 0;
		$SUMA_DZIEN_alu[$d] = 0;


	}
	for($m=1; $m<=12; $m++) {
		$SUMA_MIESIAC[$m] = 0;
		$SUMA_MIESIAC_wartosc_profili[$m] = 0;
		$SUMA_MIESIAC_alu[$m] = 0;

	}
	for($m=1; $m<=12; $m++) {
		$SREDNIA_MIESIAC[$m] = 0;
		$SREDNIA_MIESIAC_wartosc_profili[$m] = 0;
		$SREDNIA_MIESIAC_alu[$m] = 0;

	}
	
	$licz = 0;
	$pytanie5 = mysqli_query($conn, "SELECT * FROM realizacja_produkcji where data_wykonania_rok = '".$SPRAWDZANY_ROK."';");
	while($wynik5= mysqli_fetch_assoc($pytanie5))
		{
		$licz++;
		$temp_dz = $wynik5['data_wykonania_dzien'];
		$temp_mies = $wynik5['data_wykonania_miesiac'];
		$rodzaj_produktu = $wynik5['rodzaj_produktu'];

		if($rodzaj_produktu == 3)
		{
			//jak rodzaj produktu to ALU
			$SUMA_alu[$temp_dz][$temp_mies] += $wynik5['wartosc_realizacji'];
			$SUMA_DZIEN_alu[$temp_dz] += $wynik5['wartosc_realizacji'];
			$SUMA_MIESIAC_alu[$temp_mies] += $wynik5['wartosc_realizacji'];

		}
		else
		{
			// Jak każdy inny rodzaj produktu
			$SUMA[$temp_dz][$temp_mies] += $wynik5['wartosc_realizacji'];
			// $SUMA_SUM += $wynik5['wartosc_realizacji'];
			$SUMA_DZIEN[$temp_dz] += $wynik5['wartosc_realizacji'];
			$SUMA_MIESIAC[$temp_mies] += $wynik5['wartosc_realizacji'];
	
			
		}

		//liczymy dla wartości profili
		$SUMA_wartosc_profili[$temp_dz][$temp_mies] += $wynik5['wartosc_profili'];
		$SUMA_DZIEN_wartosc_profili[$temp_dz] += $wynik5['wartosc_profili'];
		$SUMA_MIESIAC_wartosc_profili[$temp_mies] += $wynik5['wartosc_profili'];
		}	
	
	$kolor_dzis = 'yellow';
	$kolor_miesiac = 'lightgreen';
	$dzisiaj = date('j', $time);
	$miesiac_dzisiaj = date('n', $time);
	$szer_rozne = '65';
	$wysokosc_rozne = '30px';
	$szer_calej_tabeli = 150 + 150 + ($szer_rozne * 31);

	echo '<table valign="top" width="'.$szer_calej_tabeli.'px" align="center" border="1" cellspacing="3" cellpadding="3" class="text" BORDERCOLOR="black" frame="box" RULES="all">';
	echo '<tr align="center" bgcolor="'.$kolor_tabeli.'" height="'.$wysokosc_rozne.'"><td width="100px">'.$wyraz_Miesiac.' / '.$wyraz_Dzien.'</td>';
	for($d=1; $d<=31; $d++)
		{
		echo '<td width="'.$szer_rozne.'px">'.$d.'</td>';
		}
	echo '<td width="100px">'.$wyraz_Srednia.'</td>';
	echo '<td width="120px">SUMA</td>';
	echo '</tr>';
	
	//srodkowe wiersze
	for($m=1; $m<=12; $m++) 
		{
		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'" height="'.$wysokosc_rozne.'">';
		echo '<td rowspan="3">'.$TABELA_MIESIECY[$m].'</td>';
		for($d=1; $d<=31; $d++) 
			{
			$SUMA[$d][$m] = number_format($SUMA[$d][$m], 2,'.','');
			if(($d == $dzisiaj) && ($m == $miesiac_dzisiaj)) $bgcolor = $kolor_dzis; 
			elseif($m == $miesiac_dzisiaj) $bgcolor = $kolor_miesiac; 
			else $bgcolor = "#ffffff"; 
			
			echo '<td bgcolor="'.$bgcolor.'" align="right">'.$SUMA[$d][$m].'</td>';

			//liczymy ilosc dni pracujacych w danym miesiacu - potrzebna do sredniej.
			if($SUMA[$d][$m] != 0) $SREDNIA_MIESIAC[$m]++;
			}

		if($SREDNIA_MIESIAC[$m] != 0) 
			{
			$SREDNIA_MIESIAC2[$m] = $SUMA_MIESIAC[$m]/$SREDNIA_MIESIAC[$m];
			$SREDNIA_MIESIAC2[$m] = number_format($SREDNIA_MIESIAC2[$m], 2,'.',' ');
			}
		else $SREDNIA_MIESIAC2[$m] = 0;
			echo '<td align="right">'.$SREDNIA_MIESIAC2[$m].' zł</td>';
		$SUMA_MIESIAC[$m] = number_format($SUMA_MIESIAC[$m], 2,'.',' ');
		echo '<td align="right">'.$SUMA_MIESIAC[$m].' zł</td>';
		echo '</tr>';


		//############################  drugi wiersz - wartosc profili
		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'" height="'.$wysokosc_rozne.'">';
		for($d=1; $d<=31; $d++) 
			{
			$SUMA_wartosc_profili[$d][$m] = number_format($SUMA_wartosc_profili[$d][$m], 2,'.','');
			if(($d == $dzisiaj) && ($m == $miesiac_dzisiaj)) $bgcolor = $kolor_dzis; 
			elseif($m == $miesiac_dzisiaj) $bgcolor = $kolor_miesiac; 
			else $bgcolor = "#ffffff"; 
			
			echo '<td bgcolor="'.$bgcolor.'" align="right">'.$SUMA_wartosc_profili[$d][$m].'</td>';

			//liczymy ilosc dni pracujacych w danym miesiacu - potrzebna do sredniej.
			if($SUMA_wartosc_profili[$d][$m] != 0) $SREDNIA_MIESIAC_wartosc_profili[$m]++;
			}

		if($SREDNIA_MIESIAC_wartosc_profili[$m] != 0) 
			{
			$SREDNIA_MIESIAC2_wartosc_profili[$m] = $SUMA_MIESIAC_wartosc_profili[$m]/$SREDNIA_MIESIAC_wartosc_profili[$m];
			$SREDNIA_MIESIAC2_wartosc_profili[$m] = number_format($SREDNIA_MIESIAC2_wartosc_profili[$m], 2,'.',' ');
			}
		else $SREDNIA_MIESIAC2_wartosc_profili[$m] = 0;
		
		echo '<td align="right">'.$SREDNIA_MIESIAC2_wartosc_profili[$m].' zł</td>';
		$SUMA_MIESIAC_wartosc_profili[$m] = number_format($SUMA_MIESIAC_wartosc_profili[$m], 2,'.',' ');
		echo '<td align="right">'.$SUMA_MIESIAC_wartosc_profili[$m].' zł</td>';
		echo '</tr>';


		//#########################   trzeci wiersz - wartosc ALU
		echo '<tr align="center" bgcolor="'.$kolor_tabeli.'" height="'.$wysokosc_rozne.'">';
		for($d=1; $d<=31; $d++) 
			{
			$SUMA_alu[$d][$m] = number_format($SUMA_alu[$d][$m], 2,'.','');
			if(($d == $dzisiaj) && ($m == $miesiac_dzisiaj)) $bgcolor = $kolor_dzis; 
			elseif($m == $miesiac_dzisiaj) $bgcolor = $kolor_miesiac; 
			else $bgcolor = "#ffffff"; 
			
			echo '<td bgcolor="'.$bgcolor.'" align="right">'.$SUMA_alu[$d][$m].'</td>';

			//liczymy ilosc dni pracujacych w danym miesiacu - potrzebna do sredniej.
			if($SUMA_alu[$d][$m] != 0) $SREDNIA_MIESIAC_alu[$m]++;
			}

		if($SREDNIA_MIESIAC_alu[$m] != 0) 
			{
			$SREDNIA_MIESIAC2_alu[$m] = $SUMA_MIESIAC_alu[$m]/$SREDNIA_MIESIAC_alu[$m];
			$SREDNIA_MIESIAC2_alu[$m] = number_format($SREDNIA_MIESIAC2_alu[$m], 2,'.',' ');
			}
		else $SREDNIA_MIESIAC2_alu[$m] = 0;
			echo '<td align="right">'.$SREDNIA_MIESIAC2_alu[$m].' zł</td>';
		$SUMA_MIESIAC_alu[$m] = number_format($SUMA_MIESIAC_alu[$m], 2,'.',' ');
		echo '<td align="right">'.$SUMA_MIESIAC_alu[$m].' zł</td>';
		echo '</tr>';
		}

	echo '</table>';
echo '</form>';
?>