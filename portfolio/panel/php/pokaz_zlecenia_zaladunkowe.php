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

		$data_zaladunku[$i]=$wynik['data_zaladunku'];
		$data_wyjazdu[$i]=$wynik['data_wyjazdu'];
		$kierowca[$i]=$wynik['kierowca'];
		$status[$i]=$wynik['status'];
		$sposob_dostawy[$i]=$wynik['sposob_dostawy'];
		}
	}



echo '<FORM name="szukaj">';
echo '<input type="hidden" name="page" value="zlecenia_transportowe">';
echo '<input type="hidden" name="jak" value="'.$jak.'">';
echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';                                
echo '<input type="hidden" name="pokaz" value="1">';        

echo '<table width="100%" align="center" class="tabela"><tr align="center" height="50px" bgcolor="'.$kolor_tabeli.'" class="text">';
echo '<td width="40px" valign="middle">'.$kol_lp.'</td>';

echo '<td width="200px">'.$kol_nr_zlecenia_transportowego.'</td>';
echo '<td>'.$kol_sposob_dostawy.'</td>';
echo '<td>'.$kol_kierowca.'</td>';
echo '<td>'.$kol_data_zaladunku.'</td>';
echo '<td>'.$kol_data_wyjazdu.'</td>';
echo '<td>'.$kol_status.'</td>';
echo '<td>Pokaż</td>';
echo '</tr>';
echo '</form>';

	for ($x=1; $x<=$i; $x++)
		{
		echo '<tr class="text_zmienny" align="center" bgcolor="'.$kolor_bialy.'"><td bgcolor="'.$kolor_tabeli.'" class="text">'.$x.'</td>';
		echo '<td>'.$nr_zlecenia_transportowego[$x].'</td>';
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
		echo '<td>'.$status[$x].'</td>';

        echo '<td><a href="php/drukuj/drukuj_zlecenie_zaladunkowe.php?id='.$id[$x].'" target="_blank">'.$image_printer.'</a></td></tr>';
		}
echo '</table>';
?>