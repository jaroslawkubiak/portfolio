<?php	
echo '<br><div align="center" class="text_duzy_zielony">Cennik indywidualny</div>';

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

	$modyfikuj=mysqli_query($conn, "update klienci set okucie=".$okucie.", zaszklenie=".$zaszklenie.", wykonanie_innej_usługi=".$wykonanie_innej_usługi.", oscieznica=".$oscieznica.", skrzydlo=".$skrzydlo.", listwa=".$listwa.", slupek=".$slupek.", wzmocnienie_do_ramy=".$wzmocnienie_do_ramy.", wzmocnienie_do_skrzydla=".$wzmocnienie_do_skrzydla.", wzmocnienie_do_slupka=".$wzmocnienie_do_slupka.", wzmocnienie_do_luku=".$wzmocnienie_do_luku.", okucia=".$okucia.", szyby=".$szyby.", inny_element=".$inny_element.", wstawienie_slupka_ruchomego=".$wstawienie_slupka_ruchomego.", dociecie_kompletu_listew_przyszybowych=".$dociecie_kompletu_listew_przyszybowych." WHERE id=".$id.";");

	echo '<div class="text_blue" align="center">Cennik został dodany.</div>';
	echo '<meta http-equiv="refresh" content="'.$czas_przeladowania.'; URL=index.php?page=klienci_dodaj&id='.$id.'&jak='.$jak.'&wg_czego='.$wg_czego.'&pod_page=klienci_dodaj_kontakt">';
	}


if (!$submit)
	{
	$pytanie = mysqli_query($conn, "SELECT * FROM klienci WHERE id = ".$id.";");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		if($wynik['wygiecie_ramy_z_pvc'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Wygięcie ramy z pvc'");
			$row = mysqli_fetch_row($pytanie);
			$wygiecie_ramy_z_pvc = number_format($row[0], 2,'.','');
			}
		else $wygiecie_ramy_z_pvc = number_format($wynik['wygiecie_ramy_z_pvc'], 2,'.','');
		
		if($wynik['wygiecie_skrzydla_z_pvc'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Wygięcie skrzydła z pvc'");
			$row = mysqli_fetch_row($pytanie);
			$wygiecie_skrzydla_z_pvc = number_format($row[0], 2,'.','');
			}
		else $wygiecie_skrzydla_z_pvc = number_format($wynik['wygiecie_skrzydla_z_pvc'], 2,'.','');
		
		if($wynik['wygiecie_listwy_z_pvc'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Wygięcie listwy z pvc'");
			$row = mysqli_fetch_row($pytanie);
			$wygiecie_listwy_z_pvc = number_format($row[0], 2,'.','');
			}
		else $wygiecie_listwy_z_pvc = number_format($wynik['wygiecie_listwy_z_pvc'], 2,'.','');
		
		if($wynik['wygiecie_innego_elementu_z_pvc'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Wygięcie innego elementu z pvc'");
			$row = mysqli_fetch_row($pytanie);
			$wygiecie_innego_elementu_z_pvc = number_format($row[0], 2,'.','');
			}
		else $wygiecie_innego_elementu_z_pvc = number_format($wynik['wygiecie_innego_elementu_z_pvc'], 2,'.','');
		
		if($wynik['wygiecie_ramy_z_alu'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Wygięcie ramy z alu'");
			$row = mysqli_fetch_row($pytanie);
			$wygiecie_ramy_z_alu = number_format($row[0], 2,'.','');
			}
		else $wygiecie_ramy_z_alu = number_format($wynik['wygiecie_ramy_z_alu'], 2,'.','');
		
		if($wynik['wygiecie_skrzydla_z_alu'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Wygięcie skrzydła z alu'");
			$row = mysqli_fetch_row($pytanie);
			$wygiecie_skrzydla_z_alu = number_format($row[0], 2,'.','');
			}
		else $wygiecie_skrzydla_z_alu = number_format($wynik['wygiecie_skrzydla_z_alu'], 2,'.','');
		
		if($wynik['wygiecie_listwy_z_alu'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Wygięcie listwy z alu'");
			$row = mysqli_fetch_row($pytanie);
			$wygiecie_listwy_z_alu = number_format($row[0], 2,'.','');
			}
		else $wygiecie_listwy_z_alu = number_format($wynik['wygiecie_listwy_z_alu'], 2,'.','');
		
		if($wynik['wygiecie_innego_elementu_z_alu'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Wygięcie innego elementu z alu'");
			$row = mysqli_fetch_row($pytanie);
			$wygiecie_innego_elementu_z_alu = number_format($row[0], 2,'.','');
			}
		else $wygiecie_innego_elementu_z_alu = number_format($wynik['wygiecie_innego_elementu_z_alu'], 2,'.','');
	
		if($wynik['wygiecie_wzmocnienia_okiennego'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Wygięcie wzmocnienia okiennego'");
			$row = mysqli_fetch_row($pytanie);
			$wygiecie_wzmocnienia_okiennego = number_format($row[0], 2,'.','');
			}
		else $wygiecie_wzmocnienia_okiennego = number_format($wynik['wygiecie_wzmocnienia_okiennego'], 2,'.','');
		
		if($wynik['wygiecie_innego_elementu_ze_stali'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Wygięcie innego elementu ze stali'");
			$row = mysqli_fetch_row($pytanie);
			$wygiecie_innego_elementu_ze_stali = number_format($row[0], 2,'.','');
			}
		else $wygiecie_innego_elementu_ze_stali = number_format($wynik['wygiecie_innego_elementu_ze_stali'], 2,'.','');
		
		if($wynik['zgrzanie'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Zgrzanie'");
			$row = mysqli_fetch_row($pytanie);
			$zgrzanie = number_format($row[0], 2,'.','');
			}
		else $zgrzanie = number_format($wynik['zgrzanie'], 2,'.','');
		
		if($wynik['wyfrezowanie_odwodnienia'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Wyfrezowanie odwodnienia'");
			$row = mysqli_fetch_row($pytanie);
			$wyfrezowanie_odwodnienia = number_format($row[0], 2,'.','');
			}
		else $wyfrezowanie_odwodnienia = number_format($wynik['wyfrezowanie_odwodnienia'], 2,'.','');

		if($wynik['wstawienie_slupka'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Wstawienie słupka stałego'");
			$row = mysqli_fetch_row($pytanie);
			$wstawienie_slupka = number_format($row[0], 2,'.','');
			}
		else $wstawienie_slupka = number_format($wynik['wstawienie_slupka'], 2,'.','');
		
		if($wynik['wstawienie_slupka_ruchomego'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Wstawienie słupka ruchomego'");
			$row = mysqli_fetch_row($pytanie);
			$wstawienie_slupka_ruchomego = number_format($row[0], 2,'.','');
			}
		else $wstawienie_slupka_ruchomego = number_format($wynik['wstawienie_slupka_ruchomego'], 2,'.','');

		if($wynik['dociecie_listwy_przyszybowej'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Docięcie listwy przyszybowej tylko łukowej'");
			$row = mysqli_fetch_row($pytanie);
			$dociecie_listwy_przyszybowej = number_format($row[0], 2,'.','');
			}
		else $dociecie_listwy_przyszybowej = number_format($wynik['dociecie_listwy_przyszybowej'], 2,'.','');

		if($wynik['dociecie_kompletu_listew_przyszybowych'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Docięcie kompletu listew przyszybowych'");
			$row = mysqli_fetch_row($pytanie);
			$dociecie_kompletu_listew_przyszybowych = number_format($row[0], 2,'.','');
			}
		else $dociecie_kompletu_listew_przyszybowych = number_format($wynik['dociecie_kompletu_listew_przyszybowych'], 2,'.','');
		
		if($wynik['okucie'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Okucie'");
			$row = mysqli_fetch_row($pytanie);
			$okucie = number_format($row[0], 2,'.','');
			}
		else $okucie = number_format($wynik['okucie'], 2,'.','');
		
		if($wynik['zaszklenie'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Zaszklenie'");
			$row = mysqli_fetch_row($pytanie);
			$zaszklenie = number_format($row[0], 2,'.','');
			}
		else $zaszklenie = number_format($wynik['zaszklenie'], 2,'.','');
		
		if($wynik['wykonanie_innej_usługi'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Wykonanie innej usługi'");
			$row = mysqli_fetch_row($pytanie);
			$wykonanie_innej_usługi = number_format($row[0], 2,'.','');
			}
		else $wykonanie_innej_usługi = number_format($wynik['wykonanie_innej_usługi'], 2,'.','');
		
		if($wynik['oscieznica'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Ościeżnica'");
			$row = mysqli_fetch_row($pytanie);
			$oscieznica = number_format($row[0], 2,'.','');
			}
		else $oscieznica = number_format($wynik['oscieznica'], 2,'.','');

		if($wynik['skrzydlo'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Skrzydło'");
			$row = mysqli_fetch_row($pytanie);
			$skrzydlo = number_format($row[0], 2,'.','');
			}
		else $skrzydlo = number_format($wynik['skrzydlo'], 2,'.','');

		if($wynik['listwa'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Listwa'");
			$row = mysqli_fetch_row($pytanie);
			$listwa = number_format($row[0], 2,'.','');
			}
		else $listwa = number_format($wynik['listwa'], 2,'.','');
		
		if($wynik['slupek'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Słupek'");
			$row = mysqli_fetch_row($pytanie);
			$slupek = number_format($row[0], 2,'.','');
			}
		else $slupek = number_format($wynik['slupek'], 2,'.','');
		
		if($wynik['wzmocnienie_do_ramy'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Wzmocnienie do ramy'");
			$row = mysqli_fetch_row($pytanie);
			$wzmocnienie_do_ramy = number_format($row[0], 2,'.','');
			}
		else $wzmocnienie_do_ramy = number_format($wynik['wzmocnienie_do_ramy'], 2,'.','');

		if($wynik['wzmocnienie_do_skrzydla'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Wzmocnienie do skrzydła'");
			$row = mysqli_fetch_row($pytanie);
			$wzmocnienie_do_skrzydla = number_format($row[0], 2,'.','');
			}
		else $wzmocnienie_do_skrzydla = number_format($wynik['wzmocnienie_do_skrzydla'], 2,'.','');

		if($wynik['wzmocnienie_do_slupka'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Wzmocnienie do słupka'");
			$row = mysqli_fetch_row($pytanie);
			$wzmocnienie_do_slupka = number_format($row[0], 2,'.','');
			}
		else $wzmocnienie_do_slupka = number_format($wynik['wzmocnienie_do_slupka'], 2,'.','');

		if($wynik['slupek'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Wzmocnienie do łuku'");
			$row = mysqli_fetch_row($pytanie);
			$wzmocnienie_do_luku = number_format($row[0], 2,'.','');
			}
		else $wzmocnienie_do_luku = number_format($wynik['wzmocnienie_do_luku'], 2,'.','');
		
		if($wynik['wzmocnienie_do_ramy'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Okucia'");
			$row = mysqli_fetch_row($pytanie);
			$okucia = number_format($row[0], 2,'.','');
			}
		else $okucia = number_format($wynik['okucia'], 2,'.','');

		if($wynik['wzmocnienie_do_skrzydla'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Szyby'");
			$row = mysqli_fetch_row($pytanie);
			$szyby = number_format($row[0], 2,'.','');
			}
		else $szyby = number_format($wynik['szyby'], 2,'.','');

		if($wynik['wzmocnienie_do_slupka'] == '')
			{
			$pytanie = mysqli_query($conn, "SELECT cena FROM cennik WHERE opis = 'Inny element'");
			$row = mysqli_fetch_row($pytanie);
			$inny_element = number_format($row[0], 2,'.','');
			}
		else $inny_element = number_format($wynik['inny_element'], 2,'.','');
		
		}		
	
	echo '<br><table border="0" width="70%" align="center"><tr align=center valign="top"><td>';

		echo '<FORM action="index.php?page='.$page.'" method="post">';
		echo '<INPUT type="hidden" name="pod_page" value="'.$pod_page.'">';
		echo '<INPUT type="hidden" name="id" value="'.$id.'">';
		echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
		echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
		echo '<INPUT type="hidden" name="szukaj" value="'.$szukaj.'">';
		echo '<INPUT type="hidden" name="szukaj_klienta" value="'.$szukaj_klienta.'">';
		echo '<INPUT type="hidden" name="zmien" value="1">';
		
		echo '<table width="100%" align="center" border="0" cellpadding="5">';
		//######################################################################################################################################################################################################################################
		//#######################################################################################################       CENNIK           ##################################################################################################
		//######################################################################################################################################################################################################################################
		echo '<tr class="text" align="center"><td align="right" class="text" width="40%">Wygięcie ramy z pvc : </td><td align="left" width="60%"><input type="text" name="wygiecie_ramy_z_pvc" value="'.$wygiecie_ramy_z_pvc.'" title="Wygięcie ramy z pvc" alt="Wygięcie ramy z pvc" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td align="right" class="text">Wygięcie skrzydła z pvc : </td><td align="left"><input type="text" name="wygiecie_skrzydla_z_pvc" value="'.$wygiecie_skrzydla_z_pvc.'" title="Wygięcie skrzydła z pvc" alt="Wygięcie skrzydła z pvc" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td align="right" class="text">Wygięcie listwy z pvc : </td><td align="left"><input type="text" name="wygiecie_listwy_z_pvc" value="'.$wygiecie_listwy_z_pvc.'" title="Wygięcie listwy z pvc" alt="Wygięcie listwy z pvc" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td align="right" class="text">Wygięcie innego elementu z pvc : </td><td align="left"><input type="text" name="wygiecie_innego_elementu_z_pvc" value="'.$wygiecie_innego_elementu_z_pvc.'" title="Wygięcie innego elementu z pvc" alt="Wygięcie innego elementu z pvc" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td colspan="2"><hr></td></tr>';
		//######################################################################################################################################################################################################################################
		echo '<tr class="text" align="center"><td align="right" class="text">Wygięcie ramy z alu : </td><td align="left"><input type="text" name="wygiecie_ramy_z_alu" value="'.$wygiecie_ramy_z_alu.'" title="Wygięcie ramy z alu" alt="Wygięcie ramy z alu" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td align="right" class="text">Wygięcie skrzydła z alu : </td><td align="left"><input type="text" name="wygiecie_skrzydla_z_alu" value="'.$wygiecie_skrzydla_z_alu.'" title="Wygięcie skrzydła z alu" alt="Wygięcie skrzydła z alu" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td align="right" class="text">Wygięcie listwy z alu : </td><td align="left"><input type="text" name="wygiecie_listwy_z_alu" value="'.$wygiecie_listwy_z_alu.'" title="Wygięcie listwy z alu" alt="Wygięcie listwy z alu" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td align="right" class="text">Wygięcie innego elementu z alu : </td><td align="left"><input type="text" name="wygiecie_innego_elementu_z_alu" value="'.$wygiecie_innego_elementu_z_alu.'" title="Wygięcie innego elementu z alu" alt="Wygięcie innego elementu z alu" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td colspan="2"><hr></td></tr>';
		//######################################################################################################################################################################################################################################
		echo '<tr class="text" align="center"><td align="right" class="text">Wygięcie wzmocnienia okiennego : </td><td align="left"><input type="text" name="wygiecie_wzmocnienia_okiennego" value="'.$wygiecie_wzmocnienia_okiennego.'" title="Wygięcie wzmocnienia okiennego" alt="Wygięcie wzmocnienia okiennego" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td align="right" class="text">Wygięcie innego elementu ze stali : </td><td align="left"><input type="text" name="wygiecie_innego_elementu_ze_stali" value="'.$wygiecie_innego_elementu_ze_stali.'" title="Wygięcie innego elementu ze stali" alt="Wygięcie innego elementu ze stali" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td align="right" class="text">Zgrzanie : </td><td align="left"><input type="text" name="zgrzanie" value="'.$zgrzanie.'" title="Zgrzanie" alt="Zgrzanie" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td align="right" class="text">Wyfrezowanie odwodnienia : </td><td align="left"><input type="text" name="wyfrezowanie_odwodnienia" value="'.$wyfrezowanie_odwodnienia.'" title="Wyfrezowanie odwodnienia" alt="Wyfrezowanie odwodnienia" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td colspan="2"><hr></td></tr>';
		//######################################################################################################################################################################################################################################
		echo '<tr class="text" align="center"><td align="right" class="text">Wstawienie słupka stałego: </td><td align="left"><input type="text" name="wstawienie_slupka" value="'.$wstawienie_slupka.'" title="Wstawienie słupka" alt="Wstawienie słupka" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td align="right" class="text">Wstawienie słupka ruchomego: </td><td align="left"><input type="text" name="wstawienie_slupka_ruchomego" value="'.$wstawienie_slupka_ruchomego.'" title="Wstawienie słupka ruchomego" alt="Wstawienie słupka ruchomego" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';



		echo '<tr class="text" align="center"><td align="right" class="text">Docięcie listwy przyszybowej tylko łukowej: </td><td align="left"><input type="text" name="dociecie_listwy_przyszybowej" value="'.$dociecie_listwy_przyszybowej.'" title="Docięcie listwy przyszybowej tylko łukowej" alt="Docięcie listwy przyszybowej tylko łukowej" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';

		echo '<tr class="text" align="center"><td align="right" class="text">Docięcie kompletu listew przyszybowych : </td><td align="left"><input type="text" name="dociecie_kompletu_listew_przyszybowych" value="'.$dociecie_kompletu_listew_przyszybowych.'" title="Docięcie kompletu listew przyszybowych" alt="Docięcie kompletu listew przyszybowych" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';

		 

		echo '<tr class="text" align="center"><td align="right" class="text">Okucie : </td><td align="left"><input type="text" name="okucie" value="'.$okucie.'" title="Okucie" alt="Okucie" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td align="right" class="text">Zaszklenie : </td><td align="left"><input type="text" name="zaszklenie" value="'.$zaszklenie.'" title="Zaszklenie" alt="Zaszklenie" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td colspan="2"><hr></td></tr>';
		//######################################################################################################################################################################################################################################
		echo '<tr class="text" align="center"><td align="right" class="text">Wykonanie innej usługi : </td><td align="left"><input type="text" name="wykonanie_innej_usługi" value="'.$wykonanie_innej_usługi.'" title="Wykonanie innej usługi" alt="Wykonanie innej usługi" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td align="right" class="text">Ościeżnica : </td><td align="left"><input type="text" name="oscieznica" value="'.$oscieznica.'" title="Ościeżnica" alt="Ościeżnica" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td align="right" class="text">Skrzydło : </td><td align="left"><input type="text" name="skrzydlo" value="'.$skrzydlo.'" title="Skrzydło" alt="Skrzydło" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td align="right" class="text">Listwa : </td><td align="left"><input type="text" name="listwa" value="'.$listwa.'" title="Listwa" alt="Listwa" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td colspan="2"><hr></td></tr>';
		//######################################################################################################################################################################################################################################
		echo '<tr class="text" align="center"><td align="right" class="text">Słupek : </td><td align="left"><input type="text" name="slupek" value="'.$slupek.'" title="Słupek" alt="Słupek" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td align="right" class="text">Wzmocnienie do ramy : </td><td align="left"><input type="text" name="wzmocnienie_do_ramy" value="'.$wzmocnienie_do_ramy.'" title="Wzmocnienie do ramy" alt="Wzmocnienie do ramy" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td align="right" class="text">Wzmocnienie do skrzydła : </td><td align="left"><input type="text" name="wzmocnienie_do_skrzydla" value="'.$wzmocnienie_do_skrzydla.'" title="Wzmocnienie do skrzydła" alt="Wzmocnienie do skrzydła" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td align="right" class="text">Wzmocnienie do s łupka : </td><td align="left"><input type="text" name="wzmocnienie_do_slupka" value="'.$wzmocnienie_do_slupka.'" title="Wzmocnienie do słupka" alt="Wzmocnienie do słupka" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td colspan="2"><hr></td></tr>';
		//######################################################################################################################################################################################################################################
		echo '<tr class="text" align="center"><td align="right" class="text">Wzmocnienie do łuku : </td><td align="left"><input type="text" name="wzmocnienie_do_luku" value="'.$wzmocnienie_do_luku.'" title="Wzmocnienie do łuku" alt="Wzmocnienie do łuku" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td align="right" class="text">Okucia : </td><td align="left"><input type="text" name="okucia" value="'.$okucia.'" title="Okucia" alt="Okucia" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td align="right" class="text">Szyby : </td><td align="left"><input type="text" name="szyby" value="'.$szyby.'" title="Szyby" alt="Szyby" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td align="right" class="text">Inny element : </td><td align="left"><input type="text" name="inny_element" value="'.$inny_element.'" title="Inny element" alt="Inny element" class="pole_input_right" size="14" maxlength="10" autocomplete="off">'.$waluta.'</td></tr>';
		echo '<tr class="text" align="center"><td colspan="2"><hr></td></tr>';		
		//######################################################################################################################################################################################################################################

		echo '<tr><td align="center" colspan="2">';
		echo '<button type="submit" class="text" name="submit">Dodaj</button></td></tr>';
		echo '</table></FORM>';

	echo '</td></tr></table>';
	}
?>