<?php	
echo '<br><div align="center" class="text_duzy_zielony">'.$kom_dane_do_logowania.'</div>';
//pobieram dane do logowania z bazy
$sql = "SELECT login, haslo, nazwa FROM klienci WHERE id = ".$id.";";
$resultsql = mysqli_query($conn, $sql);
if(mysqli_num_rows($resultsql) > 0) 
	while ($wynik24 = mysqli_fetch_assoc($resultsql)) 
		{
		$haslo_z_bazy = $wynik24['haslo'];
		$login_z_bazy = $wynik24['login'];
		$nazwa_z_bazy = $wynik24['nazwa'];
		}

if($zmien == 1)
	{
	if($losowo == "on")
		{
		$nowy_login = change_znaki($nazwa_z_bazy);
		$nowy_login = substr($nowy_login, 0, 8);
		//$nowy_login = strtoupper($nowy_login);
		$nowe_haslo1 = generate_password();
		
		$sql = mysqli_query($conn, "update klienci SET login = '".$nowy_login."' WHERE id = ".$id.";");
		echo '<div class="text_blue" align="center">'.$kom_login_zostal_zmieniony.'</div>';

		$sql = mysqli_query($conn, "update klienci SET haslo = '".$nowe_haslo1."' WHERE id = ".$id.";");
		echo '<div class="text_blue" align="center">'.$kom_haslo_zostalo_zmienione.'</div>';
		}
	else
		{
		if($login_z_bazy != $nowy_login)
			{
			$nowy_login = change_znaki($nowy_login)	;	
			$taki_login_istnieje = 0;
			//sprawdzam czy taki login juz istnieje u innego klienta
			$result = mysqli_query($conn, "SELECT id, login FROM klienci WHERE login = '".$nowy_login."' AND id <> ".$id.";");
			if(mysqli_num_rows($result) == 0)
				{
				$result = mysqli_query($conn, "update klienci SET login = '".$nowy_login."' WHERE id = ".$id.";");
				echo '<div class="text_blue" align="center">Login został zmieniony.</div>';
				}
			else
				{
				echo '<div align="center" class="text_red">Wybrany login : <font color="blue">'.$nowy_login.'</font> jest zajęty.</div>';
				}
			}
		
		if(($haslo_z_bazy == $stare_haslo) && ($nowe_haslo1 == $nowe_haslo2) && ($nowe_haslo1 != '') && ($nowe_haslo2 != ''))
			{
			$sql44 = mysqli_query($conn, "update klienci SET haslo = '".$nowe_haslo1."' WHERE id = ".$id.";");
			echo '<div class="text_blue" align="center">Hasło zostało zmienione.</div>';
			}
		else
			{
			if($haslo_z_bazy != $stare_haslo) echo '<div align="center" class="text_red">'.$kom_wpisane_haslo_jest_inne_niz_w_bazie.'</div>';
			if($nowe_haslo1 != $nowe_haslo2) echo '<div align="center" class="text_red">'.$kom_wpisane_hasla_sa_rozne.'</div>';
			}
		}
	}


if (!$submit)
	{
	$sql = "SELECT nazwa, login, haslo FROM klienci WHERE id = ".$id.";";
	$resultsql = mysqli_query($conn, $sql);
	if(mysqli_num_rows($resultsql) > 0) 
		while ($wynik24 = mysqli_fetch_assoc($resultsql)) 
			{
			$klient_nazwa = $wynik24['nazwa'];
			$klient_login = $wynik24['login'];
			$klient_haslo = $wynik24['haslo'];
			}		
	
	echo '<br><table border="0" width="80%" align="center"><tr align=center valign="top"><td>';

		echo '<FORM action="index.php?page='.$page.'" method="post">';
		echo '<INPUT type="hidden" name="pod_page" value="'.$pod_page.'">';
		echo '<INPUT type="hidden" name="id" value="'.$id.'">';
		echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
		echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
		echo '<INPUT type="hidden" name="zmien" value="1">';
		echo '<INPUT type="hidden" name="szukaj" value="'.$szukaj.'">';
		echo '<INPUT type="hidden" name="szukaj_klienta" value="'.$szukaj_klienta.'">';

		echo '<table width="100%" align="center" border="0" cellpadding="3">';
		echo '<tr class="text" align="center"><td align="right" width="50%">Login :</td><td align="left" width="50%"><input type="text" autocomplete="off" size="20" maxlength="60" class="pole_input" name="nowy_login" value="'.$klient_login.'"></td></tr>';
		echo '<tr class="text" align="center"><td align="right" width="50%">Stare hasło :</td><td align="left" width="50%"><input type="text" autocomplete="off" size="20" maxlength="20" class="pole_input" name="stare_haslo" value="'.$klient_haslo.'"></td></tr>';
		echo '<tr class="text" align="center"><td align="right" width="50%">Nowe hasło :</td><td align="left" width="50%"><input type="text" autocomplete="off" size="20" maxlength="20" class="pole_input" name="nowe_haslo1"></td></tr>';
		echo '<tr class="text" align="center"><td align="right" width="50%">Powtórz nowe hasło :</td><td align="left" width="50%"><input type="text" autocomplete="off" size="20"  maxlength="10" class="pole_input" name="nowe_haslo2"></td></tr>';
		echo '<tr class="text" align="center"><td align="right" width="50%">Losowy Login i hasło :</td><td align="left" width="50%"><input type="checkbox" name="losowo" class="pole_input">&nbsp;&nbsp;</td></tr>';
		echo '<tr><td align="center" colspan="2">';
		echo '<button type="submit" class="text" name="submit">'.$kom_zmien_dane.'</button>';
		echo '</td></tr></table></FORM>';

	echo '</td></tr></table>';
	}
?>