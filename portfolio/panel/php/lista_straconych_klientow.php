<?php
//wprowadzamy date ostatniego zamowienia w formie time
$pytanie = mysqli_query($conn, "SELECT * FROM klienci");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$klient_id2 = $wynik['id'];
	$data_ostatniego_zamowienia2=$wynik['data_ostatniego_zamowienia'];
	
	if($data_ostatniego_zamowienia2 != '')
		{
		$rozbite = explode("-", $data_ostatniego_zamowienia2);
		$data_ostatniego_zamowienia_time2 = mktime(0, 0, 0, $rozbite[1], $rozbite[0], $rozbite[2]);
		$ins=mysqli_query($conn, "update klienci set data_ostatniego_zamowienia_time = '".$data_ostatniego_zamowienia_time2."' WHERE id = ".$klient_id2.";");
		}
	}
// KONIEC
	

//przeszukujemy klientow pod katem czy jest nieaktywny
$i=0;
$nieaktywny=0;
$ilosc_dni = [];
$odstep = [];
$data_ostatniego_zamowienia_time = [];
$klient_id = [];
$nazwa = [];
$ulica = [];
$miasto = [];
$kod_pocztowy = [];
$data_ostatniej_oferty = [];
$data_ostatniego_zamowienia = [];
$pytanie3 = mysqli_query($conn, "SELECT * FROM klienci ORDER BY data_ostatniego_zamowienia_time DESC;");
while($wynik3= mysqli_fetch_assoc($pytanie3))
	{
	$i++;
	$data_ostatniego_zamowienia_time[$i]=$wynik3['data_ostatniego_zamowienia_time'];
	
	
	$odstep[$i] = $time - $czas_miedzy_zamowieniami_2 - $data_ostatniego_zamowienia_time[$i];
	if($odstep[$i] > 0) 
		{
		$nieaktywny++;
		$klient_id[$nieaktywny]=$wynik3['id'];
		$nazwa[$nieaktywny]=$wynik3['nazwa'];
		$ulica[$nieaktywny]=$wynik3['ulica'];
		$miasto[$nieaktywny]=$wynik3['miasto'];
		$data_dodania[$nieaktywny]=$wynik3['data_dodania'];
		$kod_pocztowy[$nieaktywny]=$wynik3['kod_pocztowy'];
		$data_ostatniej_oferty[$nieaktywny]=$wynik3['data_ostatniej_oferty'];
		$data_ostatniego_zamowienia[$nieaktywny]=$wynik3['data_ostatniego_zamowienia'];
		if($data_ostatniego_zamowienia_time[$i] != '') $ilosc_dni[$nieaktywny] = $odstep[$i];
		else $ilosc_dni[$nieaktywny] = '';
		}
	}
// koniec


$wybierz_kolor = 0;
echo '<table align="center" class="tabela" width="1800px"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
if($szukaj == 1) echo '<td width="5%">'.$kol_lp.'<br><a href="index.php?page=klienci&jak=DESC&wg_czego=id">'.$image_close.'</a></td>';
else echo '<td width="15px">'.$kol_lp.'</td>';
echo '<td width="200px" align="center">'.$kol_nazwa.'</td>';
echo '<td width="150px">'.$kol_adres.'</td>';
echo '<td width="120px">'.$kol_data_ostatniej_oferty.'</td>';
echo '<td width="120px">'.$kol_data_ostatniego_zamowienia.'</td>';
echo '<td width="100px">Ilość dni</td>';
echo '<td width="80px">Wyślij nową ofertę</td>';
echo '</tr>';

for ($x=1; $x<=$nieaktywny; $x++)
	{
	echo '<tr class="text_zmienny" align="center" bgcolor="'.$kolor_bialy.'"><td bgcolor="'.$kolor_tabeli.'" class="text" align="center">'.$x.'</td>';
	echo '<td align="center">'.$nazwa[$x].'</td>';
	echo '<td align="center">'.$ulica[$x].'<br>'.$kod_pocztowy[$x].' '.$miasto[$x].'</td>';

	//####################################################### data ostatniej oferty #######################################################
	if($data_ostatniej_oferty[$x] != '')
		{
		$data_ostatniej_oferty[$x] = date('d-m-Y', $data_ostatniej_oferty[$x]);
		echo '<td align="center">'.$data_ostatniej_oferty[$x].'</td>';
		}
	else echo '<td align="center"></td>';
	//#####################################################################################################################################


	//####################################################### data ostatniego zamowienia #######################################################
	echo '<td align="center">'.$data_ostatniego_zamowienia[$x].'</td>';	
	//##########################################################################################################################################
	
	echo '<td>';
	if($ilosc_dni[$x] != '') $temp = round($ilosc_dni[$x] / 86400);
	else $temp = '';
	echo $temp;
	echo '</td>';
	
	echo '<td align="center"><a href="index.php?page=klienci_edycja2&id='.$klient_id[$x].'&jak=DESC&wg_czego=id&pod_page=klienci_edycja_oferta_indywidualna&nowa_oferta=1&skad=klienci&powrot=lista_straconych">'.$image_email.'</a></td>';
	
	echo '</tr>';
	}
echo '</table>';

?>