<?php
$sql44 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nazwa FROM klienci WHERE id=".$id.";"));
$klient_nazwa = $sql44['nazwa'];


echo '<table border="0" align="left" width="1500px" cellpadding="0" cellspacing="0"><tr><td>';
	echo '<div class="text_duzy" align="center">Edycja klienta : <font color="blue">'.$klient_nazwa.'</font></div><br>';
echo '</td></tr><tr><td>';
	echo '<ol id="menu_klienci">';
	
	if($zalogowany_user == 1) {

		if($pod_page == 'klienci_edycja_informacje_ogolne') echo '<li><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_informacje_ogolne"><font color="red">'.$kom_informacje_ogolne.'</font></a></li>';
		else echo '<li><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_informacje_ogolne">'.$kom_informacje_ogolne.'</a></li>';
		
	}
		if($pod_page == 'klienci_edycja_dane_do_faktury') echo '<li><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_dane_do_faktury"><font color="red">'.$kom_dane_do_faktury.'</font></a></li>';
		else echo '<li><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_dane_do_faktury">'.$kom_dane_do_faktury.'</a></li>';
		
		if($pod_page == 'klienci_edycja_warunki_platnosci') echo '<li><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_warunki_platnosci"><font color="red">'.$kom_dane_warunki_platnosci.'</font></a></li>';
		else echo '<li><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_warunki_platnosci">'.$kom_dane_warunki_platnosci.'</a></li>';
		
		if($pod_page == 'klienci_edycja_dane_do_logowania') echo '<li><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_dane_do_logowania"><font color="red">'.$kom_dane_do_logowania.'</font></a></li>';
		else echo '<li><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_dane_do_logowania">'.$kom_dane_do_logowania.'</a></li>';
		
		if($pod_page == 'klienci_edycja_adres_dostawy') echo '<li><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_adres_dostawy"><font color="red">'.$kom_adres_dostawcy.'</font></a></li>';
		else echo '<li><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_adres_dostawy">'.$kom_adres_dostawcy.'</a></li>';
		
		if($pod_page == 'klienci_edycja_historia_wspolpracy') echo '<li><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_historia_wspolpracy"><font color="red">Historia wspópracy</font></a></li>';
		else echo '<li><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_historia_wspolpracy">Historia wspópracy</a></li>';
		
		if($pod_page == 'klienci_edycja_oferta_indywidualna') echo '<li><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_oferta_indywidualna"><font color="red">Oferta indywidualna</font></a></li>';
		else echo '<li><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_oferta_indywidualna">Oferta indywidualna</a></li>';
		
		if($pod_page == 'klienci_edycja_do_pobrania') echo '<li><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_do_pobrania"><font color="red">Do pobrania</font></a></li>';
		else echo '<li><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_do_pobrania">Do pobrania</a></li>';
		
		echo '<li><a href="index.php?page=zamowienia&jak=DESC&wg_czego=id&SORT_KLIENT_NAZWA='.$klient_nazwa.'">Zamówienia</a></li>';
		echo '<li><a href="index.php?page=fv_fakturowanie&rodzaj_dokumentu=Faktura&jak=DESC&wg_czego=data_wystawienia_time&termin_wystawienia=on&szukany_miesiac='.$AKTUALNY_MIESIAC.'&klient=on&klient_nazwa='.$klient_nazwa.'">Faktury</a></li>';
		echo '<li><a href="index.php?page=magazyn&jak=ASC&wg_czego=system&pokaz=1&SORT_KLIENT_NAZWA='.$klient_nazwa.'">Magazyn</a></li>';
		
		if($pod_page == 'klienci_edycja_technologia') echo '<li><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_technologia"><font color="red">Technologia</font></a></li>';
		else echo '<li><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_technologia">Technologia</a></li>';
				
		if($pod_page == 'klienci_edycja_kontakt') echo '<li><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_kontakt"><font color="red">Kontakt</font></a></li>';
		else echo '<li><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_kontakt">Kontakt</a></li>';
	echo '</ol>';
echo '</td></tr>';

echo '<tr><td align="center">';
	$file_name = "php/".$pod_page.".php";
	if (file_exists($file_name)) include $file_name; else echo $image_strona_w_budowie;
echo '</td></tr>';

echo '<tr><td>';
	echo $powrot_do_klienci;
	echo $powrot_do_klienci_wstecz;
echo '</td></tr></table>';
?>