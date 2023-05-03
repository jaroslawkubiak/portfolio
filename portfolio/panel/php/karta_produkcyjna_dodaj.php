<?php
echo '<div class="text_duzy_niebieski" align="center">Dodaj kartę produkcyjną.</div>';
$sciezka = '../panel_dane/karta_produkcyjna_pliki/';

if(isset($_POST['submit']))
	{
	// Count total files
	$countfiles = count($_FILES['file']['name']);
	
	if($countfiles == 1) $ilosc_plikow_opis = 'plik';
	if(($countfiles >= 2) && ($countfiles <= 4)) $ilosc_plikow_opis = 'pliki';
	if($countfiles >= 5) $ilosc_plikow_opis = 'plików';

	//usuwanie starych plików jak byly juz kiedys dodane
	for($i=0;$i<$countfiles;$i++)
		{
		$filename = $_FILES['file']['name'][$i];
		//kasowanie plików
		$pytanie14 = mysqli_query($conn, "SELECT * FROM karta_produkcyjna_pliki WHERE zamowienie_id = ".$zamowienie_id.";");
		while($wynik14= mysqli_fetch_assoc($pytanie14))
			{
			$nazwa_pliku_do_usuniecia=$wynik14['nazwa_pliku'];
			unlink($sciezka.$nazwa_pliku_do_usuniecia);
			//echo '<div align="center" class="text">Usunięto plik : '.$nazwa_pliku_do_usuniecia.' z serwera.<br></div>';
			}
		mysqli_query($conn, "DELETE FROM karta_produkcyjna_pliki WHERE zamowienie_id = ".$zamowienie_id.";");
		}
	
	
	// Looping all files
	for($i=0;$i<$countfiles;$i++)
		{
		$filename = $_FILES['file']['name'][$i];
		// Upload file
		move_uploaded_file($_FILES['file']['tmp_name'][$i],$sciezka.$filename);
		$query = mysqli_query($conn, "INSERT INTO karta_produkcyjna_pliki (`zamowienie_id`, `nr_zamowienia`, `nazwa_pliku`, `user_id`, `data`) VALUES ('$zamowienie_id', '$nr_zamowienia', '$filename', '$zalogowany_user', '$time');");		
		}
	echo '<br><div align="center" class="text_duzy_niebieski">Przesłano '.$countfiles.' '.$ilosc_plikow_opis.' na serwer.</div>';
	} 


	echo '<br><br><form action="index.php?page=karta_produkcyjna_dodaj" method="post" enctype="multipart/form-data">';
		echo '<INPUT type="hidden" name="zamowienie_id" value="'.$zamowienie_id.'">';
		echo '<INPUT type="hidden" name="nr_zamowienia" value="'.$nr_zamowienia.'">';
		echo '<INPUT type="hidden" name="klient" value="'.$klient.'">';
		echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
		echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
	
	echo '<table border="0" align="center" cellspacing="3" cellpadding="3" class="text_duzy_niebieski"><tr ><td align="center">Wybierz pliki do przesłania</td></tr>';
		echo '<tr align="center"><td><input type="file" name="file[]" id="file" multiple accept="image/jpg">';
		echo '<input type="submit" name="submit" value="Dodaj">';
	echo '</td></tr></table>';
	echo '</form>';

echo $powrot_do_konkretnego_zamowienia;

?>