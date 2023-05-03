<?php
$szerokosc_tabeli_zalaczniki = 1200;
if($oferta_wyslana == 'tak') echo '<br><div class="text_duzy" align="center"><font color="blue">'.$kom_oferta_zostala_wyslana_poprawnie.'</font></div><br>';

//########################### lista wysłanych ofert  #######################################################
if($wyslane_oferty == 1)
	{
	$ilosc_ofert = 0;
	$pytanie2 = mysqli_query($conn, "SELECT * FROM oferta_indywidualna WHERE klient_id = ".$id." ORDER BY data_time DESC;");
	while($wynik2= mysqli_fetch_assoc($pytanie2))
		{
		$ilosc_ofert++;
		$oferta_id[$ilosc_ofert]=$wynik2['id'];
		//szukam załączonych plików do oferty
		$ilosc_plikow_oferta[$oferta_id[$ilosc_ofert]] = 0;
		$pytanie77 = mysqli_query($conn, "SELECT * FROM oferta_indywidualna_wyslane_pliki WHERE oferta_id = ".$oferta_id[$ilosc_ofert].";");
		while($wynik77= mysqli_fetch_assoc($pytanie77))
			{
			$ilosc_plikow_oferta[$oferta_id[$ilosc_ofert]]++;
			$wyslany_plik_id[$oferta_id[$ilosc_ofert]][$ilosc_plikow_oferta[$oferta_id[$ilosc_ofert]]]=$wynik77['plik_id'];
			}
		
		//szukam imie i nazwisko usera który wysłała ofertę
		$oferta_user_id[$ilosc_ofert]=$wynik2['user_id'];
		$pytanie177 = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id = ".$oferta_user_id[$ilosc_ofert].";");
		while($wynik177= mysqli_fetch_assoc($pytanie177))
			{
			$oferta_user_imie[$ilosc_ofert]=$wynik177['imie'];
			$oferta_user_nazwisko[$ilosc_ofert]=$wynik177['nazwisko'];
			}		
		$oferta_data[$ilosc_ofert]=$wynik2['data'];
		$oferta_email[$ilosc_ofert]=$wynik2['email'];
		}

	echo '<br><div align="center" class="text_duzy_zielony">Wysłane oferty : '.$ilosc_ofert.'</div>';

	echo '<table border="0" width="80%" class="tabela" align="center">';
	$ilosc_kolumn = 3;
	$szerokosc_kolumny = 100/$ilosc_kolumn;		

	for ($x=1; $x<=$ilosc_ofert; $x++)
		{
		echo '<tr class="text_sredni" bgcolor="'.$kolor_tabeli.'">';
		echo '<td align="right" width="10%">Data oferty :&nbsp;</td>';
		echo '<td align="left" width="10%" bgcolor="white">&nbsp;'.$oferta_data[$x].'</td>';
		echo '<td align="right" width="10%">Wysłał :&nbsp;</td>';
		echo '<td align="left" width="20%" bgcolor="white">&nbsp;'.$oferta_user_imie[$x].' '.$oferta_user_nazwisko[$x].'</td>';
		echo '<td align="right" width="10%">Adres email :&nbsp;</td>';
		echo '<td align="left" width="20%" bgcolor="white">&nbsp;'.$oferta_email[$x].'</td></tr>';
		
		echo '<tr class="text_sredni" bgcolor="'.$kolor_bialy.'"><td align="left" width="100%" colspan="6">załączone pliki&nbsp;:&nbsp;'.$ilosc_plikow_oferta[$oferta_id[$x]].'<br><br>';
			echo '<table width="'.$szerokosc_tabeli_zalaczniki.'px" align="left" border="0" cellspacing="2" cellpadding="2">';
			$licz = 0;
			for($z=1; $z<=12; $z++) 
				{
				if($licz == 0) echo '<tr>';	
				if($licz < $ilosc_kolumn)
					{
					$licz++;
					echo '<td class="text_duzy" width="'.$szerokosc_kolumny.'%" valign="top">';
					if($wyslany_plik_id[$oferta_id[$x]][$z] != '')
						{
						$pytanie88 = mysqli_query($conn, "SELECT * FROM oferta_indywidualna_pliki WHERE id = ".$wyslany_plik_id[$oferta_id[$x]][$z].";");
						while($wynik88= mysqli_fetch_assoc($pytanie88))
							{
							$plik_opis=$wynik88['opis'];
							$plik_typ=$wynik88['typ'];
							$plik_link=$wynik88['link'];
							$plik_nazwa=$wynik88['plik_nazwa'];
							}
						$ikonka_pliku = $image_plik_nieznany;
						if((preg_match("/.jpg/", $plik_nazwa)) || (preg_match("/.JPG/", $plik_nazwa))) $ikonka_pliku = $image_plik_jpg;
						if((preg_match("/.doc/", $plik_nazwa)) || (preg_match("/.DOC/", $plik_nazwa))) $ikonka_pliku = $image_plik_jpg;
						if((preg_match("/.xls/", $plik_nazwa)) || (preg_match("/.XLS/", $plik_nazwa))) $ikonka_pliku = $image_plik_jpg;
						if((preg_match("/.pdf/", $plik_nazwa)) || (preg_match("/.PDF/", $plik_nazwa))) $ikonka_pliku = $image_plik_jpg;

						if($plik_typ == 'staly') 
							{
							echo '<table border="0" align="center"><tr align="center"><td>';
								echo '<a href="http://'.$adres_serwera_do_faktur.'/panel_dane/oferta_indywidualna_pliki/'.$plik_nazwa.'" target="_blank">'.$ikonka_pliku.'</a>';
							echo '</td></tr><tr align="center"><td>';
								echo '<a href="http://'.$adres_serwera_do_faktur.'/panel_dane/oferta_indywidualna_pliki/'.$plik_nazwa.'" target="_blank"><font color="blue">'.$plik_nazwa.'</font></a>';
							echo '</td></tr></table>';
							}
						if($plik_typ == 'temp') 
							{
							echo '<table border="0" align="center"><tr align="center"><td>';
								echo '<a href="http://'.$adres_serwera_do_faktur.'/panel_dane/oferta_indywidualna_pliki_temp/'.$plik_link.'/'.$plik_nazwa.'" target="_blank">'.$ikonka_pliku.'</a>';
							echo '</td></tr><tr align="center"><td>';
								echo '<a href="http://'.$adres_serwera_do_faktur.'/panel_dane/oferta_indywidualna_pliki_temp/'.$plik_link.'/'.$plik_nazwa.'" target="_blank"><font color="green">'.$plik_nazwa.'</font></a>';
							echo '</td></tr></table>';
							}
						if($plik_typ == 'archiwum') 
							{
							echo '<table border="0" align="center"><tr align="center"><td>';
								echo '<a href="http://'.$adres_serwera_do_faktur.'/panel_dane/oferta_indywidualna_pliki/'.$plik_link.'/'.$plik_nazwa.'" target="_blank">'.$ikonka_pliku.'</a>';
							echo '</td></tr><tr align="center"><td>';
								echo '<a href="http://'.$adres_serwera_do_faktur.'/panel_dane/oferta_indywidualna_pliki/'.$plik_link.'/'.$plik_nazwa.'" target="_blank"><font color="red">'.$plik_nazwa.'</font></a>';
							echo '</td></tr></table>';
							}
						}
					echo '</td>';
					}
				if($licz == $ilosc_kolumn) 
					{
					echo '</tr>';	
					$licz=0;
					}
				} // do for($z=1; $z<=9; $z++) 
			echo '</table>';
		echo '</td></tr>';
		}
	echo '<tr bgcolor="'.$kolor_szary.'"><td colspan="6">Nazwa pliku <font color="blue">niebieska</font> - plik stały z ustawień, nazwa pliku <font color="green">zielona</font> - plik jednorazowy, nazwa pliku <font color="red">czerwona</font> - plik zarchiwizowany.</td></tr>';
	echo '</table>';
	}



//#####################################################  wysyłamy nową ofertę   #######################################################
if($wyslij == 1)
	{
	//######################### ładujemy plik na serwer
	//$uploaddir = '../panel_dane/oferta_indywidualna_pliki_temp/'; // katalog gdzie ma został zapisany plik
	//jak dorzucamy nowy plik to tworzymy katalog
	$mozna_wysylac = 0;
	$oferta_plik = $_FILES['plik']['name'];
	if($oferta_plik != '')
		{
		//echo 'Próba ładowania pliku<br>';
		$dzis_godzina = date('d-m-Y___H_i_s', $time);
		$folder = $id.'___'.$dzis_godzina;
		mkdir ("../panel_dane/oferta_indywidualna_pliki_temp/$folder", 0777);
		$uploaddir = '../panel_dane/oferta_indywidualna_pliki_temp/'.$folder.'/';
		
		//usuwamy polskie znaki z nazwy pliku
		$oferta_plik = usun_polskie($oferta_plik);
		
		if(move_uploaded_file($_FILES['plik']['tmp_name'], $uploaddir.$oferta_plik))
			{
			echo '<br><div class="text_duzy"><font color="blue">Plik został załadowany. </font></div><br>';
			$query = mysqli_query($conn, "INSERT INTO oferta_indywidualna_pliki (`typ`, `plik_nazwa`, `link`) VALUES ('temp', '$oferta_plik', '$folder');");
			$dolaczony_plik_temp = mysqli_insert_id($conn);
			}
		else
			{
			echo '<br><div class="text_duzy"><font color="red">Plik NIE został załadowany! Oferta nie została wysłana. Proszę spróbować jeszcze raz.</font></div><br>';
			$mozna_wysylac = 1;
			}
		} // do  if($oferta_plik != '')


	//######################################## wysyłamy ofertę #############################
	if($mozna_wysylac == 0)
		{
		$pytanie3 = mysqli_query($conn, "SELECT * FROM suwaki where typ = 'tresc_oferty_indywidualnej';");
		while($wynik3= mysqli_fetch_assoc($pytanie3))
			$tresc_oferty_indywidualnej=$wynik3['opis'];
		

		$pytanie77 = mysqli_query($conn, "SELECT nazwa FROM klienci WHERE id = ".$id.";");
		while($wynik77= mysqli_fetch_assoc($pytanie77))
			$klient_nazwa=$wynik77['nazwa'];
		
		$query = mysqli_query($conn, "INSERT INTO oferta_indywidualna (`klient_id`,`klient_nazwa`, `user_id`, `data` , `data_time` , `email`, `tytul_oferty`) VALUES ('$id', '$klient_nazwa', '$zalogowany_user', '$dzis', '$time', '$email', '$tytul_oferty');");
		$oferta_id = mysqli_insert_id($conn);
	
		//sprawdzam które pliki z ustawień zostały dołączone.
		$ilosc_plikow = 0;
		$pytanie = mysqli_query($conn, "SELECT * FROM oferta_indywidualna_pliki ORDER BY kolejnosc ASC;");
		while($wynik= mysqli_fetch_assoc($pytanie))
			{
			$ilosc_plikow++;
			$plik_id[$ilosc_plikow]=$wynik['id'];
			$plik_opis[$ilosc_plikow]=$wynik['opis'];
			$plik_nazwa[$ilosc_plikow]=$wynik['plik_nazwa'];
			}
	

		//########################### wysylka email ###################################################################################################################################################
		$pytanie33 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$id.";");
		while($wynik33= mysqli_fetch_assoc($pytanie33))
			{
			$klient_nazwa=$wynik33['nazwa'];
			$klient_login=$wynik33['login'];
			$klient_haslo=$wynik33['haslo'];
			}


		$from_emailaddress = "biuro@arcus-luki.pl";
		$subject = $tytul_oferty;
		// $subject = "=?UTF-8?B?".base64_encode($subject)."?=";
		
		$tresc_maila = '<html><head>';
		$tresc_maila .= '<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">';
		$tresc_maila .= '<META HTTP-EQUIV="Content-Language" CONTENT="pl">';
		$tresc_maila .= '<link rel="stylesheet" type="text/css" href="http://www.arcus-luki.nazwa.pl/panel_dane/style.css"></head>';
		
		$tresc_maila .= $tresc_oferty_indywidualnej;


		$tresc_maila .= '<br><center>ARCUS S. C.<br>Podwiesk 65D<br>86-200 Chełmno<br><br>Telefon 52/522-22-02<br>Fax 52/569-10-38<br><br></center></html>';
		// $tresc_maila = iconv('UTF-8','windows-1250//TRANSLIT', $tresc_maila);
		
		//w przypadku działania z panelu lokalnego, email zawsze idzie na lokalny adres email.
		if($adres_ip == '127.0.0.1') $email = $lokalny_adres_email;

		//new phpmailer v6.16
		require 'phpmailer6/src/Exception.php';
		require 'phpmailer6/src/PHPMailer.php';
		require 'phpmailer6/src/SMTP.php';

		$mail = new PHPMailer\PHPMailer\PHPMailer();
		$mail->CharSet = "UTF-8";
		$mail->FromName = 'ARCUS | Biuro';
		$mail->From = $from_emailaddress;
		$mail->AddAddress($email);
		$mail->AddReplyTo($from_emailaddress,"Arcus");
		$mail->Subject = $subject;
		$mail->IsHTML(true);
		$mail->Body = $tresc_maila;
		$mail->setLanguage('pl');
		
		// załączniki 
		for($x = 1; $x <= $ilosc_plikow; $x++)
			if($dolacz_plik_id[$plik_id[$x]] == 'on') 
				{
				$query = mysqli_query($conn, "INSERT INTO oferta_indywidualna_wyslane_pliki (`oferta_id`, `plik_id`) VALUES ('$oferta_id', '$plik_id[$x]');");
				
				$pytanie88 = mysqli_query($conn, "SELECT * FROM oferta_indywidualna_pliki WHERE id = ".$plik_id[$x].";");
				while($wynik88= mysqli_fetch_assoc($pytanie88))
					{
					$plik_link=$wynik88['link'];
					$plik_nazwa=$wynik88['plik_nazwa'];
					}
				$plik_sciezka= '../panel_dane/oferta_indywidualna_pliki/'.$plik_nazwa;
				$mail->AddAttachment($plik_sciezka, $plik_nazwa);
				}

		
		//sprawdzamy czy został dołączony tymczasowy plik
		if($dolaczony_plik_temp != '') 
			{
			$query = mysqli_query($conn, "INSERT INTO oferta_indywidualna_wyslane_pliki (`oferta_id`, `plik_id`) VALUES ('$oferta_id', '$dolaczony_plik_temp');");
			$pytanie88 = mysqli_query($conn, "SELECT * FROM oferta_indywidualna_pliki WHERE id = ".$dolaczony_plik_temp.";");
			while($wynik88= mysqli_fetch_assoc($pytanie88))
				{
				$plik_link=$wynik88['link'];
				$plik_nazwa=$wynik88['plik_nazwa'];
				}
			$plik_sciezka= '../panel_dane/oferta_indywidualna_pliki_temp/'.$plik_link.'/'.$plik_nazwa;
			$mail->AddAttachment($plik_sciezka, $plik_nazwa);
			}
		
		if(!$mail->Send()) 
			{
			$error_info = $mail->ErrorInfo;
			$strona = 'klienci_edycja_oferta_indywidualna.php';
			$napis_oferta = 'Oferta id='.$oferta_id;
			//show_mail_send_error_info: bład, page, nr faktury czy nr zamowienia, adres odbiorcy
			show_mail_send_error_info($error_info, $strona, $napis_oferta, $email);
			} 	
		else 
			{
			echo '<br><div class="text_duzy"><font color="blue">Oferta została wysłana poprawnie.</font></div><br>';
			$pytanie122 = mysqli_query($conn, "UPDATE klienci SET data_ostatniej_oferty = '".$time."' WHERE id = ".$id.";");
			$pytanie122 = mysqli_query($conn, "UPDATE klienci SET ostatnio_uzyty_oferty = '".$email."' WHERE id = ".$id.";");

			if($skad == 'klienci') 
				{
				//echo '<meta http-equiv="refresh" content="0.1; URL=index.php?page=klienci&jak=DESC&wg_czego=id&oferta_wyslana=tak">';
				echo '<meta http-equiv="refresh" content="0.1; URL=index.php?page=klienci_edycja2&id='.$id.'&jak=DESC&wg_czego=id&pod_page=klienci_edycja_oferta_indywidualna&nowa_oferta=1&skad='.$skad.'&powrot='.$powrot.'&oferta_wyslana=tak">';
				}
			}
		
		}
	else echo '<br><div class="text_duzy"><font color="red">Oferta nie została wysłana. Proszę spróbować jeszcze raz.</font></div><br>';
	
	}
//#####################################################  tworzymy nową ofertę   ####################################################### 
if($nowa_oferta == 1)
	{
	include("php/lista_emaili_oferta.php");


	$pytanie34 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$id.";");
	while($wynik34= mysqli_fetch_assoc($pytanie34))
		{
		$klient_login=$wynik34['login'];
		$klient_haslo=$wynik34['haslo'];
		}

		echo '<table width="100%" align="left" border="0" class="text"><tr><td>';
	
		echo '<FORM action="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&pod_page=klienci_edycja_oferta_indywidualna&wyslij=1" method="post" enctype="multipart/form-data">';
		echo '<INPUT type="hidden" name="pod_page" value="'.$pod_page.'">';
		echo '<INPUT type="hidden" name="id" value="'.$id.'">';
		echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
		echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
		echo '<INPUT type="hidden" value="'.$page.'">';
		echo '<INPUT type="hidden" name="wyslij" value="1">';
		echo '<INPUT type="hidden" name="skad" value="'.$skad.'">';
		echo '<INPUT type="hidden" name="powrot" value="'.$powrot.'">';
		
		$pytanie3 = mysqli_query($conn, "SELECT * FROM suwaki where typ = 'tytul_oferty_indywidualnej';");
		while($wynik3= mysqli_fetch_assoc($pytanie3))
			$tytul_oferty=$wynik3['opis'];

		$pytanie3 = mysqli_query($conn, "SELECT * FROM suwaki where typ = 'tresc_oferty_indywidualnej';");
		while($wynik3= mysqli_fetch_assoc($pytanie3))
			$tresc_oferty_indywidualnej=$wynik3['opis'];

	
		echo '<br><table width="85%" align="left" border="1" class="text" BORDERCOLOR="black" frame="box" RULES="all">';
		echo '<tr class="text_duzy"><td width="100%" align="center" bgcolor="#e24139" colspan="2">Wyślij ofertę indywidualną.</td><tr>';
		echo '<tr class="text" height="30px"><td width="15%" align="right" bgcolor="#e24139">Temat :&nbsp;&nbsp;</td>';
		echo '<td width="85%" align="left" bgcolor="white">&nbsp;&nbsp;<input type="text" name="tytul_oferty" value="'.$tytul_oferty.'" class="pole_input_biale" size="120" maxlength="150" autocomplete="off"></td><tr>';
		echo '<tr class="text" height="30px"><td align="right" bgcolor="#e24139">Nadawca :&nbsp;&nbsp;</td><td align="left" bgcolor="white">&nbsp;&nbsp;biuro@arcus-luki.pl</td><tr>';
		echo '<tr class="text" height="30px"><td align="right" bgcolor="#e24139">Adresat :&nbsp;&nbsp;</td><td align="left" bgcolor="white">&nbsp;&nbsp;';
			echo '<select name="email" class="pole_input_biale" style="width: 200px" >';
			for ($k=1; $k<=$ilosc_email; $k++) 
			if($klient_email_ostatni == $klient_email[$k]) echo '<option selected="selected" value="'.$klient_email[$k].'">'.$klient_email[$k].'</option>';
			elseif($linia_rozdzielajaca == $klient_email[$k]) echo '<option value="'.$klient_email[$k].'" disabled>'.$klient_email[$k].'</option>';
			else echo '<option value="'.$klient_email[$k].'">'.$klient_email[$k].'</option>';
			echo '</select>';
		echo '</td><tr>';
		//załączniki
		echo '<tr class="text" height="30px"><td align="right" bgcolor="#e24139">Załącznik :&nbsp;&nbsp;</td><td align="left" bgcolor="white" valign="middle">';
			// tabela z plikami
			$ilosc_plikow = 0;
			$pytanie = mysqli_query($conn, "SELECT * FROM oferta_indywidualna_pliki WHERE typ = 'staly' ORDER BY kolejnosc ASC;");
			while($wynik= mysqli_fetch_assoc($pytanie))
				{
				$ilosc_plikow++;
				$plik_id[$ilosc_plikow]=$wynik['id'];
				$kolejnosc[$ilosc_plikow]=$wynik['kolejnosc'];
				$plik_opis[$ilosc_plikow]=$wynik['opis'];
				$plik_nazwa[$ilosc_plikow]=$wynik['plik_nazwa'];
				}
			//######## tabela z załącznikami
			echo '<table border="0" width="100%" align="center"><tr><td width="40%">';
				echo '<table border="0" align="left" class="text" cellpadding="5" cellspacing="5" width="100%">';
				for($x=1; $x<=$ilosc_plikow; $x++) 
					{
					$dolacz_plik_id = 'dolacz_plik_id['.$plik_id[$x].']';
					echo '<tr bgcolor="'.$kolor_bialy.'"><td><input type="checkbox" checked name="'.$dolacz_plik_id.'"></td>';
					echo '<td width="100%">'.$plik_opis[$x].' - <font color="blue">'.$plik_nazwa[$x].'</font></td></tr>';
					}
				echo '</table>';
			echo '</td><td width="60%">';
				//##################### Tymczasowy załącznik
				echo '<table border="0" align="center" cellspacing="3" cellpadding="3" class="text" width="100%"><tr><td align="center">Wybierz tymczasowy plik który chcesz załączyć do oferty.</td></tr>';
				echo '<tr align="center"><td><input type="file" name="plik"></td></tr>';
				echo '</table>';
			echo '</td></tr></table>';
		echo '</td><tr>';
		//załączniki KONIEC 
	
		echo '<tr class="text"><td align="right" bgcolor="#e24139">Treść :&nbsp;</td><td align="left" bgcolor="white" height="150px" valign="top">';
			echo '<table width="100%" align="left" border="0" class="text" cellpadding="4"><tr valign="middle"><td align="left">';
			echo $tresc_oferty_indywidualnej;
			echo '<br><center>ARCUS S. C.<br>Podwiesk 65D<br>
				86-200 Chełmno<br><br>Telefon 52/522-22-02<br>Fax 52/569-10-38<br><br><br>
				Zapraszamy do logowania się w panelu klienta pod adresem -> http://klienci.arcus-luki.pl<br>
				<b>Login : '.$klient_login.'<br>Hasło : '.$klient_haslo.'<br></b>
				</center>';
			echo '</td></tr></table>';
		echo '</td><tr>';
			if($ilosc_email != 0) echo '<tr class="text" height="30px" bgcolor="#e24139"><td align="right"></td><td align="center" valign="middle"><button type="submit" class="text" name="submit">Wyślij nową ofertę</button></td><tr>';
			else echo '<tr class="text_duzy_czerwony"><td width="100%" align="center" bgcolor="black" colspan="2">BRAK ADRESU E-MAIL NABYWCY!</td><tr>';
			if(($user_id == 1) && ($adres_ip == '127.0.0.1')) echo '<tr class="text" bgcolor="#ff41f9" align="center"><td colspan="2">Działamy lokalnie. Faktycznie wysyłka nastąpi na : '.$lokalny_adres_email.'</td><tr>';

		echo '</form>';
		echo '</table>';
	echo '</tr></td><tr><td align="center">';
		if($powrot == 'lista_straconych') echo '<br><br><a href="index.php?page=lista_straconych_klientow&wg_czego='.$_REQUEST['wg_czego'].'&jak='.$_REQUEST['jak'].'">Powrót - Lista straconych klientów</a>';
	echo '</td></tr></table>';

	}
else
	{
	
	if($zmien == 1)
		{
		//zmieniam ewentualne przecinki na kropkę
		$wygiecie_ramy_z_pvc = change($wygiecie_ramy_z_pvc);
		$wygiecie_skrzydla_z_pvc = change($wygiecie_skrzydla_z_pvc);
		$wygiecie_listwy_z_pvc = change($wygiecie_listwy_z_pvc);
		$wygiecie_innego_elementu_z_pvc = change($wygiecie_innego_elementu_z_pvc);
		$wygiecie_ramy_z_alu = change($wygiecie_ramy_z_alu);
		$wygiecie_skrzydla_z_alu = change($wygiecie_skrzydla_z_alu);
		$wygiecie_listwy_z_alu = change($wygiecie_listwy_z_alu);
		$wygiecie_innego_elementu_z_alu = change($wygiecie_innego_elementu_z_alu);
		$wygiecie_wzmocnienia_okiennego = change($wygiecie_wzmocnienia_okiennego);
		$wygiecie_innego_elementu_ze_stali = change($wygiecie_innego_elementu_ze_stali);
		$zgrzanie = change($zgrzanie);
		$wyfrezowanie_odwodnienia = change($wyfrezowanie_odwodnienia);
		$wstawienie_slupka = change($wstawienie_slupka);
		$dociecie_listwy_przyszybowej = change($dociecie_listwy_przyszybowej);

		$wstawienie_slupka_ruchomego = change($wstawienie_slupka_ruchomego);
		$dociecie_kompletu_listew_przyszybowych = change($dociecie_kompletu_listew_przyszybowych);
		$okucie = change($okucie);
		$zaszklenie = change($zaszklenie);
		$wykonanie_innej_uslugi = change($wykonanie_innej_uslugi);
		$oscieznica = change($oscieznica);
		$skrzydlo = change($skrzydlo);
		$listwa = change($listwa);
		$slupek = change($slupek);
		$wzmocnienie_do_ramy = change($wzmocnienie_do_ramy);
		$wzmocnienie_do_skrzydla = change($wzmocnienie_do_skrzydla);
		$wzmocnienie_do_slupka = change($wzmocnienie_do_slupka);
		$wzmocnienie_do_luku = change($wzmocnienie_do_luku);
		$okucia = change($okucia);
		$szyby = change($szyby);
		$inny_element = change($inny_element);
			

		$modyfikuj=mysqli_query($conn, "update klienci set wygiecie_ramy_z_pvc=".$wygiecie_ramy_z_pvc.", wygiecie_skrzydla_z_pvc=".$wygiecie_skrzydla_z_pvc.", wygiecie_listwy_z_pvc=".$wygiecie_listwy_z_pvc.", wygiecie_innego_elementu_z_pvc=".$wygiecie_innego_elementu_z_pvc.", wygiecie_ramy_z_alu=".$wygiecie_ramy_z_alu.", wygiecie_skrzydla_z_alu=".$wygiecie_skrzydla_z_alu.", wygiecie_listwy_z_alu=".$wygiecie_listwy_z_alu.", wygiecie_innego_elementu_z_alu=".$wygiecie_innego_elementu_z_alu.", wygiecie_wzmocnienia_okiennego=".$wygiecie_wzmocnienia_okiennego.", wygiecie_innego_elementu_ze_stali=".$wygiecie_innego_elementu_ze_stali.", zgrzanie=".$zgrzanie.", wyfrezowanie_odwodnienia=".$wyfrezowanie_odwodnienia.", wstawienie_slupka=".$wstawienie_slupka.", dociecie_listwy_przyszybowej=".$dociecie_listwy_przyszybowej." WHERE id=".$id.";");

		$modyfikuj=mysqli_query($conn, "update klienci set wstawienie_slupka_ruchomego=".$wstawienie_slupka_ruchomego.", dociecie_kompletu_listew_przyszybowych=".$dociecie_kompletu_listew_przyszybowych.", okucie=".$okucie.", zaszklenie=".$zaszklenie.", wykonanie_innej_usługi=".$wykonanie_innej_uslugi.", oscieznica=".$oscieznica.", skrzydlo=".$skrzydlo.", listwa=".$listwa.", slupek=".$slupek.", wzmocnienie_do_ramy=".$wzmocnienie_do_ramy.", wzmocnienie_do_skrzydla=".$wzmocnienie_do_skrzydla.", wzmocnienie_do_slupka=".$wzmocnienie_do_slupka.", wzmocnienie_do_luku=".$wzmocnienie_do_luku.", okucia=".$okucia.", szyby=".$szyby.", inny_element=".$inny_element.", widoczny_cennik='".$widoczny_cennik."', widoczne_wyceny='".$widoczne_wyceny."' , opis_dla_cennika='".$opis_dla_cennika."' WHERE id=".$id.";");

		$result = mysqli_query($conn, "UPDATE rozne SET opis = ".$wysokosc_okna_cennika_klienta." WHERE typ = 'wysokosc_okna_cennika_klienta';");
		$result = mysqli_query($conn, "UPDATE rozne SET opis = ".$szerokosc_okna_cennika_klienta." WHERE typ = 'szerokosc_okna_cennika_klienta';");
	
		echo '<br><div class="text_blue" align="center">Cennik został zmieniony.</div>';
		
		}
	
	if((!$submit) && ($wyslane_oferty != 1))
		{
		echo '<br><div align="center" class="text_duzy_zielony">Cennik indywidualny</div>';
		$pytanie = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$id.";");
		while($wynik= mysqli_fetch_assoc($pytanie))
			{
			$wygiecie_ramy_z_pvc = number_format($wynik['wygiecie_ramy_z_pvc'], 2,'.','');
			$wygiecie_skrzydla_z_pvc = number_format($wynik['wygiecie_skrzydla_z_pvc'], 2,'.','');
			$wygiecie_listwy_z_pvc = number_format($wynik['wygiecie_listwy_z_pvc'], 2,'.','');
			$wygiecie_innego_elementu_z_pvc = number_format($wynik['wygiecie_innego_elementu_z_pvc'], 2,'.','');
			
			$wygiecie_ramy_z_alu = number_format($wynik['wygiecie_ramy_z_alu'], 2,'.','');
			$wygiecie_skrzydla_z_alu = number_format($wynik['wygiecie_skrzydla_z_alu'], 2,'.','');
			$wygiecie_listwy_z_alu = number_format($wynik['wygiecie_listwy_z_alu'], 2,'.','');
			$wygiecie_innego_elementu_z_alu = number_format($wynik['wygiecie_innego_elementu_z_alu'], 2,'.','');
		
			$wygiecie_wzmocnienia_okiennego = number_format($wynik['wygiecie_wzmocnienia_okiennego'], 2,'.','');
			$wygiecie_innego_elementu_ze_stali = number_format($wynik['wygiecie_innego_elementu_ze_stali'], 2,'.','');
			$zgrzanie = number_format($wynik['zgrzanie'], 2,'.','');
			$wyfrezowanie_odwodnienia = number_format($wynik['wyfrezowanie_odwodnienia'], 2,'.','');
			
			$wstawienie_slupka = number_format($wynik['wstawienie_slupka'], 2,'.','');
			$dociecie_listwy_przyszybowej = number_format($wynik['dociecie_listwy_przyszybowej'], 2,'.','');
			$wstawienie_slupka_ruchomego = number_format($wynik['wstawienie_slupka_ruchomego'], 2,'.','');
			$dociecie_kompletu_listew_przyszybowych = number_format($wynik['dociecie_kompletu_listew_przyszybowych'], 2,'.','');
			$okucie = number_format($wynik['okucie'], 2,'.','');
			$zaszklenie = number_format($wynik['zaszklenie'], 2,'.','');
			
			$wykonanie_innej_uslugi = number_format($wynik['wykonanie_innej_usługi'], 2,'.','');
			$oscieznica = number_format($wynik['oscieznica'], 2,'.','');
			$skrzydlo = number_format($wynik['skrzydlo'], 2,'.','');
			$listwa = number_format($wynik['listwa'], 2,'.','');
	
			$slupek = number_format($wynik['slupek'], 2,'.','');
			$wzmocnienie_do_ramy = number_format($wynik['wzmocnienie_do_ramy'], 2,'.','');
			$wzmocnienie_do_skrzydla = number_format($wynik['wzmocnienie_do_skrzydla'], 2,'.','');
			$wzmocnienie_do_slupka = number_format($wynik['wzmocnienie_do_slupka'], 2,'.','');
			
			$wzmocnienie_do_luku = number_format($wynik['wzmocnienie_do_luku'], 2,'.','');
			$okucia = number_format($wynik['okucia'], 2,'.','');
			$szyby = number_format($wynik['szyby'], 2,'.','');
			$inny_element = number_format($wynik['inny_element'], 2,'.','');
			$widoczny_cennik = $wynik['widoczny_cennik'];
			$widoczne_wyceny = $wynik['widoczne_wyceny'];
			$opis_dla_cennika = $wynik['opis_dla_cennika'];
			}	

			//pobieram dane cennika
			$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT opis FROM rozne WHERE typ = 'wysokosc_okna_cennika_klienta';"));
			$wysokosc_okna_cennika_klienta = $sql['opis'];

			$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT opis FROM rozne WHERE typ = 'szerokosc_okna_cennika_klienta';"));
			$szerokosc_okna_cennika_klienta = $sql['opis'];

		echo '<br><table border="0" width="80%" align="center"><tr align=center valign="top"><td>';

			echo '<FORM action="index.php?page='.$page.'" method="post">';
			echo '<INPUT type="hidden" name="pod_page" value="'.$pod_page.'">';
			echo '<INPUT type="hidden" name="id" value="'.$id.'">';
			echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
			echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
			echo '<INPUT type="hidden" name="szukaj" value="'.$szukaj.'">';
			echo '<INPUT type="hidden" name="szukaj_klienta" value="'.$szukaj_klienta.'">';
			echo '<INPUT type="hidden" name="zmien" value="1">';
			
			echo '<table width="100%" align="center" border="0" cellpadding="5">';
			//#######################################################################################################       CENNIK           ####################################################################################################################
			echo '<tr class="text" align="center"><td align="right" class="text" width="40%">Wygięcie ramy z pvc : </td><td align="left" width="60%"><input type="text" name="wygiecie_ramy_z_pvc" value="'.$wygiecie_ramy_z_pvc.'" title="Wygięcie ramy z pvc" alt="Wygięcie ramy z pvc" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td align="right" class="text">Wygięcie skrzydła z pvc : </td><td align="left"><input type="text" name="wygiecie_skrzydla_z_pvc" value="'.$wygiecie_skrzydla_z_pvc.'" title="Wygięcie skrzydła z pvc" alt="Wygięcie skrzydła z pvc" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td align="right" class="text">Wygięcie listwy z pvc : </td><td align="left"><input type="text" name="wygiecie_listwy_z_pvc" value="'.$wygiecie_listwy_z_pvc.'" title="Wygięcie listwy z pvc" alt="Wygięcie listwy z pvc" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td align="right" class="text">Wygięcie innego elementu z pvc : </td><td align="left"><input type="text" name="wygiecie_innego_elementu_z_pvc" value="'.$wygiecie_innego_elementu_z_pvc.'" title="Wygięcie innego elementu z pvc" alt="Wygięcie innego elementu z pvc" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td colspan="2"><hr></td></tr>';
	
			echo '<tr class="text" align="center"><td align="right" class="text">Wygięcie ramy z alu : </td><td align="left"><input type="text" name="wygiecie_ramy_z_alu" value="'.$wygiecie_ramy_z_alu.'" title="Wygięcie ramy z alu" alt="Wygięcie ramy z alu" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td align="right" class="text">Wygięcie skrzydła z alu : </td><td align="left"><input type="text" name="wygiecie_skrzydla_z_alu" value="'.$wygiecie_skrzydla_z_alu.'" title="Wygięcie skrzydła z alu" alt="Wygięcie skrzydła z alu" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td align="right" class="text">Wygięcie listwy z alu : </td><td align="left"><input type="text" name="wygiecie_listwy_z_alu" value="'.$wygiecie_listwy_z_alu.'" title="Wygięcie listwy z alu" alt="Wygięcie listwy z alu" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td align="right" class="text">Wygięcie innego elementu z alu : </td><td align="left"><input type="text" name="wygiecie_innego_elementu_z_alu" value="'.$wygiecie_innego_elementu_z_alu.'" title="Wygięcie innego elementu z alu" alt="Wygięcie innego elementu z alu" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td colspan="2"><hr></td></tr>';
	
			echo '<tr class="text" align="center"><td align="right" class="text">Wygięcie wzmocnienia okiennego : </td><td align="left"><input type="text" name="wygiecie_wzmocnienia_okiennego" value="'.$wygiecie_wzmocnienia_okiennego.'" title="Wygięcie wzmocnienia okiennego" alt="Wygięcie wzmocnienia okiennego" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td align="right" class="text">Wygięcie innego elementu ze stali : </td><td align="left"><input type="text" name="wygiecie_innego_elementu_ze_stali" value="'.$wygiecie_innego_elementu_ze_stali.'" title="Wygięcie innego elementu ze stali" alt="Wygięcie innego elementu ze stali" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td align="right" class="text">Zgrzanie : </td><td align="left"><input type="text" name="zgrzanie" value="'.$zgrzanie.'" title="Zgrzanie" alt="Zgrzanie" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td align="right" class="text">Wyfrezowanie odwodnienia : </td><td align="left"><input type="text" name="wyfrezowanie_odwodnienia" value="'.$wyfrezowanie_odwodnienia.'" title="Wyfrezowanie odwodnienia" alt="Wyfrezowanie odwodnienia" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td colspan="2"><hr></td></tr>';
	
			echo '<tr class="text" align="center"><td align="right" class="text">Wstawienie słupka stałego: </td><td align="left"><input type="text" name="wstawienie_slupka" value="'.$wstawienie_slupka.'" title="Wstawienie słupka stałego" alt="Wstawienie słupka stałego" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td align="right" class="text">Wstawienie słupka ruchomego: </td><td align="left"><input type="text" name="wstawienie_slupka_ruchomego" value="'.$wstawienie_slupka_ruchomego.'" title="Wstawienie słupka ruchomego" alt="Wstawienie słupka ruchomego" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';

			echo '<tr class="text" align="center"><td align="right" class="text">Docięcie listwy przyszybowej tylko łukowej: </td><td align="left"><input type="text" name="dociecie_listwy_przyszybowej" value="'.$dociecie_listwy_przyszybowej.'" title="Docięcie listwy przyszybowej tylko łukowej" alt="Docięcie listwy przyszybowej tylko łukowej" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			
			echo '<tr class="text" align="center"><td align="right" class="text">Docięcie kompletu listew przyszybowych : </td><td align="left"><input type="text" name="dociecie_kompletu_listew_przyszybowych" value="'.$dociecie_kompletu_listew_przyszybowych.'" title="Docięcie listwy przyszybowej" alt="Docięcie listwy przyszybowej" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';


			echo '<tr class="text" align="center"><td align="right" class="text">Okucie : </td><td align="left"><input type="text" name="okucie" value="'.$okucie.'" title="Okucie" alt="Okucie" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td align="right" class="text">Zaszklenie : </td><td align="left"><input type="text" name="zaszklenie" value="'.$zaszklenie.'" title="Zaszklenie" alt="Zaszklenie" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td colspan="2"><hr></td></tr>';
	
			echo '<tr class="text" align="center"><td align="right" class="text">Wykonanie innej usługi : </td><td align="left"><input type="text" name="wykonanie_innej_uslugi" value="'.$wykonanie_innej_uslugi.'" title="Wykonanie innej usługi" alt="Wykonanie innej usługi" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td align="right" class="text">Ościeżnica : </td><td align="left"><input type="text" name="oscieznica" value="'.$oscieznica.'" title="Ościeżnica" alt="Ościeżnica" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td align="right" class="text">Skrzydło : </td><td align="left"><input type="text" name="skrzydlo" value="'.$skrzydlo.'" title="Skrzydło" alt="Skrzydło" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td align="right" class="text">Listwa : </td><td align="left"><input type="text" name="listwa" value="'.$listwa.'" title="Listwa" alt="Listwa" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td colspan="2"><hr></td></tr>';
	
			echo '<tr class="text" align="center"><td align="right" class="text">Słupek : </td><td align="left"><input type="text" name="slupek" value="'.$slupek.'" title="Słupek" alt="Słupek" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td align="right" class="text">Wzmocnienie do ramy : </td><td align="left"><input type="text" name="wzmocnienie_do_ramy" value="'.$wzmocnienie_do_ramy.'" title="Wzmocnienie do ramy" alt="Wzmocnienie do ramy" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td align="right" class="text">Wzmocnienie do skrzydła : </td><td align="left"><input type="text" name="wzmocnienie_do_skrzydla" value="'.$wzmocnienie_do_skrzydla.'" title="Wzmocnienie do skrzydła" alt="Wzmocnienie do skrzydła" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td align="right" class="text">Wzmocnienie do słupka : </td><td align="left"><input type="text" name="wzmocnienie_do_slupka" value="'.$wzmocnienie_do_slupka.'" title="Wzmocnienie do słupka" alt="Wzmocnienie do słupka" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td colspan="2"><hr></td></tr>';
	
			echo '<tr class="text" align="center"><td align="right" class="text">Wzmocnienie do łuku : </td><td align="left"><input type="text" name="wzmocnienie_do_luku" value="'.$wzmocnienie_do_luku.'" title="Wzmocnienie do łuku" alt="Wzmocnienie do łuku" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td align="right" class="text">Okucia : </td><td align="left"><input type="text" name="okucia" value="'.$okucia.'" title="Okucia" alt="Okucia" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td align="right" class="text">Szyby : </td><td align="left"><input type="text" name="szyby" value="'.$szyby.'" title="Szyby" alt="Szyby" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td align="right" class="text">Inny element : </td><td align="left"><input type="text" name="inny_element" value="'.$inny_element.'" title="Inny element" alt="Inny element" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
			echo '<tr class="text" align="center"><td colspan="2"><hr></td></tr>';		
			//#########################################################################################################################################################################################################################################
			
			echo '<tr><td align="center" colspan="2">';
			if($widoczny_cennik == 'on') $cennik_checked = 'checked'; else $cennik_checked = ''; 
				echo '<div align="center" class="text">Cennik widoczny dla klienta w panelu klienta <input type="checkbox" name="widoczny_cennik" '.$cennik_checked.'>';
			echo '</td></tr>';

			echo '<tr><td align="center" colspan="2">';
			if($widoczne_wyceny == 'on') $wyceny_checked = 'checked'; else $wyceny_checked = ''; 
				echo '<div align="center" class="text">Wyceny widoczne dla klienta w panelu klienta <input type="checkbox" name="widoczne_wyceny" '.$wyceny_checked.'>';
			echo '</td></tr>';

			//opis, uwagi dla cennika klienta
			echo '<tr><td align="center" colspan="2">';
				echo '<hr><table border="0" align="center"><tr><td colspan="2">';
					echo '<textarea class="text" name="opis_dla_cennika" rows="'.$wysokosc_okna_cennika_klienta.'" cols="'.$szerokosc_okna_cennika_klienta.'">'.$opis_dla_cennika.'</textarea>';
					echo '</td></tr>';

					echo '<tr><td width="50%">';
						echo '<table align="center" border="0"><tr class="text" align="right"><td width="50%">Szerokość okna : </td><td width="50%" align="left"><input type="text" size="5" maxlength="3" class="pole_input_right" autocomplete="off" name="szerokosc_okna_cennika_klienta" value="'.$szerokosc_okna_cennika_klienta.'"></td></tr></table>';
					echo '</td><td width="50%">';
						echo '<table align="center" border="0"><tr class="text" align="right"><td width="50%">Wysokość okna : </td><td width="50%" align="left"><input type="text" size="5" maxlength="2" class="pole_input_right" autocomplete="off" name="wysokosc_okna_cennika_klienta" value="'.$wysokosc_okna_cennika_klienta.'"></td></tr></table>';
					echo '</td></tr>';
				echo '</table>';
			echo '</td></tr>';



			// echo '<tr><td colspan="2" align="center"><hr><br><textarea class="text" name="opis_dla_cennika" rows="'.$wysokosc_okna_cennika.'" cols="'.$szerokosc_okna_cennika.'">'.$opis_dla_cennika.'</textarea><br></td></tr>';

			echo '<tr><td align="center" colspan="2">';
				echo '<button type="submit" class="text" name="submit">'.$kom_zmien_dane.'</button></td></tr>';
			echo '</table></FORM>';
	
		echo '</td></tr></table>';
		}

		if($wyslane_oferty != 1)
			{
			if($dodaj_wpis != 1) echo '<div align="center"><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&pod_page=klienci_edycja_oferta_indywidualna&nowa_oferta=1&skad=klienci">Nowa oferta</a></div><br>';
			echo '<div align="center"><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&pod_page=klienci_edycja_oferta_indywidualna&wyslane_oferty=1">Wysłane oferty</a></div><br>';
			}
		
	}
?>