<?php
echo '<table border="0" width="1600px" align="left" cellpadding="0" cellspacing="0" bgcolor="white"><tr valign="top"><td>';

if($zmiana_danych == 1)
	{
	$ins=mysqli_query($conn, "update ustawienia_zlecenia_transportowe set tytul= '".$tytul."'");
	$ins=mysqli_query($conn, "update ustawienia_zlecenia_transportowe set opis= '".$opis."' ");
	$ins=mysqli_query($conn, "update ustawienia_zlecenia_transportowe set szerokosc= ".$szerokosc.";");
	echo '<div class="text_duzy_niebieski" align="center">Uwagi zostały zmienione.</div>';
	
	
	$uploaddir = '../panel_dane/';
	$rysunek = $_FILES['plik']['name'];
	$extension=end(explode(".", $rysunek));
	$prod = 'foto';
	$newfilename=$prod .".".$extension;
	
	// echo 'plik='.$_FILES['plik']['tmp_name'].'<br>';
	move_uploaded_file($_FILES['plik']['tmp_name'], $uploaddir.$newfilename);
	}
	
	
$pytanie = mysqli_query($conn, "SELECT * FROM ustawienia_zlecenia_transportowe");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$tytul=$wynik['tytul'];
	$opis=$wynik['opis'];
	$szerokosc=$wynik['szerokosc'];
	}


	echo '<table border="0" width="1600px" align="center" cellpadding="5" cellspacing="5" bgcolor="white"><tr align="center"><td width="50%" valign="top">';
	echo '<div class="text_duzy_niebieski" align="center">Uwagi do zleceń transportowych.</div><br>';

		echo '<FORM action="index.php?page=ustawienia_zlecenia_transportowe&zmiana_danych=1"  method="post" enctype="multipart/form-data">';
		echo '<table border="0" align="center" cellpadding="5" cellspacing="5" bgcolor="white">';
			
			echo '<tr class="text" align="right"><td width="50%">Tytuł e-maila: </td><td width="50%" align="left"><input type="text" size="30" maxlength="80" class="pole_input" autocomplete="off" name="tytul" value="'.$tytul.'"></td></tr>';
			echo '<tr align="center"><td align="right" class="text">Treść maila: </td><td align="left" colspan="3" class="text" bgcolor="white">';
			echo '<textarea name="opis" cols="50" rows="6" class="pole_input_szare_ramka_uwagi">'.$opis.'</textarea><br><font color="blue">Pomoc:</font><br>';
			echo 'Aby użyć Enter wpisz: &lt;br&gt;<br><br>';
			echo 'Aby pogrubić czcionkę umieść na początku: &lt;b&gt;<br>';
			echo 'a na końcu: &lt;/b&gt;<br>';
			echo '&lt;b&gt;PRZYKŁAD&lt;/b&gt;<br>';
			
			echo '</td></tr>';
		
			echo '<tr align="center"><td align="center" class="text" colspan="2">';
				echo '<br><table border="0" align="center" cellspacing="0" cellpadding="0" class="text_duzy"><tr ><td align="center">Wybierz plik do przesłania (tylko pliki JPG)</td></tr><tr align="center"><td><br>';
				echo '<input type="file" name="plik" accept="image/jpeg">';
				echo '</td></tr></table><br>';
			echo '</td></tr>';
		
			echo '<tr class="text" align="right"><td width="50%">Szerokość zdjęcia: </td><td width="50%" align="left"><input type="text" size="10" maxlength="10" class="pole_input" autocomplete="off" name="szerokosc" value="'.$szerokosc.'"></td></tr>';
			echo '<tr><td colspan="2" align="center"><INPUT type="submit" class="text" name="submit" value="Zapisz"></td></tr>';
			
		echo '</table>';
		echo '</FORM>';
		
	echo '</td><td width="50%" class="text">';
		echo '<div class="text_duzy_niebieski" align="center">Podgląd</div><br>';
		
		echo '<table border="1"  align="center" cellpadding="5" cellspacing="5" class="text" BORDERCOLOR="black" frame="box" RULES="all"><tr align="left"><td>';
		echo $opis;
		echo '<br><img src="http://'.$adres_serwera_do_faktur.'/panel_dane/foto.jpg" border="0" width="'.$szerokosc.'">';
		echo '</td></tr></table>';
		
		echo '<br><br><a href="javascript: info_zlecenie_transportowe(3)"><font color="blue" size="+1">kliknij, aby zobaczyć podgląd okienka i wysłać info</a>';
	echo '</td></tr></table>';

echo '</td></tr></table>';
?>