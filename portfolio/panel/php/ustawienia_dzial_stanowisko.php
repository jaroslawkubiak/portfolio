<?php
//tabela do mniejszych stron
echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';

echo '<div class="text_duzy" align="center">Dział/Stanowisko - Klienci</div><br>';



if($dodaj == 'dzial')
	{
	$query = mysqli_query($conn, "INSERT INTO suwaki (`typ`, `opis`) values ('dzial', '$dzial');");	
	echo '<div class="text_duzy_niebieski" align="center">Nowy dział został dodany.</div>';
	}
	
if($dodaj == 'stanowisko')
	{
	$query = mysqli_query($conn, "INSERT INTO suwaki (`typ`, `opis`) values ('stanowisko', '$stanowisko');");	
	echo '<div class="text_duzy_niebieski" align="center">Nowe stanowisko zostało dodane.</div>';
	}
	
	
if($usun_id != '')
	{
	mysqli_query($conn, "DELETE FROM suwaki WHERE id = ".$usun_id." LIMIT 1;");
	echo '<div class="text_duzy_niebieski" align="center">Dane usunięte.</div>';
	}


$id = [];
$typ = [];
$opis = [];
$link_usun = [];

echo '<table border="0" width="300px" cellpadding="5" cellspacing="5" align="center"><tr valign="top"><td>';
	// ############################################ dział ################################################################
	echo '<table border="0" width="300px" cellpadding="5" cellspacing="5" align="center"><tr><td>';
		echo '<table border="1" align="center" width="100%" BORDERCOLOR="black" frame="box" RULES="all" bgcolor="'.$kolor_bialy.'">';
		echo '<tr class="text_duzy" bgcolor="'.$kolor_tabeli.'" align="center"><td colspan="2">Dział</td></tr>';
		$ilosc = 0;
		$pytanie = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ = 'dzial' ORDER BY opis ASC;");
		while($wynik= mysqli_fetch_assoc($pytanie))
			{
			$ilosc++;
			$id[$ilosc]=$wynik['id'];
			$typ[$ilosc]=$wynik['typ'];
			$opis[$ilosc]=$wynik['opis'];
			if(($opis[$ilosc] == 'Faktury') || ($opis[$ilosc] == 'Oferty') || ($opis[$ilosc] == 'Potwierdzenie dostawy') || ($opis[$ilosc] == 'Potwierdzenie zamówień') || ($opis[$ilosc] == 'Windykacja') || ($opis[$ilosc] == 'Wyceny')) $link_usun[$ilosc] = '';
			else $link_usun[$ilosc] = '<a href="index.php?page=ustawienia_dzial_stanowisko&usun_id='.$id[$ilosc].'">'.$image_delete.'</a>';
			}
		for($x=1; $x<=$ilosc; $x++)
			{
			echo '<tr class="text" align="left"><td width="90%">'.$tabulator.$opis[$x].'</td><td align="center">';
			echo $link_usun[$x];
			echo '</td></tr>';
			}
		echo '</table>';
		
	echo '</td></tr><tr><td>';
	
		echo '<FORM action="index.php?page=ustawienia_dzial_stanowisko" method="post">';
		echo '<INPUT type="hidden" name="page" value="'.$page.'">';
		echo '<INPUT type="hidden" name="dodaj" value="dzial">';
		echo '<br><table align="center" class="tabela" width="100%" border="0"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text"><td class="text_duzy" align="center" >Dodaj nowy dział</td></tr>';
			echo '<tr align="center" bgcolor="'.$kolor_bialy.'"><td align="left"><input autocomplete="off" type="text" size="50" maxlength="100" class="pole_input" title="Dział" alt="Dział" name="dzial"></td></tr>';
			echo '<tr class="text" bgcolor="'.$kolor_bialy.'"><td align="center"><INPUT type="submit" name="submit" value="Dodaj"></td></tr>';
		echo '</table>';
		echo '</FORM>';
		
	echo '</td></tr></table>';
	// ############################################ KONIEC dział ################################################################
	
echo '</td><td>';

	// ############################################ STANOWISKO ################################################################
	echo '<table border="0" width="300px" cellpadding="5" cellspacing="5" align="center"><tr><td>';
		echo '<table border="1" align="center" width="100%" BORDERCOLOR="black" frame="box" RULES="all" bgcolor="'.$kolor_bialy.'">';
		echo '<tr class="text_duzy" bgcolor="'.$kolor_tabeli.'" align="center"><td colspan="2">Stanowisko</td></tr>';
		$ilosc = 0;
		$pytanie = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ = 'stanowisko' ORDER BY opis ASC;");
		while($wynik= mysqli_fetch_assoc($pytanie))
			{
			$ilosc++;
			$id[$ilosc]=$wynik['id'];
			$typ[$ilosc]=$wynik['typ'];
			$opis[$ilosc]=$wynik['opis'];
			}
		for($x=1; $x<=$ilosc; $x++) echo '<tr class="text" align="left"><td width="90%">'.$tabulator.$opis[$x].'</td><td align="center"><a href="index.php?page=ustawienia_dzial_stanowisko&usun_id='.$id[$x].'">'.$image_delete.'</a></td></tr>';

		echo '</table>';
		
	echo '</td></tr><tr><td>';
	
		echo '<FORM action="index.php?page=ustawienia_dzial_stanowisko" method="post">';
		echo '<INPUT type="hidden" name="page" value="'.$page.'">';
		echo '<INPUT type="hidden" name="dodaj" value="stanowisko">';
		echo '<br><table align="center" class="tabela" width="100%" border="0"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text"><td class="text_duzy" align="center" >Dodaj nowe stanowisko</td></tr>';
			echo '<tr align="center" bgcolor="'.$kolor_bialy.'"><td align="left"><input autocomplete="off" type="text" size="50" maxlength="100" class="pole_input" title="Stanowisko" alt="Stanowisko" name="stanowisko"></td></tr>';
			echo '<tr class="text" bgcolor="'.$kolor_bialy.'"><td align="center"><INPUT type="submit" name="submit" value="Dodaj"></td></tr>';
		echo '</table>';
		echo '</FORM>';
	echo '</td></tr></table>';
	// ############################################ KONIEC STANOWISKO ################################################################


	echo '</td></tr></table>';
echo '</td></tr></table>';
?>