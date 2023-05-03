<?php
//###############################################################   przesyanie plikw na serwer ###############################################################
$uploaddir = '../panel_dane/oferta_indywidualna_pliki/';

$oferta_plik = $_FILES['plik']['name'];
$opis_temp = $oferta_plik;
//usuwamy polskie znaki z nazwy pliku
$oferta_plik = usun_polskie($oferta_plik);

//sprawdzamy czy taki plik już nie istnieje
$taki_plik_istnieje = 0;
if ($handle = opendir($uploaddir)) 
	{
	while (false !== ($file = readdir($handle))) 
		{
		if ($file != "." && $file != "..") 
			{
			if($file == $oferta_plik) $taki_plik_istnieje = 1;		
			}
		}
	closedir($handle);
	}	

if($taki_plik_istnieje == 0)
	{
	//szukamy kolejnego numeru do kolejnosci
	$pytanie = mysqli_query($conn, "SELECT * FROM oferta_indywidualna_pliki ORDER BY kolejnosc DESC LIMIT 1;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$nastepny_numer_kolejnosc=$wynik['kolejnosc'];
		}
	$nastepny_numer_kolejnosc++;
	
	//plik nie istnieje
	if(move_uploaded_file($_FILES['plik']['tmp_name'], $uploaddir.$oferta_plik))
		{
		//jak brak opisu to dajemy nazw pliku
		if($opis == '') 
			{
			$opis = $opis_temp;
			$opis = zamien_dowolne_znaki($opis, ".pdf", "");
			}
		$query = mysqli_query($conn, "INSERT INTO oferta_indywidualna_pliki (`kolejnosc`, `typ`, `opis`, `plik_nazwa`) VALUES ('$nastepny_numer_kolejnosc', 'staly', '$opis', '$oferta_plik');");
		echo '<div align="center" class="text_duzy_niebieski">Plik został przesłany na serwer</div>';
		}	
	}
else
	{
	//taki plik istnieje
	echo '<div align="center" class="text_duzy_czerwony">Plik o nazwie <font color="blue">'.$oferta_plik.'</font> już istnieje, proszę zmienić nazwę pliku.</div><br>';
	}

echo '<form action="index.php?page='.$page.'" method="post" enctype="multipart/form-data">';
	echo '<input type="hidden" name="page" value="'.$page.'">';
	echo '<input type="hidden" name="nowa_oferta" value="'.$nowa_oferta.'">';
	echo '<input type="hidden" name="id" value="'.$id.'">';
	echo '<input type="hidden" name="pod_page" value="'.$pod_page.'">';
	echo '<input type="hidden" name="page" value="'.$page.'">';
	
	echo '<input type="hidden" name="jak" value="'.$jak.'">';
	echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';                                

echo '<table border="0" align="center" cellspacing="3" cellpadding="3" class="text_duzy" width="100%"><tr><td align="center">Wybierz plik do przesłania.</td></tr>';
	echo '<tr align="center"><td><input type="text" size="80" maxlenght="30" name="opis" autocomplete="off" placeholder="Tutaj wpisz nazwę dla pliku (Zostaw puste aby użyć nazwy pliku)"></td></tr>';

	echo '<tr align="center"><td><input type="file" name="plik">';
	echo '<INPUT type="submit" value="Prześlij">';
echo '</td></tr></table>';
echo '</form>';
		
?>