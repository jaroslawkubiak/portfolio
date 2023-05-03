<?php
//tabela do mniejszych stron
echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';



	echo '<FORM action="index.php?page=wzmocnienia" method="post" id="szukaj">';
		echo '<INPUT type="hidden" name="page" value="'.$page.'">';
		echo '<table border="0" align="center" cellspacing="0" cellpadding="0" class="text"><tr class="text_ogromny"><td align="center" colspan="2">Szukaj wzmocnienia :</td></tr><tr align="center"><td>';
		echo '<input type="text" id="szukaj" autocomplete="off" size="10" class="pole_input_wzmocnienia" name="szukaj" value="'.$szukaj.'"></td>';
		echo '<td><INPUT type="image" name="submit" src="images/lupa.png"></td>';
		echo '</tr></table>';
	echo '</FORM>';

	$i = 0;
	if ($handle = opendir('wzmocnienia')) 
	{
	while (false !== ($file = readdir($handle))) 
	{
		if ($file != "." && $file != "..") 
		{
			$i++;
			$file = explode('.', $file);
			$tab_wzmocnienia_nazwa[$i] = $file[0];
			$tab_wzmocnienia_rozszerzenie[$i] = $file[1];
		}
	}
	closedir($handle);
	}		


	if($szukaj != '')
		{
		$istnieje = 0;
		for($x=1; $x<=$i; $x++) if($szukaj == $tab_wzmocnienia_nazwa[$x]) 
			{
			echo '<center><img src="wzmocnienia/'.$szukaj.'.'.$tab_wzmocnienia_rozszerzenie[$x].'" width="1000"></center>';
			$istnieje = 1;
			}

		}

	if(($istnieje == 0) && ($szukaj != '')) echo '<div align="center" class="text_duzy_czerwony">Nie ma takiego wzmocnienia</div>';


	if(($user_stanowisko == 'administrator') || ($user_id == 6))
		{
		$uploaddir = 'wzmocnienia/';
		//echo 'plik='.$_FILES['plik']['tmp_name'].'<br>';
		if(move_uploaded_file($_FILES['plik']['tmp_name'], $uploaddir.$_FILES['plik']['name']))
			{
			echo '<div align="center" class="text_duzy_niebieski">Plik został przesłany na serwer</div>';
			}
		
		echo '<br><br><form action="index.php?page=wzmocnienia" method="post" enctype="multipart/form-data">';
		echo '<table border="0" align="center" cellspacing="0" cellpadding="0" class="text_duzy"><tr ><td align="center">Wybierz plik do przesłania (tylko pliki JPG)</td></tr><tr align="center"><td>';
			echo '<input type="file" name="plik" accept="image/jpeg">';
		echo '<INPUT type="submit" value="Prześlij">';
		echo '</td></tr></table>';
		echo '</form>';
		}
echo '</td></tr></table>';

?>