<?php
$ilosc_klientow = 0;
$pytanie24 = mysqli_query($conn, "SELECT * FROM klienci ORDER BY nazwa ASC;");
while($wynik24= mysqli_fetch_assoc($pytanie24))
	{
	$ilosc_klientow++;
	$KLIENT_NAZWA[$ilosc_klientow] = $wynik24['nazwa'];
	}


echo '<table border="0" align="left">';
if($wyslij == 'TAK')
	{
	echo '<tr><td>';
	//szukam email klienta do wysylki
	$pytanie = mysqli_query($conn, "SELECT * FROM wyceny WHERE wycena_wstepna_nr = '".$wycena_wstepna_wysylka."' AND pozycja = 1;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$email=$wynik['wycena_wstepna_email'];
		$klient_nazwa_wycena=$wynik['klient_nazwa'];
		$klient_id_wycena=$wynik['klient_id'];
		}
	
	include('php/wycena_wstepna_pdf.php');
	// else $modyfikuj=mysqli_query($conn, "update wyceny set link_wycena_pdf='link' WHERE wycena_wstepna_nr = '".$wycena_wstepna_wysylka."' AND nr_zamowienia = '".$wycena_wstepna_wysylka."' AND klient_id = ".$klient_id_wycena.";"); // tylko offline
	$modyfikuj=mysqli_query($conn, "update wyceny set status ='Wysłana' WHERE wycena_wstepna_nr = '".$wycena_wstepna_wysylka."' AND nr_zamowienia = '".$wycena_wstepna_wysylka."' AND klient_id = ".$klient_id_wycena.";");
	echo '</td></tr>';
	}
	
//usun wycene
if(($usun_wycene != '') && ($potwierdzam_usuniecie == 'TAK'))
	{
	echo '<tr><td>';
	$pytanie = mysqli_query($conn, "SELECT * FROM wyceny WHERE wycena_wstepna_nr = '".$usun_wycene."' AND pozycja = 1;");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$klient_nazwa_wycena=$wynik['klient_nazwa'];
		}

	$sql = mysqli_query($conn, "DELETE FROM wyceny WHERE wycena_wstepna_nr = '".$usun_wycene."';");
	echo '<br><div class="text_green" align="center">Wycena wstępna nr <font color="blue">'.$usun_wycene.'</font> dla <font color="blue">'.$klient_nazwa_wycena.'</font> została <font color="red">usunięta</font>.</div><br>';
	echo '</td></tr>';
	}

	//5184000 dwa miechy 60 dni
	//2592000 dwa miechy 30 dni
	//86400 dwa miechy 1 dzien
	$status_ilosc_dni = 2592000;
	$status_starszy = $time - $status_ilosc_dni;
	$warunek = " wycena_wstepna_nr != '' AND pozycja = 1";
	if($SORT_KLIENT_NAZWA != "") $warunek .= ' AND klient_nazwa = "'.$SORT_KLIENT_NAZWA.'"';

	if($pokaz_wszystkie != 'TAK') $warunek .= ' AND data_wyceny > "'.$status_starszy.'"'; 

	$i=0;
	$produkt2 = [];
	$status2 = [];
	$nr_zamowienia2 = [];
	$wartosc_netto2 = [];
	$id = [];
	$zamowienie_id2 = [];
	$klient_id2 = [];
	$data_wyceny2 = [];
	$wycena_wstepna_nr2 = [];
	$link_wycena_pdf2 = [];
	$klient_nazwa2 = [];
	$kolor2 = [];
	$wycena_wstepna_dodal_klient_id = [];
	$pytanie = mysqli_query($conn, "SELECT * FROM wyceny WHERE ".$warunek." ORDER BY ".$wg_czego." ".$jak.";");
	while($wynik= mysqli_fetch_assoc($pytanie))
		{
		$i++;
		$id[$i]=$wynik['id'];
		$zamowienie_id2[$i]=$wynik['zamowienie_id'];
		$nr_zamowienia2[$i]=$wynik['nr_zamowienia'];
		$klient_id2[$i]=$wynik['klient_id'];
		$data_wyceny2[$i]=$wynik['data_wyceny'];
		$wycena_wstepna_nr2[$i]=$wynik['wycena_wstepna_nr'];
		
		$wartosc_netto2[$i]=$wynik['wycena_wstepna_wartosc_netto'];
		$link_wycena_pdf2[$i]=$wynik['link_wycena_pdf'];
		$produkt2[$i]=$wynik['nazwa_produktu'];
		$klient_nazwa2[$i]=$wynik['klient_nazwa'];
		$kolor2[$i]=$wynik['kolor'];

		if($wynik['wycena_wstepna_dodal_klient_id']) $wycena_wstepna_dodal_klient_id[$i] = $wynik['wycena_wstepna_dodal_klient_id'];
		else $wycena_wstepna_dodal_klient_id[$i] = 'BRAK';
		
		if($link_wycena_pdf2[$i] != '') $status2[$i] = 'Wysłana'; else $status2[$i] = 'Nie wysłana';
		if($zamowienie_id2[$i] != 0) $status2[$i] = 'Nr zam : '.$nr_zamowienia2[$i];

		}


	echo '<FORM action="index.php?page='.$page.'&szukaj=1" method="post" id="szukaj">';
	echo '<INPUT type="hidden" name="page" value="'.$page.'">';
	echo '<INPUT type="hidden" name="jak" value="'.$jak.'">';
	echo '<INPUT type="hidden" name="wg_czego" value="'.$wg_czego.'">';
	echo '<INPUT type="hidden" name="pokaz_wszystkie" value="'.$pokaz_wszystkie.'">';

	echo '<tr><td>';
		echo '<table width="100%" align="center" border="0" cellpadding="1" cellspacing="1"><tr class="text"><td width="30%">';
		echo '</td><td width="40% align="center">';
			if($pokaz_wszystkie != 'TAK') echo '<div align="center"><a href="index.php?page=wyceny_wstepne&jak=DESC&wg_czego=id&pokaz_wszystkie=TAK&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA.'&SORT_STATUS='.$SORT_STATUS.'">Pokaż wszystkie wyceny</a></div>';
			else echo '<div align="center"><a href="index.php?page=wyceny_wstepne&jak=DESC&wg_czego=id&SORT_KLIENT_NAZWA='.$SORT_KLIENT_NAZWA.'&SORT_STATUS='.$SORT_STATUS.'">Pokaż wyceny z 30 dni</a></div>';
		echo '<td width="30% align="right">';
			echo '<table width="200px" align="right" border="0" cellpadding="1" cellspacing="1"><tr class="text"><td width="100%" align="right" valign="middle">';
				echo '<a href="index.php?page=wycena_wstepna_dodaj&jak=DESC&wg_czego=id">'.$image_plusik.'</a>';
			echo '</td><td>';
				echo '<a href="index.php?page=wycena_wstepna_dodaj&jak=DESC&wg_czego=id">Dodaj</a>';
			echo '</td></tr></table>';
		echo '</td></tr></table>';

	
	echo '</td></tr><tr><td>';
		
		echo '<table align="left" class="tabela"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
		if($szukaj == 1) echo '<td width="5%">'.$kol_lp.'<br><a href="index.php?page=wyceny_wstepne&jak=DESC&wg_czego=id">'.$image_close.'</a></td>';
		else echo '<td width="25px">'.$kol_lp.'</td>';
		echo '<td width="220px">Klient<div align="right"><a href="index.php?page=wyceny_wstepne'.$SORTOWANIE_DIV.'&jak=DESC&wg_czego=klient_nazwa">'.$image_arrow_down.'</a><a href="index.php?page=wyceny_wstepne'.$SORTOWANIE_DIV.'&jak=ASC&wg_czego=klient_nazwa">'.$image_arrow_up.'</a></div>';
			echo '<select name="SORT_KLIENT_NAZWA" onchange="submit();" class="pole_input_sortowanie" style="width: 100%">';
			echo '<option></option>';
			for ($k=1; $k<=$ilosc_klientow; $k++) 
				if ($KLIENT_NAZWA[$k] == $SORT_KLIENT_NAZWA) echo '<option value="'.$KLIENT_NAZWA[$k].'" selected="selected">'.$KLIENT_NAZWA[$k].'</option>';
				else echo '<option value="'.$KLIENT_NAZWA[$k].'">'.$KLIENT_NAZWA[$k].'</option>';
			echo '</select>';
		echo '</td>';


		echo '<td width="120px">Nr wyceny</td>';
		echo '<td width="100px">Data</td>';
		echo '<td width="200px">Produkt</td>';
		echo '<td width="200px">Kolor</td>';
		echo '<td width="200">'.$kol_status.'</td>';
		echo '<td width="140px">Wartość netto</td>';
		echo '<td width="50px">PDF</td>';
		echo '</tr>';
			for ($x=1; $x<=$i; $x++)
				{
				echo '<tr class="text_zmienny" align="center" bgcolor="'.$kolor_bialy.'"><td bgcolor="'.$kolor_tabeli.'" class="text">'.$x.'</td>';
				//
				echo '<td><a href="index.php?page=wycena_wstepna_edycja&wycena_wstepna_nr='.$wycena_wstepna_nr2[$x].'&jak='.$jak.'&wg_czego='.$wg_czego.'">'.$klient_nazwa2[$x].'</a></td>';

				if($wycena_wstepna_dodal_klient_id[$x] != 'BRAK') echo '<td><font color="red">'.$wycena_wstepna_nr2[$x].'</font></td>';
				else echo '<td>'.$wycena_wstepna_nr2[$x].'</td>';
				$data_wyceny2[$x] = date('d-m-Y', $data_wyceny2[$x]);
				echo '<td>'.$data_wyceny2[$x].'</td>';
				
				echo '<td>'.$produkt2[$x].'</td>';
				echo '<td>'.$kolor2[$x].'</td>';
				
				//status : wyslana - jak jest link do pliku, zatwierdzona - jak jest nr zamowienia
				
				echo '<td>'.$status2[$x].'</td>';
		
				$wartosc_netto2[$x] = number_format($wartosc_netto2[$x], 2,'.',' ');
				echo '<td>'.$wartosc_netto2[$x].'</td>';
				if($link_wycena_pdf2[$x] != '') echo '<td><a href="http://'.$adres_serwera_do_faktur.'/panel_dane/pdf_wyceny_wstepne/'.$link_wycena_pdf2[$x].'" target="_blank">'.$image_pdf_mini2.'</a></td></tr>';
				else echo '<td>'.$image_pdf_mini2_gray.'</td></tr>';
				}
		echo '</table>';
	echo '</td></tr></table>';
		
echo '</td></tr></table>';

?>