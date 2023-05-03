<?php
echo '<table width="1300px" align="left" border="0" cellpadding="3"><tr><td width="100%" align="center" valign="top">';

echo '<div class="text_duzy" align="center">Druk</div><br>';


if($zapisz == 'Zapisz')
{

$pytanie2 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$data_przyjecia2."' WHERE opis = 'data_przyjecia2' AND drukuj='lista_zamowien';");
$pytanie3 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$nr_zamowienia2."' WHERE opis = 'nr_zamowienia2' AND drukuj='lista_zamowien';");
$pytanie69 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$nr_zamowienia_klienta2."' WHERE opis = 'nr_zamowienia_klienta2' AND drukuj='lista_zamowien';");
$pytanie4 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$produkt2."' WHERE opis = 'produkt2' AND drukuj='lista_zamowien';");
$pytanie5 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$profil2."' WHERE opis = 'profil2' AND drukuj='lista_zamowien';");
$pytanie7 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$rodzaj_okuc2."' WHERE opis = 'rodzaj_okuc2' AND drukuj='lista_zamowien';");

$pytanie8 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$rodzaj_szyb2."' WHERE opis = 'rodzaj_szyb2' AND drukuj='lista_zamowien';");
$pytanie9 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$kolor_profili2."' WHERE opis = 'kolor_profili2' AND drukuj='lista_zamowien';");
$pytanie81 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$kolor_uszczelek2."' WHERE opis = 'kolor_uszczelek2' AND drukuj='lista_zamowien';");
$pytanie82 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$magazyn2."' WHERE opis = 'magazyn2' AND drukuj='lista_zamowien';");
$pytanie83 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$stan2."' WHERE opis = 'stan2' AND drukuj='lista_zamowien';");
$pytanie84 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$sztuki2."' WHERE opis = 'sztuki2' AND drukuj='lista_zamowien';");
$pytanie85 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$luki_pvc2."' WHERE opis = 'luki_pvc2' AND drukuj='lista_zamowien';");

$pytanie845 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$luki_stal2."' WHERE opis = 'luki_stal2' AND drukuj='lista_zamowien';");
$pytanie86 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$luki_alu2."' WHERE opis = 'luki_alu2' AND drukuj='lista_zamowien';");
$pytanie87 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$zgrzewy2."' WHERE opis = 'zgrzewy2' AND drukuj='lista_zamowien';");
$pytanie88 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$odwodnienia2."' WHERE opis = 'odwodnienia2' AND drukuj='lista_zamowien';");
$pytanie89 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$otwory_pod_klamke2."' WHERE opis = 'otwory_pod_klamke2' AND drukuj='lista_zamowien';");
$pytanie80 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$otwory_odpowietrzajace2."' WHERE opis = 'otwory_odpowietrzajace2' AND drukuj='lista_zamowien';");

$pytanie865 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$slupki2."' WHERE opis = 'slupki2' AND drukuj='lista_zamowien';");
$pytanie865 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$slupki_ruchome2."' WHERE opis = 'slupki_ruchome2' AND drukuj='lista_zamowien';");

$pytanie22 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$okuwanie2."' WHERE opis = 'okuwanie2' AND drukuj='lista_zamowien';");
$pytanie33 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$szklenie2."' WHERE opis = 'szklenie2' AND drukuj='lista_zamowien';");
$pytanie44 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$dociecie_listwy2."' WHERE opis = 'dociecie_listwy2' AND drukuj='lista_zamowien';");
$pytanie44 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$dociecie_kompletu_listew2."' WHERE opis = 'dociecie_kompletu_listew2' AND drukuj='lista_zamowien';");
$pytanie55 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$nr_wyceny2."' WHERE opis = 'nr_wyceny2' AND drukuj='lista_zamowien';");
$pytanie66 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$wartosc_netto2."' WHERE opis = 'wartosc_netto2' AND drukuj='lista_zamowien';");

$pytanie77 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$termin_realizacji2."' WHERE opis = 'termin_realizacji2' AND drukuj='lista_zamowien';");
$pytanie28 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$data_dostawy2."' WHERE opis = 'data_dostawy2' AND drukuj='lista_zamowien';");
$pytanie29 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$nr_zlecenia_transportowego2."' WHERE opis = 'nr_zlecenia_transportowego2' AND drukuj='lista_zamowien';");
$pytanie727 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$nr_faktury2."' WHERE opis = 'nr_faktury2' AND drukuj='lista_zamowien';");
$pytanie228 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$status2."' WHERE opis = 'status2' AND drukuj='lista_zamowien';");
$pytanie229 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$uwagi2."' WHERE opis = 'uwagi2' AND drukuj='lista_zamowien';");
$pytanie2239 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$data_wysylki_potwierdzenia."' WHERE opis = 'data_wysylki_potwierdzenia' AND drukuj='lista_zamowien';");
$pytanie249 = mysqli_query($conn, "UPDATE ust_druku SET widoczna = '".$data_wysylki_potwierdzenia_dostawy."' WHERE opis = 'data_wysylki_potwierdzenia_dostawy' AND drukuj='lista_zamowien';");
}



$id2 = [];
$opis2 = [];
$opis_pl2 = [];
$widoczna2 = [];

$j=0;
$pytanie = mysqli_query($conn, "SELECT * FROM ust_druku WHERE drukuj='lista_zamowien' ORDER BY ID ASC;");
while($wynik= mysqli_fetch_assoc($pytanie))
	{
	$j++;
	$id2[$j]=$wynik['id'];
	$opis2[$j]=$wynik['opis'];
	$opis_pl2[$j]=$wynik['opis_pl'];
	$widoczna2[$j]=$wynik['widoczna'];
	}


$wybierz_kolor = 0;
echo '<table width="600px" class="tabela" align="center" border="0"><tr align="center" bgcolor="'.$kolor_tabeli.'" class="text">';
echo '<td>'.$kol_lp.'</td>';
echo '<td>Nazwa wiersza</td>';
echo '<td>Drukować?</td></tr>';
echo '<FORM action="index.php?page=ustawienia_druku" method="post">';
	echo '<tr class="text" align="center"><td bgcolor="'.$kolor_tabeli.'" class="text_duzy_white" colspan="3">Drukuj listę zamówień</td></tr>';
	for ($x=1; $x<=$j; $x++)
		{
		echo '<tr class="text_zmienny" align="center" bgcolor="'.$kolor_bialy.'"><td bgcolor="'.$kolor_tabeli.'" class="text">'.$x.'</td>';
		echo '<td>'.$opis_pl2[$x].'</td>';
		if($widoczna2[$x] == 'on') echo '<td><input type="checkbox" name="'.$opis2[$x].'" checked="checked"></td></tr>';
		else echo '<td><input type="checkbox" name="'.$opis2[$x].'"></td></tr>';
		}	


echo '<tr bgcolor="'.$kolor_tabeli.'"><td colspan="3" align="center"><INPUT type="submit" name="zapisz" value="Zapisz"></td></tr>';
echo '</table>';
echo '</form>';

echo '</td></tr></table>';

?>