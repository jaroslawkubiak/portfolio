<?php
$jak = 'DESC';
$wg_czego = 'id';
$czas_przeladowania = 1;
$pytanie = mysqli_query($conn, "SELECT * FROM klienci WHERE id=".$id.";");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$klient_nazwa=$wynik['nazwa'];
	}

echo '<table border="0" align="left" width="1300px" cellpadding="0" cellspacing="0"><tr><td>';
	echo '<div class="text_duzy" align="center">Dodaj klienta <font color="blue">'.$klient_nazwa.'</font></div><br>';
echo '</td></tr><tr><td>';
	echo '<ol id="menu_klienci">';
	
		if($pod_page == 'klienci_dodaj_dane_do_faktury') echo '<li><a href="index.php?page=klienci_dodaj&id='.$id.'&pod_page=klienci_dodaj_dane_do_faktury"><font color="red">Dane do faktury</font></a></li>';
		else echo '<li><a href="index.php?page=klienci_dodaj&id='.$id.'&pod_page=klienci_dodaj_dane_do_faktury">Dane do faktury</a></li>';
		if($klient_nazwa == '')
			{
			echo '<li><a>Warunki płatności</a></li>';
			echo '<li><a>Adres dostawy</a></li>';
			echo '<li><a>Oferta indywidualna</a></li>';
			echo '<li><a>Kontakt</a></li>';
			}
		else
			{
			if($pod_page == 'klienci_dodaj_warunki_platnosci') echo '<li><a href="index.php?page=klienci_dodaj&id='.$id.'&pod_page=klienci_dodaj_warunki_platnosci"><font color="red">Warunki płatności</font></a></li>';
			else echo '<li><a href="index.php?page=klienci_dodaj&id='.$id.'&pod_page=klienci_dodaj_warunki_platnosci">Warunki płatności</a></li>';
			
			if($pod_page == 'klienci_dodaj_adres_dostawy') echo '<li><a href="index.php?page=klienci_dodaj&id='.$id.'&pod_page=klienci_dodaj_adres_dostawy"><font color="red">Adres dostawy</font></a></li>';
			else echo '<li><a href="index.php?page=klienci_dodaj&id='.$id.'&pod_page=klienci_dodaj_adres_dostawy">Adres dostawy</a></li>';
			
			if($pod_page == 'klienci_dodaj_oferta_indywidualna') echo '<li><a href="index.php?page=klienci_dodaj&id='.$id.'&pod_page=klienci_dodaj_oferta_indywidualna"><font color="red">Oferta indywidualna</font></a></li>';
			else echo '<li><a href="index.php?page=klienci_dodaj&id='.$id.'&pod_page=klienci_dodaj_oferta_indywidualna">Oferta indywidualna</a></li>';
			
			if($pod_page == 'klienci_dodaj_kontakt') echo '<li><a href="index.php?page=klienci_dodaj&id='.$id.'&pod_page=klienci_dodaj_kontakt"><font color="red">Kontakt</font></a></li>';
			else echo '<li><a href="index.php?page=klienci_dodaj&id='.$id.'&pod_page=klienci_dodaj_kontakt">Kontakt</a></li>';
			}
	echo '</ol>';
echo '</td></tr>';

echo '<tr><td align="center">';
	$file_name = "php/".$pod_page.".php";
	if (file_exists($file_name)) include_once $file_name; else echo $image_strona_w_budowie;
	
echo '</td></tr>';

echo '<tr><td>';
	echo $powrot_do_klienci;
	
	echo $powrot_do_klienci_wstecz;
echo '</td></tr></table>';
?>