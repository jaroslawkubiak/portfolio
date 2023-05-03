<?php
echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';

echo '<div class="text_duzy" align="center">Cennik domyślny</div><br>';



if($zmiana_danych == 1)
	{
	for ($x=1; $x<=$ilosc; $x++) 
		{
		$cenka[$x] = change($cenka[$x]);
		$ins=mysqli_query($conn, "update cennik set cena=".$cenka[$x]." WHERE id = ".$x.";");
		}

	mysqli_query($conn, "UPDATE rozne SET opis = '".$opis_dla_cennika."' WHERE typ = 'opis_dla_cennika';");
	mysqli_query($conn, "UPDATE rozne SET opis = ".$wysokosc_okna_cennika." WHERE typ = 'wysokosc_okna_cennika';");
	mysqli_query($conn, "UPDATE rozne SET opis = ".$szerokosc_okna_cennika." WHERE typ = 'szerokosc_okna_cennika';");


	echo '<div class="text_duzy_niebieski" align="center">Cenink domyślny został zmieniony.</div><br>';
	}


$i = 0;
$opis = [];
$cena = [];
$pytanie = mysqli_query($conn, "SELECT * FROM cennik ORDER BY id ASC;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$i++;
	$opis[$i]=$wynik['opis'];
	$cena[$i]=$wynik['cena'];
	$cena[$i] = number_format($cena[$i], 2,'.','');
	}
		
//pobieram dane cennika
$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT opis FROM rozne WHERE typ = 'opis_dla_cennika';"));
$opis_dla_cennika = $sql['opis'];
		
$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT opis FROM rozne WHERE typ = 'wysokosc_okna_cennika';"));
$wysokosc_okna_cennika = $sql['opis'];

$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT opis FROM rozne WHERE typ = 'szerokosc_okna_cennika';"));
$szerokosc_okna_cennika = $sql['opis'];


	echo '<FORM action="index.php?page=ustawienia_cennik&zmiana_danych=1" method="post">';
	echo '<table border="0" align="center" width="100%">';
	echo '<INPUT type="hidden" name="ilosc" value="'.$i.'">';
	$z=0;
	for ($x=1; $x<=$i; $x++)
		{
		if($z == 4) 
			{
			$z = 0;
			echo '<tr class="text" align="right"><td width="100%" colspan="2">&nbsp;</td></tr>';
			}
		$z++;
		$cenka = 'cenka['.$x.']';		
		echo '<tr class="text" align="right"><td width="50%">'.$opis[$x].' :</td><td width="50%" align="left"><input type="text" size="8" maxlength="10" class="pole_input_right" autocomplete="off" name="'.$cenka.'" value="'.$cena[$x].'"></td></tr>';
		}
	


	echo '<tr><td colspan="2" align="center">';
		echo '<table border="0" align="center"><tr><td colspan="2">';
			echo '<textarea class="text" name="opis_dla_cennika" rows="'.$wysokosc_okna_cennika.'" cols="'.$szerokosc_okna_cennika.'">'.$opis_dla_cennika.'</textarea>';
			echo '</td></tr>';

			echo '<tr><td width="50%">';
				echo '<table align="center" border="0"><tr class="text" align="right"><td width="50%">Szerokość okna : </td><td width="50%" align="left"><input type="text" size="5" maxlength="3" class="pole_input_right" autocomplete="off" name="szerokosc_okna_cennika" value="'.$szerokosc_okna_cennika.'"></td></tr></table>';
			echo '</td><td width="50%">';
				echo '<table align="center" border="0"><tr class="text" align="right"><td width="50%">Wysokość okna : </td><td width="50%" align="left"><input type="text" size="5" maxlength="2" class="pole_input_right" autocomplete="off" name="wysokosc_okna_cennika" value="'.$wysokosc_okna_cennika.'"></td></tr></table>';
			echo '</td></tr>';
		echo '</table>';
	echo '</td></tr>';



	// echo '<tr><td colspan="2" align="center"><br><br><textarea class="text" name="opis_dla_cennika" rows="'.$wysokosc_okna_cennika.'" cols="'.$szerokosc_okna_cennika.'">'.$opis_dla_cennika.'</textarea></td></tr>';
	
	echo '<tr><td colspan="2" align="center"><INPUT type="submit" class="text" name="submit" value="Zmień"></td></tr>';
	echo '</table>';
	echo '</FORM>';

echo '</td></tr></table>';


?>