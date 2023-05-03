<?php
if($usunac == 1)
	{
	$sql = mysqli_query($conn, "DELETE FROM klienci WHERE id = ".$usun_klienta_id." LIMIT 1;");
	$sql = mysqli_query($conn, "DELETE FROM klienci_kontakt WHERE klient_id = ".$usun_klienta_id.";");
	echo '<div align="center" class="text_duzy_niebieski"><br>Klient został usunięty z bazy</div>';
	}

echo '<div align="center"><a href="index.php?page=klienci_logowania">Logowania klientów</a></div><br>';
$i=0;
$klient_id=array();
$klucz=array();
$opiekun_handlowy=array();
$ulica=array();
$miasto=array();
$kod_pocztowy=array();
$status_firmy=array();
$nazwa=array();
$strefa=array();
$klient_wojewodztwo=array();
$login=array();
$haslo=array();
$data_dodania=array();
$data_ostatniego_zamowienia=array();
$data_ostatniej_oferty=array();
$data_ostatniego_logowania=array();
$odstep=array();
$ilosc_dodanych_frezow=array();
$frezy_dodal_user_id=array();
$frezy_dodal_klient_id=array();
$frezy_data_dodania_sposobow=array();
$ilosc_dodanych_zgrzewow=array();
$zgrzewy_dodal_user_id=array();
$zgrzewy_dodal_klient_id=array();
$zgrzewy_data_dodania_sposobow=array();
$godzina_wylogowania=array();
$data_ostatniego_logowania=array();
$data_ostatniego_zamowienia_time=array();

if(($szukaj == 1) && ($SORT_STREFA == '')) $sql = "SELECT * FROM klienci WHERE nazwa LIKE '%".$szukaj_klienta."%' ORDER BY ".$wg_czego." ".$jak.";";
elseif($SORT_STREFA != '') $sql = "SELECT * FROM klienci WHERE strefa = '".$SORT_STREFA."' ORDER BY ".$wg_czego." ".$jak.";";
else $sql = "SELECT * FROM klienci ORDER BY ".$wg_czego." ".$jak.";";
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0) 
	while ($wynik = mysqli_fetch_assoc($result)) 
		{
		$i++;
		$klient_id[$i] = $wynik['id'];
		
		//dodanie nowego klucza do wysłania tabelki ze sposobami - klucz do linku.
		$klucz[$i]=$wynik['klucz'];
		if($klucz[$i] == '') 
			{
			$klucz[$i] = generate_key();
			$sql = "UPDATE klienci SET klucz = '".$klucz[$i]."' WHERE id = ".$klient_id[$i].";";
			$result = mysqli_query($conn, $sql);
			}
		
		//szukamy czy tabelka jest juz uzupelniona
		$ilosc_dodanych_frezow[$i] = 0;
		$sql11 = "SELECT * FROM sposob_frezowania_odwodnien WHERE klient_id= ".$klient_id[$i]." ;";
		$result11 = mysqli_query($conn, $sql11);
		if(mysqli_num_rows($result11) > 0) 
			while ($wynik11 = mysqli_fetch_assoc($result11)) 
				{
				$ilosc_dodanych_frezow[$i] = 1;
				$frezy_dodal_user_id[$i]=$wynik11['dodal_user_id'];
				$frezy_dodal_klient_id[$i]=$wynik11['dodal_klient_id'];
				$frezy_data_dodania_sposobow[$i]=$wynik11['data_dodania'];
				}

		$ilosc_dodanych_zgrzewow[$i] = 0;
		$sql22 = "SELECT * FROM sposob_czyszczenia_zgrzewow WHERE klient_id= ".$klient_id[$i]." ;";
		$result22 = mysqli_query($conn, $sql22);
		if(mysqli_num_rows($result22) > 0) 
			while ($wynik22 = mysqli_fetch_assoc($result22)) 
				{
				$ilosc_dodanych_zgrzewow[$i] = 1;
				$zgrzewy_dodal_user_id[$i]=$wynik22['dodal_user_id'];
				$zgrzewy_dodal_klient_id[$i]=$wynik22['dodal_klient_id'];
				$zgrzewy_data_dodania_sposobow[$i]=$wynik22['data_dodania'];
				}

		$status_firmy[$i]=$wynik['status_firmy'];
		$nazwa[$i]=$wynik['nazwa'];
		$ulica[$i]=$wynik['ulica'];
		$miasto[$i]=$wynik['miasto'];
		$strefa[$i]=$wynik['strefa'];
		$klient_wojewodztwo[$i]=$wynik['wojewodztwo'];
		$login[$i]=$wynik['login'];
		$haslo[$i]=$wynik['haslo'];
		$opiekun_handlowy[$i]=$wynik['opiekun_handlowy'];
		$data_dodania[$i]=$wynik['data_dodania'];
		$kod_pocztowy[$i]=$wynik['kod_pocztowy'];
		$data_ostatniego_zamowienia[$i]=$wynik['data_ostatniego_zamowienia'];
		$data_ostatniego_logowania[$i]=$wynik['data_ostatniego_logowania'];
		$data_ostatniej_oferty[$i]=$wynik['data_ostatniej_oferty'];
		if($data_ostatniego_zamowienia[$i] != '')
			{
			$rozbite = explode("-", $data_ostatniego_zamowienia[$i]);
			$data_ostatniego_zamowienia_time[$i] = mktime(0, 0, 0, $rozbite[1], $rozbite[0], $rozbite[2]);
			}
		else $data_ostatniego_zamowienia_time[$i] = 0;
		}




	
// formularz
echo '<FORM action="index.php?page='.$page.'&szukaj=1" method="post" id="szukaj">';
echo '<INPUT type="hidden" name="page" value="'.$page.'">';
echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';


$wybierz_kolor = 0;
echo '<table align="center" class="tabela" width="1800px"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
if($szukaj == 1) echo '<td width="5%">'.$kol_lp.'<br><a href="index.php?page=klienci&jak=DESC&wg_czego=id">'.$image_close.'</a></td>';
else echo '<td width="15px">'.$kol_lp.'</td>';
echo '<td width="200px" align="center">'.$kol_nazwa;
	//szukaj klienta
	echo '<table border="0" cellspacing="0" cellpadding="0" valign="bottom"><tr valign="bottom"><td align="center" valign="bottom">';
	echo '<input type="text" id="szukaj" autocomplete="off" size="18" maxlength="18" class="pole_input_sortowanie" name="szukaj_klienta" value="'.$szukaj_klienta.'"></td>';
	echo '<td><INPUT type="image" name="submit" src="images/search_black.png">';
	echo '</FORM>';
	echo '<td>&nbsp;';
	echo '<a href="index.php?page=klienci&jak=DESC&wg_czego=nazwa&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'">'.$image_arrow_down.'</a><a href="index.php?page=klienci&jak=ASC&wg_czego=nazwa&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'">'.$image_arrow_up.'</a></td>';
	echo '</tr></table></td>';
	
echo '<td width="150px">'.$kol_adres.'</td>';
echo '<td width="100px">Opiekun handlowy</td>';
echo '<td width="100px">'.$kol_status_firmy.'</td>';
echo '<td width="150px">Województwo</td>';
echo '<td width="80px">'.$kol_data_dodania.'</td>';
echo '<td width="120px">'.$kol_login_haslo.'</td>';
	if($user_id == 1) 
		{
		echo '<td width="50px">'.$kol_strefa.'<br>';
		echo '<select name="SORT_STREFA" class="pole_input_biale" onchange="submit();">';
		for($k=1; $k<=$DL_TABELA_STREFY; $k++)
			if($SORT_STREFA == $TABELA_STREFY[$k]) echo '<option selected="selected" value="'.$TABELA_STREFY[$k].'">'.$TABELA_STREFY[$k].'</option>';
			else echo '<option value="'.$TABELA_STREFY[$k].'">'.$TABELA_STREFY[$k].'</option>';
		echo '</select>';
		echo '</td>';
		}
	
//echo '<td width="120px">'.$kol_wyslij_tabele.'</td>';
echo '<td width="80px">'.$kol_data_ostatniej_oferty.'</td>';
echo '<td width="80px">'.$kol_data_ostatniego_zamowienia.'</td>';
echo '<td width="100px"><a href="javascript: pokaz_historie_logowan_klientow()"><font color="black">'.$kol_data_ostatniego_logowania.'</font></a></td>';
echo '<td width="80px">'.$kol_status_logowania.'</td>';
echo '<td width="80px">Wyślij nową ofertę</td></tr>';

for ($x=1; $x<=$i; $x++)
	{
	echo '<tr class="text_zmienny" align="center" bgcolor="'.$kolor_bialy.'"><td bgcolor="'.$kolor_tabeli.'" class="text" align="center">'.$x.'</td>';
	echo '<td><a href="index.php?page=klienci_edycja2&pod_page=klienci_edycja_dane_do_faktury&id='.$klient_id[$x].'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'">'.$nazwa[$x].'</a></td>';
	echo '<td><a href="index.php?page=klienci_edycja2&pod_page=klienci_edycja_dane_do_faktury&id='.$klient_id[$x].'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'">'.$ulica[$x].'<br>'.$kod_pocztowy[$x].' '.$miasto[$x].'</a></td>';
	echo '<td><a href="index.php?page=klienci_edycja2&pod_page=klienci_edycja_dane_do_faktury&id='.$klient_id[$x].'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'">'.$opiekun_handlowy[$x].'</a></td>';
	echo '<td><a href="index.php?page=klienci_edycja2&pod_page=klienci_edycja_dane_do_faktury&id='.$klient_id[$x].'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'">'.$status_firmy[$x].'</a></td>';
	echo '<td><a href="index.php?page=klienci_edycja2&pod_page=klienci_edycja_adres_dostawy&id='.$klient_id[$x].'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'">'.$klient_wojewodztwo[$x].'</a></td>';
	$data[$x] = date('d-m-Y', $data_dodania[$x]);
	echo '<td>'.$data[$x].'</td>';
	echo '<td><a href="index.php?page=klienci_edycja2&pod_page=klienci_edycja_dane_do_logowania&id='.$klient_id[$x].'&jak='.$jak.'&wg_czego='.$wg_czego.'&szukaj='.$szukaj.'&szukaj_klienta='.$szukaj_klienta.'">'.$login[$x].'<br>'.$haslo[$x].'</a></td>';
	if($user_id == 1) echo '<td width="50px">'.$strefa[$x].'</td>';
	
	//#####################################   wysyłamy tabelkę ze sposobami do wypełnienia przez klienta
	/*echo '<td align="center">';
	if($klucz[$x] != '') 
		{
		//echo 'zg='.$ilosc_dodanych_zgrzewow[$x].'<br>';
		//echo 'fr='.$ilosc_dodanych_frezow[$x].'<br>';
		echo '<a href="javascript: sposoby_wyslij_tabele(\''.$klient_id[$x].'\')">'.$image_email.'</a>';
		}
	echo '</td>';
	//####################################################################################################################################
*/

	//####################################################### data ostatniej oferty #######################################################
	if($data_ostatniej_oferty[$x] != '')
		{
		$data_ostatniej_oferty[$x] = date('d-m-Y', $data_ostatniej_oferty[$x]);
		echo '<td>'.$data_ostatniej_oferty[$x].'</td>';
		}
	else echo '<td></td>';
	//####################################################################################################################################

	//####################################################### data ostatniego zamówienia #######################################################
	$odstep[$x] = $time - $czas_miedzy_zamowieniami_2 - $data_ostatniego_zamowienia_time[$x];
	if($odstep[$x] > 0) echo '<td><font color="red">'.$data_ostatniego_zamowienia[$x].'</font></td>';
	else echo '<td><font color="black">'.$data_ostatniego_zamowienia[$x].'</font></td>';
	//####################################################################################################################################
	
	//####################################################### data ostatniego logowania #######################################################
	if($data_ostatniego_logowania[$x] != '') 
		{
		$data_ostatniego_logowania[$x] = date('d-m-Y', $data_ostatniego_logowania[$x]);
		echo '<td><a href="javascript: pokaz_historie_logowan_klienta(\''.$klient_id[$x].'\')"><font color="black">'.$data_ostatniego_logowania[$x].'</font></a></td>';
		}
	else 
		{
		$data_ostatniego_logowania[$x] = 'Brak logowań';
		echo '<td>'.$data_ostatniego_logowania[$x].'</td>';
		}
	//####################################################################################################################################
	
	//####################################################### sprawdzam status zalogowania #######################################################
	$sql44 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT godzina_wylogowania, godzina_logowania FROM logowania_klientow WHERE klient_id = ".$klient_id[$x]." ORDER BY id DESC LIMIT 1;"));
	if(isset($sql44['godzina_wylogowania'])) $godzina_wylogowania[$x] = $sql44['godzina_wylogowania'];
	else $godzina_wylogowania[$x] = 0;

	if($godzina_wylogowania[$x] == 0) $obrazek_logowania = $image_green_dot;
	if(($godzina_wylogowania[$x] != 0) || ($godzina_wylogowania[$x] == '')) $obrazek_logowania = $image_red_dot; 
	echo '<td>'.$obrazek_logowania.'</td>';
	echo '<td align="center"><a href="index.php?page=klienci_edycja2&id='.$klient_id[$x].'&jak=DESC&wg_czego=id&pod_page=klienci_edycja_oferta_indywidualna&nowa_oferta=1&skad=klienci">'.$image_send_mail.'</a></td>';
	
	echo '</tr>';
	//####################################################################################################################################
	}
echo '</table>';
?>