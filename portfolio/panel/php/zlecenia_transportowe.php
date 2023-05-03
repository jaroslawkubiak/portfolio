<?php
$warunek = "";

if($SORT_STATUS != "") 
	{
	if($warunek == "") $warunek .= 'WHERE status = "'.$SORT_STATUS.'"';
	else $warunek .= ' AND status = "'.$SORT_STATUS.'"';
	}          

$ilosc_status = 0;
$pytanie24 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='status_zlec_trans' ORDER BY opis ASC;");
while($wynik24 = mysqli_fetch_assoc($pytanie24))
	{
	$ilosc_status++;
	$status_opis[$ilosc_status] = $wynik24['opis'];
	}		

$id = [];
$nr_zlecenia_transportowego = [];
$data_zaladunku = [];
$data_wyjazdu = [];
$kierowca = [];
$status = [];
$sposob_dostawy = [];
$suma_zlecenia = [];

$i=0;
$pytanie = mysqli_query($conn, "SELECT * FROM zlecenia_transportowe_naglowek ".$warunek." ORDER BY ".$wg_czego." ".$jak.";");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$temp_status=$wynik['status']; 
	if(($temp_status != "Dostarczone") || ($SORT_STATUS == "Dostarczone"))
		{
		$i++;
		$id[$i]=$wynik['id'];
		$nr_zlecenia_transportowego[$i]=$wynik['nr_zlecenia_transportowego'];
		// sprawdzanie sumy zlecenia
		$SUMA_BRUTTO = 0;
		$pytanie15 = mysqli_query($conn, "SELECT kwota_brutto, zamowienie_id FROM zlecenia_transportowe_tresc WHERE nr_zlecenia_transportowego='".$nr_zlecenia_transportowego[$i]."';");
		while($wynik15= mysqli_fetch_assoc($pytanie15))
		{
			$kwota_brutto=$wynik15['kwota_brutto'];
			//sprawdzamy czy zlec transp to odbiór osobisty lub kurier. jezeli tak, to sprawdzamy status zamowienia, czy nie jest zamknięte. Jak dostarczonem anulowane lub odebrane to nie liczymy sumy i nie wyswietlamy na liście w zlec transp
			if(($nr_zlecenia_transportowego[$i] == 'Odbiór własny') || ($nr_zlecenia_transportowego[$i] == 'Kurier'))
			{
				$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT status FROM zamowienia WHERE id = ".$wynik15['zamowienie_id'].";"));
				if(isset($sql['status']))
					if(($sql['status'] != 'Dostarczone') && ($sql['status'] != 'Odebrane') && ($sql['status'] != 'Anulowane'))
						$SUMA_BRUTTO += $kwota_brutto;

			}
			else $SUMA_BRUTTO += $kwota_brutto;
		}
		$SUMA_BRUTTO = change($SUMA_BRUTTO);
		$pytanie122 = mysqli_query($conn, "UPDATE zlecenia_transportowe_naglowek SET suma_zlecenia = ".$SUMA_BRUTTO." WHERE nr_zlecenia_transportowego='".$nr_zlecenia_transportowego[$i]."';");
		$data_zaladunku[$i]=$wynik['data_zaladunku'];
		$data_wyjazdu[$i]=$wynik['data_wyjazdu'];
		$kierowca[$i]=$wynik['kierowca'];
		$status[$i]=$wynik['status'];
		$sposob_dostawy[$i]=$wynik['sposob_dostawy'];
		$suma_zlecenia[$i]=$SUMA_BRUTTO;
		}
	}



echo '<FORM name="szukaj">';
echo '<input type="hidden" name="page" value="zlecenia_transportowe">';
echo '<input type="hidden" name="jak" value="'.$jak.'">';
echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';                                
echo '<input type="hidden" name="pokaz" value="1">';        

echo '<table width="100%" align="center" class="tabela"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
if($pokaz == 1) echo '<td width="40px" valign="middle">'.$kol_lp.'<br>'.$i.'<br><a href="index.php?page=zlecenia_transportowe&jak=ASC&wg_czego=id">'.$image_close.'</a></td>';
else echo '<td width="40px" valign="middle">'.$kol_lp.'<br>'.$i.'</td>';

echo '<td width="200px">'.$kol_nr_zlecenia_transportowego.'<div align="right"><a href="index.php?page=zlecenia_transportowe&jak=DESC&wg_czego=nr_zlecenia_transportowego">'.$image_arrow_down.'</a><a href="index.php?page=zlecenia_transportowe&jak=ASC&wg_czego=nr_zlecenia_transportowego">'.$image_arrow_up.'</a></div></td>';
echo '<td>'.$kol_sposob_dostawy.'<div align="right"><a href="index.php?page=zlecenia_transportowe&jak=DESC&wg_czego=sposob_dostawy">'.$image_arrow_down.'</a><a href="index.php?page=zlecenia_transportowe&jak=ASC&wg_czego=sposob_dostawy">'.$image_arrow_up.'</a></div></td>';
echo '<td>'.$kol_kierowca.'<div align="right"><a href="index.php?page=zlecenia_transportowe&jak=DESC&wg_czego=kierowca">'.$image_arrow_down.'</a><a href="index.php?page=zlecenia_transportowe&jak=ASC&wg_czego=kierowca">'.$image_arrow_up.'</a></div></td>';
echo '<td>'.$kol_data_zaladunku.'<div align="right"><a href="index.php?page=zlecenia_transportowe&jak=DESC&wg_czego=data_zaladunku">'.$image_arrow_down.'</a><a href="index.php?page=zlecenia_transportowe&jak=ASC&wg_czego=data_zaladunku">'.$image_arrow_up.'</a></div></td>';
echo '<td>'.$kol_data_wyjazdu.'<div align="right"><a href="index.php?page=zlecenia_transportowe&jak=DESC&wg_czego=data_wyjazdu">'.$image_arrow_down.'</a><a href="index.php?page=zlecenia_transportowe&jak=ASC&wg_czego=data_wyjazdu">'.$image_arrow_up.'</a></div></td>';
echo '<td width="200px">'.$kol_suma_zamowien_brutto.'<div align="right"><a href="index.php?page=zlecenia_transportowe&jak=DESC&wg_czego=suma_zlecenia">'.$image_arrow_down.'</a><a href="index.php?page=zlecenia_transportowe&jak=ASC&wg_czego=suma_zlecenia">'.$image_arrow_up.'</a></div></td>';
echo '<td>'.$kol_status.'<div align="right"><a href="index.php?page=zlecenia_transportowe&jak=DESC&wg_czego=status">'.$image_arrow_down.'</a><a href="index.php?page=zlecenia_transportowe&jak=ASC&wg_czego=status">'.$image_arrow_up.'</a></div>';
	echo '<select name="SORT_STATUS" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
	echo '<option></option>';
	for ($k=1; $k<=$ilosc_status; $k++) 
		if ($status_opis[$k] == $SORT_STATUS) echo '<option value="'.$status_opis[$k].'" selected="selected">'.$status_opis[$k].'</option>';
		else echo '<option value="'.$status_opis[$k].'">'.$status_opis[$k].'</option>';
	echo '</select>';
echo '</td></tr>';
echo '</form>';

	for ($x=1; $x<=$i; $x++)
		{
		echo '<tr class="text_zmienny" align="center" bgcolor="'.$kolor_bialy.'"><td bgcolor="'.$kolor_tabeli.'" class="text">'.$x.'</td>';
		echo '<td><a href="index.php?page=zlecenie_transportowe_pokaz&id='.$id[$x].'&jak='.$jak.'&wg_czego='.$wg_czego.'"><font color="black">'.$nr_zlecenia_transportowego[$x].'</font></a></td>';
		echo '<td>'.$sposob_dostawy[$x].'</td>';

		if($kierowca[$x])
		{
			$pytanie2 = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id = ".$kierowca[$x].";");
			while($wynik2 = mysqli_fetch_assoc($pytanie2))
				$kierowca_opis[$x] = $wynik2['imie'].' '.$wynik2['telefon'];
		}
		if(!isset($kierowca_opis[$x])) $kierowca_opis[$x] = '';
		echo '<td>'.$kierowca_opis[$x].'</td>';
		echo '<td>'.$data_zaladunku[$x].'</td>';
		echo '<td>'.$data_wyjazdu[$x].'</td>';
		$suma_zlecenia[$x] = kwota($suma_zlecenia[$x]);
		echo '<td>'.$suma_zlecenia[$x].$waluta.'</td>';
		echo '<td>'.$status[$x].'</td></tr>';
		}
echo '</table>';
?>