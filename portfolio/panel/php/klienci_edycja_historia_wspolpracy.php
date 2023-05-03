<?php	
echo '<br><div align="center" class="text_duzy_zielony">Historia współpracy</div><br>';
if($usun_wpis != '')
	{
	$sql = mysqli_query($conn, "DELETE FROM historia_wspolpracy WHERE id = ".$usun_wpis." LIMIT 1;");
	echo '<div class="text_blue" align="center">'.$kom_wpis_zostal_usuniety.'</div><br>';
	}
	
if($dodaj == 1)
	{
	$sql = mysqli_query($conn, "INSERT INTO historia_wspolpracy (`data`, `klient_id`, `user_id`, `opis`) values ('$time', '$klient_id', '$zalogowany_user', '$opis');");
	echo '<div class="text_blue" align="center">'.$kom_wpis_zostal_dodany.'</div><br>';
	}

if($dodaj_kontakt == 1) {
	$data_do_bazy = explode('-', $data_kontaktu);
	$data_kontaktu_time = mktime(0,0,0,$data_do_bazy[1], $data_do_bazy[0], $data_do_bazy[2]);
	$sql = mysqli_query($conn, "INSERT INTO historia_wspolpracy (`data`, `klient_id`, `user_id`, `opis`, `kontakt_data_dzien`, `kontakt_data_miesiac`, `kontakt_data_rok`, `kontakt_data_time`, `kontakt_data`) values ('$time', '$klient_id', '$zalogowany_user', '$opis', '$data_do_bazy[0]', '$data_do_bazy[1]', '$data_do_bazy[2]', '$data_kontaktu_time', '$data_kontaktu');");
	echo '<div class="text_blue" align="center">'.$kom_kontakt_zostal_zaplanowany.'</div><br>';
}


if (!$submit)
	{
	if($zaplanuj_kontakt == 1)
		{
		echo '<FORM action="index.php?page='.$page.'" method="post">';
		echo '<INPUT type="hidden" name="pod_page" value="'.$pod_page.'">';
		echo '<INPUT type="hidden" name="id" value="'.$id.'">';
		echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
		echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
		echo '<INPUT type="hidden" name="szukaj" value="'.$szukaj.'">';
		echo '<INPUT type="hidden" name="szukaj_klienta" value="'.$szukaj_klienta.'">';
		echo '<INPUT type="hidden" name="dodaj_kontakt" value="1">';
		echo '<INPUT type="hidden" name="klient_id" value="'.$id.'">';

		echo '<table border="0" width="60%" align="center">';

		echo '<tr><td align="center">';
		echo '<table cellspacing="1" cellpadding="0" border="0"><tr><td class="text">Data kontaktu
		<input type="text" maxlength="12" class="pole_input" autocomplete="off"  name="data_kontaktu" id="f_date_c" value="'.$data_kontaktu.'"/>
		</td></tr></table>';
		?>
		<script type="text/javascript">
		Calendar.setup({
			inputField     :    "f_date_c",     // id of the input field
			ifFormat       :    "%d-%m-%Y",      // format of the input field
			button         :    "f_date_c",  // trigger for the calendar (button ID)
			singleClick    :    true
		});
		</script>
		<?php
		echo '</td></tr>';

		echo '<tr align=center valign="top"><td>';
			echo '<textarea name="opis" cols="80" rows="4" class="pole_input_szare_ramka_opis">'.$opis.'</textarea>';
		echo '</td></tr>';


		echo '<tr><td align="center">';
		echo '<button type="submit" class="text" name="submit">Zaplanuj kontakt</button></td></tr>';
		echo '</FORM>';
		echo '</td></tr></table><br><br>';
		}



	if($dodaj_wpis == 1)
		{
		echo '<FORM action="index.php?page='.$page.'" method="post">';
		echo '<INPUT type="hidden" name="pod_page" value="'.$pod_page.'">';
		echo '<INPUT type="hidden" name="id" value="'.$id.'">';
		echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
		echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
		echo '<INPUT type="hidden" name="szukaj" value="'.$szukaj.'">';
		echo '<INPUT type="hidden" name="szukaj_klienta" value="'.$szukaj_klienta.'">';
		echo '<INPUT type="hidden" name="zmien" value="1">';
		echo '<INPUT type="hidden" name="dodaj" value="1">';
		echo '<INPUT type="hidden" name="klient_id" value="'.$id.'">';
		echo '<table border="0" width="60%" align="center"><tr align=center valign="top"><td>';
		echo '<textarea name="opis" cols="80" rows="6" class="pole_input_szare_ramka_opis">'.$opis.'</textarea>';
		echo '</td></tr>';
		echo '<tr><td align="center">';
		echo '<button type="submit" class="text" name="submit">Dodaj opis</button></td></tr>';
		echo '</FORM>';
		echo '</td></tr></table><br><br>';
		}
	
	$ilosc = 0;
	$sql = "SELECT * FROM historia_wspolpracy WHERE klient_id = ".$id." ORDER BY data DESC;";
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result) > 0) 
		while ($wynik = mysqli_fetch_assoc($result)) 
			{
			$ilosc++;
			$wpis_id[$ilosc]=$wynik['id'];
			$data_baza[$ilosc]=$wynik['data'];
			$user_id_baza[$ilosc]=$wynik['user_id'];
			$opis_baza[$ilosc]=$wynik['opis'];
			$kontakt_data_baza[$ilosc]=$wynik['kontakt_data'];
			

			$sql2 = "SELECT imie, nazwisko FROM uzytkownicy WHERE id = ".$user_id_baza[$ilosc].";";
			$result2 = mysqli_query($conn, $sql2);
			if(mysqli_num_rows($result2) > 0) 
				while ($wynik2 = mysqli_fetch_assoc($result2)) 
					{
					$user_baza_imie[$ilosc]=$wynik2['imie'];
					$user_baza_nazwisko[$ilosc]=$wynik2['nazwisko'];
					}
			}

	if($dodaj_wpis != 1) echo '<div align="center"><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_historia_wspolpracy&dodaj_wpis=1">Dodaj nowy wpis</a></div><br>';
	if($zaplanuj_kontakt != 1) echo '<div align="center"><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_historia_wspolpracy&zaplanuj_kontakt=1">Zaplanuj kontakt</a></div><br>';	
				


	echo '<table border="0" width="80%" class="tabela" align="center">';

	for ($x=1; $x<=$ilosc; $x++)
		{
		//echo '<table border="0" width="100%" align="center" class="tabela">';
		$data_temp = date('d-m-Y', $data_baza[$x]);
		echo '<tr class="text_sredni" bgcolor="'.$kolor_tabeli.'"><td align="center" width="10%">'.$data_temp.'</td><td align="left" width="90%">';
			echo '<table width="100% border="1"><tr class="text_sredni"><td>'.$user_baza_imie[$x].' '.$user_baza_nazwisko[$x].'</td>';
			if($kontakt_data_baza[$x]) echo '<td>Zaplanowany kontakt na '.$kontakt_data_baza[$x].'</td>';
			echo '<td width="10%" align="right"><a href="index.php?page=klienci_edycja2&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'&pod_page=klienci_edycja_historia_wspolpracy&usun_wpis='.$wpis_id[$x].'">'.$image_delete.'</a></td></tr></table>';
		echo '</td></tr>';
		
		echo '<tr class="text_sredni" bgcolor="'.$kolor_bialy.'"><td align="left" width="100%" colspan="2">'.$opis_baza[$x].'</td></tr>';
		//echo '</table>';
		}
	echo '</table>';
	}

?>