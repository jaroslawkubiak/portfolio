<?php


/*	
$ilosc_jpk=0;
$pytanie6 = mysqli_query($conn, "SELECT * FROM jpk_vat ORDER BY id ASC;");
while($wynik6= mysqli_fetch_assoc($pytanie6))
	{
	$ilosc_jpk++;
	$jpk_opis[$ilosc_jpk]=$wynik6['opis'];
	$jpk_kolumna[$ilosc_jpk]=$wynik6['kolumna'];
	}
*/

$SUMA_NETTO = 0;
$SUMA_BRUTTO = 0;
$ilosc_pozycji = 0;
$nazwa_produktu = [];
$ilosc_sztuk = [];
$pozycja_transport = [];
$wartosc_netto = [];
$wartosc_brutto = [];
$stawka_vat_np = [];
$stawka_vat = [];
$cena_netto_za_sztuke = [];
$nr_fv_wycena = [];
$data_fv_wycena = [];
$nazwa_pozycja = [];

$pytanie = mysqli_query($conn, "SELECT * FROM wyceny WHERE zamowienie_id = ".$zamowienie_id." AND korekta_fv = 'NIE' ORDER BY pozycja ASC;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$ilosc_pozycji++;
	$klient_id=$wynik['klient_id'];
	$nr_zamowienia=$wynik['nr_zamowienia'];
	$nazwa_produktu[$ilosc_pozycji]=$wynik['nazwa_produktu'];
	$ilosc_sztuk[$ilosc_pozycji]=$wynik['ilosc_sztuk'];
	$pozycja_transport[$ilosc_pozycji]=$wynik['pozycja_transport'];
	$cena_netto_za_sztuke[$ilosc_pozycji]=$wynik['cena_netto_za_sztuke'];

	if($wynik['vat'] == 'NP') 
		{
		$stawka_vat_np[$ilosc_pozycji] = 'NP'; 
		$stawka_vat[$ilosc_pozycji] = 0;
		}
	else 
		{
		$stawka_vat_np[$ilosc_pozycji] = $wynik['vat'];
		$stawka_vat[$ilosc_pozycji] = $wynik['vat'];
		}
	//dla pewnosci obliczamy jeszcze raz
	// $wartosc_netto[$ilosc_pozycji] = $ilosc_sztuk[$ilosc_pozycji] * $cena_netto_za_sztuke[$ilosc_pozycji];
	// $result = mysqli_query($conn, "UPDATE wyceny SET wartosc_netto = ".$wartosc_netto[$ilosc_pozycji]." WHERE zamowienie_id = ".$zamowienie_id." AND korekta_fv = 'NIE' AND pozycja = ".$ilosc_pozycji.";");
	$wartosc_netto[$ilosc_pozycji]=$wynik['wartosc_netto'];
	$SUMA_NETTO += $wartosc_netto[$ilosc_pozycji];

	//dla pewnosci obliczamy jeszcze raz
	// $wartosc_brutto[$ilosc_pozycji] = $wartosc_netto[$ilosc_pozycji] * ($stawka_vat[$ilosc_pozycji]/100) + $wartosc_netto[$ilosc_pozycji];
	// $result = mysqli_query($conn, "UPDATE wyceny SET wartosc_brutto = ".$wartosc_brutto[$ilosc_pozycji]." WHERE zamowienie_id = ".$zamowienie_id." AND korekta_fv = 'NIE' AND pozycja = ".$ilosc_pozycji.";");
	$wartosc_brutto[$ilosc_pozycji]=$wynik['wartosc_brutto'];
	$SUMA_BRUTTO += $wartosc_brutto[$ilosc_pozycji];

	$nr_fv_wycena[$ilosc_pozycji]=$wynik['nr_faktury'];
	$data_fv_wycena[$ilosc_pozycji]=$wynik['data_faktury'];
	
	if($pozycja_transport[$ilosc_pozycji] == 'tak')
		{
		$nazwa_produktu[$ilosc_pozycji] = 'Transport';
		$ilosc_sztuk[$ilosc_pozycji] = 1;
		$cena_netto_za_sztuke[$ilosc_pozycji] = $wartosc_netto[$ilosc_pozycji];
		}
	}

$pytanie22 = mysqli_query($conn, "SELECT * FROM fv_ustawienia;");
while($wynik22= mysqli_fetch_assoc($pytanie22))
	{
	$sprzedawca_nazwa=$wynik22['nazwa'];
	$sprzedawca_ulica=$wynik22['ulica'];
	$sprzedawca_miasto=$wynik22['miasto'];
	$sprzedawca_kod_pocztowy=$wynik22['kod_pocztowy'];
	$sprzedawca_nip=$wynik22['nip'];
	$sprzedawca_miejsce_wystawienia=$wynik22['miejsce_wystawienia'];
	$sprzedawca_konto_opis=$wynik22['konto_opis'];
	$sprzedawca_konto=$wynik22['konto'];
	$sprzedawca_konto_euro=$wynik22['konto_euro'];
	$sprzedawca_opis=$wynik22['opis'];
	$sprzedawca_email=$wynik22['email'];
	$sprzedawca_telefon=$wynik22['telefon'];
	$sprzedawca_www=$wynik22['www'];
	}
	
	
$pytanie3 = mysqli_query($conn, "SELECT * FROM rozne WHERE typ='nr_fv';");
while($wynik3= mysqli_fetch_assoc($pytanie3))
	$numer_fv=$wynik3['opis'];
	
	
$pytanie22 = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$klient_id.";");
while($wynik22= mysqli_fetch_assoc($pytanie22))
	{
	$nabywca_nazwa=$wynik22['pelna_nazwa'];
	$nabywca_ulica=$wynik22['ulica'];
	$nabywca_miasto=$wynik22['miasto'];
	$nabywca_kod_pocztowy=$wynik22['kod_pocztowy'];
	$nabywca_kraj=$wynik22['kraj'];
	$nabywca_nip=$wynik22['nip'];
	$nabywca_forma_platnosci=$wynik22['sposob_platnosci'];
	$nabywca_termin_platnosci_dni=$wynik22['termin_platnosci_dni'];
	$nabywca_nazwa_skrocona=$wynik22['nazwa'];
	$nabywca_ostatnio_uzyte_konto=$wynik22['ostatnio_uzyte_konto'];
	}	
		
		
// zaczynam wystawiac fakture
if($submit == 'Wystaw')
	{
	$wystawiamy_fv = 0;
	$faktura_juz_jest = 0;
	if($zmienic_sposob_platnosci == 'on')
		{
		$ins = mysqli_query($conn, "UPDATE klienci SET sposob_platnosci='".$sposob_platnosci."', termin_platnosci_dni='".$termin_platnosci."' WHERE id = ".$klient_id.";");
		echo '<div align="center" class="text_duzy_niebieski">Sposób płatności został zmieniony na "'.$sposob_platnosci.'".</div><br>';
		}
		
	if($nowa_informacja_o_fakturze != '')	
		{
		echo '<div class="text_green" align="center">Dodano nową informację o fakturze.</div>';
		$pytanie = mysqli_query($conn, "INSERT INTO suwaki (`typ`, `opis`)  values ('informacja_o_fakturze', '$nowa_informacja_o_fakturze');");
		$informacja_o_fakturze = $nowa_informacja_o_fakturze;
		}

	for($x = 1; $x<=$ilosc_pozycji; $x++) 
		if($pozycja[$x] == 'on') 
			{
			// echo 'szukamy id pozycji wyceny, pozycja =on<br>';
			$pytanie2 = mysqli_query($conn, "SELECT id FROM wyceny WHERE pozycja = ".$x." AND zamowienie_id =".$zamowienie_id.";");
			while($wynik2= mysqli_fetch_assoc($pytanie2))
				$pozycja_id=$wynik2['id'];

				$wystawiamy_fv = 1;
				//sprawdzamy czy nie było odśwież
				$pytanie33 = mysqli_query($conn, "SELECT * FROM fv_pozycje WHERE pozycja_id = ".$pozycja_id.";");
				while($wynik33= mysqli_fetch_assoc($pytanie33)) {
					$pozycja_fv_id=$wynik33['fv_id'];
					//sprawdzamy czy ta pozycja nie jest pozycją proformy
					$pytanie323 = mysqli_query($conn, "SELECT typ_dok FROM fv_naglowek WHERE id = ".$pozycja_fv_id." AND typ_dok = 'Faktura';");
					while($wynik323= mysqli_fetch_assoc($pytanie323)) {
						echo 'fv już jest!!!! <br>';
						$faktura_juz_jest = 1;
					}
				}
			}
			
			
	if(($wystawiamy_fv == 1) && ($faktura_juz_jest == 0))
		{
		//pobieram imie i nazwisko uzytkownika ktory wystawia fv
		$user_id = $_SESSION["USER_ID"];
		$pytanie33 = mysqli_query($conn, "SELECT * FROM uzytkownicy WHERE id = ".$user_id.";");
		while($wynik33= mysqli_fetch_assoc($pytanie33))
			{
			$user_imie = $wynik33['imie'];
			$user_nazwisko = $wynik33['nazwisko'];
			}
			
		$numer_faktury = $numer_fv.'/'.$AKTUALNY_ROK;
		$numer_fv++;
		$ins = mysqli_query($conn, "UPDATE rozne SET opis=".$numer_fv." WHERE typ = 'nr_fv';");
		
		$data = date('d-m-Y', $time);
		$data_rok = date('Y', $time);
		$data_miesiac = date('m', $time);
		if($data_miesiac != 10) $data_miesiac = zamien_dowolne_znaki($data_miesiac, '0', '');

		// obliczamy termin płatności
		$do_kiedy_termin_platnosci = $time + ($termin_platnosci * 86400); // 86400 to 1 dzień
		
		$kopia_nr = change_link($numer_faktury);
		$link_fv = 'faktura_'.$kopia_nr.'.pdf';		

		$faktura_juz_jest = 0;
		//sprawdzamy jeszcze raz czy ktoras z pozycji nie ma już nr fv
		for($x = 1; $x<=$ilosc_pozycji; $x++) 
			if($pozycja[$x] == 'on')
				{
					//szukamy id pozycji wyceny
					$pytanie2 = mysqli_query($conn, "SELECT id FROM wyceny WHERE pozycja = ".$x." AND zamowienie_id =".$zamowienie_id.";");
					while($wynik2= mysqli_fetch_assoc($pytanie2))
					{
						$pozycja_id=$wynik2['id'];
						//sprawdzamy czy ta pozycja nie ma juz wystawionej fv
						$pytanie33 = mysqli_query($conn, "SELECT fv_id FROM fv_pozycje WHERE pozycja_id = ".$pozycja_id.";");
						while($wynik33= mysqli_fetch_assoc($pytanie33))
						{
							$pozycja_fv_id=$wynik33['fv_id'];
							//sprawdzamy czy ta pozycja nie jest pozycją proformy
							$pytanie323 = mysqli_query($conn, "SELECT typ_dok FROM fv_naglowek WHERE id = ".$pozycja_fv_id." AND typ_dok = 'Faktura';");
							while($wynik323= mysqli_fetch_assoc($pytanie323)) 
								$faktura_juz_jest = 1;
						}
					}

				}

		if($faktura_juz_jest == 0)
			{
			//if(($kurs_euro != '') && ($kurs_euro != 0)) $waluta_na_fv = 'EUR'; else $waluta_na_fv = 'PLN';
			//zmieniamy ostatnio uzyte konto przy fv
			$ins = mysqli_query($conn, "UPDATE klienci SET ostatnio_uzyte_konto = '".$wybrane_konto."' WHERE id = ".$klient_id.";");
		
			$query = mysqli_query($conn, "INSERT INTO fv_naglowek (`nr_dok`, `typ_dok`, `waluta`, `pole_jpk`, `zamowienie_id`, `nabywca_id`, `nabywca_nazwa_skrocona`, `data_wystawienia`, `wartosc_netto_fv`, `vat`, `wartosc_brutto_fv`, `wplacono`, `zaplacona`, `link_folder`, `nazwa_pliku`, `data_wygenerowania_dokumentu`, `nabywca_nazwa`, `nabywca_ulica`, `nabywca_miasto`, `nabywca_kod_pocztowy`, `nabywca_nip`, `nabywca_sposob_platnosci`, `termin_platnosci`, `termin_platnosci_dni`, `data_wystawienia_time`, `data_wystawienia_miesiac`, `data_wystawienia_rok`, `data_zakonczenia_dostawy`, `user_id`, `user_imie`, `user_nazwisko`,`informacja_o_fakturze`, `konto`)
										values ('$numer_faktury', 'Faktura', 'PLN', '$pole_jpk', '$zamowienie_id', '$klient_id', '$nabywca_nazwa_skrocona', '$data', '0', '$stawka_vat_np[1]', '0', '0', 'nie', 'faktury', '$link_fv', '$data', '$nabywca_nazwa', '$nabywca_ulica', '$nabywca_miasto', '$nabywca_kod_pocztowy', '$nabywca_nip', '$sposob_platnosci', '$do_kiedy_termin_platnosci', '$termin_platnosci', '$time', '$data_miesiac', '$data_rok', '$data', '$user_id', '$user_imie', '$user_nazwisko', '$informacja_o_fakturze', '$wybrane_konto');");
			
			$fv_id = mysqli_insert_id($conn);

			//echo 'fv_id='.$fv_id.'<br>';
			$SUMA_NETTO = 0;
			$SUMA_BRUTTO = 0;
			for($x = 1; $x<=$ilosc_pozycji; $x++) 
			if($pozycja[$x] == 'on')
				{
				$SUMA_NETTO += $wartosc_netto[$x];
				$SUMA_BRUTTO += $wartosc_brutto[$x];
			
				$cena_brutto_za_sztuke[$x] = $cena_netto_za_sztuke[$x] + ($cena_netto_za_sztuke[$x] * $stawka_vat[$x]/100);
				$cena_brutto_za_sztuke[$x] = number_format($cena_brutto_za_sztuke[$x], 2,'.','');
				
				//szukamy id pozycji wyceny
				$pytanie2 = mysqli_query($conn, "SELECT id FROM wyceny WHERE pozycja = ".$x." AND zamowienie_id =".$zamowienie_id.";");
				while($wynik2= mysqli_fetch_assoc($pytanie2))
					$pozycja_id=$wynik2['id'];
				
				$ilosc_sztuk[$x] = change($ilosc_sztuk[$x]);
				$cena_netto_za_sztuke[$x] = change($cena_netto_za_sztuke[$x]);
				$cena_brutto_za_sztuke[$x] = change($cena_brutto_za_sztuke[$x]);
				$wartosc_netto[$x] = change($wartosc_netto[$x]);
				$wartosc_brutto[$x] = change($wartosc_brutto[$x]);
				$query = mysqli_query($conn, "INSERT INTO fv_pozycje (`fv_id`, `nr_fv`, `zamowienie_id`, `nabywca_id`, `pozycja`, `nazwa_produktu`, `jednostka`, `ilosc`, `cena_netto`, `vat`, `cena_brutto`, `wartosc_netto`, `wartosc_brutto`, `pozycja_id`) 
				values ('$fv_id', '$numer_faktury', '$zamowienie_id', '$klient_id', '$x', '$nazwa_produktu[$x]', '$jednostka[$x]', '$ilosc_sztuk[$x]', '$cena_netto_za_sztuke[$x]', '$stawka_vat_np[$x]', '$cena_brutto_za_sztuke[$x]', '$wartosc_netto[$x]', '$wartosc_brutto[$x]', '$pozycja_id');");

				mysqli_query($conn, "UPDATE wyceny SET nr_faktury = '".$numer_faktury."', data_faktury = '".$data."', data_faktury_time = '".$time."', data_faktury_miesiac = '".$data_miesiac."', data_faktury_rok = '".$data_rok."' WHERE zamowienie_id = ".$zamowienie_id." AND pozycja = ".$x.";");
				
				$SUMA_NETTO = number_format($SUMA_NETTO, 2,'.','');
				$SUMA_BRUTTO = number_format($SUMA_BRUTTO, 2,'.','');
				$SUMA_NETTO = change($SUMA_NETTO);
				$SUMA_BRUTTO = change($SUMA_BRUTTO);
				$ins = mysqli_query($conn, "UPDATE fv_naglowek SET wartosc_netto_fv = ".$SUMA_NETTO.", vat = '".$stawka_vat_np[$x]."', wartosc_brutto_fv = ".$SUMA_BRUTTO.", do_zaplaty = ".$SUMA_BRUTTO." WHERE id = ".$fv_id.";");
				
				} // do if($pozycja[$x] == 'on')
			echo '<div align="center" class="text_duzy_niebieski">Faktura '.$numer_faktury.' dla zamówienia '.$nr_zamowienia.' została wystawiona.</div><br>';
			include('php/generuj_fakture.php');


			//efakruta - wysyłam automatycznie
			if($efaktura != '')
				{
				$sql = "SELECT * FROM fv_naglowek WHERE id = ".$fv_id.";";
				$result = mysqli_query($conn, $sql);
				if(mysqli_num_rows($result) > 0) 
					while ($wynik2 = mysqli_fetch_assoc($result)) 
						{
						$nr_fv=$wynik2['nr_dok'];
						$link_faktura=$wynik2['nazwa_pliku'];
						$link_folder=$wynik2['link_folder'];
						$nabywca_id=$wynik2['nabywca_id'];
						$typ_dok_baza=$wynik2['typ_dok'];
						$faktura_euro=$wynik2['faktura_euro'];  //jezeli bedzie TAK to bedzie mozna drukowac te fv
						}
				
				
				$pytanie = mysqli_query($conn, "SELECT * FROM fv_ustawienia;");
				while($wynik= mysqli_fetch_assoc($pytanie))
					{
					$wysylka_fv_email_nadawca=$wynik['wysylka_fv_email_nadawca'];
					
					if($typ_dok_baza == 'Faktura')
						{
						$wysylka_fv_email_tytul=$wynik['wysylka_fv_email_tytul'];
						$wysylka_fv_email_tresc=$wynik['wysylka_fv_email_tresc'];
						}
						
					if($typ_dok_baza == 'Korekta')
						{
						$wysylka_fv_email_tytul=$wynik['wysylka_fv_email_tytul_korekta'];
						$wysylka_fv_email_tresc=$wynik['wysylka_fv_email_tresc_korekta'];
						}
						
					if($typ_dok_baza == 'Duplikat')
						{
						$wysylka_fv_email_tytul=$wynik['wysylka_fv_email_tytul_duplikat'];
						$wysylka_fv_email_tresc=$wynik['wysylka_fv_email_tresc_duplikat'];
						}
						
					if($typ_dok_baza == 'Proforma')
						{
						$wysylka_fv_email_tytul=$wynik['wysylka_fv_email_tytul_proforma'];
						$wysylka_fv_email_tresc=$wynik['wysylka_fv_email_tresc_proforma'];
						}
					}
				

				// wysylka fv na email
				$sciezka = '../panel_dane/'.$link_folder.'/'.$link_faktura;

				$wysylka_fv_email_tytul2 = $wysylka_fv_email_tytul.' : '.$nr_fv;
				// $wysylka_fv_email_tytul2 = "=?UTF-8?B?".base64_encode($wysylka_fv_email_tytul2)."?=";
				$tresc_maila = '<html><head>';
				$tresc_maila .= '<META HTTP-EQUIV="Content-type" CONTENT="text/html; charset=UTF-8">';
				$tresc_maila .= '<META HTTP-EQUIV="Content-Language" CONTENT="pl">';
				$tresc_maila .= '<link rel="stylesheet" type="text/css" href="http://www.arcus-luki.pl/panel_dane/style.css"></head>';
				$tresc_maila .= '<div align="left">';
				$tresc_maila .= $wysylka_fv_email_tresc;
				$tresc_maila .= '</div>';
				$tresc_maila .= '</html>';
				// $tresc_maila = iconv('UTF-8','windows-1250//TRANSLIT', $tresc_maila);
				
				//w przypadku działania z panelu lokalnego, email zawsze idzie na lokalny adres email.
				if($adres_ip == '127.0.0.1') $efaktura = $lokalny_adres_email;

				//new phpmailer v6.16
				require 'phpmailer6/src/Exception.php';
				require 'phpmailer6/src/PHPMailer.php';
				require 'phpmailer6/src/SMTP.php';

				$mail = new PHPMailer\PHPMailer\PHPMailer();
				$mail->CharSet = "UTF-8";
				$mail->FromName = 'ARCUS | Biuro';
				$mail->From = $wysylka_fv_email_nadawca;
				$mail->AddAddress($efaktura);
				$mail->AddReplyTo($wysylka_fv_email_nadawca,"Arcus");
				$mail->Subject = $wysylka_fv_email_tytul2;
				$mail->IsHTML(true);
				$mail->Body = $tresc_maila;
				$mail->setLanguage('pl');
				$mail->AddAttachment($sciezka, $link_faktura);

				if(!$mail->Send()) 
					{
					$error_info = $mail->ErrorInfo;
					$strona = 'fv_wystaw_fv.php';
					//show_mail_send_error_info: bład, page, nr faktury czy nr zamowienia, adres odbiorcy
					show_mail_send_error_info($error_info, $strona, $link_faktura, $efaktura);
					} 	
				else 
					{
					echo '<div align="center" class="text_duzy_zielony"><br>'.$kom_faktura_zostala_wyslana_na_adres.' : '.$efaktura.'</div>';
					$ins=mysqli_query($conn, "UPDATE fv_naglowek SET wyslana_przez_email = 'tak' WHERE id = ".$fv_id.";");
					$ins=mysqli_query($conn, "UPDATE fv_naglowek SET wyslana_przez_email_data = '".$time."' WHERE id = ".$fv_id.";");
					$ins=mysqli_query($conn, "UPDATE fv_naglowek SET wyslana_przez_email_user_id = ".$user_id." WHERE id = ".$fv_id.";");
					$ins=mysqli_query($conn, "UPDATE fv_naglowek SET wyslana_na_email = '".$efaktura."' WHERE id = ".$fv_id.";");
					$ins=mysqli_query($conn, "UPDATE fv_naglowek SET wyslana_na_email_przez_efakture = 'tak' WHERE id = ".$fv_id.";");
					$ins=mysqli_query($conn, "UPDATE klienci SET ostatnio_uzyty_faktury = '".$efaktura."' WHERE id = ".$nabywca_id.";");
					}
				}		

			echo '<center><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/faktury/'.$link_fv.'" target="_blank">'.$image_pdf_icon2.'</a></center>';
			
			if($skad == 'zlecenie_transportowe') echo $powrot_do_konkretnego_zlecenia_transportowego_edycja;
			else echo $powrot_do_zamowienia;
			} // do if($faktura_juz_jest == 0)
		else echo '<div align="center" class="text_duzy_czerwony">Nie można wystawić faktury.</div><br>'.$powrot_do_zamowienia;
		} // do if(($wystawiamy_fv == 1) && ($faktura_juz_jest == 0))
			
		elseif($faktura_juz_jest == 1) echo '<div align="center" class="text_duzy_czerwony">Zaznaczona pozycja ma już wystawioną fakturę.</div><br>'.$powrot_do_zamowienia;
		elseif($wystawiamy_fv == 0) 
			{
			echo '<div align="center" class="text_duzy_czerwony">Faktura NIE została wystawiona - brak zaznaczonych pozycji.</div><br>';
			echo '<div align="center"><a href="index.php?page=fv_wystaw&zamowienie_id='.$zamowienie_id.'&jak='.$jak.'&wg_czego='.$wg_czego.'">Powrót do wystawiania faktury</a></div>';
			}

	} 
else
	{
	//wyswietlamy formularz do wystawienia faktury
	$pozycja = [];

	if(($nabywca_ulica == '') || ($nabywca_miasto == '') || ($nabywca_kod_pocztowy == '') || ($nabywca_nip == '') || ($nabywca_forma_platnosci == '') || ($nabywca_nazwa == '')) $brak_danych_nabywcy = 1; else $brak_danych_nabywcy = 0;
	
	$nabywca_nip = zamien_dowolne_znaki($nabywca_nip, '-', '');

	if(($sprzedawca_nazwa == '') || ($sprzedawca_ulica == '') || ($sprzedawca_miasto == '') || ($sprzedawca_kod_pocztowy == '') || ($sprzedawca_nip == '') || ($sprzedawca_miejsce_wystawienia == '') || ($sprzedawca_konto == '') || ($sprzedawca_email == '')) $brak_danych_sprzedawcy = 1; else $brak_danych_sprzedawcy = 0;

	echo '<FORM action="index.php?page=fv_wystaw&zamowienie_id='.$zamowienie_id.'" method="post">';
	echo '<input type="hidden" name="zamowienie_id" value="'.$zamowienie_id.'">';
	echo '<input type="hidden" name="wg_czego" value="'.$wg_czego.'">';
	echo '<input type="hidden" name="jak" value="'.$jak.'">';
	//echo '<input type="hidden" name="kurs_euro" value="'.$kurs_euro.'">';
	echo '<input type="hidden" name="skad" value="'.$skad.'">';
	echo '<input type="hidden" name="id_zlec_transp" value="'.$id_zlec_transp.'">';
	echo '<input type="hidden" name="rodzaj_dokumentu" value="'.$rodzaj_dokumentu.'">';

	//if(($kurs_euro != '') && ($kurs_euro != 0)) $napis_euro = '<font color="red"> EURO </font>'; else $napis_euro = ' ';

	echo '<div align="center" class="text_ogromny">Wystaw fakturę do zamówienia : <font color="blue">'.$nr_zamowienia.'</font></div><br>';
	
	echo '<table width="1100px" align="center" class="text" border="0">';
	echo '<tr align="center" class="text"><td width="100%" colspan="2">';
		echo '<table width="100%" align="center" class="text" border="0">';
		echo '<tr align="center" class="text" valign="top"><td width="50%" align="left"><img src="images/arcus_logo_mini.png" height="100px"></td>';
		echo '<td width="50%" align="right">';
		echo 'Telefon: '.$sprzedawca_telefon.'<br>';
		echo 'e-mail: '.$sprzedawca_email.'<br><br>';
		echo $sprzedawca_www.'<br><br>';
		echo '</td></tr></table>';
	echo '<hr></td></tr>';
	
	echo '<tr class="text_duzy"><td width="50%" align="left">FAKTURA</td><td width="50%" align="right">Nr: '.$numer_fv.'/'.$AKTUALNY_ROK.'</td></tr>';
			
	echo '<tr width="100%"><td colspan="2"><hr></td></tr>';
	// dane sprzedawcy i nabywcy
	echo '<tr align="center" class="text"><td width="50%">';
		if($brak_danych_sprzedawcy == 1) $bg_color="red"; else $bg_color="white";
		echo '<table width="100%" align="center" class="text" BORDERCOLOR="black" frame="box" RULES="all"><tr bgcolor="'.$kolor_szary.'"><td align="center" class="text_duzy">SPRZEDAWCA</td></tr>';
			echo '<tr><td><table width="100%" align="center" border="0" bgcolor="'.$bg_color.'">';
				echo '<tr><td class="text_duzy" height="70px" valign="top">'.$sprzedawca_nazwa.'</td><tr>';
				echo '<tr><td class="text_sredni">'.$sprzedawca_ulica.'<br>';
				echo $sprzedawca_kod_pocztowy.' '.$sprzedawca_miasto.', Polska<br>';
				echo 'NIP '.$sprzedawca_nip.'<br>';
			echo '</td></tr></table>';
		echo '</td></tr></table>';
	echo '</td>';
	echo '<td width="50%">';
		if($brak_danych_nabywcy == 1) $bg_color="red"; else $bg_color="white";
		echo '<table width="100%" align="center" class="text" BORDERCOLOR="black" frame="box" RULES="all"><tr bgcolor="'.$kolor_szary.'"><td align="center" class="text_duzy">NABYWCA</td></tr>';
			echo '<tr><td><table width="100%" align="center" border="0" bgcolor="'.$bg_color.'">';
				echo '<tr><td class="text_duzy" height="70px" valign="top">'.$nabywca_nazwa.'</td><tr>';
				echo '<tr><td class="text_sredni">'.$nabywca_ulica.'<br>';
				echo $nabywca_kod_pocztowy.' '.$nabywca_miasto.', '.$nabywca_kraj.'<br>';
				echo 'NIP '.$nabywca_nip.'<br>';
			echo '</td></tr></table>';
		echo '</td></tr></table>';
	echo '</td></tr>';
	
	
	// dane
	$informacja_o_fakturze_id = [];
	$informacja_o_fakturze_opis = [];
	echo '<tr align="center" class="text"><td width="50%">';
		echo '<table width="100%" align="center" class="text" border="0" cellpadding="3" cellspacing="3">';
		echo '<tr class="text" align="left"><td width="40%">Miejsce wystawienia:</td><td colspan="2">'.$sprzedawca_miejsce_wystawienia.'</td></tr>';
		echo '<tr class="text" align="left"><td>Termin płatności:</td><td colspan="2">';
		
		echo '<select name="termin_platnosci" class="pole_input" style="width: 60px">';
		if($nabywca_termin_platnosci_dni == 1) echo '<option selected="selected">1</option>'; else echo '<option>1</option>';
		if($nabywca_termin_platnosci_dni == 3) echo '<option selected="selected">3</option>'; else echo '<option>3</option>';
		if($nabywca_termin_platnosci_dni == 7) echo '<option selected="selected">7</option>'; else echo '<option>7</option>';
		if($nabywca_termin_platnosci_dni == 14) echo '<option selected="selected">14</option>'; else echo '<option>14</option>';
		if($nabywca_termin_platnosci_dni == 21) echo '<option selected="selected">21</option>'; else echo '<option>21</option>';
		if($nabywca_termin_platnosci_dni == 28) echo '<option selected="selected">28</option>'; else echo '<option>28</option>';
		echo '</select> dni</td></tr>';

		if($nabywca_forma_platnosci == '') echo '<tr class="text" align="left"><td>Forma płatności:</td><td colspan="2"><font color="red">BRAK SPOSOBU PŁATNOŚCI</font></td></tr>';
		else 
			{
			echo '<tr class="text" align="left"><td>Forma płatności:</td><td>';
			// sposób płatności
			$ilosc_sposob_platnosci = 0;
			$pytanie3 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='sposob_platnosci' ORDER BY opis ASC;");
			while($wynik3= mysqli_fetch_assoc($pytanie3))
				{
				$ilosc_sposob_platnosci++;
				$sposob_platnosci_id[$ilosc_sposob_platnosci] = $wynik3['id'];
				$sposob_platnosci_opis[$ilosc_sposob_platnosci] = $wynik3['opis'];
				}
			echo '<select name="sposob_platnosci" class="pole_input" style="width: 180px">';
			echo '<option></option>';
			for ($k=1; $k<=$ilosc_sposob_platnosci; $k++) 
			if($nabywca_forma_platnosci == $sposob_platnosci_opis[$k]) echo '<option selected="selected" value="'.$sposob_platnosci_opis[$k].'">'.$sposob_platnosci_opis[$k].'</option>';
			else echo '<option value="'.$sposob_platnosci_opis[$k].'">'.$sposob_platnosci_opis[$k].'</option>';
			echo '</select>';
			echo '</td>';
			echo '<td width="50%" valign="middle"><input name="zmienic_sposob_platnosci" type="checkbox">zmienić na stałe?</td></tr>';
			}

		echo '</table>';
	echo '</td>';
	echo '<td width="50%" valign="top">';
		echo '<table width="100%" align="center" class="text" border="0" cellpadding="3" cellspacing="3">';
		$data = date('d-m-Y', $time);
		echo '<tr class="text" align="right"><td width="80%">Data wystawienia:</td><td width="20%">'.$data.'</td></tr>';
		echo '<tr class="text" align="right"><td>Data zakończenia dostawy/usług:</td><td>'.$data.'</td></tr>';
		echo '</table>';
	echo '</td></tr>';

	echo '<tr align="center" class="text"><td colspan="2" width="100%">';
		echo '<table width="100%" align="center" class="text" border="0" cellpadding="3" cellspacing="3">';
			echo '<tr><td width="150px">Informacja o fakturze:</td><td>';
			$ilosc_informacja_o_fakturze = 0;
			$pytanie3 = mysqli_query($conn, "SELECT * FROM suwaki WHERE typ='informacja_o_fakturze' ORDER BY opis ASC;");
			while($wynik3= mysqli_fetch_assoc($pytanie3))
				{
				$ilosc_informacja_o_fakturze++;
				$informacja_o_fakturze_id[$ilosc_informacja_o_fakturze] = $wynik3['id'];
				$informacja_o_fakturze_opis[$ilosc_informacja_o_fakturze] = $wynik3['opis'];
				}
			echo '<select name="informacja_o_fakturze" class="pole_input" style="width: 650px">';
			echo '<option></option>';
			for ($k=1; $k<=$ilosc_informacja_o_fakturze; $k++) 
			if($informacja_o_fakturze == $informacja_o_fakturze_opis[$k]) echo '<option selected="selected" value="'.$informacja_o_fakturze_opis[$k].'">'.$informacja_o_fakturze_opis[$k].'</option>';
			else echo '<option value="'.$informacja_o_fakturze_opis[$k].'">'.$informacja_o_fakturze_opis[$k].'</option>';
			echo '</select></td></tr>';


			echo '<tr class="text" align="left"><td>LUB</td><td><input autocomplete="off" type="text" size="40" maxlength="150" title="Informacja o fakturze" alt="Informacja o fakturze" class="pole_input" name="nowa_informacja_o_fakturze" value="'.$nowa_informacja_o_fakturze.'"></td></tr>';
		echo '</table>';
	echo '</td></tr>';


	// wykaz pozycji
	echo '<td width="100%" colspan="2">';
		echo '<table width="100%" align="center" class="text" border="1" BORDERCOLOR="black" frame="box" RULES="all" cellpadding="2" cellspacing="2">';
		echo '<tr class="text" align="center" bgcolor="'.$kolor_szary.'">';
		echo '<td width="10px">Lp.</td>';
		echo '<td>Towar / Usługa</td>';
		echo '<td width="50px">Jednostka</td>';
		echo '<td width="50px">'.$kol_ilosc.'</td>';
		echo '<td width="90px">Cena<br>netto</td>';
		echo '<td width="50px">VAT</td>';
		echo '<td width="90px">Cena<br>brutto</td>';
		echo '<td width="90px">Wartość<br>netto</td>';
		echo '<td width="90px">Wartość<br>brutto</td>';
		echo '<td width="80px" valign="middle">Pozycje';
		if($ilosc_pozycji >=2) 
			{
			$id_test = 'id_'.$zamowienie_id;
			echo '<input type="checkbox" id="'.$id_test.'" name="nazwa_wszystkie_pozycje" checked onClick="zaznacz_pozycje('.$zamowienie_id.')">';
			}
		echo '</td></tr>';
			
		echo '<INPUT type="hidden" name="ilosc_pozycji" id="'.$zamowienie_id.'" value="'.$ilosc_pozycji.'">';
		
		$czy_mozna_wystawiac_fv = 0;
		for($x = 1; $x<=$ilosc_pozycji; $x++)
			{
			echo '<tr class="text" align="center" bgcolor="white"><td width="10px">'.$x.'</td>';
			echo '<td align="left">'.$nazwa_produktu[$x].'</td>';
			echo '<td>';
				$nazwa_jednostka = 'jednostka['.$x.']';
				echo '<select name="'.$nazwa_jednostka.'" class="pole_input_biale">';
				for($k = 1; $k <= $DL_TABELA_LISTA_JEDNOSTEK; $k++)
				if($jednostka == $TABELA_LISTA_JEDNOSTEK[$k]) echo '<option selected="selected" value="'.$TABELA_LISTA_JEDNOSTEK[$k].'">'.$TABELA_LISTA_JEDNOSTEK[$k].'</option>';
				else echo '<option value="'.$TABELA_LISTA_JEDNOSTEK[$k].'">'.$TABELA_LISTA_JEDNOSTEK[$k].'</option>';
				echo '</select>';
			echo '</td>';
			$ilosc_sztuk[$x] = number_format($ilosc_sztuk[$x], 2,'.','');
			echo '<td align="right">'.$ilosc_sztuk[$x].'</td>';
			$cena_netto_za_sztuke[$x] = number_format($cena_netto_za_sztuke[$x], 2,'.','');
			echo '<td align="right">'.$cena_netto_za_sztuke[$x].'</td>';
			
			if($stawka_vat_np[$x] == 'NP') echo '<td>'.$stawka_vat_np[$x].'</td>'; else echo '<td>'.$stawka_vat[$x].'%</td>';
			
			$cena_brutto_za_sztuke[$x] = $cena_netto_za_sztuke[$x] + ($cena_netto_za_sztuke[$x] * $stawka_vat[$x]/100);
			$cena_brutto_za_sztuke[$x] = number_format($cena_brutto_za_sztuke[$x], 2,'.','');
			echo '<td align="right">'.$cena_brutto_za_sztuke[$x].'</td>';
			$waluta_na_fv = ' PLN';

			//sprawdzamy czy ktoras z wartosci pozycji wyceny nie jest rowna 0 - wtedy uniemozliwiamy wystawienie fv
			if(($wartosc_netto[$x] == 0) || ($wartosc_brutto[$x]  == 0) || ($wartosc_netto[$x] == '') || ($wartosc_brutto[$x]  == '')) $czy_mozna_wystawiac_fv++;
			
			if(($wartosc_netto[$x] == 0) || ($wartosc_netto[$x]  == '')) $zerowa_wartosc_netto[$x] = ' bgcolor="red" '; else $zerowa_wartosc_netto[$x] = '';
			if(($wartosc_brutto[$x] == 0) || ($wartosc_brutto[$x]  == '')) $zerowa_wartosc_brutto[$x] = ' bgcolor="red" '; else $zerowa_wartosc_brutto[$x] = '';

			$wartosc_netto[$x] = number_format($wartosc_netto[$x], 2,'.',' ');
			$wartosc_brutto[$x] = number_format($wartosc_brutto[$x], 2,'.',' ');
			echo '<td align="right" '.$zerowa_wartosc_netto[$x].'>'.$wartosc_netto[$x].'</td>';
			echo '<td align="right" '.$zerowa_wartosc_brutto[$x].'>'.$wartosc_brutto[$x].'</td>';


			$nazwa_pozycja = 'pozycja['.$x.']';
			if($nr_fv_wycena[$x] != '') 
				{
				$disabled = ' disabled="disabled" '; 
				$checked = ' ';
				$title = 'Nr faktury: '.$nr_fv_wycena[$x];
				}
				else 
				{
				$disabled = '';
				$checked = ' checked ';
				$title = '';
				}
			if($nr_fv_wycena[$x] == '') echo '<td><input name="'.$nazwa_pozycja.'" type="checkbox" '.$checked.' '.$disabled.' ></td></tr>';
			else echo '<td title="'.$title.'"><input type="checkbox" disabled="disabled"></td></tr>';
			}

		//$SUMA_BRUTTO = number_format($SUMA_BRUTTO, 2,'.','');
		echo '<tr class="text" align="center" bgcolor="white"><td colspan="6" align="left">Razem słownie: ';
		
		//if(($kurs_euro != '') && ($kurs_euro != 0)) $slownie_kwota = kwotaslownieeuro($SUMA_BRUTTO); else 
		
		$slownie_kwota = kwotaslownie($SUMA_BRUTTO);
		echo $slownie_kwota;
		echo '</td>';
		echo '<td align="right">Razem w '.$waluta_na_fv.': </td>';
		/*
		if(($kurs_euro != '') && ($kurs_euro != 0))
			{
			$SUMA_NETTO = $SUMA_NETTO/$kurs_euro;
			$SUMA_BRUTTO = $SUMA_BRUTTO/$kurs_euro;
			}
		*/
		$SUMA_NETTO = number_format($SUMA_NETTO, 2,'.',' ');
		$SUMA_BRUTTO = number_format($SUMA_BRUTTO, 2,'.',' ');
		
		echo '<td align="right" bgcolor="'.$kolor_szary.'">'.$SUMA_NETTO.'</td>';
		echo '<td align="right" bgcolor="'.$kolor_szary.'">'.$SUMA_BRUTTO.'</td>';
		echo '<td align="right"></td>';
		echo '</table>';
	echo '</td></tr>';
	
	
	// wybór konta
	echo '<tr align="center" class="text"><td colspan="2" width="100%">';
	
		echo 'Wybierz konto : ';
		echo '<select name="wybrane_konto" class="pole_input" style="width: 600px">';
		if($nabywca_ostatnio_uzyte_konto == $sprzedawca_konto) echo '<option value="'.$sprzedawca_konto.'" selected="selected">'.$sprzedawca_konto.'</option>';
		else echo '<option value="'.$sprzedawca_konto.'">'.$sprzedawca_konto.'</option>';
		
		if($nabywca_ostatnio_uzyte_konto == $sprzedawca_konto_euro) echo '<option value="'.$sprzedawca_konto_euro.'" selected="selected">'.$sprzedawca_konto_euro.'</option>';
		else echo '<option value="'.$sprzedawca_konto_euro.'">'.$sprzedawca_konto_euro.'</option>';
		echo '</select>';
	
	echo '</td></tr>';
	
	
	
	
	echo '<input type="hidden" name="pole_jpk" value="K_19">';
	/*
	//################################################ lista typów JPK    ################################################
	echo '<tr align="center" class="text"><td colspan="2" width="100%"><br><br>';
	
		echo '<div class="text_duzy_czerwony">Wybierz rodzaj sprzedaży</div><br>';
		echo '<select name="pole_jpk" class="pole_input_czerwone">';
		for ($k=1; $k<=$ilosc_jpk; $k++) 
		if($jpk_kolumna[$k] == 'K_19') echo '<option value="'.$jpk_kolumna[$k].'" selected="selected">'.$jpk_kolumna[$k].' - '.$jpk_opis[$k].'</option>';
		else echo '<option value="'.$jpk_kolumna[$k].'">'.$jpk_kolumna[$k].' - '.$jpk_opis[$k].'</option>';
		echo '</select><br><br>';
	echo '</td></tr>';	
	//##############################################################################################################
	*/
	
	echo '<tr align="center" class="text"><td colspan="2" width="100%">';
		if($brak_danych_sprzedawcy == 1) echo '<a href="index.php?page=fv_ustawienia&zamowienie_id='.$zamowienie_id.'&jak=DESC&wg_czego=id&skad=wystaw_fv"><font color="red" size="+2">Uzupełnij dane sprzedawcy!</a></font>';
		elseif($brak_danych_nabywcy == 1) echo '<a href="index.php?page=klienci_edycja&id='.$klient_id.'&zamowienie_id='.$zamowienie_id.'&jak=DESC&wg_czego=id&skad=wystaw_fv"><font color="red" size="+2">Uzupełnij dane nabywcy!</a></font>';
		elseif($czy_mozna_wystawiac_fv != 0) echo '<a href="index.php?page=wycena_edycja&zamowienie_id='.$zamowienie_id.'&jak=DESC&wg_czego=id"><font color="red" size="+2">Uzupełnij wartość wszystkich pozycji!</a></font>';
		else echo '<input type="submit" name="submit" value="Wystaw">';
	echo '</td></tr>';

	//info o efakturze
	//sprawdamy czy efaktura jest wybrana dla klienta
	$sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT efaktura FROM klienci WHERE id = ".$klient_id.";"));
	$efaktura = $sql['efaktura'];
	if($efaktura == 'on') 
	{
		echo '<tr align="center" class="text"><td colspan="2" width="100%">';

			$pytanie = mysqli_query($conn, "SELECT * FROM klienci_kontakt WHERE klient_id = ".$klient_id." AND dzial = 'Faktury' ORDER BY ID DESC LIMIT 1;");
			while($wynik= mysqli_fetch_assoc($pytanie))
				$klient_email_faktury=$wynik['email'];

			// $sql = mysqli_fetch_assoc(mysqli_query($conn, "SELECT ostatnio_uzyty_faktury FROM klienci WHERE id = ".$klient_id.";"));
			// $ostatnio_uzyty_faktury = $sql['ostatnio_uzyty_faktury'];

			// echo 'klient_email_faktury='.$klient_email_faktury.'<br>';
			// echo 'ostatnio_uzyty_faktury='.$ostatnio_uzyty_faktury.'<br>';
			
			if($klient_email_faktury != '') $adres_do_wysylki = $klient_email_faktury;
			// if($ostatnio_uzyty_faktury != '') $adres_do_wysylki = $ostatnio_uzyty_faktury;

			echo '<input type="hidden" name="efaktura" value="'.$adres_do_wysylki.'">';
			echo '<font color="blue">Klient ma zaznaczoną e-fakturę. Wystawiona faktura zostanie automatycznie wysłana na email : '.$adres_do_wysylki.'</font>';
		echo '</td></tr>';
	}

	
	echo '</table>';
	echo '</form>';
	
	echo '<br><div align="center"><a href="index.php?page=wycena_edycja&zamowienie_id='.$zamowienie_id.'&jak='.$jak.'&wg_czego='.$wg_czego.'">Powrót do edycji wyceny</a></div>';
	} // do else

?>