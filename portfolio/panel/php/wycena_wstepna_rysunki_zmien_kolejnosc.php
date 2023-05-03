<?php
echo '<table border="0" width="1180"><tr><td>';

if($submit)
	{
	echo '<div align="center" class="text_duzy_niebieski">Kolejność zmieniona.</div><br>';
	
	$pytanie2 = mysqli_query($conn, "SELECT * FROM rysunki ORDER BY id ASC");
	while($wynik2= mysqli_fetch_assoc($pytanie2))
		{
		$id2=$wynik2['id'];
		$pytanie122 = mysqli_query($conn, "UPDATE rysunki SET kolejnosc = '".$nazwa_kolejnosc[$id2]."' WHERE id = ".$id2.";");
		}
	
	}
	
	$ilosc_rysunkow = 0;
	$id = [];
	$kolejnosc = [];
	$opis = [];
	$link = [];

	$pytanie = mysqli_query($conn, "SELECT * FROM rysunki ORDER BY kolejnosc ASC");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$ilosc_rysunkow++;
		$id[$ilosc_rysunkow]=$wynik['id'];
		$kolejnosc[$ilosc_rysunkow]=$wynik['kolejnosc'];
		$opis[$ilosc_rysunkow]=$wynik['opis'];
		$link[$ilosc_rysunkow]=$wynik['link'];
		}
	
	
	
	echo '<FORM action="index.php?page='.$page.'&jak='.$jak.'&wg_czego='.$wg_czego.'" method="post">';
	echo '<input type="hidden" name="jak" value="'.$jak.'">';
	echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';                                

	
		echo '<table border="0" width="1180" class="tabela">';
		echo '<tr bgcolor="'.$kolor_tabeli.'" align="center" class="text_duzy"><td width="15%">Kolejność</td><td width="85%">Opis rysunku</td></tr>';
		for($x=1; $x<=$ilosc_rysunkow; $x++) 
			{
			echo '<tr bgcolor="'.$kolor_bialy.'">';
			$nazwa_kolejnosc = 'nazwa_kolejnosc['.$id[$x].']';
			echo '<td align="center"><input type="number" name="'.$nazwa_kolejnosc.'" autocomplete="off" value="'.$kolejnosc[$x].'" class="pole_input_kolejnosc" min="1" step="1"></td>';
			echo '<td align="left" class="text_duzy">'.$opis[$x].'</td></tr>';
			}
		echo '</table>';
		echo $tabulator.'<div>'.$tabulator.$tabulator.$tabulator.'<INPUT type="submit" name="submit" value="Zapisz"></div>';
	echo '</form>';
		
	echo $powrot_do_rysunkow;
	
echo '</td></tr></table>';
	
?>